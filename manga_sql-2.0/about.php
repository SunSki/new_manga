<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>新着WEBマンガ一覧</title>
    <?php
        require('php/head.php');
    ?>
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

    <div class="container" id="main">
        <div class="bg-light p-4 m-4 rounded">
            <div class="h2">Wevcomixとは？</div>
            <hr>
            <div>
                <div class="mb-1 h4">概要</div>
                <ul class="ml-4">
                    <li>複数のWEBマンガサイトの新着マンガを、いい感じに読めるサービス</li>
                    <li>WEBマンガ読み慣れている人向けです。</li>
                    <li>30日以内に更新された作品を公開しています。</li>
                    <li>一日2回スクレイピングしているのでリンク切れがありません。</li>
                    <li>現在は
                        <span><a href="https://shonenjumpplus.com/series">少年ジャンプ+</a></span>、
                        <span><a href="https://tonarinoyj.jp/series">となりのヤングジャンプ</a></span>、
                        <span><a href="https://web-ace.jp/youngaceup/contents/">ヤングエースUP</a></span>のみ対応しています。
                    </li>
                    <li><a href="log-reg.php">ログイン</a>して、お気に入りにマンガを登録して見ることができます。</li>
                    <li>Webじゃないよ、Wevだよ。</li>
                    <li>このページ作ったけど、多分ほとんど誰も見ない。</li>
                </ul>
                <div class="mt-3 mt-4 mb-2 h4">使用言語</div>
                <div>html, css, php, python</div>
            </div>
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