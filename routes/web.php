<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;

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

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    //module
    Route::get('/announcement', [AdminDashboardController::class, 'AnnouncementPage'])->name('admin.announce');
    Route::get('/create_post', [AdminDashboardController::class, 'create_announce'])->name('admin.create_post');
    Route::post('/insert_post', [AdminDashboardController::class, 'insert_post'])->name('admin.insert_post');
    //edit_post
    Route::get('/announce/{id}/edit', [AdminDashboardController::class, 'edit_post'])->name('admin.edit_post');
    Route::post('/announce-update/{id}', [AdminDashboardController::class, 'update_post'])->name('admin.update_post');
});

Route::prefix('user')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/home', [PageController::class, 'home'])->name('local.home');
});


Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
    Route::get('/register', [LoginController::class, 'showregisterForm'])->name('register');
});


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Route::post('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');
//Route::get('/lang/{lang}',[ LanguageController::class,'switchLang'])->name('switch_lang');
//Route::get('/pagination-per-page/{per_page}',[ PaginationController::class,'set_pagination_per_page'])->name('pagination_per_page');
