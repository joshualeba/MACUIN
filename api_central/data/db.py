from sqlalchemy import create_engine, Column, Integer, String, Boolean, Float, Text, text
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import sessionmaker

import os
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
DB_PATH = os.path.join(BASE_DIR, "macuin.db")
SQLALCHEMY_DATABASE_URL = f"sqlite:///{DB_PATH}"

engine = create_engine(
    SQLALCHEMY_DATABASE_URL, connect_args={"check_same_thread": False}
)
SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

Base = declarative_base()

# Modelos de la base de datos
class User(Base):
    __tablename__ = "users"

    id = Column(Integer, primary_key=True, index=True)
    nombre = Column(String)
    email = Column(String, unique=True, index=True)
    password = Column(String)
    is_active = Column(Boolean, default=True)
    role = Column(String, default="Cliente")
    estado_ciudad = Column(String, default="N/A")
    telefono = Column(String, default="N/A")

class Product(Base):
    __tablename__ = "products"
    
    id = Column(Integer, primary_key=True, index=True)
    nombre = Column(String, index=True)
    precio = Column(String)
    stock = Column(Integer, default=0)
    imagen = Column(String)
    desc_breve = Column(Text)
    desc_completa = Column(Text)
    cat = Column(String)
    active = Column(Boolean, default=True)

from sqlalchemy.orm import relationship
from sqlalchemy import ForeignKey, DateTime
from datetime import datetime

class Order(Base):
    __tablename__ = "orders"
    
    id = Column(Integer, primary_key=True, index=True)
    no_orden = Column(String, unique=True, index=True)
    fecha = Column(DateTime, default=datetime.utcnow)
    cliente = Column(String)
    total = Column(Float)
    estado = Column(String, default="En proceso")  # En proceso, Enviado, Entregado
    items = relationship("OrderItem", back_populates="order", cascade="all, delete-orphan")

class OrderItem(Base):
    __tablename__ = "order_items"
    
    id = Column(Integer, primary_key=True, index=True)
    order_id = Column(Integer, ForeignKey("orders.id"))
    product_nombre = Column(String)
    qty = Column(Integer)
    price = Column(Float)
    
    order = relationship("Order", back_populates="items")

# Dependencia para obtener la sesión
def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()
