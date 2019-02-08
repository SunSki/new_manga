<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ユーザー登録完了画面</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/manga-style.css">
    <script src="js/fade.js"></script>

    <?php
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
                    $sql = "insert into users (name) values ('$name')";
                    $result = $mysqli->query($sql); //SQL文の実行
                    echo "${name}で登録しました！<br>";
                    session_start();
                    $_SESSION['name'] = $name;
                    echo "<a href='auth.php'>ユーザーページへ行く</a>";
                }else{
                    echo "<div>${name}はすでに登録されています</div>";
                    echo "<a href='log-reg.php'>ログイン&登録ページへ戻る</a>";
                }
                $result->close(); // 結果セットを閉じる
            }else{
                echo"<div>登録する名前を入力してください</div>";
                echo "<a href='log-reg.php'>ログイン&登録ページへ戻る</a>";
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