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
    <title>グラフ(24時間) mentalcheckapp</title>
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
                @if($logs == null)
                    <div class="col-12 text-center mt-5">
                        <div class="graph-select text-center mt-3 mb-3">
                            <a class="mr-3" href="{{ route('log-show-day') }}">24時間</a>
                            <a class="mr-3" href="{{ route('log-show-week') }}">週</a>
                            <a class="mr-3" href="{{ route('log-show-month') }}">月</a>
                            <a class="mr-3" href="{{ route('log-show-year') }}">年</a>
                        </div>
                        <div class="message">
                            <h4 class="no-message">まだ24時間以内の体調は記録されていません。</h4>
                        </div>
                    </div>
                @else 
                    <div class="col-12">
                        <div class="graph-select text-center mt-3">
                            <a class="mr-3" href="{{ route('log-show-day') }}">24時間</a>
                            <a class="mr-3" href="{{ route('log-show-week') }}">週</a>
                            <a class="mr-3" href="{{ route('log-show-month') }}">月</a>
                            <a class="mr-3" href="{{ route('log-show-year') }}">年</a>
                            <div class="d-flex justify-content-around">
                                <button id="searchBefore">前のグラフ</a>
                                <button id="searchAfter">後のグラフ</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="explaination mt-3">
                            <p>○：服薬済み ×：服薬忘れ </p>
                            <p>※グラフのマークにカーソルを当てると<br>不調レポートが表示されます</p>
                        </div>
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
        let logs = @json($logs);
        let mental_point = [];
        let created_at = [];
        let comment = [];
        let counter = 0;
        //ユーザーに表示しているグラフの時間。
        //0:現在(初期値),-1以下:24時間以前,+1以上:24時間以後。
        let displayTime = 0;

        for(let index=0;index<logs.length;index++) {
            mental_point.push(logs[index]['mental_point']);
            created_at.push(formatDate(new Date(logs[index]['created_at']), "MM-DD hh:mm"));
        }

        let ctx = document.getElementById("mentalChart");
        let mentalLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: created_at,
                datasets: [
                    {
                        label: '体調',
                        data: mental_point,
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
                title: {              // タイトルの設定
                    display: true,         // 表示設定
                    position: 'bottom',       // 表示位置
                    fontSize: 18,          // フォントサイズ
                    fontColor: "blue",    // 文字の色
                    text: "24時間以内の体調(数値が高いほど好調)", 
                },
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
                    enabled: false,
                    titleFontSize: 18,
                    bodyFontSize: 18,
                    callbacks: {
                        title: function (tooltipItem, data){
                            return "不調レポート";
                        },
                        label: function (tooltipItem, data){
                            return getComment();
                        }
                    },
                    custom: function(tooltipModel) {
                        // ツールチップ要素
                        var tooltipEl = document.getElementById('chartjs-tooltip');

                        // 最初の表示時に要素を生成。
                        if (!tooltipEl) {
                            tooltipEl = document.createElement('div');
                            tooltipEl.id = 'chartjs-tooltip';
                            tooltipEl.innerHTML = "<table></table>"
                            this._chart.canvas.parentNode.appendChild(tooltipEl);
                        }

                        // ツールチップが無ければ非表示。
                        if (tooltipModel.opacity === 0) {
                            tooltipEl.style.opacity = 0;
                            return;
                        }

                        // キャレット位置をセット。
                        tooltipEl.classList.remove('above', 'below', 'no-transform');
                        if (tooltipModel.yAlign) {
                            tooltipEl.classList.add(tooltipModel.yAlign);
                        } else {
                            tooltipEl.classList.add('no-transform');
                        }

                        function getBody(bodyItem) {
                            return bodyItem.lines;
                        }

                        // テキストをセット。
                        if (tooltipModel.body) {
                            var titleLines = tooltipModel.title || [];
                            var bodyLines = tooltipModel.body.map(getBody);

                            var innerHtml = '<thead>';

                            titleLines.forEach(function(title) {
                                innerHtml += '<tr><th>' + title + '</th></tr>';
                            });
                            innerHtml += '</thead><tbody>';

                            bodyLines.forEach(function(body, i) {
                                var colors = tooltipModel.labelColors[i];
                                var style = 'background:' + colors.backgroundColor;
                                style += '; border-color:' + colors.borderColor;
                                style += '; border-width: 2px';
                                var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                                innerHtml += '<tr><td>' + span + body + '</td></tr>';
                            });
                            innerHtml += '</tbody>';

                            var tableRoot = tooltipEl.querySelector('table');
                            tableRoot.innerHTML = innerHtml;
                        }
                        // `this`はツールチップ全体です。
                        var positionY = this._chart.canvas.offsetTop;
                        var positionX = this._chart.canvas.offsetLeft;

                        // 表示、位置、フォントスタイル指定します。
                        tooltipEl.style.opacity = 1;
                        tooltipEl.style.left = positionX + tooltipModel.caretX + 'px';
                        tooltipEl.style.top = positionY + tooltipModel.caretY + 'px';
                        tooltipEl.style.fontFamily = tooltipModel._fontFamily;
                        tooltipEl.style.fontSize = tooltipModel.fontSize;
                        tooltipEl.style.fontStyle = tooltipModel._fontStyle;
                        tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
                    }
                },
            },
        });

        function formatDate(date, format) {
            if (!format) format = 'YYYY-MM-DD hh:mm:ss.SSS';
                format = format.replace(/YYYY/g, date.getFullYear());
                format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
                format = format.replace(/DD/g, ('0' + date.getDate()).slice(-2));
                format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
                format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
                format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
            if (format.match(/S/g)) {
                var milliSeconds = ('00' + date.getMilliseconds()).slice(-3);
                var length = format.match(/S/g).length;
                for (var i = 0; i < length; i++) format = format.replace(/S/, milliSeconds.substring(i, i + 1));
            }
            return format;
        };

        function getComment(){
            comment = logs[counter]['comment'];
            counter++;
            return comment;
        }

        let searchAfter = document.getElementById('searchAfter');

        searchAfter.onclick = searchAf;

        $(function(){
            $('#searchBefore').click(function() {
                --displayTime;
                getLogs();

            });
        });

        function searchAf() {
            ++displayTime;
            getLogs();
            console.log(logs);
        }

        //引数にlogsを取る
        function drawChart(logs) {
            let mental_point = [];
            let created_at = [];
            let comment = [];
            let counter = 0;
            //ユーザーに表示しているグラフの時間。
            //0:現在(初期値),-1以下:24時間以前,+1以上:24時間以後。
            let displayTime = 0;

            for(let index=0;index<logs.length;index++) {
                mental_point.push(logs[index]['mental_point']);
                created_at.push(formatDate(new Date(logs[index]['created_at']), "MM-DD hh:mm"));
            }

            let ctx = document.getElementById("mentalChart");
            let mentalLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: created_at,
                    datasets: [
                        {
                            label: '体調',
                            data: mental_point,
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
                    title: {              // タイトルの設定
                        display: true,         // 表示設定
                        position: 'bottom',       // 表示位置
                        fontSize: 18,          // フォントサイズ
                        fontColor: "blue",    // 文字の色
                        text: "24時間以内の体調(数値が高いほど好調)", 
                    },
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
                        enabled: false,
                        titleFontSize: 18,
                        bodyFontSize: 18,
                        callbacks: {
                            title: function (tooltipItem, data){
                                return "不調レポート";
                            },
                            label: function (tooltipItem, data){
                                console.log(tooltipItem);
                                return tooltipItem.yLavel;
                            }
                        },
                        custom: function(tooltipModel) {
                            // ツールチップ要素
                            var tooltipEl = document.getElementById('chartjs-tooltip');

                            // 最初の表示時に要素を生成。
                            if (!tooltipEl) {
                                tooltipEl = document.createElement('div');
                                tooltipEl.id = 'chartjs-tooltip';
                                tooltipEl.innerHTML = "<table></table>"
                                this._chart.canvas.parentNode.appendChild(tooltipEl);
                            }

                            // ツールチップが無ければ非表示。
                            if (tooltipModel.opacity === 0) {
                                tooltipEl.style.opacity = 0;
                                return;
                            }

                            // キャレット位置をセット。
                            tooltipEl.classList.remove('above', 'below', 'no-transform');
                            if (tooltipModel.yAlign) {
                                tooltipEl.classList.add(tooltipModel.yAlign);
                            } else {
                                tooltipEl.classList.add('no-transform');
                            }

                            function getBody(bodyItem) {
                                return bodyItem.lines;
                            }

                            // テキストをセット。
                            if (tooltipModel.body) {
                                var titleLines = tooltipModel.title || [];
                                var bodyLines = tooltipModel.body.map(getBody);

                                var innerHtml = '<thead>';

                                titleLines.forEach(function(title) {
                                    innerHtml += '<tr><th>' + title + '</th></tr>';
                                });
                                innerHtml += '</thead><tbody>';

                                bodyLines.forEach(function(body, i) {
                                    var colors = tooltipModel.labelColors[i];
                                    var style = 'background:' + colors.backgroundColor;
                                    style += '; border-color:' + colors.borderColor;
                                    style += '; border-width: 2px';
                                    var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                                    innerHtml += '<tr><td>' + span + body + '</td></tr>';
                                });
                                innerHtml += '</tbody>';

                                var tableRoot = tooltipEl.querySelector('table');
                                tableRoot.innerHTML = innerHtml;
                            }
                            // `this`はツールチップ全体です。
                            var positionY = this._chart.canvas.offsetTop;
                            var positionX = this._chart.canvas.offsetLeft;

                            // 表示、位置、フォントスタイル指定します。
                            tooltipEl.style.opacity = 1;
                            tooltipEl.style.left = positionX + tooltipModel.caretX + 'px';
                            tooltipEl.style.top = positionY + tooltipModel.caretY + 'px';
                            tooltipEl.style.fontFamily = tooltipModel._fontFamily;
                            tooltipEl.style.fontSize = tooltipModel.fontSize;
                            tooltipEl.style.fontStyle = tooltipModel._fontStyle;
                            tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
                        }
                    },
                },
            });
        } 

        function getLogs() {
            $.ajax({
                type: 'GET',
                url: '/graph/show-day/ajax-get-logs/' + displayTime,
                data: {
                    'displayTime': displayTime,
                },
                dataType: 'json',
                 //リクエストが完了するまで実行される
                beforeSend: function(){
                    $('.loading').removeClass('hide');
                }

            }).done(function (data) {
                $('.loading').addClass('hide');
                console.log(data);
                returnLogs(data);
                console.log(displayTime);

            }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        　　　//ajax通信がエラーのときの処理
                console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            　　console.log("textStatus     : " + textStatus);
            　　console.log("errorThrown    : " + errorThrown.message);
            });
            return false;
        }   

        function returnLogs(data){
            console.log(displayTime);
            drawChart(data);
        }
    </script>
</body>
</html>