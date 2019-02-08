<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ログイン&登録</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/manga-style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/fade.js"></script>
    <?php
        require('php/db-con.php');
    ?>
</head>

<body>
    <?php
        require('php/header.php');
    ?>

    <div class="container" id="main">
        <div class="row mt-5">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="mb-5 p-5 shadow log-reg-box">
                    <form action="auth.php" method="post">
                        <h3>ログイン</h3>
                        <input type="text" name="login" class="input">
                        <input type="submit" value="Login" class="log-reg-input mt-3">
                    </form>
                </div>
                
                <div class="mb-5 p-5 shadow log-reg-box">
                    <form action="reg.php" method="post">
                        <h3>登録</h3>
                        <input type="text" name="reg" class="input">
                        <input type="submit" value="Registration" class="log-reg-input mt-3">
                    </form>
                </div>

                <div>
                    <div class="h5">初回で登録してログインすると、<br>次回からMyページでログインできます。</div>
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

    <?php
        require('php/footer-fix.php');
    ?>
</body>

<?php
    $mysqli->close();
?>

</html>