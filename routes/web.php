<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FavoriteController;

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

Route::get('/dashboard', [BukuController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // searching
    Route::get('buku/search', [BukuController::class, 'search'])->name('buku.search');
    // detail buku
    Route::get('/detail-buku/{title}', [BukuController::class, 'galBuku'])->name('galeri.buku');
    // rate buku
    Route::post('/buku/rate/{id}', [BukuController::class, 'rate'])->name('buku.rate');
    // favorites
    Route::post('/buku/favorites/{id}', [BukuController::class, 'addToFavorites'])->name('buku.favorite');
    Route::get('/buku/myfavorite', [FavoriteController::class, 'index'])->name('favorites.index');
    
    Route::middleware('admin')->group(function () {
        // menambah buku
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        // menghapus buku
        Route::post('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
        // update/edit buku
        Route::get('buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
        // menghapus gambar di galeri
        Route::get('/gallery/delete/{id}', [BukuController::class, 'deleteGallery'])->name('buku.deleteGallery');
        // store update
        Route::post('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
    });
    
});

// list buku
Route::get('/buku/list', [BukuController::class, 'listBuku'])->name('buku.list');
// detail buku
// Route::get('/detail-buku/{title}', [BukuController::class, 'galBuku'])->name('galeri.buku');

require __DIR__.'/auth.php';