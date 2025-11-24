<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PcBuildController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/parts', [PartController::class, 'index'])->name('parts');

Route::get('/pcbuild', [PcBuildController::class, 'index'])->name('pcbuild');

Route::post('/pcbuild/add', [PcBuildController::class, 'add'])->name('pcbuild.add');

Route::post('/pcbuild/remove', [PcBuildController::class, 'remove'])->name('pcbuild.remove');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
