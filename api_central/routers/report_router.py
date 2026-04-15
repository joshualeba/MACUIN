from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from data.db import get_db, User, Product, Order
from sqlalchemy import func
from routers.auth_router import get_current_user

router = APIRouter(tags=["Reportes administrativos"])

def check_admin(user: User):
    if user.role not in ["Super admin", "Soporte técnico"]:
        raise HTTPException(status_code=403, detail="Acceso denegado. Se requieren permisos administrativos para ver reportes.")

@router.get("/inventario", summary="Obtener reporte de inventario")
async def get_inventory_report(db: Session = Depends(get_db), current_user: User = Depends(get_current_user)):
    """Reporte 1: Estado del inventario y valuación."""
    check_admin(current_user)
    products = db.query(Product).all()
    total_items = len(products)
    low_stock = [p for p in products if p.stock < 5]
    total_value = sum(p.precio * p.stock for p in products)
    
    # Agrupar por categoría
    cats = db.query(Product.cat, func.count(Product.id)).group_by(Product.cat).all()
    category_dist = {cat: count for cat, count in cats}

    return {
        "summary": {
            "total_products": total_items,
            "low_stock_count": len(low_stock),
            "total_inventory_value": total_value
        },
        "category_distribution": category_dist,
        "detail": [{"nombre": p.nombre, "stock": p.stock, "precio": p.precio, "cat": p.cat} for p in products]
    }

@router.get("/clientes", summary="Reporte de análisis de clientes")
async def get_clients_report(db: Session = Depends(get_db), current_user: User = Depends(get_current_user)):
    """Reporte 2: Análisis de clientes y consumo."""
    check_admin(current_user)
    # Solo consideramos usuarios con rol de "Cliente"
    clients = db.query(User).filter(User.role == "Cliente").all()
    
    client_metrics = []
    for c in clients:
        # Buscamos órdenes por el nombre del cliente (ya que el modelo Order usa 'cliente')
        orders = db.query(Order).filter(Order.cliente == c.nombre).all()
        total_spent = sum(o.total for o in orders)
        client_metrics.append({
            "nombre": c.nombre,
            "email": c.email,
            "total_orders": len(orders),
            "total_spent": total_spent,
            "is_active": c.is_active
        })
        
    return {
        "total_clients": len(clients),
        "active_clients": len([c for c in clients if c.is_active]),
        "metrics": sorted(client_metrics, key=lambda x: x["total_spent"], reverse=True)
    }

@router.get("/pedidos", summary="Reporte de logística y ventas")
async def get_orders_report(db: Session = Depends(get_db), current_user: User = Depends(get_current_user)):
    """Reporte 3: Estado de logística y ventas."""
    check_admin(current_user)
    orders = db.query(Order).all()
    stats = db.query(Order.estado, func.count(Order.id)).group_by(Order.estado).all()
    
    return {
        "total_orders": len(orders),
        "status_summary": {status: count for status, count in stats},
        "recent_orders": [{"id": o.id, "total": o.total, "estado": o.estado, "fecha": o.fecha} for o in orders[-10:]]
    }

@router.get("/actividad-sistema", summary="Reporte de actividad y personal")
async def get_activity_report(db: Session = Depends(get_db), current_user: User = Depends(get_current_user)):
    """Reporte 4: Control de personal y actividad del sistema."""
    check_admin(current_user)
    users = db.query(User).all()
    roles = db.query(User.role, func.count(User.id)).group_by(User.role).all()
    
    return {
        "total_users": len(users),
        "role_distribution": {rol: count for rol, count in roles},
        "inactive_accounts": len([u for u in users if not u.is_active])
    }
