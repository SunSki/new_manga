<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>新着WEBマンガ一覧</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/manga-style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/up.js"></script>
    <script src="js/fade.js"></script>
    <?php
        date_default_timezone_set('Asia/Tokyo');

        function week ($date){
            $datetime = new DateTime($date);
            $week = array("日", "月", "火", "水", "木", "金", "土");
            $w = (int)$datetime->format('w');
            echo $week[$w] . "曜日";
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

        function manga_show($res,$mode){
            $today = date("Y/m/d");
            $date_now ='';
            foreach($res as $item){
                $title = $item->title; //書籍のタイトル
                $link = $item->link; //書籍のリンク
                $date = $item->date;
                $img = $item->img;
                $detail = $item->detail;
                if ($date_now != $date){
                    echo "<hr>";
                    $ago = day_diff($today,$date);
                    if($ago!=0){
                        echo "<div class='ago'>${ago}日前</div>";
                    }else{
                        echo "<div class='ago'>本日更新</div>";
                    }
                    
                    echo "<div class='split-date'>$date</div>";
                    $week = week($date);
                    echo "<div class='split-date'>$week</div>";
                }
                $date_now = $date;
                echo "<div class='container'>";
                echo "<a href='${link}'>";
                    echo "<div class='row work-list pt-1 pb-1 mb-1 mt-1'>";
                        echo "<div><img src='${img}' class='manga-img'></div>";
                        if($mode == "title"){
                            echo "<div class='title'>${title}</div>";
                        }
                        echo "<div class='title'>${detail}</div>";
                        //echo "<div class='date'>${date}</div>";
                    echo "</div>";
                echo"</a>";
                echo "</div>";
            }
        }

        function logo($img,$url){
            echo "<p><a href='${url}'><img src='${img}' height='30px'></a></p>";
        }

        require('php/json_get.php');
    ?>
</head>

<body>

    <?php
        require('php/header.php');
    ?>

    <nav class="navbar justify-content-around sticky-top down">
        <div class="container logo_head pt-2">
            <?php
                //プラス
                logo("img/plus_60.png","https://shonenjumpplus.com/series");
            ?>
            <?php
                //となり
                echo"<div class='tonari'>";
                logo("img/tonari_60.png","https://tonarinoyj.jp/series");
                echo"</div>";
                
            ?>
            <hr>

            <?php
                //ヤング
                echo"<div class='young'>";
                logo("img/young_60.png","https://web-ace.jp/youngaceup/contents/");
                echo"</div>";
                
            ?>
        </div>
    </nav>

    <div class="container" id="main">
        <div class="row">
            <div class="col-md-4">
                <?php
                    //echo count($res_plus)."作品";
                    manga_show($res_plus,'none');
                ?>
                <hr>
            </div>
            <div class="col-md-4">
                <?php
                    //echo count($res_tonari)."作品";
                    manga_show($res_tonari,'none');
                ?>
                <hr>
            </div>
            <div class="col-md-4">
                <?php
                    //echo count($res_young)."作品";
                    echo"<div class='young_list'>";
                    manga_show($res_young,'title');
                    echo"</div>";
                    
                ?>
                <hr>
            </div>
        </div>
    </div>

    <div id="page_top"><a href="#"></a></div>

    <footer id="footer">
        <div class="container">
            <a href='about.html' class="about-site">このサイトについて</a>
        </div>
    </footer>
</body>

</html>
