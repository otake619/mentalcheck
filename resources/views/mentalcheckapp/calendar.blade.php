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
    <title>カレンダー mentalcheckapp</title>
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
                    <a class="nav-link">メンタルグラフ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">メンタルカレンダー</a>
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
    <section class="calendar-space">
        <div id="calendar">

        </div>
        <div class="calendar-control mt-3 text-center">
            <button id="control-buttons" class="back" type="button"><i class="fas fa-arrow-left"></i></button>
            <button id="control-buttons" class="next" type="button"><i class="fas fa-arrow-right"></i></button>
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
    {{-- カレンダーのロジックとなるjs --}}
    <script type="text/javascript" src="{{ asset('/js/calendar.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            var myDate = new Date();
            var myYear = myDate.getFullYear();  // 年を取得    
            var MyMonth = myDate.getMonth();    // 月を取得(0月～11月)
            setCalender(myYear,MyMonth);

            $('.next').click(function(){

                MyMonth++;
                if(MyMonth == 12){
                    MyMonth = 0;
                    myYear++;
                }
                $('#calendar').empty();
                $('#calendar').text(setCalender(myYear,MyMonth));
            });

            $('.back').click(function(){

                MyMonth--;
                if(MyMonth == -1){
                    MyMonth = 11;
                    myYear--;
                }
                $('#calendar').empty();
                $('#calendar').text(setCalender(myYear,MyMonth));
            });
        });
    </script>
</body>
</html>