<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <title>ユーザー登録完了画面</title>

    <?php
        require('php/head.php');
        require('php/db-con.php')
    ?>

</head>

<body>
    <?php
        require('php/header.php');
    ?>

    <div id="main">
        <?php
            //入力データの受取
            echo"<div class='container'>";
            if(!empty($_POST["reg"])){
                //POSTされた変数の受取
                $name = $_POST["reg"];
                //ユーザ名が既に使用されているかのチェック
                $sql = "select * from users where name = '$name'";
                $result = $mysqli->query($sql); //SQL文の実行
                if( $result->num_rows == 0){
                    echo "<div class='container text-center'>";
                        $sql = "insert into users (name) values ('$name')";
                        $result = $mysqli->query($sql); //SQL文の実行
                        echo "<div class='h2 mt-5 mb-3' style='color:white'>${name}で登録しました</div>";
                        session_start();
                        $_SESSION['name'] = $name;
                        echo "<div class='mt-5 not-found-btn'><a href='auth.php'>ユーザーページ</a></div>";
                    echo "</div>";
                }else{
                    echo "<div class='container text-center'>";
                        echo "<div class='h2 mt-5 mb-3' style='color:white'>その名前はすでに登録されています</div>";
                        echo "<div><img src='img/not_found.png' width='60%'></div>";
                        echo "<div class='mt-5 not-found-btn'><a href='log-reg.php'>ログイン & 登録ページ</a></div>";
                    echo "</div>";
                }
                $result->close(); // 結果セットを閉じる
            }else{
                echo "<div class='container text-center'>";
                    echo "<div class='h2 mt-5 mb-3' style='color:white'>名前を入力してください</div>";
                    echo "<div><img src='img/not_found.png' width='60%'></div>";
                    echo "<div class='mt-5 not-found-btn'><a href='log-reg.php'>ログイン & 登録ページ</a></div>";
                echo "</div>";
                require('php/footer-fix.php');
            }
            echo"</div>";
        ?>
    </div>
    <?php
        require('php/footer-fix.php');
    ?>
</body>

<?php
    $mysqli->close();
?>

</html>