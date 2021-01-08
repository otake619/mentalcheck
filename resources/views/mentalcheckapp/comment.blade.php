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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <title>不調内容 mentalcheckapp</title>
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
    <section class="comment-space mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-12 col-md-6">
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
                <div class="col-md-3">
                </div>
            </div>
        </div>
    </section>
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
    <script type="text/javascript">
        
    </script>
</body>
</html>