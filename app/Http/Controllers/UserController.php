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
        $is_posted = 0;
        return view('mentalcheckapp.account_info', 
            compact('user_info', 'is_posted'));
    }

    //ユーザー情報をアップデート
    public function update(Request $request)
    {
        $user_name = $request->input('name');
        $update_info = $this->user->update_info($user_name);
        $is_posted = 1;
        $user_info = $this->user->get_info(Auth::id());
        $request->session()->regenerateToken();
        return view('mentalcheckapp.account_info',
            compact('user_info', 'is_posted'));
    }
}
