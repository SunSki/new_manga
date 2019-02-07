<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お気に入り削除</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="manga_style.css">
    <?php
        //接続用パラメータの設定
        $host = 'localhost';
        $user = 'root';
        $pass = 'root'; 
        $dbname = 'manga_alpha';
        $mysqli = new mysqli($host,$user,$pass,$dbname);
        if ($mysqli->connect_error) { 
            echo $mysqli->connect_error;
            exit();
            } else {
                $mysqli->set_charset("utf8");
            }

        function removeShow($mysqli, $json){
            $name = $_SESSION['name'];
            $sql = "select * from favo where name = '$name'";
            $resultShow = $mysqli->query($sql);
            if($resultShow->num_rows > 0){
                echo"<div class='container'>";
                echo"<form method='post' action='auth.php'>";
                    echo "<div class='cp_ipcheck'>";
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
                echo "<input type='submit' value='お気に入りを削除' class='del-botton mt-3'>";
                echo"</form>";
                echo"</div>";
            }else{
                echo "<div class='container'>";
                    echo "<div>お気に入りが存在しません。</div>";
                    echo "<a href='auth.php'>ユーザーページへ戻る</a>";
                echo "</div>";
            }
        }

        function jsonDecode($link){
            $json = file_get_contents($link);
            return json_decode($json);
        }

        function show($mysqli,$name){   
            $res_all = jsonDecode('http://localhost:3001/get_all');
            removeShow($mysqli,$res_all);
        }

        $state;
        session_start();//セッション開始
        if(isset($_SESSION['name'])){
            $name = $_SESSION['name'];
            $state = 0;
        } else {
            $state = 1;
        }

    ?>
</head>

<header>
    <div class="container">
        <div class="row">
            <div class="col-md logo">
                <a href="index.php">新着WEBマンガ</a>
            </div>
            <div class="col-md text-right">
                <?php
                    if($state == 0){
                        echo"<a href='auth.php' class='mypage mr-3'>${name}のページ</a>";
                    }
                ?>
                <a href="log-reg.php" class="square_btn">ログイン & 登録</a>
            </div>
        </div>
    </div>
</header>

<body>
    <?php
        if(state == 0){
            $name = $_SESSION['name'];
            show($mysqli,$name);
        }else{
            echo "ログインしていません。";
        }
        
    ?>

</body>

<?php
    $mysqli->close();
?>

</html>
