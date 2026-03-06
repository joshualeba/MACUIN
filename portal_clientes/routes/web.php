<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/registro', function () {
    return view('registro');
});

// Se han habilitado nuevamente para permitir la entrada al Dashboard
Route::get('/catalogo', function () { return view('catalogo'); });
Route::get('/producto/{id}', function ($id) { return view('producto', ['id' => $id]); });
Route::get('/carrito', function () { return view('carrito'); });
Route::get('/pago', function () { return view('pago'); });
Route::get('/historial', function () { return view('historial'); });
Route::get('/pedido/{id}', function ($id) { return view('detalle_pedido', ['id' => $id]); });
Route::get('/perfil', function () { return view('perfil'); });

