<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>新着WEBマンガ一覧</title>

    <?php
        require('php/head.php');

        date_default_timezone_set('Asia/Tokyo');

        function week ($date){
            $datetime = new DateTime($date);
            $week = array("日", "月", "火", "水", "木", "金", "土");
            $w = (int)$datetime->format('w');
            echo $week[$w] . "曜日";
        }

        function day_diff($date1, $date2) {
            // 日付をUNIXタイムスタンプに変換
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
         
            // 何秒離れているかを計算
            $seconddiff = abs($timestamp2 - $timestamp1);
         
            // 日数に変換
            $daydiff = $seconddiff / (60 * 60 * 24);
         
            // 戻り値
            return $daydiff;
        }
        //$modeはタイトルを入れるかどうか
        // function manga_show($res,$mode){
        //     $today = date("Y/m/d");
        //     $date_now ='';
        //     foreach($res as $item){
        //         $title = $item->title; //書籍のタイトル
        //         $link = $item->link; //書籍のリンク
        //         $date = $item->date;
        //         $img = $item->img;
        //         $detail = $item->detail;
        //         echo "<div ml-1>";
        //             if ($date_now != $date){
        //                 echo "<hr>";
        //                 $ago = day_diff($today,$date);
        //                 if($ago!=0){
        //                     echo "<div class='ago'>${ago}日前</div>";
        //                 }else{
        //                     echo "<div class='ago'>本日更新</div>";
        //                 }
                        
        //                 echo "<div class='split-date'>$date</div>";
        //                 $week = week($date);
        //                 echo "<div class='split-date'>$week</div>";
        //             }
        //             $date_now = $date;
        //             echo "<div class='container'>";
        //             echo "<a href='${link}'>";
        //                 echo "<div class='row work-list pt-1 pb-1 mb-1 mt-1'>";
        //                     echo "<div><img src='${img}' class='manga-img'></div>";
        //                     if($mode == "title"){
        //                         echo "<div class='title'>${title}</div>";
        //                     }
        //                     echo "<div class='title'>${detail}</div>";
        //                     //echo "<div class='date'>${date}</div>";
        //                 echo "</div>";
        //             echo"</a>";
        //             echo "</div>";
        //         echo "</div>";
        //     }
        // }

        function manga_show($res){
            $today = date("Y/m/d");
            $date_now = '';

            $manga_list = [];
            $date_list = [];

            $first_flag = 0;
            $state = "working";
            $first_flag  = 0;
            foreach($res as $item){#リストの作成
                $title = $item->title;
                $link = $item->link;
                $date = $item->date;
                $img = $item->img;
                $site = $item->site;
                $detail = $item->detail;
                if($date_now != $date){
                    if($first_flag == 0){
                        $first_flag = 1;
                    }else{
                        array_push($date_list, $date_now);
                        array_push($manga_list, $manga_day_list);
                    }
                    $manga_day_list = [];
                }
                $date_now = $date;
                $manga_param_list = [];
                array_push($manga_param_list, $title,$link,$img,$site,$detail);
                array_push($manga_day_list, $manga_param_list);
            }
            array_push($date_list, $date_now);
            array_push($manga_list, $manga_day_list);

            #manga_list[day][item][0:title,1:link,2:img,3:site,4:detail]
            $day = 0;
            foreach($manga_list as $manga_day){
                echo("<div>$date_list[$day]</div>");
                $item_num = count($manga_day);
                echo "<div>";
                    echo $item_num;
                echo "</div>";
                $day += 1;
            }

        }


        function logo($img,$url){
            echo "<p><a href='${url}'><img src='${img}' height='30px'></a></p>";
        }
  
    ?>
</head>

<body>

    <?php
        require("php/json_get.php");
        require('php/header.php');
    ?>

    <?php
        manga_show($res_all);
    ?>

    <div id="page_top"><a href="#"></a></div>
</body>

</html>
