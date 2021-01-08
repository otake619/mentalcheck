<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>ホーム mentalcheckapp</title>
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
    <section class="form">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="mentalcheck shadow mt-5">
                        <div class="form-title bg-primary d-flex">
                            <i class="far fa-heart bg-light text-danger h1 mb-0" id="heart-icon"></i>
                            <h4 class="text-white pt-2">メンタルチェック</h4>
                        </div>
                        <div class="menu text-center bg-info pt-4 pb-4">
                            <form action="{{ route('store') }}" method="POST">
                                @csrf
                                <h4 class="text-white">今の精神状態をチェック！(5段階で値が高いほど調子が良い)</h4>
                                <label for="range" class="form-label text-white" id="display-range"></label>
                                <div class="range text-center">
                                    <input type="range" class="custom-range w-50" min="1" max="5" step="1" id="range" name="mental_check" />
                                </div>
                                <hr>
                                <h4 class="text-white pt-4">薬を決められた時間に服用できたかチェック！</h4>
                                <div class="form-check text-center pb-4">
                                    <input type="hidden" value="0" name="medicine_check">
                                    <input type="checkbox" class="form-check-input" id="checkbox" name="medicine_check">
                                    <label for="checkbox" class="form-check-label text-white">決められた時間に服用した</label>
                                </div>
                                <hr>
                                <h4 class="text-white">不調の具体的な原因をチェック！</h4>
                                <div class="text-area text-center">
                                    <textarea class="form-control w-50 mr-auto ml-auto" id="text-area" rows="3" name="comment" required></textarea>
                                </div>
                                <div class="submit text-center mt-3 pb-3">
                                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="送信">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- 広告を貼る --}}
    {{-- <section class="adsense bg-light fixed-bottom">
        <h4 class="text-center">*広告を貼るスペース</h4>
    </section> --}}
    {{-- コピーライト --}}
    <section class="copyright-space bg-info mt-5">
        <div class="copy-right text-center text-white pb-5 pt-3">
            <h4>メンタルチェックアプリ</h4>
            <small>&copy;otake619 All Rights Reserved.</small>
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
    <!-- Toartr -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">

        $(function(){
            $("#range").click(function() {
                let rangeValue = $("#range").val();
                $("#display-range").text("現在の精神状態:" + rangeValue);
            });
        });

        let is_posted = @json($is_posted);
        if(is_posted == 1){
            toastr.success("体調の記録が完了しました。", "お知らせ");
        }
        console.log(is_posted);
    </script>
</body>
</html>