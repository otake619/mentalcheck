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
    <title>退会フォーム mentalcheckapp</title>
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
                    <a class="nav-link" href="{{ route('get-logout') }}">ログアウト</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('account-info') }}">アカウント情報</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('get-delete') }}">退会</a>
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
                    <div class="user-profile text-center mt-5 shadow">
                        <form action="{{ route('update-account') }}" method="POST">
                            @csrf
                            @foreach ($user_info as $item)
                                <div class="form-outline">
                                    <h4 class="pt-5">アカウント名</h4>
                                    <input type="text" id="formControlLg" class="form-control form-control-lg" name="name" value="{{ $item->name }}"/>
                                </div>
                                <br>
                                <h4>Email</h4>
                                <h4>{{ $item->email }}</h4>
                                <br>
                                <h4>アカウント作成日</h4>
                                <h4>{{ $item->created_at->diffForHumans() }}</h4>
                                <p class="mt-4 mb-4">*Emailは書き換え出来ません</p>
                                <input type="submit" class="btn btn-primary" value="更新する">
                                <input type="button" class="btn btn-secondary" value="キャンセル">
                            @endforeach
                        </form>
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
    </script>
</body>
</html>