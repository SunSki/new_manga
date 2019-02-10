<?php
ini_set('display_errors', 1);

try {
    // 接続
    $pdo = new PDO('sqlite:/Applications/MAMP/htdocs/new_manga/py/manga-list.db');

    // SQL実行時にもエラーの代わりに例外を投げるように設定
    // (毎回if文を書く必要がなくなる)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // トランザクション開始
	$pdo->beginTransaction ();

    // 選択 (プリペアドステートメント)
    $plus_q = $pdo->query("SELECT json FROM plus ORDER BY id DESC LIMIT 1");
    $tonari_q = $pdo->query("SELECT json FROM tonari ORDER BY id DESC LIMIT 1");
    $young_q = $pdo->query("SELECT json FROM young ORDER BY id DESC LIMIT 1");
    $all_q = $pdo->query("SELECT json FROM allManga ORDER BY id DESC LIMIT 1");

    $plus = $plus_q->fetchall();
    $tonari = $tonari_q->fetchall();
    $young = $young_q->fetchall();
    $all = $all_q->fetchall();

    foreach($plus as $row){
        $res_plus = json_decode($row[0]);
    }
    foreach($tonari as $row){
        $res_tonari = json_decode($row[0]);
    }
    foreach($young as $row){
        $res_young = json_decode($row[0]);
    }
    foreach($all as $row){
        $res_all = json_decode($row[0]);
    }
    $pdo = null;

} catch (Exception $e) {

    echo $e->getMessage() . PHP_EOL;
    
}
?>