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
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $user_name = $request->input('name');
        $update_info = $this->user->update_info($user_name);
        $is_posted = 1;
        $user_info = $this->user->get_info(Auth::id());
        $request->session()->regenerateToken();
        return view('mentalcheckapp.account_info',
            compact('user_info', 'is_posted'));
    }

    public function get_delete()
    {
        return view('mentalcheckapp.delete_form');
    }

    public function delete_account(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');
        if($email === Auth::user()->email){
            //入力したメールアドレスが合っていて、退会処理を実行する
            //退会処理を行った後、ログアウト→退会後画面へリダイレクトする
            $delete_account = $this->user->delete_account();
            Auth::logout();
            return redirect('/');
        } else {
            //入力したメールアドレスが間違っていた場合
            //TODO バリデーションを行う
            return view('mentalcheckapp.delete_form');
        }
    }
}
