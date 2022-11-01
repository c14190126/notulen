<?php

use App\Http\Controllers\KlienController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotesNotulenController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Models\Perusahaan;
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

Route::get('/', [NotulenController::class, 'index'])->middleware('auth:user,klien');
Route::get('/list-notulen-acc', [NotulenController::class, 'indexacc'])->middleware('auth:user,klien');
Route::post('/create-notulen', [NotulenController::class, 'store']);
Route::post('/get-url', [NotulenController::class, 'getURL']);
Route::post('/get-user', [NotulenController::class, 'getUser']);
Route::post('/get-revisi', [NotulenController::class, 'getRevisi']);
Route::get('/add-notulen', [NotulenController::class, 'indexAdd'])->middleware('auth:user');
Route::post('/send-wa', [NotulenController::class, 'send_wa'])->middleware('auth:user');

Route::get('/notulen/{id}', [NotulenController::class, 'show']);
Route::delete('/notulen/{notulen:id}', [NotulenController::class, 'destroy']);
Route::get('/notulen/{notulen:id}/edit', [NotulenController::class, 'edit'])->middleware('auth:user,klien');
Route::put('/edit-notulen/{notulen:id}', [NotulenController::class, 'update']);
Route::post('/notulen/{id}/edit/add-catatan', [NotesNotulenController::class, 'store']);

Route::get('/daftar-klien', [KlienController::class, 'indexdaftar'])->middleware('auth:user');
Route::get('/add-klien', [KlienController::class, 'indexadd'])->middleware('auth:user');
Route::post('/add-klien', [KlienController::class, 'store']);
Route::post('/edit-klien/{klien:id}', [KlienController::class, 'update']);
Route::delete('/klien/{klien:id}', [KlienController::class, 'destroy']);
Route::put('/klien-edit/{klien:id}', [KlienController::class, 'edit']);
Route::get('/change-password', [KlienController::class, 'changePassword']);
Route::post('/change-password/{id}', [KlienController::class, 'updatePassword']);

Route::get('/daftar-perusahaan', [PerusahaanController::class, 'index'])->middleware('auth:user');
Route::get('/add-perusahaan', [PerusahaanController::class, 'indexAdd'])->middleware('auth:user');
Route::post('/add-perusahaan', [PerusahaanController::class, 'store']);
Route::post('/edit-perusahaan/{perusahaan:id}', [PerusahaanController::class, 'update']);
Route::delete('/perusahaan/{perusahaan:id}', [PerusahaanController::class, 'destroy']);
Route::put('/perusahaan-edit/{perusahaan:id}', [PerusahaanController::class, 'edit']);

Route::get('/add-user', [UserController::class, 'indexadd'])->middleware('auth:user');
Route::get('/daftar-user', [UserController::class, 'indexdaftar'])->middleware('auth:user');
Route::post('/add-user', [UserController::class, 'store']);
Route::delete('/user/{user:id}', [UserController::class, 'destroy']);
Route::get('/user-change-password', [UserController::class, 'changePassword']);
Route::post('/user-change-password/{id}', [UserController::class, 'updatePassword']);
Route::put('/user-edit/{user:id}', [UserController::class, 'edit']);
Route::post('/edit-user/{user:id}', [UserController::class, 'update']);

// Route::get('/change-password', [UserController::class, 'change_password']);
// Route::post('/change-password', [UserController::class, 'update_password']);
