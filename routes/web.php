<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\MyFileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SharedFileController;
use App\Http\Controllers\TrashController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/myfiles', [MyFileController::class, 'index'])->name('myfiles');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::get('/sharedfiles', [SharedFileController::class, 'index'])->name('sharedfiles');
    Route::get('/trash', [TrashController::class, 'index'])->name('trash');

});


//TODO:create a Route group for crud files
Route::post('/create-file', [FileController::class, 'saveFile'])->name('savefile');
Route::get('/file/{path}', [MyFileController::class, 'directory'])->name('directory');


//rename
Route::post('/rename/{file}', [MyFileController::class, 'rename'])->name('rename');
//trash
Route::delete('/delete/{file}', [MyFileController::class, 'destroy'])->name('trash');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
