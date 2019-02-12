<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Wevcomix</title>

    <?php   #初期設定
        require('php/head.php');
        date_default_timezone_set('Asia/Tokyo');
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js" integrity="sha256-F0O1TmEa4I8N24nY0bya59eP6svWcshqX1uzwaWC4F4="
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="./js/iziModal.js"></script>

</head>

<body>
    <script type="text/javascript">
        $(function () {
            $(".iziModal").iziModal();
        })
    </script>
    <div class="iziModal" data-izimodal-title="ボタン" data-izimodal-subtitle="サブボタン">
        <p>コンテンツ</p>
    </div>
    <a href="#" data-izimodal-open=".iziModal">リンク</a>

</body>

</html>
