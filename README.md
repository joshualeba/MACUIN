<p align="center">
  <img src="logo_white.png" alt="Macuin Logo" width="300">
</p>

# MACUIN autopartes

Este es el repositorio central del sistema **MACUIN**, una plataforma para la gestión de autopartes, pedidos y clientes. 🚀

## 📋 Descripción del proyecto
MACUIN integra dos portales principales trabajando en conjunto mediante contenedores:
1.  **Portal administrativo (Flask):** Gestión interna de inventarios, pedidos y reportes.
2.  **Portal de clientes (Laravel):** Catálogo de productos y carrito de compras optimizado.

---

## 🛠️ Guía de instalación rápida (Windows)
Sigue estos pasos para instalar el proyecto desde cero y asegurar que funcione de forma fluida.

### 1. Requisitos previos
*   Instalar **Docker Desktop** (debe estar abierto).
*   Instalar **Git**.

### 2. Clonar el proyecto
Abre una terminal (PowerShell) como administrador y ejecuta:
```powershell
git clone https://github.com/joshualeba/macuin.git C:\MACUIN
cd C:\MACUIN
copy portal_clientes\.env.example portal_clientes\.env
```

### 3. Levantar servidores y configurar
Ejecuta los siguientes comandos en orden para configurar el entorno optimizado:

```powershell
# Levantar contenedores
docker-compose up -d --build

# Instalar dependencias de PHP (tardará unos minutos)
docker-compose exec portal_clientes bash -c "curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer install"

# Configurar carpetas y base de datos
docker-compose exec portal_clientes mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
docker-compose exec portal_clientes chmod -R 777 storage bootstrap/cache
docker-compose exec portal_clientes php artisan key:generate
docker-compose exec portal_clientes touch database/database.sqlite
docker-compose exec portal_clientes php artisan migrate
docker-compose exec portal_clientes chmod 777 database/database.sqlite
```

---

## 🚀 Accesos locales
*   **Portal de clientes:** [http://localhost:8005](http://localhost:8005)
*   **Portal administrativo:** [http://localhost:5005](http://localhost:5005)

---

## 📅 Integrantes del equipo
*   **Joshua:** Integración y configuración del repositorio.
*   **Santy:** Frontend del portal de clientes.
*   **Maria:** Especialista Docker.
*   **Fabiola:** Documentación técnica y aseguramiento de calidad.
*   **Akerizz:** Frontend del portal de personal interno.