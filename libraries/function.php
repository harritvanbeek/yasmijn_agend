<?php

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

function escape($data){
    return htmlentities($data, ENT_QUOTES, 'UTF-8');
}

function TeamDev(){
    //you can set here your local ip
    if(USER_IP === "192.168.2.9"){
        return true;
    }
}

function debug($data, $options = null){
    echo "<pre>", print_r($data, $options), "</pre>";
}
