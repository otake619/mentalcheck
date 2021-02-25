<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    private $log;

    public function __construct(Log $log)
    {
        //認証チェック
        $this->middleware('auth');
        $this->log = $log;
    }

    public function get_home()
    {
        $is_posted = 0;
        return view('mentalcheckapp.home', compact('is_posted'));
    }

    //calendar画面を返す
    public function display_calendar()
    {
        $user_id = Auth::id();
        $logs = $this->log->get_date($user_id);
        return view('mentalcheckapp.fullcalendar', compact('logs'));
    }
    //ホーム画面でログをPOST
    public function log_post()
    {
        $is_posted = 1;
        return view('mentalcheckapp.comment', compact('is_posted'));
    }

    //ログをデータベースに格納
    public function store(Request $request)
    {
        //バリデーション。入力値がルールに沿っているかチェック。
        $validator = $request->validate([
            'mental_point' => 'required|between:1,5|numeric',
            'medicine_check' => 'required|boolean',
            'comment' => 'required|max:200',
        ]);

        $is_posted = 1;
        $user_id = Auth::id();
        $mental_point = $request->input('mental_point');
        $medicine_check = $request->input('medicine_check');
        $comment = $request->input('comment');
        $logs = $this->log->store($user_id, $mental_point, $medicine_check, $comment);
        $request->session()->regenerateToken();
        return view('mentalcheckapp.home', compact('is_posted'));
    }

    //ログを更新
    public function update(Request $request)
    {
        //バリデーション。入力値がルールに沿っているかチェック。
        $validated = $request->validate([
            'mental_point' => 'required|digits_between:1,5',
            'medicine_check' => 'required',
            'comment' => 'required|max:200',
        ]);

        $is_posted = 1;
        $user_id = Auth::id();
        $mental_point = $request->input('mental_point');
        $medicine_check = $request->input('medicine_check');
        $comment = $request->input('comment');
        $day = $request->input('day');
        $created_at = $request->input('created_at');
        $logs = $this->log->update_log($user_id, $mental_point, $medicine_check, $comment, $created_at);
        $request->session()->regenerateToken();
        return redirect()->route('display-logs', ['searchDay' => $day])->with('is_posted', 1);
    }

    public function display_logs($searchDay)
    {
        //正規表現。カレンダー画面でのルーティングで、
        //日にち以外の形式が入力された場合はカレンダー画面へリダイレクト
        if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $searchDay)){
             //TODO: 後で必ず調整
            $user_id = Auth::id();
            $logs = $this->log->get_logs($user_id, $searchDay);
            return view('mentalcheckapp.logs', compact('logs', 'searchDay'));
        } else {
            return redirect('/calendar');
        }
    }
}
