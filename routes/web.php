<?php

use App\Http\Controllers\KlienController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/', [NotulenController::class, 'index'])->middleware('auth');
Route::post('/create-notulen', [NotulenController::class, 'store']);
Route::post('/get-url', [NotulenController::class, 'getURL']);
Route::post('/get-user', [NotulenController::class, 'getUser']);
Route::get('/add-notulen', [NotulenController::class, 'indexAdd'])->middleware('auth');

Route::get('/notulen/{id}', [NotulenController::class, 'show']);
Route::delete('/notulen/{notulen:id}', [NotulenController::class, 'destroy']);
Route::get('/notulen/{notulen:id}/edit', [NotulenController::class, 'edit']);
Route::put('/edit-notulen/{notulen:id}', [NotulenController::class, 'update']);

Route::get('/daftar-klien', [KlienController::class, 'indexdaftar'])->middleware('auth');
Route::get('/add-klien', [KlienController::class, 'indexadd'])->middleware('auth');
Route::post('/add-klien', [KlienController::class, 'store']);
Route::delete('/klien/{klien:id}', [KlienController::class, 'destroy']);

Route::get('/add-user', [UserController::class, 'indexadd'])->middleware('auth');
Route::get('/daftar-user', [UserController::class, 'indexdaftar'])->middleware('auth');
Route::post('/add-user', [UserController::class, 'store']);
Route::delete('/user/{user:id}', [UserController::class, 'destroy']);

// Route::get('/change-password', [UserController::class, 'change_password']);
// Route::post('/change-password', [UserController::class, 'update_password']);
