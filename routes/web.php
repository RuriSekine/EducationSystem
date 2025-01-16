<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\TopController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\DeliveryController;
use App\Http\Controllers\User\ProgressController;
use App\Http\Controllers\User\Curriculum_listController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CurriculumController;

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

Route::get('/', function () {
    return redirect()->route('user.login');
});


//bannerの画像が表示されるか確認するために担当ではないですが一応設定をおこなっています。
Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::get('/banner_edit', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('show.banner.edit');
    Route::post('banner_store',[App\Http\Controllers\Admin\BannerController::class, 'store'])->name('store.banner');
    });


Route::prefix('user')->namespace('User')->name('user.')->group(function () {
Route::get('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',[App\Http\Controllers\User\Auth\LoginController::class, 'login'])->name('login.post');
Route::post('/logout',[App\Http\Controllers\User\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',[App\Http\Controllers\User\Auth\RegisterController::class, 'register'])->name('register.post');
Route::get('/top', [App\Http\Controllers\User\TopController::class, 'index'])->name('show.top');
//トップ画面が未ログイン状態で共通ヘッダーの表記とお知らせ一覧の動きと表示を調査するためにauthの外に配置

Route::middleware(['auth'])->group(function () {
Route::get('/article/{id}', [App\Http\Controllers\User\ArticleController::class, 'show'])->name('show.article');
Route::get('/curriculum_list', [App\Http\Controllers\User\Curriculum_listController::class, 'index'])->name('show.curriculum');
Route::get('/progress', [App\Http\Controllers\User\ProgressController::class, 'index'])->name('show.progress');
Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('show.profile');
Route::get('/delivery/{id}', [App\Http\Controllers\User\DeliveryController::class, 'index'])->name('show.delivery');
Route::post('/delivery/{id}/complete', [App\Http\Controllers\User\DeliveryController::class, 'completeCurriculum'])->name('complete.delivery');
});
});
