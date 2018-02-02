<?php

require_once('GorillaBlogDb.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, X-Request');
header('Content-Type: application/json');

if (isset($_GET['category'])) {
    GetArticlesByCategory($_GET['category']);
} else {
    GetArticles();
}

function GetArticles() {
    $db = DbConnect();

    $sql = "select * from articles";
    $statement = $db->prepare($sql);
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($res, JSON_NUMERIC_CHECK);
}

function GetArticlesByCategory($category) {
    $db = DbConnect();

    $sql = "select a.id, a.title, a.text"
        .   " from articles a"
        .   " join article_categories ac"
        .     " on ac.article_id = a.id"
        .   " join categories c"
        .     " on ac.category_id = c.id"
        .  " where c.title = :category";
    $statement = $db->prepare($sql);
    $statement->bindParam(':category', $category);
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($res, JSON_NUMERIC_CHECK);
}

?>
