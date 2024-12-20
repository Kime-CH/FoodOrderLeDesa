<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\AdminController;

Route::get('/', [MenuController::class, 'index']);
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::post('/keranjang/kurang/{id}', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');
Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
Route::post('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
Route::post('/keranjang/lanjutkan-pembayaran', [KeranjangController::class, 'lanjutkanPembayaran'])->name('keranjang.lanjutkanPembayaran');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/pesan', [KeranjangController::class, 'index'])->name('pesan');

Route::get('/admin/menu/create', [AdminController::class, 'createMenu'])->name('menu.create');
Route::post('/admin/menu', [AdminController::class, 'storeMenu'])->name('menu.store');
Route::get('/admin/menu/{id}/edit', [AdminController::class, 'editMenu'])->name('menu.edit');
Route::put('/admin/menu/{id}', [AdminController::class, 'updateMenu'])->name('menu.update');
Route::delete('/admin/menu/{id}', [AdminController::class, 'destroyMenu'])->name('menu.destroy');


Route::group([], function () {
    Route::get('/cottage1', [MenuController::class, 'index']);
    Route::get('/cottage2', [MenuController::class, 'index']);
    Route::get('/cottage3', [MenuController::class, 'index']);
    Route::get('/pesan/cottage1', [KeranjangController::class, 'index'])->name('pesan');
    Route::get('/pesan/cottage2', [KeranjangController::class, 'index'])->name('pesan');
    Route::get('/pesan/cottage3', [KeranjangController::class, 'index'])->name('pesan');
});


//URL::forceScheme('https');