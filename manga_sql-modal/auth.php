<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <title>Wevcomix</title>

    <?php
        ini_set('display_errors', 1);#エラーを表示させる
        date_default_timezone_set('Asia/Tokyo');#標準時間を日本に設定
        require('php/head.php');
    ?>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://code.jquery.com/jquery-migrate-3.0.1.min.js' integrity='sha256-F0O1TmEa4I8N24nY0bya59eP6svWcshqX1uzwaWC4F4='crossorigin='anonymous'></script>
    <script src='js/iziModal.js'></script>
    <script src='js/up.js'></script>
    <script src='js/fade.js'></script>

    <?php
        require('php/db-con.php');

        function week ($date){
            $datetime = new DateTime($date);
            $week = array("日", "月", "火", "水", "木", "金", "土");
            $w = (int)$datetime->format('w');
            return "(". $week[$w] . ")";
        }
        
        #お気に入り消去ボタンが押された時
        function removeFavo($mysqli){
            if(!empty($_GET["removeFavo"])){
                $name = $_SESSION['name'];
                $favoTitle = $_GET["removeFavo"];
                $sql = "delete from favo where name = '$name' and title = '$favoTitle'";
                $resultCheck = $mysqli->query($sql);
            }
        }

        function siteShow($site){
            if($site == 'plus'){
                return '少年ジャンプ+';
            }elseif($site == 'tonari'){
                return 'となりのヤングジャンプ';
            }elseif($site == 'young'){
                return 'ヤングエース';
            }else{
                return '';
            }
        }

        #ユーザーのお気に入りを表示
        function showFavo($mysqli, $json){
            $today = date("Y/m/d");
            $date_now ='';
            $name = $_SESSION['name'];
            $sql = "select * from favo where name = '$name'";
            $resultShow = $mysqli->query($sql);

            //お気に入り一覧を表示
            if($resultShow->num_rows > 0){
                echo "<div class='favo-top mb-4 ml-4 white'><a href='auth.php'>${name}のリスト</a></div>";
                echo "<div class='manga-list' id='user-favo'>";

                    $id = 0;
                    $id_favo = 1000;
                    foreach($json as $item){//jsonを巡回
                        $jsonTitle = $item->title;
                        $img = $item->img;
                        $resultShow = $mysqli->query($sql);
                        while ($row = $resultShow->fetch_assoc()){//データベースを巡回
                            $title = $row["title"];
                            if($title==$jsonTitle){
                                $link = $item->link;
                                $date = $item->date;
                                $site = $item->site;
                                $title = $item->title;
                                $detail = $item->detail;
                                if($date_now != $date){
                                    if($date_now != ''){  #初回以降適用
                                        echo "</ul><hr>";####1閉じる ul
                                    }
                                    
                                    $week = week($date);
                                    $scroll_date = substr($date,5,5);
                                    if($week == "(月)"){
                                        echo "<div class='pl-3 mb-4 index_date mon'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                                    }elseif($week == "(火)"){
                                        echo "<div class='pl-3 mb-4 index_date tue'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                                    }elseif($week == "(水)"){
                                        echo "<div class='pl-3 mb-4 index_date wed'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                                    }elseif($week == "(木)"){
                                        echo "<div class='pl-3 mb-4 index_date thr'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                                    }elseif($week == "(金)"){
                                        echo "<div class='pl-3 mb-4 index_date fri'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                                    }elseif($week == "(土)"){
                                        echo "<div class='pl-3 mb-4 index_date sat'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                                    }elseif($week == "(日)"){
                                        echo "<div class='pl-3 mb-4 index_date sun'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                                    }
                                    
                                    echo "<ul class='horizontal-list pl-3'>";####1開始 ul
                                }
                                $date_now = $date;

                                echo "<li class='item mr-3'>";

                                    #モーダル設定
                                    echo"<script type='text/javascript'>";
                                        echo"$(function () {";
                                            echo"$('#$id').iziModal();";
                                        echo"})";
                                    echo"</script>";

                                    #モーダルで表示するものを設定
                                    echo"<div id='$id' class='modal' data-izimodal-title='$title'>";

                                        echo"<img src=${img} width='100%'>";
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
                                        //削除ボタン 
                                        echo"<form method='get' action='auth.php'>";
                                            echo "<button type='submit' value='$title' name='removeFavo' class='ml-2 mt-2'>マイリストから削除</button>";
                                        echo"</form>";

                                        echo"<a href='${link}'><div class='pl-2 pt-3 pb-3 h5 read-comic'>この作品を読む</div></a>";

                                    echo"</div>";


                                    //サムネイルの表示
                                    echo "<a href='${link}' class='thumbnail' data-izimodal-open='#$id'>";
                                        echo "<div class='title'>";
                                            echo "<div><img src='${img}' class='shadow-sm' width='100%' height='160px'></div>";
                                            if($site == "young" || $site == "ura"){
                                                echo "<div class='title'>${title}${detail}</div>";
                                            }else{
                                                echo "<div class='title'>${detail}</div>";
                                            }
                                        echo "</div>";
                                    echo"</a>";



                                echo"</li>";

                                break;
                            }
                        }
                        $resultShow->close();
                        $id+=1;
                        $id_favo+=1;
                    }
                echo "</ul>";####1閉じる ul
            echo "</div>";

            }else{
                $user_name = $_SESSION['name'];
                echo "<div class='white ml-4 mt-4 h4'>ようこそ${user_name}さん</div>";
                echo "<div class='favo-top mb-4 ml-4 mr-4 h4 p-2 favo-add-top .rounded'>マイリストに追加すると作品が表示されます</div>";
            }
        }

        function userShow($name,$mysqli){
            require('php/json_get.php');

            #ボタンが押された時の処理
            removeFavo($mysqli);

            #ユーザーのお気に入りを表示
            showFavo($mysqli, $res_all);

            echo "<hr>";
        }

        session_start();//セッション開始

        $state;//状態の振り分け 0:初回ログイン,1:名前なし,2:セッションでログイン,3:不正なアクセス       
        if(!empty($_POST["login"])){
            $name = $_POST["login"];
            $sql = "select * from users where name = '$name'";
            $result = $mysqli->query($sql); //SQL文の実行

            if($result->num_rows != 0){

                $name = $_POST["login"];
                $_SESSION['name'] = $name;
                //echo "ログイン成功！<br>";
                $state = 0;
            }else{
                //名前が登録されていない時
                $state = 1;
            }
        }else if(isset($_SESSION['name'])){
            //echo "セッションからログイン<br>";
            $name = $_SESSION['name'];
            $state = 2;
        }else{
            //セッションなしで、直接URL
            $state = 3;
        }
    ?>

</head>

<body>

    <?php
        require('php/header.php');
    ?>


    <div id="main">
        <?php
            if($state == 0){//ログイン
                userShow($name,$mysqli);
                echo"<div class='mt-5'>";
                    require('php/footer-fix.php');
                echo"</div>";
                
            }
            elseif($state == 1){//ユーザー名なし
                echo "<div class='container text-center'>";
                    echo "<div class='h2 mt-5 mb-3 white'>ユーザー名がありません</div>";
                    //echo"<iframe class='youtube mt-3' src='https://www.youtube.com/embed/L5HBVl5YYlU' frameborder='0' allowfullscreen></iframe>";
                    echo "<div class='mt-5 not-found-btn'><a href='log-reg.php'>ログイン & 登録ページ</a></div>";
                echo "</div>";
            }
            elseif($state == 2){//セッションあり
                userShow($name,$mysqli);
                echo"<div class='mt-5'>";
                    require('php/footer-fix.php');
                echo"</div>";
            }
            else{//ログインしてください
                echo "<div class='container text-center'>";
                    echo "<div class='h2 mt-5 mb-3 white'>ログインして下さい</div>";
                    //echo "<iframe class='youtube mt-3' src='https://www.youtube.com/embed/L5HBVl5YYlU' frameborder='0' allowfullscreen></iframe>";
                    echo "<div class='mt-5 not-found-btn'><a href='log-reg.php'>ログイン & 登録ページ</a></div>";
                echo "</div>";
            }
        ?>
    </div>
    

</body>

<!-- <div id="page_top"><a href="#"></a></div> -->

<?php
    $mysqli->close();
?>

</html>