from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from data import db as database
from typing import List
from models.product_schemas import ProductCreate, ProductUpdate, ProductResponse, CheckoutRequest, OrderResponse, OrderStatusUpdate
from security.auth_handler import oauth2_scheme
from routers.auth_router import get_current_user

router = APIRouter(
    tags=["Catálogo de autopartes"]
)

import uuid

@router.patch("/pedidos/{no_orden}/estado", response_model=OrderResponse, summary="Actualizar estado de pedido")
def update_order_status(no_orden: str, status_data: OrderStatusUpdate, db: Session = Depends(database.get_db), current_user: database.User = Depends(get_current_user)):
    """Solo administradores pueden cambiar el estado logístico"""
    if current_user.role not in ["Super admin", "Soporte técnico"]:
        raise HTTPException(status_code=403, detail="Permisos insuficientes para cambiar el estado de pedidos.")

    order = db.query(database.Order).filter(database.Order.no_orden == no_orden).first()
    if not order:
        raise HTTPException(status_code=404, detail="Orden no encontrada")
    
    order.estado = status_data.estado
    db.commit()
    db.refresh(order)
    return order

@router.post("/pago", summary="Procesar pago de carrito")
def checkout_cart(data: CheckoutRequest, db: Session = Depends(database.get_db)):
    """
    Resta stock a los productos adquiridos durante una compra y crea la Orden.
    """
    out_of_stock = []
    total_venta = 0.0
    
    # Primera pasada: Validar stock de todos los artículos antes de restar a cualquiera
    for item in data.items:
        product = db.query(database.Product).filter(database.Product.id == item.id).first()
        if not product:
            continue
        if product.stock < item.qty:
            out_of_stock.append(product.nombre)
            
    if out_of_stock:
        raise HTTPException(
            status_code=400, 
            detail=f"Stock insuficiente para: {', '.join(out_of_stock)}"
        )
        
    # Crear la Orden
    no_orden = f"ORD-{uuid.uuid4().hex[:8].upper()}"
    nueva_orden = database.Order(
        no_orden=no_orden,
        cliente=data.cliente,
        estado="En proceso"
    )
    db.add(nueva_orden)
    db.flush() # Para obtener ID
    
    # Actualizar Estado/Ciudad del usuario si viene el dato
    if data.email:
        user = db.query(database.User).filter(database.User.email == data.email.lower()).first()
        if user and data.estado and data.ciudad:
            user.estado_ciudad = f"{data.estado}, {data.ciudad}"
        
    # Segunda pasada: Realizar la deducción de inventario de forma segura y crear Items
    for item in data.items:
        product = db.query(database.Product).filter(database.Product.id == item.id).first()
        if product:
            product.stock -= item.qty
            precio_unit = float(product.precio.replace(",", "")) if isinstance(product.precio, str) else float(product.precio)
            subtotal = precio_unit * item.qty
            total_venta += subtotal
            
            order_item = database.OrderItem(
                order_id=nueva_orden.id,
                product_nombre=product.nombre,
                qty=item.qty,
                price=precio_unit
            )
            db.add(order_item)
            
    # Añadir IVA
    nueva_orden.total = total_venta * 1.16
            
    db.commit()
    return {"message": "Inventario actualizado exitosamente tras realizar la compra. ¡Gracias!", "no_orden": no_orden}

@router.get("/pedidos/todos", response_model=List[OrderResponse], summary="Obtener historial global de pedidos")
def get_all_orders(db: Session = Depends(database.get_db), current_user: database.User = Depends(get_current_user)):
    """Acceso restringido al historial completo de ventas"""
    if current_user.role not in ["Super admin", "Soporte técnico"]:
        raise HTTPException(status_code=403, detail="No tienes autorización para ver el historial global de pedidos.")
        
    orders = db.query(database.Order).order_by(database.Order.fecha.desc()).all()
    return orders

@router.get("/pedidos/{cliente}", response_model=List[OrderResponse], summary="Obtener pedidos por nombre de cliente")
def get_orders_by_client(cliente: str, db: Session = Depends(database.get_db)):
    orders = db.query(database.Order).filter(database.Order.cliente == cliente).order_by(database.Order.fecha.desc()).all()
    return orders

@router.get("/", response_model=List[ProductResponse], summary="Obtener catálogo completo de productos")
def get_products(db: Session = Depends(database.get_db)):
    products = db.query(database.Product).all()
    return products

@router.get("/{product_id}", response_model=ProductResponse, summary="Obtener un producto por su id")
def get_product(product_id: int, db: Session = Depends(database.get_db)):
    product = db.query(database.Product).filter(database.Product.id == product_id).first()
    if not product:
        raise HTTPException(status_code=404, detail="Producto no encontrado")
    return product

@router.put("/{product_id}", response_model=ProductResponse, summary="Actualizar información de producto")
def update_product(product_id: int, product_data: ProductUpdate, db: Session = Depends(database.get_db), current_user: database.User = Depends(get_current_user)):
    if current_user.role not in ["Super admin", "Soporte técnico"]:
        raise HTTPException(status_code=403, detail="Solo administradores pueden editar el inventario.")

    product = db.query(database.Product).filter(database.Product.id == product_id).first()
    if not product:
        raise HTTPException(status_code=404, detail="Producto no encontrado")
    
    update_data = product_data.dict(exclude_unset=True)
    for key, value in update_data.items():
        setattr(product, key, value)
        
    db.commit()
    db.refresh(product)
    return product

@router.post("/", response_model=ProductResponse, summary="Crear un nuevo producto en el catálogo")
def create_product(product_data: ProductCreate, db: Session = Depends(database.get_db), current_user: database.User = Depends(get_current_user)):
    if current_user.role not in ["Super admin", "Soporte técnico"]:
        raise HTTPException(status_code=403, detail="No tienes permisos para añadir productos.")

    nuevo = database.Product(**product_data.dict())
    db.add(nuevo)
    db.commit()
    db.refresh(nuevo)
    return nuevo

@router.delete("/{product_id}", summary="Eliminar producto del sistema")
def delete_product(product_id: int, db: Session = Depends(database.get_db), current_user: database.User = Depends(get_current_user)):
    if current_user.role not in ["Super admin", "Soporte técnico"]:
        raise HTTPException(status_code=403, detail="Operación denegada. Contacta al Super Admin para eliminar productos.")

    product = db.query(database.Product).filter(database.Product.id == product_id).first()
    if not product:
        raise HTTPException(status_code=404, detail="Producto no encontrado")
    db.delete(product)
    db.commit()
    return {"detail": "Producto eliminado mediante la base de datos central"}
