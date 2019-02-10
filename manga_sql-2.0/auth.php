<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <title>ユーザーマンガ一覧</title>

    <?php
        ini_set('display_errors', 1);#エラーを表示させる
        date_default_timezone_set('Asia/Tokyo');#標準時間を日本に設定
        require('php/head.php');
        require('php/db-con.php');

        function week ($date){
            $datetime = new DateTime($date);
            $week = array("日", "月", "火", "水", "木", "金", "土");
            $w = (int)$datetime->format('w');
            return "(". $week[$w] . ")";
        }
        
        #お気に入り追加ボタンが押された時
        function addFavo($mysqli){
            if(!empty($_POST["addFavo"])){
                $addFavo_list = $_POST["addFavo"];
                $name = $_SESSION['name'];
                foreach($addFavo_list as $favoTitle){
                    $sql = "select * from favo where name = '$name' and title = '$favoTitle'";
                    $resultCheck = $mysqli->query($sql);
                    if ($resultCheck->num_rows == 0){   #何か選択されていたら
                        $sql = "insert into favo (name, title) values ('$name', '$favoTitle')";
                        $resultAdd = $mysqli->query($sql);
                    }
                    $resultCheck->close();
                }
                
            }
        }
        #お気に入り消去ボタンが押された時
        function removeFavo($mysqli){
            if(!empty($_POST["removeFavo"])){
                $name = $_SESSION['name'];
                $removeFavo_list = $_POST["removeFavo"];
                foreach($removeFavo_list as $favoTitle){
                    $sql = "delete from favo where name = '$name' and title = '$favoTitle'";
                    $resultCheck = $mysqli->query($sql);
                }
                $resultCheck = $mysqli->query($sql);
            }
        }

        function siteImg($site){
            if($site == 'plus'){
                return 'img/jumpplus_red.png';
            }elseif($site == 'tonari'){
                return 'img/tonari.png';
            }elseif($site == 'young'){
                return 'img/youngaceup-logo.png';
            }else{
                return '';
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
                echo "<div class='favo-top mb-4'><a href='auth.php'>お気に入り一覧</a></div>";
                echo "<div class='manga-list' id='user-favo'>";
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
                                $site = siteShow($site);
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

                                echo "<li class='item mr-5'>";
                                    echo "<a href='${link}'>";
                                        echo "<div class='title'>";
                                            echo "<div><img src='${img}' class='shadow-sm' width='100%'></div>";
                                            if($site == "young"){
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
                    }
                echo "</ul>";####1閉じる ul
            echo "</div>";
            echo "<hr>";
            echo "<div><a href='remove_favo.php' class='del-btn'>お気に入り削除ページ</a></div>";
            }
        }

        function favo_input($res,$mysqli){
            $name = $_SESSION['name'];
            $site = $res[0]->site;
            $img_url = siteImg($site);

            echo "<img src=${img_url}  class='worksImg'>";//サイトの画像
            echo "<hr>";
            echo "<div class='cp_ipcheck'>";//チェックボックスのデザイン
            foreach($res as $item){
                $title = $item->title;
                $sql = "select * from favo where name = '$name' and title = '$title'";
                $resultFavo = $mysqli->query($sql);
                if($resultFavo){
                    if($resultFavo->num_rows == 0){
                        $link = $item->link;
                        $date = $item->date;
                        //echo "<input type='checkbox' name='addFavo[]' value='$title'><a href='$link' target='_blank'>$title</a>date:$date<br>";
                        echo "<div class='list_item'>";
                            echo "<input type='checkbox' name='addFavo[]' value='${title}' class='option-input' id='${link}'>";
                            echo "<label for='${link}'>${title}</label>";
                        echo "</div>";
                    }
                    $resultFavo->close();
                }
            }
            echo "</div>";

        }

        function userShow($name,$mysqli){
            require('php/json_get.php');

            #ボタンが押された時の処理
            removeFavo($mysqli);
            addFavo($mysqli);

            #ユーザーのお気に入りを表示
            showFavo($mysqli, $res_all);

            echo "<hr>";

            echo "<form method='post' action='auth.php'>";
                echo "<div class='container pb-5'>";
                echo "<h4 class='mb-4'>作品一覧</h4>";
                echo "<div class='row'>";
                    echo "<div class='col-md-4'>";
                        favo_input($res_plus,$mysqli);
                    echo "</div>";
                    echo "<div class='col-md-4'>";
                        favo_input($res_tonari,$mysqli);
                    echo "</div>";
                    echo "<div class='col-md-4'>";
                        favo_input($res_young,$mysqli);
                    echo "</div>";
                echo "</div>";
                echo"</div>";
                echo"<div class='text-center'><input type='submit' value='お気に入りに追加' id='add' class='favo-btn '></div>";            
            echo"</form>";
        
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
    <!-- ログインの有無でユーザー名を表示するか決める -->
    <div class='top pt-2 pb-2' id="header">
        <nav class="navbar justify-content-between sticky-top">
            <div class="logo ml-4">
                    <a href="index.php">新着WEBマンガ</a>
            </div>
            <div class="text-left ml-4 mr-4 mypage-head">
                <?php
                    if($state == 0 or $state == 2){
                        $name = $_SESSION['name'];
                        echo"<a href='auth.php' class='mypage mr-3'>${name}のページ</a>";
                    }
                ?>
                <a href="log-reg.php" class="square_btn">ログイン & 登録</a>
            </div>
        </nav>
    </div>


    <div id="main">
        <?php
            if($state == 0){//ログイン
                userShow($name,$mysqli);
            }
            elseif($state == 1){//ユーザー名なし
                echo "<div class='container text-center'>";
                    echo "<div class='h2 mt-5 mb-3'>ユーザー名がありません</div>";
                    echo "<div><img src='img/not-found.png' width='60%'></div>";
                    echo "<div class='mt-5 not-found-btn'><a href='log-reg.php'>ログイン & 登録ページ</a></div>";
                echo "</div>";
                require('php/footer-fix.php');
            }
            elseif($state == 2){//セッションあり
                userShow($name,$mysqli);
            }
            else{//ログインしてください
                echo "<div class='container text-center'>";
                    echo "<div class='h2 mt-5 mb-3'>ログインして下さい</div>";
                    echo "<div><img src='img/not-found.png' width='60%'></div>";
                    echo "<div class='mt-5 not-found-btn'><a href='log-reg.php'>ログイン & 登録ページ</a></div>";
                echo "</div>";
                require('php/footer-fix.php');
            }
        ?>
    </div>
    
    <?php
        require('php/footer.php');
    ?>

</body>

<div id="page_top"><a href="#"></a></div>

<?php
    $mysqli->close();
?>

</html>