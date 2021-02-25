<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;

//ログイン前のトップページへ遷移
Route::get('/', function() {
    return view('mentalcheckapp.toppage');
});
//ホーム画面へ遷移
Route::get('/home', [LogController::class, 'get_home'])->name('home');
//ホーム画面でログをPOST
Route::post('/home', [LogController::class, 'log_post'])->name('log-post');
//トップページでログイン画面を返す
Route::get('/login-view', function() {
    return view('auth.login');
})->name('login-view');
//トップページで新規登録画面を返す
Route::get('/register-view', function() {
    return view('auth.register');
})->name('register-view');

//選択した日にちのログを返す
Route::get('/select-day/{searchDay}', [LogController::class, 'display_logs'])->name('display-logs');
//カレンダー画面を返す
Route::get('/calendar', [LogController::class, 'display_calendar'])->name('calendar');
//ログに関するルーティング
Route::prefix('log')->group(function(){
    //不調理由をデータベースに保存
    Route::post('store', [LogController::class, 'store'])->name('store-data');
    //ログを編集・更新
    Route::post('update', [LogController::class, 'update'])->name('update');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

//アカウント、および認証に関するルーティング
Route::prefix('user')->group(function(){
    //ログアウト画面に遷移
    Route::get('get-logout', [UserController::class, 'get_logout'])->name('get-logout');
    //ログアウト処理
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    //アカウント情報を表示
    Route::get('account-info', [UserController::class, 'get_account_info'])->name('account-info');
    //アカウント削除画面を表示
    Route::get('display-delete', function() {
        return view('mentalcheckapp.delete_form');
    })->name('display-delete');
    //アカウントを更新
    Route::post('update', [UserController::class, 'update'])->name('update-account');
    //アカウントを削除
    Route::post('delete-account', [UserController::class, 'delete_account'])->name('delete-account');
    //アカウント削除後
    Route::get('done-delete', function(){
        view('mentalcheckapp.done_delete');
    });
});