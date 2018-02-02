<?php

function DbConnect() {
    $dbserver = "localhost";
    $dbname = "gorillablog";
    $dbuser = "gorillablog";
    $dbpass = "gorillablog";

    $db = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpass);

    return $db;
}

?>
