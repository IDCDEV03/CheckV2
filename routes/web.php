<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\User\AgencyMainController;
use App\Http\Controllers\User\UserMainController;
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


Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    //module
    Route::get('/announcement', [AdminDashboardController::class, 'AnnouncementPage'])->name('admin.announce');
    Route::get('/create_post', [AdminDashboardController::class, 'create_announce'])->name('admin.create_post');
    Route::post('/insert_post', [AdminDashboardController::class, 'insert_post'])->name('admin.insert_post');
    //edit-update-delete_post
    Route::get('/announce/{id}/edit', [AdminDashboardController::class, 'edit_post'])->name('admin.edit_post');
    Route::post('/announce-update/{id}', [AdminDashboardController::class, 'update_post'])->name('admin.update_post');
    Route::get('/announce-delete/{id}/file', [AdminDashboardController::class, 'delete_file'])->name('admin.delete_file');
     Route::get('/announce-delete/{id}/post', [AdminDashboardController::class, 'delete_post'])->name('admin.delete_post');
});

Route::prefix('user')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/home', [PageController::class, 'home'])->name('local.home');

    Route::get('/check/start/{id}', [UserMainController::class, 'start_check'])->name('user.chk_start');
});

Route::prefix('agency')->middleware(['auth', 'role:agency'])->group(function () {
    Route::get('/dashboard', [PageController::class, 'home'])->name('agency.index');
    Route::get('/main', [AgencyMainController::class, 'main_page'])->name('agency.main');

    //ฟอร์ม
    Route::get('/form', [AgencyMainController::class, 'form_list'])->name('agency.form_list');
    Route::get('/create-form', [AgencyMainController::class, 'form_create'])->name('agency.create_form');
    Route::post('/insert_form', [AgencyMainController::class, 'form_insert'])->name('agency.insert_form');

    //หมวดหมู่
    Route::get('/chk-categories/{form_id}', [AgencyMainController::class, 'cates_list'])->name('agency.cates_list');
    Route::get('/chk-cates-create/{id}', [AgencyMainController::class, 'create_cates'])->name('agency.create_cates');
    Route::post('/insert_cates/{id}', [AgencyMainController::class, 'insert_cates'])->name('agency.insert_cates');
    Route::get('/categories/{cates_id}', [AgencyMainController::class, 'cates_detail'])->name('agency.cates_detail');

    //ข้อตรวจ
    Route::get('/item-new/{id}', [AgencyMainController::class, 'item_create'])->name('agency.item_create');
    Route::post('/insert-item', [AgencyMainController::class, 'item_insert'])->name('agency.item_insert');
    Route::get('/item-edit/{id}', [AgencyMainController::class, 'item_edit'])->name('agency.item_edit');
    Route::post('/item-update', [AgencyMainController::class, 'item_update'])->name('agency.item_update');
    Route::get('/item-delete/{id}/image', [AgencyMainController::class, 'item_delete_image'])->name('agency.item_delete_image');

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
