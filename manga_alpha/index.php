<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>新着WEBマンガ一覧</title>
    <link rel="stylesheet" type="text/css" href="reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="manga-style.css">
    <?php
        date_default_timezone_set('Asia/Tokyo');

        #jsonからphp用のオブジェクトに変換
        function jsonDecode($link){
            $json = file_get_contents($link);
            return json_decode($json);
        }

        function day_diff($date1, $date2) {
            // 日付をUNIXタイムスタンプに変換
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
         
            // 何秒離れているかを計算
            $seconddiff = abs($timestamp2 - $timestamp1);
         
            // 日数に変換
            $daydiff = $seconddiff / (60 * 60 * 24);
         
            // 戻り値
            return $daydiff;
        }

        function manga_show($res){
            $today = date("Y/m/d");
            $date_now ='';
            foreach($res as $item){
                $title = $item->title; //書籍のタイトル
                $link = $item->link; //書籍のリンク
                $date = $item->date;
                $img = $item->img;
                if ($date_now != $date){
                    echo "<hr>";
                    $ago = day_diff($today,$date);
                    if($ago!=0){
                        echo "<div>${ago}日前</div>";
                    }else{
                        echo "<div>本日更新</div>";
                    }
                    
                    echo "<div class='split-date'>$date</div>";
                }
                $date_now = $date;
                echo "<div class='container'>";
                echo "<a href='${link}' target='_blank'>";
                    echo "<div class='row work-list pt-1 pb-1 mb-1 mt-1'>";
                        echo "<div class='col-sm-4'>";
                            echo "<div><img src='${img}' class='manga-img'></div>";
                        echo "</div>";
                        echo "<div class='col-sm-8'>";
                            echo "<div class='title'>${title}</div>";
                            echo "<div class='date'>${date}</div>";
                        echo "</div>";
                    echo "</div>";
                echo"</a>";
                echo "</div>";
            }
        }

        function logo($img,$url){
            echo "<p><a href='${url}' target='_blank'><img src='${img}' height='30em'></a></p>";
        }

        $res_plus = jsonDecode('http://localhost:3001/get_jampplus');
        $res_tonari = jsonDecode('http://localhost:3001/get_tonari');
        $res_young = jsonDecode('http://localhost:3001/get_young');
    ?>
</head>

<header>
    <div class="container">
        <div class="row">
            <div class="col-md logo">
                <a href="index.php">新着WEBマンガ</a>
            </div>
            <div class="col-md text-right">
                <a href="auth.php" class="mypage mr-3">Myページ</a>
                <a href="log-reg.php" class="square_btn">ログイン & 登録</a>
            </div>
        </div>
    </div>
</header>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?php
                    //プラス
                    logo("img/jumpplus_red.png","https://shonenjumpplus.com/series");
                    //echo count($res_plus)."作品";
                    manga_show($res_plus);
                ?>
                <hr>
            </div>
            <div class="col-md-4">
                <?php
                    //となり
                    logo("img/tonari.png","https://tonarinoyj.jp/series");
                    //echo count($res_tonari)."作品";
                    manga_show($res_tonari);
                ?>
                <hr>
            </div>
            <div class="col-md-4">
                <?php
                    //ヤング
                    logo("img/youngaceup-logo.png","https://web-ace.jp/youngaceup/contents/");
                    //echo count($res_young)."作品";
                    manga_show($res_young);
                ?>
                <hr>
            </div>
        </div>
    </div>
</body>

</html>
