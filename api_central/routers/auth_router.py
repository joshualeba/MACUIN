from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from data import db as database
from models import user_schemas as schemas
from security import auth_handler as security
from fastapi.security import OAuth2PasswordRequestForm
from fastapi import Body
from typing import Optional

router = APIRouter(
    tags=["Autenticación"]
)

# Dependencia para obtener el usuario actual desde el token
def get_current_user(token: str = Depends(security.oauth2_scheme), db: Session = Depends(database.get_db)):
    credentials_exception = HTTPException(
        status_code=status.HTTP_401_UNAUTHORIZED,
        detail="No se pudo validar su sesión. Por favor, inicie sesión de nuevo.",
        headers={"WWW-Authenticate": "Bearer"},
    )
    payload = security.decode_token(token)
    if payload is None:
        raise credentials_exception
    
    email: str = payload.get("sub")
    if email is None:
        raise credentials_exception
    
    user = db.query(database.User).filter(database.User.email == email).first()
    if user is None:
        raise credentials_exception
    return user

@router.post("/registro", response_model=schemas.UserResponse, summary="Registrar nuevo usuario")
def register_user(user: schemas.UserCreate, db: Session = Depends(database.get_db)):
    """
    Registra un nuevo usuario después de validar el correo y la contraseña.
    """
    # Verificar si el correo ya existe
    db_user = db.query(database.User).filter(database.User.email == user.email).first()
    if db_user:
        raise HTTPException(
            status_code=400, 
            detail="Este correo electrónico ya está registrado."
        )
    
    # Crear el usuario con la contraseña hasheada
    new_user = database.User(
        nombre=user.nombre,
        email=user.email,
        password=security.hash_password(user.password)
    )
    db.add(new_user)
    db.commit()
    db.refresh(new_user)
    return new_user

@router.post("/registro-admin", response_model=schemas.UserResponse, summary="Registrar nuevo personal de Macuin (Solo Super Admin)")
def register_admin(user: schemas.UserAdminCreate, db: Session = Depends(database.get_db), current_user: database.User = Depends(get_current_user)):
    """
    Permite a un Super Admin crear cuentas para Soporte Técnico u otros Super Admins.
    """
    # Solo el Super Admin puede crear otros administradores
    if current_user.role != "Super admin":
        raise HTTPException(status_code=403, detail="Operación restringida. Solo el Super Admin principal puede dar de alta a personal administrativo.")

    # Verificar si el correo ya existe
    db_user = db.query(database.User).filter(database.User.email == user.email).first()
    if db_user:
        raise HTTPException(status_code=400, detail="Este correo ya tiene una cuenta activa.")

    if user.role not in ["Super admin", "Soporte técnico", "Cliente"]:
        raise HTTPException(status_code=400, detail="Rol no válido para personal de Macuin.")

    new_admin = database.User(
        nombre=user.nombre,
        email=user.email,
        password=security.hash_password(user.password),
        role=user.role
    )
    db.add(new_admin)
    db.commit()
    db.refresh(new_admin)
    return new_admin

@router.post("/login", summary="Iniciar sesión (JSON)", response_model=schemas.Token)
def login_user(user: schemas.UserLogin, db: Session = Depends(database.get_db), isAdmin: bool = False):
    """
    Valida credenciales vía JSON y devuelve un token JWT.
    """
    try:
        input_email = user.email.lower()
        db_user = db.query(database.User).filter(database.User.email == input_email).first()
        
        if not db_user:
            raise HTTPException(status_code=401, detail="Usuario no encontrado.")
        if not db_user.is_active:
            raise HTTPException(status_code=403, detail="Cuenta desactivada.")
        if not security.verify_password(user.password, db_user.password or ""):
            raise HTTPException(status_code=401, detail="Contraseña incorrecta.")

        access_token = security.create_access_token(data={"sub": db_user.email})
        return {
            "access_token": access_token,
            "token_type": "bearer",
            "user": db_user
        }
    except HTTPException as he:
        raise he
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

@router.post("/token", summary="Obtener token (Swagger/Form)", include_in_schema=False)
def login_for_access_token(form_data: OAuth2PasswordRequestForm = Depends(), db: Session = Depends(database.get_db)):
    """
    Endpoint especial para el botón 'Authorize' de Swagger.
    """
    db_user = db.query(database.User).filter(database.User.email == form_data.username.lower()).first()
    if not db_user or not security.verify_password(form_data.password, db_user.password or ""):
        raise HTTPException(status_code=status.HTTP_401_UNAUTHORIZED, detail="Credenciales inválidas")
    
    access_token = security.create_access_token(data={"sub": db_user.email})
    return {"access_token": access_token, "token_type": "bearer", "user": db_user}

@router.get("/usuarios", summary="Obtener lista de usuarios")
def get_all_users(db: Session = Depends(database.get_db), current_user: database.User = Depends(get_current_user)):
    """
    Obtiene todos los usuarios registrados. Solo accesible para personal administrativo.
    """
    if current_user.role not in ["Super admin", "Soporte técnico"]:
        raise HTTPException(status_code=403, detail="No tienes permisos para ver la lista de usuarios.")

    users = db.query(database.User).all()
    return [{
        "id": u.id, 
        "nombre": u.nombre, 
        "email": u.email, 
        "is_active": u.is_active,
        "role": u.role,
        "estado_ciudad": u.estado_ciudad,
        "telefono": u.telefono or "N/A"
    } for u in users]

@router.patch("/usuarios/{user_id}", summary="Actualizar datos de usuario")
def update_user_role(user_id: int, update_data: schemas.UserUpdate, db: Session = Depends(database.get_db), current_user: database.User = Depends(get_current_user)):
    """
    Actualiza datos de un usuario. Solo Super Admin o Soporte Técnico pueden hacer esto.
    """
    # Verificación de permisos
    if current_user.role not in ["Super admin", "Soporte técnico"]:
        raise HTTPException(status_code=403, detail="No tienes permisos para modificar usuarios.")

    user = db.query(database.User).filter(database.User.id == user_id).first()
    if not user:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    
    # Prevenir que cambien el rol del Super Admin original
    if user.email.lower() == "joshualeba2109@gmail.com" and update_data.role is not None:
        raise HTTPException(status_code=403, detail="No puedes remover los privilegios del Super Admin principal.")

    if update_data.is_active is not None:
        user.is_active = update_data.is_active
    if update_data.role is not None:
        if update_data.role not in ["Super admin", "Soporte técnico", "Cliente"]:
            raise HTTPException(status_code=400, detail="Rol inválido")
        user.role = update_data.role
    if update_data.nombre is not None:
        user.nombre = update_data.nombre
    if update_data.estado_ciudad is not None:
        user.estado_ciudad = update_data.estado_ciudad
    if update_data.telefono is not None:
        user.telefono = update_data.telefono
    if update_data.password is not None:
        user.password = security.hash_password(update_data.password)

    db.commit()
    db.refresh(user)
    return user


@router.delete("/usuarios/{user_id}", summary="Eliminar un usuario")
def delete_user(user_id: int, db: Session = Depends(database.get_db), current_user: database.User = Depends(get_current_user)):
    """
    Elimina un usuario. Solo accesible para el Super Admin.
    """
    # Solo el Super Admin puede eliminar
    if current_user.role != "Super admin":
        raise HTTPException(status_code=403, detail="Solo el Super Admin tiene permisos para eliminar cuentas definitivamente.")

    user = db.query(database.User).filter(database.User.id == user_id).first()
    if not user:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    if user.email.lower() == "joshualeba2109@gmail.com":
        raise HTTPException(status_code=403, detail="No se puede eliminar al Super Admin principal.")
    
    db.delete(user)
    db.commit()
    return {"message": "Usuario eliminado correctamente"}

