<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VentaController;
use App\Models\Producto;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'productos' => Producto::all(),
    ]);
});
Route::get('producto/{id}', [
    'as' => 'producto',
    'uses' => 'ProductoController@show'
]);
Route::get('/productosauth', [ProductoController::class, 'productos'])->name('productos');
Route::get('/productosapi', [ProductoController::class, 'productosapi']);
Route::get('/productosapipublic', [ProductoController::class, 'productosapipublic']);

Route::post('/crearproducto', [ProductoController::class, 'crearproducto']);
Route::post('/actualizarproducto', [ProductoController::class, 'update']);
Route::post('/eliminarproducto', [ProductoController::class, 'delete']);

Route::get('editarproducto/{id}', [ProductoController::class, 'edit']);
Route::get('productosedit/{id}', [ProductoController::class, 'productosedit']);

Route::get('/stockauth', [StockController::class, 'index']);
Route::get('/ventasauth', [VentaController::class, 'index']);

Route::post('/comprarproducto', [VentaController::class, 'comprar']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
