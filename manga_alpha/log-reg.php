<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン&登録</title>
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
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-8">
                <div class="mb-5">
                    <form action="auth.php" method="post">
                        <p>ログイン<br>
                        <input type="text" name="login"></p>
                        <input type="submit" value="ログイン">
                    </form>
                </div>
                
                <div class="mb-5">
                    <form action="reg.php" method="post">
                        <p>登録<br>
                        <input type="text" name="reg"></p>
                        <input type="submit" value="登録">
                    </form>
                </div>
                <?php
                    $sql = "select * from users";
                    $result = $mysqli->query($sql);
                    echo "<ユーザー一覧><br>";
                    if ($result) { //実行結果が正しければ
                        while ($row = $result->fetch_assoc()) {
                        echo $row["name"] . "<br>";
                        }
                        // 結果セットを閉じる
                        $result->close();
                    }else{
                        echo "なし";
                    }
                ?>
            </div>
        </div>




    </div>

</body>

<?php
    $mysqli->close();
?>

</html>