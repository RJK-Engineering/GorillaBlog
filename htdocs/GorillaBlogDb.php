<?php

function DbConnect() {
    $dbserver = getenv('GORILLABLOG_DBSERVER');
    $dbname = getenv('GORILLABLOG_DBNAME');
    $dbuser = getenv('GORILLABLOG_DBUSER');
    $dbpass = getenv('GORILLABLOG_DBPASS');

    $db = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpass);

    return $db;
}

?>
