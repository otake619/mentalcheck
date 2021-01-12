<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Log extends Model
{
    use HasFactory;

    //指定した日にちのログを全て検索して返す
    public function search_log(int $user_id, string $search_day)
    {
        $search_day = new Carbon($search_day);
        $logs = Log::whereDate('created_at', $search_day)->where('user_id', '=', $user_id)->get();
        return $logs;
    }

    //ログがあった日にちを取得
    public function get_date(int $user_id)
    {
        $logs = Log::where('user_id', $user_id)->where('medicine_check', '=', 1)->select('created_at')->get();
        return $logs;
    }

    public function ajax_get_logs(int $user_id, int $display_time)
    {
        $display_time = $display_time * 24;
        if($display_time >= 0){
            //一日後、二日後・・・
            $start_time = $display_time - 24;
            $from = date("Y-m-d H:i:s", strtotime("{$start_time} hour"));
            $until = date("Y-m-d H:i:s", strtotime("{$display_time} hour"));
            $logs = Log::whereBetween("created_at", [$from, $until])
                        ->where('user_id', '=', $user_id)
                        ->orderBy('created_at', 'asc')
                        ->get();
        } else {
            //一日前、二日前・・・
            $end_time = $display_time + 24;
            $from = date("Y-m-d H:i:s", strtotime("{$display_time} hour"));
            $until = date("Y-m-d H:i:s", strtotime("{$end_time} hour"));
            $logs = Log::whereBetween("created_at", [$from, $until])
                        ->where('user_id', '=', $user_id)
                        ->orderBy('created_at', 'asc')
                        ->get();
        }

        return $logs;
    }

    //1日のログ-24時間あたりのログの平均値を求めて出力する
    public function show_day(int $user_id)
    {   
        $from = date("Y-m-d H:i:s", strtotime("-23 hour"));
        $until = date("Y-m-d H:i:s", strtotime("now"));
        $logs = Log::whereBetween("created_at", [$from, $until])
                    ->where('user_id', '=', $user_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        return $logs;
    }

    //1週間のログ-7日あたりのログの平均値を求めて出力する
    public function show_week(int $user_id)
    {   
        $logs = [];
        for($day=-6;$day<=0;$day++){
            $eachDay = date("Y-m-d", strtotime("{$day} day"));
            $getMentalPoint = Log::where('created_at','like', "%$eachDay%")->where('user_id', '=', $user_id)->avg('mental_point');
            $log = array('mental_point'=>$getMentalPoint, 'created_at'=>$eachDay);
            array_push($logs, $log);
        }
        return $logs;
    }

    //1ヵ月のログ-1ヵ月当たりのログの平均値を求めて出力する
    public function show_month(int $user_id)
    {   
        $logs = [];
        for($week=-3;$week<=0;$week++){
            $eachWeek = date("Y-m-d", strtotime("{$week} week"));
            $getMentalPoint = Log::where('created_at','like', "%$eachWeek%")->where('user_id', '=', $user_id)->avg('mental_point');
            if($week === 0){
                $eachWeek = '今週';
            } else {
                $eachWeek = abs($week) . '週間前';
            }
            $log = array('mental_point'=>$getMentalPoint, 'created_at'=>$eachWeek);
            array_push($logs, $log);
        }
        return $logs;
    }

    //1年分のログ-1年当たりのログの平均値を求めて出力する
    public function show_year(int $user_id)
    {   
        $logs = [];
        for($month=-11;$month<=0;$month++){
            $eachMonth = date("Y-m-d", strtotime("{$month} month"));
            $getMentalPoint = Log::where('created_at','like', "%$eachMonth%")->where('user_id', '=', $user_id)->avg('mental_point');
            $eachMonth = mb_substr($eachMonth, 0, 7);
            $log = array('mental_point'=>$getMentalPoint, 'created_at'=>$eachMonth);
            array_push($logs, $log);
        }
        return $logs;
    }

    public function store(int $user_id, int $mental_point, bool $medicine_check, string $comment)
    {
        $this->user_id = $user_id;
        $this->mental_point = $mental_point;
        $this->medicine_check = $medicine_check;
        $this->comment = $comment;
        $this->save();
    }

    public function update_log(int $user_id, int $mental_point, bool $medicine_check, string $comment, string $created_at)
    {
        // $created_at = date('Y-m-d H:i:s', strtotime($created_at));
        // Log::where('user_id', $user_id)
        // ->where('created_at', $created_at)
        // ->update([
        //     'mental_point' => $mental_point,
        //     'medicine_check' => $medicine_check,
        //     'comment' => $comment,
        //     'updated_at' => date('Y-m-d H:i:s')
        // ]);
        // $created_at = Date('Y-m-d H:i:s', strtotime($created_at));
        // $created_at = $created_at->format('Y-m-d H:i:s');
        $log = Log::where('user_id', $user_id)
        ->where('created_at',"$created_at")
        ->first();
        $log->mental_point = $mental_point;
        $log->medicine_check = $medicine_check;
        $log->comment = $comment;
        $log->updated_at = date('Y-m-d H:i:s');
        $log->save();
    }

    public function get_logs(int $user_id, string $search_day)
    {
        $search_day = new Carbon($search_day);
        $logs = Log::whereDate('created_at', $search_day)
        ->where('user_id', '=', $user_id)
        ->orderBy('created_at', 'asc')
        ->get();
        return $logs;
    }

    public function get_info(int $user_id, string $created_at)
    {
        $created_at_tmp = new Carbon($created_at);
        $log_info = Log::where('created_at', $created_at_tmp)
        ->where('user_id', $user_id)
        ->get();
        return $log_info;
    }
}
