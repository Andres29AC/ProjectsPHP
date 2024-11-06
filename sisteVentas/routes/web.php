<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ventaController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;

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

// Route::get('/', function () {
//     return view('template');
// });
Route::get('/', [homeController::class, 'index'])->name('panel');
// Route::view('/panel','panel.index')->name('panel');

//Route::view('/categorias','categoria.index');

Route::resource('categorias',CategoriaController::class);
Route::resource('marcas',MarcaController::class);
Route::resource('presentaciones',PresentacionController::class);
Route::resource('productos',ProductoController::class);
Route::resource('clientes',ClienteController::class);
Route::resource('proveedores',ProveedorController::class);
Route::resource('compras',CompraController::class);
Route::resource('ventas',ventaController::class);
Route::resource('users',userController::class);
Route::resource('roles',roleController::class);
Route::resource('profile',profileController::class);



Route::get('/login', [loginController::class, 'index'])->name('login');
Route::post('/login', [loginController::class, 'login']);
Route::get('/logout', [logoutController::class, 'logout'])->name('logout');
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
//SECTION -  php artisan serve
//ANCHOR - Para migraciones:
//SECTION - php artisan migrate
//SECTION - php artisan migrate:status
//SECTION - php artisan migrate:rollback
//SECTION - php artisan migrate:fresh
//SECTION - php artisan route:list
//SECTION - php artisan make:model Documento -m  ->tabla fuerte
//SECTION - php artisan make:model Persona  -m   ->tabla debil
//SECTION - php artisan make:model Proveedore  -m
//SECTION - php artisan make:model Clientes -m
//SECTION - php artisan make:model Compras -m

//NOTE - Comienza creando por las entidades fuertes osea 
//NOTE - las que no dependan de otras tablas
//NOTE - $table->foreignId('comprobante_id')->constrained('comproantes')->onDelete('set null');
//NOTE - set null sirve asi si se elimina un comprobante que siga existiendo la compra

//NOTE - Para las tablas pivote:
//SECTION - php artisan make:migration create_compra_producto_table
//NOTE tambien tienes la opcion de crear la tabla pivote desde el modelo
//NOTE - para tener un mejor control de las tablas pivote

//NOTE - Comandos para migraciones y modificaciones de tablas
//SECTION php artisan make:migration update_colums_to_documentos_table 
//SECTION php artisan migrate:status
//SECTION php artisan migrate
//NOTE: Creacion de seeders
//SECTION php artisan make:seeder DocumentoSeeder
//SECTION php artisan db:seed

//NOTE - Creacion de controlador de clientes
//SECTION php artisan make:controller ClienteController --resource
//SECTION php artisan make:controller CompraController --resource

//NOTE - Creacion de venta
//!SECTION php artisan make:controller ventaController --resource