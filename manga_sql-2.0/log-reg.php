<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン&登録</title>
    <?php
        require('php/head.php');
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
                        <h3 class='white'>ログイン</h3>
                        <input type="text" name="login" class="input">
                        <input type="submit" value="Login" class="log-reg-input mt-3">
                    </form>
                </div>
                
                <div class="mb-5 p-5 shadow log-reg-box">
                    <form action="reg.php" method="post">
                        <h3 class='white'>登録</h3>
                        <input type="text" name="reg" class="input">
                        <input type="submit" value="Registration" class="log-reg-input mt-3">
                    </form>
                </div>

                <div>
                    <div class="h5 mb-5" style="color:white">初回で登録してログインすると、<br>次回からMyページでログインできます。</div>
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

</body>

<?php
    $mysqli->close();
?>

</html>