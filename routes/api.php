<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoraController;
use App\Http\Controllers\UsuariosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/usuarios', function () {

});

Route::get('/usuarios', [UsuariosController::class, 'index']);
Route::post('/usuariosAgregar', [UsuariosController::class, 'store']);
Route::put('/usuariosActualizar/{id}', [UsuariosController::class, 'update']);
Route::get('/usuariosBuscar/{id}', [UsuariosController::class, 'show']);
Route::delete('/usuariosEliminar/{id}', [UsuariosController::class, 'delete']);
