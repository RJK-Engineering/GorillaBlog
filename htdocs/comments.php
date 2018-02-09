<?php

require_once('GorillaBlogDb.php');
require_once('GetRequestData.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, X-Request');
header('Content-Type: application/json');

$db = new GorillaBlogDb();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['articleId'])) {
        $response = [ 'comments' => $db->getComments($_GET['articleId']) ];
    } else {
        http_response_code(400);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $put = GetRequestData();
    $db->insertArticle($put['title'], $put['text']);
    $articleId = $db->lastInsertId();
    $db->setCategories($articleId, $put['categories']);
    $response = [ 'id' => $articleId ];
} else {
    http_response_code(400);
    exit;
}

echo json_encode($response);

?>
