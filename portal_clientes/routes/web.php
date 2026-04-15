<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/registro', function () {
    return view('registro');
});

use Illuminate\Support\Facades\Http;

// Se han habilitado nuevamente para permitir la entrada al Dashboard
Route::get('/catalogo', function () { 
    try {
        // En Docker, usamos api_central:8008, fallback a localhost si falla localmente
        $response = Http::timeout(3)->get('http://api_central:8008/productos/');
        $productos = $response->json();
        
        // Filtramos para que los clientes solo vean los productos activos
        if (is_array($productos)) {
            $productos = array_filter($productos, function($p) {
                return isset($p['active']) && $p['active'] === true;
            });
        }
    } catch (\Exception $e) {
        $productos = [];
    }
    return view('catalogo', ['productos' => $productos]); 
});
Route::get('/producto/{id}', function ($id) { 
    try {
        $response = Http::timeout(3)->get("http://api_central:8008/productos/{$id}");
        if ($response->ok()) {
            $producto = $response->json();
            // Verificar si el producto existe y está activo
            if (isset($producto['active']) && $producto['active'] === true) {
                return view('producto', ['producto' => $producto, 'id' => $id]);
            }
        }
    } catch (\Exception $e) {
        // Fallback en caso de error
    }
    return redirect('/catalogo'); 
});
Route::get('/carrito', function () { return view('carrito'); });
Route::get('/pago', function () { return view('pago'); });
Route::get('/historial', function () { return view('historial'); });
Route::get('/pedido/{id}', function ($id) { return view('detalle_pedido', ['id' => $id]); });
Route::get('/perfil', function () { return view('perfil'); });

