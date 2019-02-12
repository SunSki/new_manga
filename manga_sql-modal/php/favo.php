<?php
    try {
        $pdo = new PDO('mysql:host=localhost; dbname=manga_alpha; charset=utf8','root','root',
        array(PDO::ATTR_EMULATE_PREPARES => false));
    } catch (PDOException $e) {
        exit('データベース接続失敗。'.$e->getMessage());
    }
?>

<?php
    //ajax送信でPOSTされたデータを受け取る
    $name = $_POST['post_name'];
    $title = $_POST['post_title'];

    //INSERT
    $stmt = $pdo -> prepare("INSERT INTO favo (name, title) VALUES (?, ?)");
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $title, PDO::PARAM_STR);
    $stmt->execute();

    //通信確認用
    $return_array = array($name, $title);
    //「$return_array」をjson_encodeして出力
    echo json_encode($return_array);
?>
