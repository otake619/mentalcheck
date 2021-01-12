<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/css/mdb.min.css" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- chart.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>ログ mentalcheckapp</title>
</head>
<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark primary-color">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="#">mentalcheckapp</a>
        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
        aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">
            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">ホーム</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('calendar') }}">カレンダー</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">ログアウト</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">アカウント情報</a>
                </li>
            </ul>
        </div>
        <!-- Collapsible content -->
    </nav>
    <!--/.Navbar-->
    <section class="graph">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-12 text-center mt-4">
                    <a href="{{ route('calendar') }}">カレンダーへ戻る</a>
                    <h4 class="mt-3 mb-3">{{ $searchDay }}の記録</h4>
                    <p>○：服薬した ×：服薬しなかった</p>
                    <p>※○か×をクリックすると、その時の記録の詳細を見ることが出来ます。</p>
                    <canvas id="mentalChart">
                    </canvas>
                </div>
            </div>
        </div>
    </section>
    <section class="comments">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-12 text-center mb-5">
                    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" id="my_modal">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">記録の詳細</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div><!-- /.modal-header -->
                                <div class="modal-body">
                                    <p id="created_at"></p>
                                    <form action="{{ route('update') }}" method="POST">
                                        @csrf
                                        <h4>精神状態</h4>
                                        <label for="range" class="form-label" id="display-range"></label>
                                        <div class="range text-center">
                                            <input type="range" class="custom-range w-50" min="1" max="5" step="1" id="mental_point" name="mental_point" />
                                            <input type="hidden" name="day" value="{{ $searchDay }}">
                                            <input type="hidden" name="created_at" id="time">
                                        </div>
                                        <hr>
                                        <h4 class="pt-4">服薬チェック</h4>
                                        <div class="form-check text-center pb-4">
                                            <input type="hidden" value="0" name="medicine_check">
                                            <input type="checkbox" class="form-check-input" id="checkbox" name="medicine_check">
                                            <label for="checkbox" class="form-check-label text-white">決められた時間に服用した</label>
                                        </div>
                                        <hr>
                                        <h4 class="">不調の原因</h4>
                                        <div class="text-area text-center">
                                            <textarea class="form-control w-50 mr-auto ml-auto" id="comment" rows="3" name="comment" required placeholder="200文字以内でお願いします"></textarea>
                                        </div>
                                        <div class="modal-footer mt-5">
                                            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">キャンセル</button>
                                            <button type="submit" class="btn btn-primary btn-block">更新</button>
                                        </div><!-- /.modal-footer -->
                                    </form>
                                </div><!-- /.modal-body -->
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="comments">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (count($logs) > 0)
                        <div class="logs">
                            <h4 class="text-center mb-3">{{ $searchDay }}の記録</h4>
                            @foreach ($logs as $log)
                                @if (isset($log->comment))
                                    <div class="log pr-5 pl-5 shadow rounded">
                                        <div class="log-content">
                                            <p>{{ $log->created_at }}</p>
                                            <hr>
                                            <p class="text-center">不調レポート</p>
                                            <p class="text-center">{{ $log->comment }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <div class="text-center">
                                <a href="{{ route('calendar') }}">カレンダーへ戻る</a>
                            </div>
                        </div>
                    @else 
                        <div class="no-logs text-center">
                            <h4>{{ $searchDay }}の記録はありません。</h4>
                            <a href="{{ route('calendar') }}">カレンダーへ戻る</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>
    <!-- chart.js -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <!-- Toartr -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        $('#my_modal').modal('hide');
        let mental_point;
        let medicine_check;
        let comment;
        let created_at;
        let mentalChart = document.getElementById("mentalChart");
        let myChart = new Chart(mentalChart, {
            type: 'line',
            data: {
                labels: [
                    @foreach($logs as $log)
                        // '{{ $log['created_at'] }}',
                        '{{ date("H:i:s", strtotime($log['created_at'])) }}',
                    @endforeach
                ],
                datasets: [
                    {
                        label: '体調',
                        data: [
                            @foreach($logs as $log)
                                '{{ $log['mental_point'] }}',
                            @endforeach
                        ],
                        borderColor: '#000080',
                        backgroundColor: 'rgba(0, 0, 0, 0)',
                        spanGaps: true,
                        pointRadius: 10,
                        borderWidth: 3,
                        pointBorderColor: [
                            @foreach($logs as $log)
                                @if($log['medicine_check'])
                                    '#7fff00',
                                @else 
                                    '#ff0000',
                                @endif
                            @endforeach
                        ],
                        pointStyle: [
                            @foreach($logs as $log)
                                @if($log['medicine_check'])
                                    'circle',
                                @else 
                                    'crossRot',
                                @endif
                            @endforeach
                        ],
                    },
                ],
            },
            options: {
                responsive: true,
                elements: {
                    line: {
                        tension: 0, // ベジェ曲線を無効にする
                    }
                },
                animation: {
                    duration: 0, // 一般的なアニメーションの時間
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            maxTicksLimit: 24,
                        }
                    }],
                },
                tooltips: {
                    callbacks: {
                        // title: function(tooltipItems, data) {
                        //     return new Date().toLocaleTimeString();
                        // },
                    },
                },
                hover: {
                    mode: 'point',
                },
                onClick: function(event, elements) {
                    elements.forEach(function(element) {
                        let pointTime = myChart.data.labels[element._index];
                        let searchDay = @json($searchDay);
                        let createdAt = searchDay + ' ' + pointTime;
                        let createdAtTmp = createdAt;
                        let logs = @json($logs);
                        createdAt = new Date(createdAt);
                        for(let index=0;index<logs.length;index++){
                            if(new Date(logs[index]['created_at']).getTime() == createdAt.getTime()){
                                mental_point = logs[index]['mental_point'];
                                medicine_check = logs[index]['medicine_check'];
                                comment = logs[index]['comment'];
                                time = createdAtTmp;
                                console.log(time);
                                created_at = dateToFormatString(new Date(logs[index]['created_at']), '%YYYY%年%MM%月%DD%日 (%w%) %HH%時%mm%分%ss%秒');
                                $('#my_modal').modal();
                                document.getElementById('created_at').innerText = created_at + 'の記録';
                                document.getElementById('mental_point').value = mental_point;
                                document.getElementById('time').value = time;
                                document.getElementById('comment').innerText = comment;
                                $(function(){
                                    $("#mental_point").click(function() {
                                        let rangeValue = $("#mental_point").val();
                                        $("#display-range").text("精神状態:" + rangeValue);
                                    });
                                });
                            }
                        }
                    });
                },
            },
        });

        function dateToFormatString(date, fmt, locale, pad) {
            var padding = function(n, d, p) {
                p = p || '0';
                return (p.repeat(d) + n).slice(-d);
            };
            var DEFAULT_LOCALE = 'ja-JP';
            var getDataByLocale = function(locale, obj, param) {
                var array = obj[locale] || obj[DEFAULT_LOCALE];
                return array[param];
            };
            var format = {
                'YYYY': function() { return padding(date.getFullYear(), 4, pad); },
                'YY': function() { return padding(date.getFullYear() % 100, 2, pad); },
                'MMMM': function(locale) {
                    var month = {
                        'ja-JP': ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                        'en-US': ['January', 'February', 'March', 'April', 'May', 'June',
                                'July', 'August', 'September', 'October', 'November', 'December'],
                    };
                    return getDataByLocale(locale, month, date.getMonth());
                },
                'MMM': function(locale) {
                    var month = {
                        'ja-JP': ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                        'en-US': ['Jan.', 'Feb.', 'Mar.', 'Apr.', 'May', 'June',
                                'July', 'Aug.', 'Sept.', 'Oct.', 'Nov.', 'Dec.'],
                    };
                    return getDataByLocale(locale, month, date.getMonth());
                },
                'MM': function() { return padding(date.getMonth()+1, 2, pad); },
                'M': function() { return date.getMonth()+1; },
                'DD': function() { return padding(date.getDate(), 2, pad); },
                'D': function() { return date.getDate(); },
                'HH': function() { return padding(date.getHours(), 2, pad); },
                'H': function() { return date.getHours(); },
                'hh': function() { return padding(date.getHours() % 12, 2, pad); },
                'h': function() { return date.getHours() % 12; },
                'mm': function() { return padding(date.getMinutes(), 2, pad); },
                'm': function() { return date.getMinutes(); },
                'ss': function() { return padding(date.getSeconds(), 2, pad); },
                's': function() { return date.getSeconds(); },
                'A': function() {
                    return date.getHours() < 12 ? 'AM' : 'PM';
                },
                'a': function(locale) {
                    var ampm = {
                        'ja-JP': ['午前', '午後'],
                        'en-US': ['am', 'pm'],
                    };
                    return getDataByLocale(locale, ampm, date.getHours() < 12 ? 0 : 1);
                },
                'W': function(locale) {
                    var weekday = {
                        'ja-JP': ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
                        'en-US': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    };
                    return getDataByLocale(locale, weekday, date.getDay());
                },
                'w': function(locale) {
                    var weekday = {
                        'ja-JP': ['日', '月', '火', '水', '木', '金', '土'],
                        'en-US':  ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                    };
                    return getDataByLocale(locale, weekday, date.getDay());
                },
            };
            var fmtstr = ['']; // %%（%として出力される）用に空文字をセット。
            Object.keys(format).forEach(function(key) {
                fmtstr.push(key); // ['', 'YYYY', 'YY', 'MMMM',... 'W', 'w']のような配列が生成される。
            })
            var re = new RegExp('%(' + fmtstr.join('|') + ')%', 'g');
            // /%(|YYYY|YY|MMMM|...W|w)%/g のような正規表現が生成される。
            var replaceFn = function(match, fmt) {
            // match には%YYYY%などのマッチした文字列が、fmtにはYYYYなどの%を除くフォーマット文字列が入る。
                if(fmt === '') {
                    return '%';
                }
                var func = format[fmt];
                // fmtがYYYYなら、format['YYYY']がfuncに代入される。つまり、
                // function() { return padding(date.getFullYear(), 4, pad); }という関数が代入される。
                if(func === undefined) {
                    //存在しないフォーマット
                    return match;
                }
                return func(locale);
            };
            return fmt.replace(re, replaceFn);
        }

        let is_posted = @json(session('is_posted'));
        if(is_posted == 1){
            toastr.success("記録の編集が完了しました。", "お知らせ");
        }
    </script>
</body>
</html>