<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    private $log;

    public function __construct(Log $log)
    {
        $this->middleware('auth');
        $this->log = $log;
    }

    //精神状態をデータベースに追加
    public function store_mental(Request $request)
    {   
        $is_posted = 1;
        //TODO: 後で必ず修正する
        $user_id = 1;
        $mental_point = $request->input('mental_check');
        $this->log->store_mental($user_id, $mental_point);
        return view('mentalcheckapp.home', compact('is_posted'));
    }

    //服薬状況をデータベースに追加
    public function store_medicine(Request $request)
    {
        $is_posted = 1;
        //TODO: 後で必ず修正する
        $user_id = 1;
        $medicine_check = $request->input('medicine_check');
        $this->log->store_medicine($user_id, $medicine_check);
        return view('mentalcheckapp.home', compact('is_posted'));
    }

    public function get_home()
    {
        $is_posted = 0;
        return view('mentalcheckapp.home', compact('is_posted'));
    }

    //不調理由をデータベースに追加
    public function store_comment(Request $request)
    {
        $is_posted = 1;
        //TODO: 後で必ず修正する
        $user_id = 1;
        $comment = $request->input('comment');
        $this->log->store_comment($user_id, $comment);
        return view('mentalcheckapp.home', compact('is_posted'));
    }

    //calendar画面を返す
    public function get_calendar()
    {
        //TODO：後で変更する
        $user_id = 1;
        $logs = $this->log->get_date($user_id);
        return view('mentalcheckapp.fullcalendar', compact('logs'));
    }

    public function get_comment($searchDay)
    {
        //TODO: 後で必ず調整
        $user_id = 1;
        $logs = $this->log->search_log($user_id, $searchDay);
        return view('mentalcheckapp.comment', compact('logs', 'searchDay'));
    }

    public function home_post()
    {
        $is_posted = 1;
        return view('mentalcheckapp.comment', compact('is_posted'));
    }

    //24時間単位でのグラフの表示
    public function show_day()
    {
        //TODO: 後で必ず調整
        $user_id = 1;
        $logs = $this->log->show_day($user_id);
        return view('mentalcheckapp.day_graph', compact('logs'));
    }

    public function ajax_get_logs(Request $request)
    {
        $display_time = $request->input('displayTime');
        //TODO: 後で必ず調整
        $user_id = 1;
        $logs = $this->log->ajax_get_logs($user_id, $display_time);
        return response()->json($logs);
    }
    //1週間単位でのグラフの表示
    public function show_week()
    {
        //後で必ず変更
        $user_id = 1;
        $logs = $this->log->show_week($user_id);
        return view('mentalcheckapp.week_graph', compact('logs'));
    }

    //1カ月単位でのグラフの表示
    public function show_month()
    {
        //後で必ず変更
        $user_id = 1;
        $logs = $this->log->show_month($user_id);
        return view('mentalcheckapp.month_graph', compact('logs'));
    }
    
    //1年単位でのグラフの表示
    public function show_year()
    {
        //後で必ず変更
        $user_id = 1;
        $logs = $this->log->show_year($user_id);
        return view('mentalcheckapp.year_graph', compact('logs'));
    }

    //1年単位でのグラフの表示
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mental_point' => 'required|digits_between:1,5',
            'medicine_check' => 'required',
            'comment' => 'required|max:200',
        ]);

        $is_posted = 1;
        //後で必ず変更
        $user_id = 1;
        $mental_point = $request->input('mental_point');
        $medicine_check = $request->input('medicine_check');
        $comment = $request->input('comment');
        $logs = $this->log->store($user_id, $mental_point, $medicine_check, $comment);
        return view('mentalcheckapp.home', compact('is_posted'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'mental_point' => 'required|digits_between:1,5',
            'medicine_check' => 'required',
            'comment' => 'required|max:200',
        ]);

        $is_posted = 1;
        //後で必ず変更
        $user_id = 1;
        $mental_point = $request->input('mental_point');
        $medicine_check = $request->input('medicine_check');
        $comment = $request->input('comment');
        $day = $request->input('day');
        $created_at = $request->input('created_at');
        $logs = $this->log->update_log($user_id, $mental_point, $medicine_check, $comment, $created_at);
        return redirect()->route('get-logs', ['searchDay' => $day])->with('is_posted', 1);
    }

    public function get_logs($searchDay)
    {
        if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $searchDay)){
             //TODO: 後で必ず調整
            $user_id = 1;
            $logs = $this->log->get_logs($user_id, $searchDay);
            return view('mentalcheckapp.logs', compact('logs', 'searchDay'));
        } else {
            return redirect('/calendar');
        }
    }
    //$created_atで指定された時間のレコードを取得して返す
    public function ajax_info(Request $request)
    {
        $data = $request->all();
        $created_at = $data['created_at'];
        $user_id = 1;
        $log_info = $this->log->get_info($user_id, $created_at);
        return response()->json([
            'log_info' => $log_info,
        ]);
    }
}
