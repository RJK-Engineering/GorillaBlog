<?php

require_once('GorillaBlogDb.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, X-Request');
header('Content-Type: application/json');

GetCategories();

function GetCategories() {
    $db = DbConnect();

    $sql = "select * from categories";
    $statement = $db->prepare($sql);
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($res, JSON_NUMERIC_CHECK);
}

?>