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
use App\Models\categoria_pro;
use App\Models\categoria_recetas;
use App\Http\Controllers\Api\paso_receta_controller; 
use App\Http\Controllers\Api\menu_controller; 
use App\Http\Controllers\Api\categoria_menu_controller;
use App\Http\Controllers\Api\reservas_controller;
use App\Models\categorias_pro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//apis de la aplicacion movil
Route::get('app_category_menu', [menu_controller::class, 'app_category_menu']);
Route::get('app_filter_id/{id}', [menu_controller::class, 'app_filter_id']);
Route::get('app_menu/{id}', [menu_controller::class, 'app_menu']);
Route::get('app_menu_img/{id}', [menu_controller::class, 'app_menu_img']);
Route::post('app_menu_filter', [menu_controller::class, 'app_menu_filter']);
Route::get('image_and_email/{id}',[usuario_controller::class, 'image_and_email']);
Route::get('app_reservas/{id}',[reservas_controller::class, 'app_reservas']);



Route::get('reservas/{id}',[reservas_controller::class, 'reservas']);
Route::apiResource('reservas', reservas_controller::class);



//autentificacion
Route::post('registro', [auth_controller::class, 'register']);
Route::post('login', [auth_controller::class, 'login']);


//lista solo si el estado esta activo(tiene que tener el valor de 1)
Route::get('listasolo1', [categoria_pro_controller::class, 'listasolo1']);
Route::get('listasolounidademedia1', [unidad_medida_controller::class, 'listasolo1']);

Route::get('Productosactivos', [productos_controller::class, 'listarsoloactivos']);



Route::get('productoscategoria/{id}', [productos_controller::class, 'productocateg']);

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
Route::get('receta/{id_receta}', [receta_producto_controller::class, 'showRecetaConProductos']);


//crud de receta_producto
Route::apiResource('receta_producto', receta_producto_controller::class);
Route::get('receta-productos/{id_receta}', [receta_producto_controller::class, 'getProductosPorReceta']);


// CRUD de pasos de receta
Route::apiResource('pasos_receta', paso_receta_controller::class);
Route::get('pasos-receta/{id_receta}', [paso_receta_controller::class, 'index']);

//Crud de menu
Route::apiResource('menu', menu_controller::class);
Route::apiResource('categorias_menu', categoria_menu_controller::class);
Route::get('filter_cero', [menu_controller::class, 'menu_filter_cero']);
Route::get('menu_filter', [menu_controller::class, 'menu_filter']);
