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
    <title>トップページ mentalcheckapp</title>
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
                    <a class="nav-link" href="#">TOP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">ログイン</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">新規アカウント作成</a>
                </li>
            </ul>
        </div>
        <!-- Collapsible content -->
    </nav>
    <!--/.Navbar-->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-6 mt-3">
                    <img src="{{ asset('images/heart.jpg') }}" alt="トップページの画像" class="rounded-pill mw-100">
                </div>
                <div class="col-12 col-lg-6 mt-5 text-center">
                    <h4 class="text-primary">メンタルチェックアプリへようこそ！</h4>
                    <p class="text-info mt-5">メンタルチェックアプリは、精神的に不調を抱える人のための<br>メンタル記録アプリです。</p>
                    <p class="text-info">このアプリの製作者も精神的な不調を抱えています。</p>
                    <p class="text-info">このアプリを活用して、不調の波を把握しましょう！</p>
                </div>
            </div>
        </div>
    </section>
    <section class="buttons">
        <div class="container-fluid">
            <div class="row text-center mt-5">
                <div class="col-12 col-lg-6">
                    <a href="{{ route('register') }}" class="col btn btn-info">新規アカウント作成</a>
                </div>
                <div class="col-12 col-lg-6">
                    <a href="{{ route('login') }}" class="col btn btn-primary mb-5">ログイン</a>
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

    </script>
</body>
</html>