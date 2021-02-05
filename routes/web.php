<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;

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

Route::get('/', [LogController::class, 'get_home'])->name('home');
// Route::get('/', function () {
//     return view('auth.login');
// });

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
    Route::get('account-info', [UserController::class, 'account_info'])->name('account-info');
    //アカウント削除画面を表示
    Route::get('get-delete', [UserController::class, 'get_delete'])->name('get-delete');
    //アカウントを更新
    Route::post('update', [UserController::class, 'update'])->name('update');
    //アカウントを削除
    Route::post('delete', [UserController::class, 'delete'])->name('delete');
});