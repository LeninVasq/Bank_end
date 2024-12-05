<?php

use App\Http\Controllers\Api\auth_controller;
use App\Http\Controllers\Api\categoria_pro_controller;
use App\Http\Controllers\Api\categorias_pro_controller;
use App\Http\Controllers\Api\categorias_recetas_controller;
use App\Http\Controllers\Api\ingreso_controller;
use App\Http\Controllers\Api\productos_controller;
use App\Http\Controllers\Api\receta_producto_controller;
use App\Http\Controllers\Api\recetas_controller;
use App\Http\Controllers\Api\tipo_usuario_controller;
use App\Http\Controllers\Api\unidad_medida_controller;
use App\Http\Controllers\Api\usuario_controller;
use App\Models\categoria_recetas;
use App\Models\categorias_pro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//autentificacion
Route::post('registro', [auth_controller::class, 'register']);
Route::post('login', [auth_controller::class, 'login']);



//busqueda por token
Route::get('userProfile', [auth_controller::class, 'userProfile']);

//logout
Route::get('logout/{id}', [auth_controller::class, 'logout']);

//crud de tipos de usuarios
Route::apiResource('tipo_usuario', tipo_usuario_controller::class);

//crud de usuarios
Route::apiResource('user', usuario_controller::class);

//crud de categorias recetas
Route::apiResource('cate_recetas', categorias_recetas_controller::class);

//crud de categorias recetas
Route::apiResource('cate_pro', categoria_pro_controller::class);

//crud de unidades de medida
Route::apiResource('uni_medidas', unidad_medida_controller::class);

//crud de productos
Route::apiResource('productos', productos_controller::class);

//crud de ingreso
Route::apiResource('ingreso', ingreso_controller::class);

//crud de recetas
Route::apiResource('recetas', recetas_controller::class);

//crud de receta_producto
Route::apiResource('receta_producto', receta_producto_controller::class);
