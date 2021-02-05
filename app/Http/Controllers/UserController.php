<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //ログアウト画面に遷移
    public function get_logout()
    {
        return view('mentalcheckapp.logout');
    }
    //ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    //ユーザー情報を取得して、登録情報画面を返す
    public function get_account_info()
    {
        $user_id = Auth::id();
        $user_info = $this->user->get_info($user_id);
        return view('mentalcheckapp.account_info', compact('user_info'));
    }
}
