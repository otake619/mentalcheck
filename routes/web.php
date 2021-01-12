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

Route::post('/', [LogController::class, 'home_post'])->name('home-post');

Route::post('/comment/{searchDay}', [LogController::class, 'get_comment']);
Route::get('/comment/{searchDay}', [LogController::class, 'get_logs']);

Route::get('/calendar', [LogController::class, 'get_calendar'])->name('calendar');
// Route::post('/calendar/{sendDay}', [LogController::class, 'get_calendar']);

Route::prefix('log')->group(function(){
    //不調理由をデータベースに保存
    Route::post('store', [LogController::class, 'store'])->name('store');
    //不調理由をデータベースに保存
    Route::get('store', [LogController::class, 'store'])->name('store');
});

Route::prefix('graph')->group(function(){
    //グラフ画面でログを図式化して表示(24時間)
    Route::get('show-day', [LogController::class, 'show_day'])->name('log-show-day');
    //ajaxを使用して24時間を超えた範囲のグラフを表示
    Route::get('show-day/ajax-get-logs/{displayTime}', [LogController::class, 'ajax_get_logs'])->name('ajax-get-logs');
    //グラフ画面でログを図式化して表示(1週間)
    Route::get('show-week', [LogController::class, 'show_week'])->name('log-show-week');
    //グラフ画面でログを図式化して表示(1ヵ月)
    Route::get('show-month', [LogController::class, 'show_month'])->name('log-show-month');
    //グラフ画面でログを図式化して表示(1年)
    Route::get('show-year', [LogController::class, 'show_year'])->name('log-show-year');
});
