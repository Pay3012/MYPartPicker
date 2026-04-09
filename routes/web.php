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

Route::post('/pcbuild/save', [PcBuildController::class, 'save'])->name('pcbuild.save')->middleware('auth');
Route::post('/pcbuild/decrement', [PcBuildController::class, 'decrement'])->name('pcbuild.decrement');
Route::post('/pcbuild/remove', [PcBuildController::class, 'remove'])->name('pcbuild.remove');

Route::get('/dashboard', function () {
    $builds = \App\Models\Pcbuild::where('user_id', auth()->id())
        ->with('parts')
        ->latest()
        ->get();
    return view('dashboard', compact('builds'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
