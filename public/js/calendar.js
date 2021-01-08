function setCalender(y,l){
    'use strict';
    var myDate = new Date();
    var myToday = myDate.getDate(); // 今日の'日'を退避
    var todayMyMonth = myDate.getMonth();   // 月を取得(0月～11月)
    var $calendar = $('#calendar');
    var myWeekTbl = new Array('月','火','水','木','金','土','日');   // 曜日テーブル定義
    var myMonthTbl= new Array(31,28,31,30,31,30,31,31,30,31,30,31); // 月テーブル定義
    var myYear = y;
    myDate = new Date(myYear,l);    // 今日の日付データ取得

    ((myYear % 4)===0 && (myYear % 100) !==0) || (myYear % 400)===0 ? myMonthTbl[1] = 29: 28;   // うるう年だったら...
    // ２月を２９日とする
    var myMonth = myDate.getMonth();    // 月を取得(0月～11月)
    myDate.setDate(1);  // 日付を'１日'に変えて、
    var myWeek = myDate.getDay() - 1;   // '１日'の曜日を取得
    var myTblLine = Math.ceil((myWeek+myMonthTbl[myMonth])/7);  // カレンダーの行数
    var myTable = new Array(7*myTblLine);   // 表のセル数を用意
    for(var i=0; i<7*myTblLine; i++){
        myTable[i]=' '; // セルを全て空にする
    }
    for(i=0; i<myMonthTbl[myMonth]; i++){
       myTable[i+myWeek]=i+1;   // 日付を埋め込む
    }

    var source = '';
    var td = '<td>';
    var tdC = '</td>';
    var tr = '<tr>';
    var trC = '</tr>';
    var aTag = '<a class="date" href="#">';
    var aTagC = '</a>';

    for(i=0; i<myTblLine; i++){ // 表の「行」のループ
        source += tr;
        for (var j = 0; j < 7; j++) {
            var mydat = myTable[j+(i*7)];
            if(todayMyMonth === myMonth && mydat === myToday){
                // source += '<td class="today">' + mydat + tdC;
                source += '<td class="today">' + aTag + mydat + aTagC + tdC;
            }else if(j === 5){
                source += '<td class="sat">' + aTag + mydat + aTagC + tdC;
            }else if(j === 6){
                source += '<td class="sun">' + aTag + mydat + aTagC + tdC;
            }else{
                source += td + aTag + mydat + aTagC + tdC;
            }
        }
        source += trC;
    }
    var week = '';
    for(var k=0; k<7; k++){ // 曜日
        if(k === 5){
            week += '<td class="sat">' + myWeekTbl[k] + tdC;
        }else if(k === 6){
            week += '<td class="sun">' + myWeekTbl[k] + tdC;
        }else{
            week += td + myWeekTbl[k] + tdC;
        }
    }
    var weekTr = tr + week + trC;
    var tableSource = '<table>' +
        '<tr><td colspan="7">' +
            myYear + '年' + (myMonth+1) + '月' +
            '</td></tr>' + weekTr + source + '</table>';

    $calendar.append(tableSource);  // 表の作成開始

    $('.date').on('click', function () {
        let sendDay = $(this).text();
        let sendYear = myYear;
        let sendMonth = myMonth + 1;
        let searchDay = sendYear + '-' + sendMonth + '-' + sendDay;
        $(".date").attr("href", "/comment/" + searchDay);
        console.log(searchDay);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url: '/comment/' + searchDay,
            dataType: 'text',
        }).done(function (data, textStatus, jqXHR) {
            console.log('success');
        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
    　　　//ajax通信がエラーのときの処理
            alert(errorThrown);
        });
    });
}


