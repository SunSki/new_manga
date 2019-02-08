<?php
    function jsonDecode($link){
        $json = file_get_contents($link);
        return json_decode($json);
    }
    $res_plus = jsonDecode('http://localhost:3001/get_jampplus');
    $res_tonari = jsonDecode('http://localhost:3001/get_tonari');
    $res_young = jsonDecode('http://localhost:3001/get_young');
    $res_all = jsonDecode('http://localhost:3001/get_all');
?>