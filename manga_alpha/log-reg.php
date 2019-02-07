<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ログイン&登録</title>
    <link rel="stylesheet" type="text/css" href="reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="manga-style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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

<body>

    <div class='top pt-2 pb-2'>
        <nav class="navbar justify-content-between sticky-top">
            <div class="logo ml-4">
                    <a href="index.php">新着WEBマンガ</a>
            </div>
            <div class="text-right mr-4">
                <a href="auth.php" class="mypage mr-3">Myページ</a>
                <a href="log-reg.php" class="square_btn">ログイン & 登録</a>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="row mt-5">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="mb-5 p-5 shadow-sm">
                    <form action="auth.php" method="post">
                        <h3>ログイン</h3>
                        <input type="text" name="login" class="input">
                        <input type="submit" value="Login" class="log-reg-input mt-3">
                    </form>
                </div>
                
                <div class="mb-5 p-5 shadow-sm">
                    <form action="reg.php" method="post">
                        <h3>登録</h3>
                        <input type="text" name="reg" class="input">
                        <input type="submit" value="Registration" class="log-reg-input mt-3">
                    </form>
                </div>
                <!-- <?php
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
                ?> -->
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <footer class="fixed-bottom">
        <div class="container">
            <a href='about.html' class="about-site">このサイトについて</a>
        </div>
    </footer>

</body>

<?php
    $mysqli->close();
?>

</html>