<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::get('/my-clients/{user_id?}', [UserController::class, 'users'])->name('my-clients');

    Route::resource('profile', ProfileController::class);
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin/user-childs/{user_id?}', [AdminController::class, 'adminUser'])->name('admin.user');
    Route::resource('administration', AdminController::class);

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});
require __DIR__.'/auth.php';
