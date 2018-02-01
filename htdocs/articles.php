<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, X-Request');
header('Content-Type: application/json');

GetArticles();

function GetArticles() {
    $db = DbConnect();

    $sql = "select * from articles";
    $statement = $db->prepare($sql);
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($res, JSON_NUMERIC_CHECK);
}

function DbConnect() {
    $dbserver = "localhost";
    $dbname = "gorillablog";
    $dbuser = "gorillablog";
    $dbpass = "gorillablog";

    $db = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpass);

    return $db;
}

?>
