<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
    <link rel="stylesheet" type="text/css" href="reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="manga-style.css">
    <?php
        //接続用パラメータの設定
        $host = 'localhost'; //データベースが動作するホスト
        $user = 'root'; //ユーザ名（各自が設定）
        $pass = 'root'; //パスワード（各自が設定）
        $dbname = 'manga_alpha';//データベース名（各自が設定）

        // mysqliクラスのオブジェクトを作成
        $mysqli = new mysqli($host,$user,$pass,$dbname);
            if ($mysqli->connect_error) { //接続エラーになった場合
            echo $mysqli->connect_error; //エラーの内容を表示
            exit();//終了
        } else {
            //echo "You are connected to the DB successfully.<br>"; //正しく接続できたことを確認
            $mysqli->set_charset("utf8"); //文字コードを設定
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
                <a href="auth.php" class="mypage mr-3">Myページ</a>
                <a href="log-reg.php" class="square_btn">ログイン & 登録</a>
            </div>
        </div>
    </div>
</header>

<body>
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

</body>

<?php
    $mysqli->close();
?>

</html>