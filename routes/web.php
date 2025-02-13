<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\DeliveryController;


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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // 授業一覧画面
    Route::get('/curriculum_list', [CurriculumController::class, 'showCurriculumList'])->name('curriculum.list');

    // 授業新規登録画面
    Route::get('/curriculum_create', [CurriculumController::class, 'showCurriculumCreate'])->name('curriculum.create');

    // 授業新規登録処理
    Route::post('/curriculum_Regist', [CurriculumController::class, 'CurriculumRegist'])->name('curriculum.Regist');

    // 授業編集画面
    Route::get('/curriculum_edit/{id}', [CurriculumController::class, 'showCurriculumEdit'])->name('curriculum.edit');

    // 授業更新処理
    Route::put('/curriculum_update/{id}', [CurriculumController::class, 'CurriculumUpdate'])->name('curriculum.update');

    // 配信日時設定画面
    Route::get('/delivery_edit/{id}', [DeliveryController::class, 'showDeliveryEdit'])->name('delivery.edit');

    // 配信日時設定登録処理
    Route::post('/delivery_update/{id}', [DeliveryController::class, 'updateDelivery'])->name('delivery.update');
});

