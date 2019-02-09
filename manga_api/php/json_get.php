<?php
    function jsonDecode($link){
        $json = file_get_contents($link);
        return json_decode($json);
    }
    $res_plus = jsonDecode('http://127.0.0.1:5042/get/plus');
    $res_tonari = jsonDecode('http://127.0.0.1:5042/get/tonari');
    $res_young = jsonDecode('http://127.0.0.1:5042/get/young');
    $res_all = jsonDecode('http://127.0.0.1:5042/get/all');
?>
