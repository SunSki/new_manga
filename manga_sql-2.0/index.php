<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Wevcomix</title>

    <?php
        require('php/head.php');

        date_default_timezone_set('Asia/Tokyo');

        function week ($date){
            $datetime = new DateTime($date);
            $week = array("日", "月", "火", "水", "木", "金", "土");
            $w = (int)$datetime->format('w');
            return "(". $week[$w] . ")";
        }

        function manga_show($res){
            $today = date("Y/m/d");
            $date_now ='';
            echo "<div id='index_manga'>";
            echo "<ul>";
            foreach($res as $item){
                $title = $item->title; //書籍のタイトル
                $link = $item->link; //書籍のリンク
                $date = $item->date;
                $img = $item->img;
                $site = $item->site;
                $detail = $item->detail;
                if ($date_now != $date){
                    echo"</ul>";
                    //echo "<hr>";

                    $week = week($date);
                    $scroll_date = substr($date,5,5);
                    if($week == "(月)"){
                        echo "<div class='pl-3 mb-2 index_date mon'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(火)"){
                        echo "<div class='pl-3 mb-2 index_date tue'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(水)"){
                        echo "<div class='pl-3 mb-2 index_date wed'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(木)"){
                        echo "<div class='pl-3 mb-2 index_date thr'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(金)"){
                        echo "<div class='pl-3 mb-2 index_date fri'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(土)"){
                        echo "<div class='pl-3 mb-2 index_date sat'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }elseif($week == "(日)"){
                        echo "<div class='pl-3 mb-2 index_date sun'><span id='month-day'>${scroll_date}</span><span id='week'>${week}</span></div>";
                    }
                    
                    echo "<ul class='horizontal-list pl-3'>";
                }
                $date_now = $date;
                echo "<li class='item mr-2'>";
                    echo "<a href='${link}'>";
                        echo "<div class='title'>";
                            echo "<div><img src='${img}' class='shadow-sm' width='100%' height='120px'></div>";
                            if($site == "young" || $site == "ura"){
                                echo "<div class='title'>${title}${detail}</div>";
                            }else{
                                echo "<div class='title'>${detail}</div>";
                            }
                            
                        echo "</div>";
                    echo"</a>";
                echo"</li>";
            }
            echo"</ul>";
            echo"</div>";
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
    <div class="manga-list" id="main">
        <?php
            manga_show($res_all);
        ?>
    </div>


    <?php
        require("php/footer.php");
    ?>

    <div id="page_top"><a href="#"></a></div>
</body>

</html>
