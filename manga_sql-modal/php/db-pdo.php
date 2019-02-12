<?php
    try {
        $pdo = new PDO('mysql:host=localhost; dbname=manga_alpha; charset=utf8','root','root',
        array(PDO::ATTR_EMULATE_PREPARES => false));
    } catch (PDOException $e) {
        exit('データベース接続失敗。'.$e->getMessage());
    }
?>