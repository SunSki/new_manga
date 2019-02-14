<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Wevcomix</title>
    <?php
        require('php/head.php');
    ?>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://code.jquery.com/jquery-migrate-3.0.1.min.js' integrity='sha256-F0O1TmEa4I8N24nY0bya59eP6svWcshqX1uzwaWC4F4='crossorigin='anonymous'></script>
    <script src='js/iziModal.js'></script>
    <script src='js/up.js'></script>
    <script src='js/fade.js'></script>
    
    <style>
        li {
            margin: 10px 0;
        }

        a {
            color: #E67A7A;
        }

        a:hover {
            cursor: pointer;
        }

        span {
            font-weight: bold;
        }

        i {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php
        require('php/header.php');
    ?>

    <div class="container about" id="main">
        <div class="bg-light p-4 m-4 rounded">
            <div class="h2"><span class="wevcomix">Wevcomix</span>とは？</div>
            <hr>
            <div>
                <div class="mb-1 h4">概要</div>
                <ul class="ml-4">
                    <li>新着の公式WEBマンガサイトをまとめて、いい感じに読めるサービス</li>
                    <li>現在は
                        <span><a href="https://shonenjumpplus.com/series">少年ジャンプ+</a></span>、
                        <span><a href="https://tonarinoyj.jp/series">となりのヤングジャンプ</a></span>、
                        <span><a href="https://web-ace.jp/youngaceup/contents/">ヤングエースUP</a></span>、
                        <span><a href="https://urasunday.com/">裏サンデー</a></span>
                        のみ対応しています。
                    </li>
                    <li>30日以内に更新された作品を公開しています。</li>
                    <li><a href="log-reg.php">ログイン</a>して、お気に入りにマンガを登録して見ることができます。</li>
                </ul>
            </div>
        </div>

        <div class="bg-light p-4 m-4 rounded">
            <div class="h2">お問い合わせ</div>
            <hr>
            <div class="h5 mb-3"><a target='_blank' href='https://docs.google.com/forms/d/e/1FAIpQLSc3Y4-rz5Wog8ITCk-kDzDAKzP2zfrLJRdKrBjtf0695UHADA/viewform'>こちらのフォームからご意見お願いします。</a></div>
        </div>
    
        <div class="bg-light p-4 m-4 rounded">
            <div class="h4">このサイトを共有</div>
            <hr>
            <a href="javascript:window.open('http://twitter.com/share?text='+encodeURIComponent('新着の公式WEBマンガをまとめていい感じに読める、Wevcomix。')+
            '&url='+encodeURIComponent('wevcomix.com'),'sharewindow','width=550, height=450, personalbar=0, toolbar=0, scrollbars=1, resizable=!');">
                <div><i class="fab fa-twitter-square fa-7x"></i></div>
            </a>
        </div>

        <div class="bg-light p-4 m-4 rounded">
            <div class="h4">制作者</div>
            <hr>
            <div class="row">
                <div class="col-sm-4">
                    <div class="mt-2 mb-2 h5">HiBiナツキ</div>
                </div>
                <div class="col-sm-8">
                    <ul class="ml-2">
                        <li><i class="fab fa-twitter"></i><a href="https://twitter.com/HibiNext" target="_blank">Twitter</a></li>
                        <li><i class="fab fa-github"></i><a href="https://github.com/SunSki" target="_blank">GitHub</a>
                        </li>
                        <li><i class="fas fa-blog"></i><a href="https://natsuki.themedia.jp/" target="_blank">ブログ</a>
                        </li>
                        <li><i class="fab fa-youtube"></i><a href="https://www.youtube.com/user/hibinatsuki/" target="_blank">Youtube</a></li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</body>

</html>