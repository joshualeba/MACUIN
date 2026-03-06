import os
import requests
from flask import Flask, jsonify, render_template, request, redirect, url_for

app = Flask(__name__)
app.config['TEMPLATES_AUTO_RELOAD'] = True

# Leemos la URL de la api desde la configuración del entorno (Docker)
API_URL = os.getenv("API_URL", "http://127.0.0.1:8000")

@app.route("/")
def login():
    return render_template("login.html")

@app.route("/dashboard")
def dashboard():
    return render_template("panel_control.html", active_page="panel")

@app.route("/inventario")
def inventario():
    return render_template("inventario.html", active_page="inventario")

@app.route("/pedidos")
def pedidos():
    return render_template("pedidos.html", active_page="pedidos")

@app.route("/perfil")
def perfil():
    return render_template("perfil.html", active_page="perfil")

@app.route("/usuarios")
def usuarios():
    # Nueva ruta para administrar personal y clientes
    return render_template("usuarios.html", active_page="usuarios")

@app.route("/reporte_clientes")
def reporte_clientes():
    return render_template("reporte_clientes.html", active_page="reportes")

@app.route("/admin/ver_stock/<int:producto_id>")
def revisar_stock(producto_id):
    try:
        respuesta = requests.get(f"{API_URL}/api/stock/{producto_id}")
        if respuesta.status_code == 200:
            return jsonify(respuesta.json())
        else:
            return jsonify({"error": "No se pudo obtener el stock"}), respuesta.status_code
    except requests.exceptions.ConnectionError:
        return jsonify({"error": "La API central no está disponible"}), 503

if __name__ == '__main__':
    app.run(debug=True, host="0.0.0.0", port=5000)
