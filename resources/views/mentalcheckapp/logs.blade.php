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
                    <h4 class="mt-3 mb-3">不調の具体的な内容</h4>
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
    <script type="text/javascript">
        let ctx = document.getElementById("mentalChart");
        let mentalLineChart = new Chart(ctx, {
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
            },
        });
    </script>
</body>
</html>