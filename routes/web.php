<?php

use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth','admin'])->group(function () {
    Route::resource('users', UserController::class)->only(['index']);
    Route::post('/impersonate/{user}', [ImpersonationController::class,'start'])->name('impersonate.start');
});
Route::get('/impersonate/stop', [ImpersonationController::class,'stop'])->middleware('auth')->name('impersonate.stop');

require __DIR__.'/auth.php';
