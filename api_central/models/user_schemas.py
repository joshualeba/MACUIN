from pydantic import BaseModel, EmailStr, validator
import re

class UserCreate(BaseModel):
    nombre: str
    email: EmailStr
    password: str

    @validator('password')
    def password_complexity(cls, v):
        if not (8 <= len(v) <= 25):
            raise ValueError('La contraseña debe tener entre 8 y 25 caracteres.')
        if not re.search("[A-Z]", v):
            raise ValueError('La contraseña debe contener al menos una mayúscula.')
        if not re.search("[!@#$%^&*(),.?\":{}|<>]", v):
            raise ValueError('La contraseña debe contener al menos un carácter especial.')
        return v

class UserAdminCreate(UserCreate):
    role: str # "Super admin" o "Soporte técnico"

class UserLogin(BaseModel):
    email: EmailStr
    password: str

class UserResponse(BaseModel):
    id: int
    nombre: str
    email: str
    is_active: bool
    role: str
    estado_ciudad: str
    telefono: str = "N/A"

    class Config:
        from_attributes = True

from typing import Optional

class UserUpdate(BaseModel):
    is_active: Optional[bool] = None
    role: Optional[str] = None
    nombre: Optional[str] = None
    estado_ciudad: Optional[str] = None
    telefono: Optional[str] = None
    password: Optional[str] = None

    @validator('password')
    def password_complexity(cls, v):
        if v is not None:
            if not (8 <= len(v) <= 25):
                raise ValueError('La contraseña debe tener entre 8 y 25 caracteres.')
            if not re.search("[A-Z]", v):
                raise ValueError('La contraseña debe contener al menos una mayúscula.')
            if not re.search("[!@#$%^&*(),.?\":{}|<>]", v):
                raise ValueError('La contraseña debe contener al menos un carácter especial.')
        return v

class Token(BaseModel):
    access_token: str
    token_type: str
    user: UserResponse

class TokenData(BaseModel):
    email: Optional[str] = None
    role: Optional[str] = None
    user_id: Optional[int] = None

