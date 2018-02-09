<?php

require_once('../GorillaBlogDb.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, X-Request');
header('Content-Type: application/json');

$db = new GorillaBlogDb();

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $put = GetRequestData();
    $db->insertArticle($put['title'], $put['text']);
    $articleId = $db->lastInsertId();
    $db->setCategories($articleId, $put['categories']);
    $response = [ 'id' => $articleId ];
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db->updateArticle($_POST['id'], $_POST['title'], $_POST['text']);
    $db->setCategories($_POST['id'], $_POST['categories']);
    $response = [ 'id' => $_POST['id'] ];
} else {
    http_response_code(400);
    exit;
}

echo json_encode($response);

function GetRequestData() {
    parse_str(file_get_contents('php://input'), $data);
    return $data;
}

?>
