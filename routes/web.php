<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use \App\Http\Controllers\Admin\UserController;
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


define('PAGINATION_COUNT', 10);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/users/{user}/profile', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{user}/profile', [UserController::class, 'update'])->name('users.update');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('/categories', CategoryController::class);
    Route::resource('/posts', PostController::class);
    Route::get('/trashed-posts', [PostController::class, 'trashed'])->name('trashed.index');
    Route::get('/trashed-posts/{id}', [PostController::class, 'restore'])->name('trashed.restore');
    Route::resource('/tags', TagController::class);
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/make-admin', [UserController::class, 'makeAdmin'])->name('users.make-admin');
});


require __DIR__ . '/auth.php';
