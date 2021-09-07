<?php
    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    

    $host = "localhost";
    $username = "root";
    $password = "Re89on2#23";
    $db = "clinicria";
    //$host = "localhost:3306";
    //$password = "itilria#8kk0";
    //$username = "itilrtzg_itilria";
    //$db = "itilrtzg_itilria";

    $mysqli = new mysqli($host, $username, $password, $db);

    if($mysqli->connect_error){
        echo "problem occured could not connect " .$mysqli->connect_error;
        exit();
    }
?>