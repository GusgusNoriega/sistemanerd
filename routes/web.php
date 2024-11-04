<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::middleware('auth.token')->get('/verify-token', function () {
    return response()->json(['status' => 'Token válido'], 200);
});
// Ruta protegida para la página de inicio
Route::get('/inicio', function () {
    return view('pages.home');
});
