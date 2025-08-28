<?php

use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserNotificationController;
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


Route::middleware('auth')->group(function () {
    // Impersonation
    Route::get('impersonate/stop', [ImpersonationController::class, 'stop'])->name('impersonate.stop');

    // Admin-only
    Route::middleware('admin')->group(function () {
        Route::post('impersonate/{user}', [ImpersonationController::class, 'start'])->name('impersonate.start');

        // Users
        Route::resource('users', UserController::class)->only('index');

        // Admin Notifications
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('notifications', AdminNotificationController::class);
        });
    });

    // User Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [UserNotificationController::class, 'index'])->name('index');
        Route::post('mark-read', [UserNotificationController::class, 'markRead'])->name('mark-read');
    });
});

require __DIR__ . '/auth.php';
