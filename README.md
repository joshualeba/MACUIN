<p align="center">
  <img src="logo_white.png" alt="Macuin Logo" width="300">
</p>

# MACUIN Autopartes

Este es el repositorio central del sistema **MACUIN**, una plataforma para la gestión de autopartes, pedidos y clientes, diseñada para el **Segundo Parcial**. 🚀

## 📋 Descripción del proyecto
MACUIN integra dos portales principales trabajando en conjunto mediante contenedores:
1.  **Portal Administrativo (Flask):** Gestión interna de inventarios, pedidos y reportes.
2.  **Portal de Clientes (Laravel):** Catálogo de productos y carrito de compras.

---

## 🛠️ Guía de instalación para el equipo
Para que el proyecto funcione en tu equipo local, sigue estos pasos detallados:

### 1. Requisitos previos
*   Tener instalado **Docker Desktop**.
*   Tener instalado **Git**.

### 2. Clonar el repositorio
Abre una terminal y ejecuta el siguiente comando:
```bash
git clone https://github.com/joshualeba/macuin.git
cd macuin
```

### 3. Levantar los servidores
No necesitas instalar Python ni PHP localmente, todo corre en los contenedores:
```bash
docker-compose up --build -d
```

### 4. Accesos locales
*   **Panel de administración:** [http://localhost:5005](http://localhost:5005)
*   **Portal de clientes:** [http://localhost:8005](http://localhost:8005)

---

## 👨‍💻 Flujo de trabajo (Git Flow)
Por favor, sigan estos pasos para subir sus cambios y evitar conflictos:

1.  **Sincronizar:** `git pull origin develop`
2.  **Nueva Tarea:** `git checkout -b feature/HU_X.X`
3.  **Configurar autor:**
    *   `git config user.name "TuNombre"`
    *   `git config user.email "tu@email.com"`
4.  **Guardar y Subir:**
    *   `git add .`
    *   `git commit -m "Descripción de la tarea"`
    *   `git push origin feature/HU_X.X`

---

## 📅 Integrantes del equipo
*   **Joshua:** Integración y Configuración del Repo.
*   **Santy:** Gestión de Pedidos y Logística.
*   **Maria:** Catálogo y Carrito de Compras.
*   **Fabiola:** Gestión de Clientes y Reportes.
*   **Akerizz:** Inventario y Almacén.