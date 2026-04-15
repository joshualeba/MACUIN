import os
import requests
from fastapi import FastAPI, Request, HTTPException
from fastapi.responses import HTMLResponse, JSONResponse
from fastapi.staticfiles import StaticFiles
from fastapi.templating import Jinja2Templates

app = FastAPI()

# Configuración de templates
templates = Jinja2Templates(directory="templates")

# URL de la API central (Docker)
API_URL = os.getenv("API_URL", "http://127.0.0.1:8008")

@app.get("/", response_class=HTMLResponse)
async def login(request: Request):
    return templates.TemplateResponse("login.html", {"request": request})

@app.get("/dashboard", response_class=HTMLResponse)
async def dashboard(request: Request):
    return templates.TemplateResponse("panel_control.html", {"request": request, "active_page": "panel"})

@app.get("/inventario", response_class=HTMLResponse)
async def inventario(request: Request):
    return templates.TemplateResponse("inventario.html", {"request": request, "active_page": "inventario"})

@app.get("/pedidos", response_class=HTMLResponse)
async def pedidos(request: Request):
    return templates.TemplateResponse("pedidos.html", {"request": request, "active_page": "pedidos"})

@app.get("/perfil", response_class=HTMLResponse)
async def perfil(request: Request):
    return templates.TemplateResponse("perfil.html", {"request": request, "active_page": "perfil"})

@app.get("/usuarios", response_class=HTMLResponse)
async def usuarios(request: Request):
    return templates.TemplateResponse("usuarios.html", {"request": request, "active_page": "usuarios"})

@app.get("/reporte_clientes", response_class=HTMLResponse)
async def reporte_clientes(request: Request):
    return templates.TemplateResponse("reporte_clientes.html", {"request": request, "active_page": "reportes"})

@app.get("/admin/ver_stock/{producto_id}")
async def revisar_stock(producto_id: int):
    try:
        respuesta = requests.get(f"{API_URL}/api/stock/{producto_id}")
        if respuesta.status_code == 200:
            return JSONResponse(content=respuesta.json())
        else:
            return JSONResponse(content={"error": "No se pudo obtener el stock"}, status_code=respuesta.status_code)
    except requests.exceptions.ConnectionError:
        return JSONResponse(content={"error": "La API central no está disponible"}, status_code=503)

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=5000)
