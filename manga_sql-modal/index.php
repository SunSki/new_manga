<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Wevcomix</title>

    
    <?php   #初期設定
        require('php/head.php');
        date_default_timezone_set('Asia/Tokyo');
    ?>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://code.jquery.com/jquery-migrate-3.0.1.min.js' integrity='sha256-F0O1TmEa4I8N24nY0bya59eP6svWcshqX1uzwaWC4F4='crossorigin='anonymous'></script>
    <script src='js/iziModal.js'></script>
    <script src='js/up.js'></script>
    <!-- <script src='js/fade.js'></script> -->


    <?php
        function week ($date){
            $datetime = new DateTime($date);
            $week = array("日", "月", "火", "水", "木", "金", "土");
            $w = (int)$datetime->format('w');
            return "(". $week[$w] . ")";
        }

        function manga_show($res){
            $today = date("Y/m/d");
            $date_now ='';
            echo "<div id='index_manga'>";
            echo "<ul>";

            $id = 0;
            $id_favo = 1000;
            foreach($res as $item){
                $title = $item->title; //書籍のタイトル
                $link = $item->link; //書籍のリンク
                $date = $item->date;
                $img = $item->img;
                $site = $item->site;
                $detail = $item->detail;
                if ($date_now != $date){
                    echo"</ul>";
                    //echo "<hr>";

                    //年月日をを曜日に変換
                    $week = week($date);
                    $scroll_date = substr($date,5,5);
                    if($week == "(月)"){
                        echo "<div class='pl-3 mb-2 index_date mon'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(火)"){
                        echo "<div class='pl-3 mb-2 index_date tue'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(水)"){
                        echo "<div class='pl-3 mb-2 index_date wed'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(木)"){
                        echo "<div class='pl-3 mb-2 index_date thr'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(金)"){
                        echo "<div class='pl-3 mb-2 index_date fri'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(土)"){
                        echo "<div class='pl-3 mb-2 index_date sat'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(日)"){
                        echo "<div class='pl-3 mb-2 index_date sun'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }
                    
                    echo "<ul class='horizontal-list pl-3'>";
                }
                $date_now = $date;
                echo "<li class='item mr-2'>";

                    #モーダル設定
                    echo"<script type='text/javascript'>";
                        echo"$(function () {";
                            echo"$('#$id').iziModal();";
                        echo"})";
                    echo"</script>";



                    #モーダルで表示するものを設定
                    echo"<div id='$id' class='modal'>";

                        //お気に入り登録クリック後
                        echo"<script type='text/javascript'>";
                            echo"$('#$id_favo').click(function() {";
                                echo"$(this).css('color','red');";
                                echo"$(this).css('pointer-events','none');";
                                echo"console.log('クリックされました！');";
                                //ここにデータベースに追加処理をかく
                            echo"})";
                        echo"</script>";

                        echo"<img src=${img} width='100%'>";
                        echo"<p>${title}</p>";
                        echo"<p>${detail}</p>";
                        if($site=='plus'){
                            $site_name = '少年ジャンプ+';
                        }elseif($site=='ura'){
                            $site_name = '裏サンデー';
                        }elseif($site=='young'){
                            $site_name = 'ヤングエースUP';
                        }
                        elseif($site=='tonari'){
                            $site_name = 'となりのヤングジャンプ';
                        }
                        echo"<p>${site_name}</p>";
                        echo"<a id='${id_favo}'>マイリストに追加</a>";
                        echo"<p><a href='${link}'>この作品を読む</a></p>";
                    echo"</div>";
                    

                    
                    //サムネイル
                    echo "<a href='$link' data-izimodal-open='#$id'>";
                        echo "<div class='title'>";
                            echo "<div><img src='${img}' class='shadow-sm' width='100%' height='120px'></div>";
                            if($site == "young" || $site == "ura"){
                                echo "<div class='title'>${title}${detail}</div>";
                            }else{
                                echo "<div class='title'>${detail}</div>";
                            }
                        echo "</div>";
                    echo"</a>";



                echo"</li>";
                $id+=1;
                $id_favo+=1;
            }
            echo"</ul>";
            echo"</div>";
            
        }

        function logo($img,$url){
            echo "<p><a href='${url}'><img src='${img}' height='30px'></a></p>";
        }
  
    ?>


</head>

<body>

    <?php
        require("php/json_get.php");
        require('php/header.php');
    ?>
    <div class="manga-list" id="main">
        <?php
            manga_show($res_all);
        ?>
    </div>


    <?php
        require("php/footer.php");
    ?>

    <div id="page_top"><a href="#"></a></div>
</body>

</html>
