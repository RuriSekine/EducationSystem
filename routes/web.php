<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\TopController;
use App\Http\Controllers\User\ArticleController as UserArticleController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\User\DeliveryController;
use App\Http\Controllers\User\ProgressController;
use App\Http\Controllers\User\Curriculum_listController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\Auth\LoginController as UserLoginController; 
use App\Http\Controllers\Admin\Auth\RegisterController as AdminRegisterController;
use App\Http\Controllers\User\Auth\RegisterController as UserRegisterController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\User\CurriculumController as UserCurriculumController;
use App\Http\Controllers\Admin\CurriculumController as AdminCurriculumController;

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

/*
//bannerの画像が表示されるか確認するために担当ではないですが一応設定をおこなっています。
Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::get('/banner_edit', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('show.banner.edit');
    Route::post('banner_store',[App\Http\Controllers\Admin\BannerController::class, 'store'])->name('store.banner');
    });
*/

Route::prefix('user')->namespace('User')->name('user.')->group(function () {
Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',[UserLoginController::class, 'login'])->name('login.post');
Route::post('/logout',[UserLoginController::class, 'logout'])->name('logout');
Route::get('/register', [UserRegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',[UserRegisterController::class, 'register'])->name('register.post');
Route::get('/top', [UserArticleController::class, 'index'])->name('top.index');

Route::middleware(['auth:user'])->group(function () {
// 記事・カリキュラム・進捗画面
Route::get('/curriculum_list', [UserCurriculumController::class, 'index'])->name('show.curriculum');
Route::get('/progress', [App\Http\Controllers\User\ProgressController::class, 'index'])->name('show.progress');
Route::get('/article/{id}', [UserArticleController::class, 'show'])->name('show.article');

Route::get('/curriculum/{id}', [DeliveryController::class, 'show'])->name('show.curriculum');
Route::post('/curriculum/{id}/complete', [DeliveryController::class, 'complete'])->name('curriculum.complete');
// プロフィール編集
Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'edit'])->name('edit.profile');
Route::put('/profile', [App\Http\Controllers\User\ProfileController::class, 'update'])->name('update.profile');

// パスワード変更
Route::get('/profile/password_edit', [App\Http\Controllers\User\ProfileController::class, 'editPassword'])->name('edit.password');
Route::put('/profile/password_edit', [App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('password.update');
});
});

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::get('/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.post');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/curriculum/create', [AdminCurriculumController::class, 'create'])->name('curriculum.create');
        Route::post('/curriculum/store', [AdminCurriculumController::class, 'store'])->name('curriculum.store');
        // 記事の一覧表示
        Route::get('/article', [AdminArticleController::class, 'index'])->name('articles.index');
        // 記事作成/編集
        Route::get('/article/edit/{id?}', [AdminArticleController::class, 'edit'])->name('article.edit');
        // 記事の保存 (新規作成と更新)
        Route::post('/article', [AdminArticleController::class, 'store'])->name('article.store');
        // 記事の更新
        Route::put('/article/{id}', [AdminArticleController::class, 'update'])->name('article.update');
        // 記事の削除
        Route::delete('/article/{id}', [AdminArticleController::class, 'destroy'])->name('article.destroy');
    });
});