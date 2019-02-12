$.ajax({
    url: "ajax.php",
    type: "POST",
    dataType: "json",
    <?php
    echo"data : {post_name:'$name', post_title:'$title'},"
    ?>
    error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log("ajax通信に失敗しました");
    },
    success: function (response) {
        console.log("ajax通信に成功しました");
        console.log(response[0]);
        console.log(response[1]);
    }
});