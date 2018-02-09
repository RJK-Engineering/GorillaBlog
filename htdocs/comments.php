<?php

require_once('GorillaBlogDb.php');
require_once('GetRequestData.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, X-Request');
header('Content-Type: application/json');

$db = new GorillaBlogDb();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $response = [ 'comments' => $db->getComments() ];
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $reqData = GetRequestData();
    $db->insertComment($reqData['articleId'], $reqData['comment']);
    $commentId = $db->lastInsertId();
    $response = [ 'id' => $commentId ];
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $reqData = GetRequestData();
    $db->insertComment($reqData['commentId']);
    $response = [ 'id' => $reqData['commentId'] ];
} else {
    http_response_code(400);
    exit;
}

echo json_encode($response);

?>
