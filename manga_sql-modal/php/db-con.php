<?php
    //接続用パラメータの設定
    $host = 'localhost'; //データベースが動作するホスト
    $user = 'root'; //ユーザ名（各自が設定）
    $pass = 'root'; //パスワード（各自が設定）
    $dbname = 'manga_alpha';//データベース名（各自が設定）

    // mysqliクラスのオブジェクトを作成
    //mysqliにSQLを送る
    $mysqli = new mysqli($host,$user,$pass,$dbname);
    
    if ($mysqli->connect_error) { //接続エラーになった場合
        echo $mysqli->connect_error; //エラーの内容を表示
        exit();//終了
    } else {
        $mysqli->set_charset("utf8"); //文字コードを設定
    }

    
?>
