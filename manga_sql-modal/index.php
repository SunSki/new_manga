<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Wevcomix</title>

    
    <?php   #初期設定
        ini_set('display_errors', 1);
        require('php/head.php');
        date_default_timezone_set('Asia/Tokyo');
        require('php/db-pdo.php');

        session_start();//セッション開始
        if(isset($_SESSION['name'])){
            $name = $_SESSION['name'];
            echo"<script>console.log('$name')</script>";
        }else{
            echo"<script>console.log('no login')</script>";
        }
        
    ?>

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://code.jquery.com/jquery-migrate-3.0.1.min.js' integrity='sha256-F0O1TmEa4I8N24nY0bya59eP6svWcshqX1uzwaWC4F4='crossorigin='anonymous'></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

        function manga_show($res,$pdo){
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
                    echo"<div id='$id' class='modal' data-izimodal-title='${title}'>";

                        //お気に入り登録クリック後
                        echo"<script type='text/javascript'>";
                            //データベースに追加
                            echo"$('#$id_favo').click(function() {";
                                if(isset($_SESSION['name'])){
                                    $name = $_SESSION['name'];
                                    $stmt = $pdo->query("SELECT COUNT(*) FROM favo WHERE name='$name' AND title='$title'");
                                    $count = $stmt->fetchColumn();
                                    if($count == 0){
                                        echo"$(this).css('color','red');";
                                        echo"$(this).css('pointer-events','none');";
                                        echo"$.ajax({".
                                            "url:'php/favo.php',".
                                            "type:'POST',".
                                            "dataType:'json',".
                                            "data:{post_name:'$name', post_title:'$title'},".
                                            "error:function(XMLHttpRequest, textStatus, errorThrown) {".
                                                "console.log('ajax通信に失敗しました');".
                                            "},".
                                            "success:function(response){".
                                                "console.log('ajax通信に成功しました');".
                                                "console.log(response[0]);".
                                                "console.log(response[1]);".
                                            "}".
                                        "});";

                                        echo"swal('Good job!', 'マイリストに追加しました。', 'success');";
                                    }else{
                                        echo"swal('Error','すでに追加されています。','error');";
                                    }
                                }else{
                                    echo"swal('Error','ログインすると追加できます。','error');";
                                }
                            echo"})";
                        echo"</script>";

                        echo"<img src=${img} width='100%'>";
                        echo"<div class='row'>";
                            echo"<div class='col-8'>";
                                if($site=='plus'){
                                    $site_name = '少年ジャンプ+';
                                    $site_url = 'https://shonenjumpplus.com/';
                                }elseif($site=='ura'){
                                    $site_name = '裏サンデー';
                                    $site_url = 'https://urasunday.com/';
                                    echo"<div class='ml-2 mt-2 h5'><strong>${title}</strong></div>";
                                }elseif($site=='young'){
                                    $site_name = 'ヤングエースUP';
                                    $site_url = 'https://web-ace.jp/youngaceup/';
                                    echo"<div class='ml-2 mt-2 h5'><strong>${title}</strong></div>";
                                }
                                elseif($site=='tonari'){
                                    $site_name = 'となりのヤングジャンプ';
                                    $site_url = 'https://tonarinoyj.jp/';
                                }
                                echo"<div class='ml-2 mt-1'>${detail}</div>";
        
                                echo"<div class='ml-2 mt-2'><a href='${site_url}'>${site_name}</a></div>";
                            echo"</div>";
                            echo"<div class='col-4'>";
                            echo"<a href=\"javascript:window.open('http://twitter.com/share?text='+encodeURIComponent('新着の公式WEBマンガをまとめていい感じに読める、Wevcomix。')+'&url='+encodeURIComponent('wevcomix.com'),'sharewindow','width=550, height=450, personalbar=0, toolbar=0, scrollbars=1, resizable=!');\">";
                                echo"<div><i class='fab fa-twitter-square fa-3x'></i></div>";
                                echo"<div>サイトをツイート</div>";
                            echo"</a>";
                            echo"</div>";
                        echo"</div>";

                        echo"<hr>";
                        echo"<div class='ml-2 mt-3 mb-3'><a id='${id_favo}' class='favo h5'>マイリストに追加</a></div>";
                        
                        echo"<a href='${link}'><div class='pl-2 pt-3 pb-3 mt-2 h5 read-comic'>この作品を読む</div></a>";
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
            require('php/db-pdo.php');
            manga_show($res_all,$pdo);
        ?>
    </div>

    <?php
        require("php/footer.php");
    ?>

    <div id="page_top"><a href="#"></a></div>
</body>

</html>
