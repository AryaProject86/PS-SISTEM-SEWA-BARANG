<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PelangganController;

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard pelanggan (sementara)
Route::get('/dashboard', function () {
    return "Dashboard Pelanggan";
})->middleware('auth');

// Redirect root
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/kuitansi/{id}', 
    [PelangganController::class, 'kuitansi']
)->name('kuitansi')->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function(){
Route::get('/dashboard',[PelangganController::class,'dashboard']);
Route::get('/barang',[PelangganController::class,'barang']);

Route::get('/peminjaman',[PelangganController::class,'peminjamanIndex']);
Route::get('/peminjaman/create',[PelangganController::class,'peminjamanCreate']);
Route::post('/peminjaman',[PelangganController::class,'peminjamanStore']);

Route::get('/pengembalian',[PelangganController::class,'pengembalian']);
Route::post('/pengembalian/{id}',[PelangganController::class,'prosesPengembalian']);

Route::get('/laporan',[PelangganController::class,'laporan']);

});
