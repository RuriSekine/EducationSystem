<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\ManufacturerController; 
use App\Http\Controllers\Admin\Auth\HomeController;
use App\Http\Controllers\Admin\TopController;
use App\Http\Controllers\Admin\BannerController;

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
    return view('welcome');
});

Auth::routes();

//管理者用
Route::prefix('admin')->namespace('Admin\Auth')->name('admin.')->group(function () {

    //ログインフォーム表示
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('show.login');
    //ログイン処理
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    //ログインが成功時
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    //ユーザーをログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    //新規登録フォーム表示
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('show.register');
    //新規登録処理
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    //未ログインユーザーが下記ルートにアクセスしようとすると自動的にログインページにリダイレクト
    Route::middleware('auth:admin')->group(function () {
    //トップ画面
        Route::get('/top', [TopController::class, 'showTop'])->name('show.top');
    //バナー管理
        Route::get('/banner_edit', [BannerController::class, 'showBannerEdit'])->name('show.banner.edit');
    //バナー登録
        Route::post('/banner_update', [BannerController::class, 'BannerUpdate'])->name('banner.update');
    //仮
        Route::get('/curriculum_list', function() {
            return '授業管理ページ作成中';
        })->name('show.curriculum.list');
        Route::get('/article_list', function() {
            return 'お知らせ管理ページ作成中';
        })->name('show.article.list');
        
    });
});