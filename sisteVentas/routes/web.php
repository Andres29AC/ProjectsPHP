<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('template');
});
Route::view('/panel','panel.index')->name('panel');

//Route::view('/categorias','categoria.index');

Route::resource('categorias',CategoriaController::class);
Route::resource('marcas',MarcaController::class);
Route::resource('presentaciones',PresentacionController::class);
Route::resource('productos',ProductoController::class);
Route::resource('clientes',ClienteController::class);
Route::resource('proveedores',ProveedorController::class);



Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});

//ANCHOR - Para levantar el servidor de laravel
//TODO - php artisan serve
//ANCHOR - Para migraciones:
//TODO - php artisan migrate
//TODO - php artisan migrate:status
//TODO - php artisan migrate:rollback
//TODO - php artisan migrate:fresh
//TODO - php artisan route:list
//TODO - php artisan make:model Documento -m  ->tabla fuerte
//TODO - php artisan make:model Persona  -m   ->tabla debil
//TODO - php artisan make:model Proveedore  -m
//TODO - php artisan make:model Clientes -m
//TODO - php artisan make:model Compras -m

//NOTE - Comienza creando por las entidades fuertes osea 
//NOTE - las que no dependan de otras tablas
//NOTE - $table->foreignId('comprobante_id')->constrained('comproantes')->onDelete('set null');
//NOTE - set null sirve asi si se elimina un comprobante que siga existiendo la compra

//NOTE - Para las tablas pivote:
//TODO - php artisan make:migration create_compra_producto_table
//NOTE tambien tienes la opcion de crear la tabla pivote desde el modelo
//NOTE - para tener un mejor control de las tablas pivote

//NOTE - Comandos para migraciones y modificaciones de tablas
//TODO: php artisan make:migration update_colums_to_documentos_table 
//TODO: php artisan migrate:status
//TODO: php artisan migrate
//NOTE: Creacion de seeders
//TODO: php artisan make:seeder DocumentoSeeder
//TODO: php artisan db:seed

//NOTE - Creacion de controlador de clientes
//TODO: php artisan make:controller ClienteController --resource