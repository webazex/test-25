<?php
spl_autoload_register(function ($str){
    if(strpos($str, "Webazex") !== false){
        $trueStr = str_replace("Webazex\\", '', $str);
        require_once $trueStr.'.php';
    }
});