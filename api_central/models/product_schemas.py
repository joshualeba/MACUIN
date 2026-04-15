from pydantic import BaseModel
from typing import Optional

class ProductBase(BaseModel):
    nombre: str
    precio: str
    stock: int
    imagen: str
    desc_breve: str
    desc_completa: str
    cat: str
    active: bool = True

    class Config:
        orm_mode = True
        from_attributes = True

class ProductCreate(ProductBase):
    pass

class ProductUpdate(BaseModel):
    nombre: Optional[str] = None
    precio: Optional[str] = None
    stock: Optional[int] = None
    imagen: Optional[str] = None
    desc_breve: Optional[str] = None
    desc_completa: Optional[str] = None
    cat: Optional[str] = None
    active: Optional[bool] = None

class ProductResponse(ProductBase):
    id: int

    class Config:
        orm_mode = True
        from_attributes = True

from typing import List, Optional
from datetime import datetime

class CartItem(BaseModel):
    id: int
    qty: int
    nombre: Optional[str] = None
    precio: Optional[float] = None

class CheckoutRequest(BaseModel):
    items: List[CartItem]
    cliente: str
    email: Optional[str] = None
    ciudad: Optional[str] = None
    estado: Optional[str] = None

class OrderItemResponse(BaseModel):
    id: int
    product_nombre: str
    qty: int
    price: float
    
    class Config:
        orm_mode = True

class OrderResponse(BaseModel):
    id: int
    no_orden: str
    fecha: datetime
    cliente: str
    total: float
    estado: str
    items: List[OrderItemResponse]
    
    class Config:
        orm_mode = True

class OrderStatusUpdate(BaseModel):
    estado: str
