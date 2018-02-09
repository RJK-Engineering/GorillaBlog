<?php

require_once('../GorillaBlogDb.php');
require_once('../GetRequestData.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, X-Request');
header('Content-Type: application/json');

$db = new GorillaBlogDb();

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $reqData = GetRequestData();

    $db->insertArticle($reqData['title'], FormatText($reqData['text']));
    $articleId = $db->lastInsertId();

    $categories = isset($reqData['categories']) ? $reqData['categories'] : [];
    $db->setCategories($articleId, $categories);

    $response = [ 'id' => $articleId ];
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db->updateArticle($_POST['id'], $_POST['title'], FormatText($_POST['text']));

    $categories = isset($_POST['categories']) ? $_POST['categories'] : [];
    $db->setCategories($_POST['id'], $categories);

    $response = [ 'id' => $_POST['id'] ];
} else {
    http_response_code(400);
    exit;
}

echo json_encode($response);

function FormatText($text) {
    $formatted = preg_replace('/\n\r?\n\r?/', '</p><p>', $text);
    $formatted = '<p>' . $formatted . '</p>';
    $formatted = preg_replace('/\*(.+?)\*/', '<b>$1</b>', $formatted);
    $formatted = preg_replace('/_(.+?)_/', '<i>$1</i>', $formatted);
    return $formatted;
}

?>
