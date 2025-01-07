<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\ManufacturerController; 

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
    
    //ユーザーをログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    //新規登録フォーム表示
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('show.register');
    //新規登録処理
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    
});