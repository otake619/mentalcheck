<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <title>グラフ(年) mentalcheckapp</title>
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
                    <a class="nav-link" href="{{ route('log-show-day') }}">グラフ</a>
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
                @if($logs === null)
                    <div class="col-12 text-center mt-5">
                        <div class="graph-select text-center mt-3 mb-3">
                            <a class="mr-3" href="{{ route('log-show-day') }}">24時間</a>
                            <a class="mr-3" href="{{ route('log-show-week') }}">週</a>
                            <a class="mr-3" href="{{ route('log-show-month') }}">月</a>
                            <a class="mr-3" href="{{ route('log-show-year') }}">年</a>
                        </div>
                        <div class="message">
                            <h4 class="no-message">まだ1年以内の体調は記録されていません。</h4>
                        </div>
                    </div>
                @else 
                    <div class="col-12">
                        <div class="graph-select text-center mt-3">
                            <a class="mr-3" href="{{ route('log-show-day') }}">24時間</a>
                            <a class="mr-3" href="{{ route('log-show-week') }}">週</a>
                            <a class="mr-3" href="{{ route('log-show-month') }}">月</a>
                            <a class="mr-3" href="{{ route('log-show-year') }}">年</a>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="charts">
                            <canvas id="mentalChart"></canvas>
                        </div>
                    </div>
                @endif
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
                        '{{ $log['created_at'] }}',
                    @endforeach
                ],
                datasets: [
                    {
                        label: '体調の平均値(0~100)',
                        data: [
                            @foreach($logs as $log)
                                {{ $log['mental_point'] }},
                            @endforeach
                        ],
                        borderColor: '#000080',
                        backgroundColor: 'rgba(0, 0, 0, 0)',
                        spanGaps: true,
                        pointRadius: 10,
                    }
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
                            maxTicksLimit:7
                        }
                    }],
                }
            }
        });
    </script>
</body>
</html>