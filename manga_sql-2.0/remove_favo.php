<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お気に入り削除</title>
    <?php
        require('php/head.php');
        require('php/db-con.php');

        function removeShow($mysqli, $json){
            $name = $_SESSION['name'];
            $sql = "select * from favo where name = '$name'";
            $resultShow = $mysqli->query($sql);
            if($resultShow->num_rows > 0){
                echo"<div class='container' style='margin-bottom:120px'>";
                echo"<div class='h3 mt-5 white'>削除する作品を選択</div>";
                echo"<form method='post' action='auth.php'>";
                    echo "<div class='cp_ipcheck mb-5'>";
                        foreach($json as $item){//jsonを巡回
                            $jsonTitle = $item->title;
                            $resultShow = $mysqli->query($sql);
                            
                            while ($row = $resultShow->fetch_assoc()){//データベースを巡回
                                $title = $row["title"];
                                if($title==$jsonTitle){
                                    $link = $item->link;
                                    $date = $item->date;
                                    echo "<div class='list_item'>";
                                        echo "<input type='checkbox' name='removeFavo[]' value='${title}' class='option-input' id='${link}'>";
                                    echo "<label for='${link}'>${title}</label>";
                                echo "</div>";
                                    break;
                                }
                            }
                            $resultShow->close();
                        }
                    echo "</div>";
                echo "<input type='submit' value='お気に入りを削除' class='del-botton fixed-bottom'>";
                echo"</form>";
                echo"</div>";
            }else{
                echo "<div class='container'>";
                    echo "<div>お気に入りが存在しません。</div>";
                    echo "<a href='auth.php'>ユーザーページへ戻る</a>";
                echo "</div>";
            }
        }

        function show($mysqli,$name){
            require('php/json_get.php');
            removeShow($mysqli,$res_all);
        }

        $state;//0:ログインしてる 1:ログインしてない
        session_start();//セッション開始
        if(isset($_SESSION['name'])){
            $name = $_SESSION['name'];
            $state = 0;
        } else {
            $state = 1;
        }
    ?>
</head>

<body>
    <!-- <div class='top pt-2 pb-2' id="header">
        <nav class="navbar justify-content-between sticky-top">
            <div class="logo ml-4">
                    <a href="index.php">新着WEBマンガ</a>
            </div>
            <div class="text-left ml-4 mr-4">
                <?php
                    if($state == 0){
                        echo"<a href='auth.php' class='mypage mr-3'>${name}のページ</a>";
                    }
                ?>
                <a href="log-reg.php" class="square_btn">ログイン & 登録</a>
            </div>
        </nav>
    </div> -->
    <?php
        require("php/header.php");
    ?>
    
    <div id="main">
        <?php
            if(state == 0){
                $name = $_SESSION['name'];
                show($mysqli,$name);
            }else{ 
                echo "<div>ログインしていません。</div>";
            }
        ?>
    </div>
</body>

<?php
    $mysqli->close();
?>

</html>
