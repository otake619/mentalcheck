<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;

Route::get('/', [LogController::class, 'get_home'])->name('home')->middleware('auth');
// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/toppage', [UserController::class, 'toppage']);

Route::post('/', [LogController::class, 'home_post'])->name('home-post');

Route::post('/comment/{searchDay}', [LogController::class, 'get_comment']);
Route::get('/comment/{searchDay}', [LogController::class, 'get_logs'])->name('get-logs');

Route::get('/calendar', [LogController::class, 'get_calendar'])->name('calendar');
// Route::post('/calendar/{sendDay}', [LogController::class, 'get_calendar']);

Route::prefix('log')->group(function(){
    //不調理由をデータベースに保存
    Route::post('store', [LogController::class, 'store'])->name('store-data');
    //不調理由をデータベースに保存
    Route::get('store', [LogController::class, 'store'])->name('store');
    //ログを編集・更新
    Route::post('update', [LogController::class, 'update'])->name('update');
    //ログを編集・更新
    Route::post('ajax-info', [LogController::class, 'ajax_info'])->name('ajax-info');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    [UserController::class, 'login'];
})->name('dashboard');

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
Route::prefix('user')->group(function(){
    //ログアウト画面に遷移
    Route::get('get-logout', [UserController::class, 'get_logout'])->name('get-logout');
    //ログアウト処理
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    //アカウント情報を表示
    Route::get('account-info', [UserController::class, 'get_account_info'])->name('account-info');
    //アカウント削除画面を表示
    Route::get('get-delete', [UserController::class, 'get_delete'])->name('get-delete');
    //アカウントを更新
    Route::post('update', [UserController::class, 'update'])->name('update-account');
    //アカウントを削除
    Route::post('delete-account', [UserController::class, 'delete_account'])->name('delete-account');
    //アカウント削除後
    Route::get('done-delete', function(){
        view('mentalcheckapp.done_delete');
    });
});