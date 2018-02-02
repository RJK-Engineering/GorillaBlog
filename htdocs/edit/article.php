<?php

require_once('../GorillaBlogDb.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, X-Request');
header('Content-Type: application/json');

if (isset($_POST['title'][0], $_POST['text'][0], $_POST['category'][0])) {
    if (isset($_POST['id'][0]) && $_POST['id'][0]) {
        UpdateArticle($_POST['id'][0], $_POST['title'][0], $_POST['text'][0], $_POST['category'][0]);
    } else {
        WriteArticle($_POST['title'][0], $_POST['text'][0], $_POST['category'][0]);
    }
} else {
    http_response_code(400);
    exit;
}

function UpdateArticle($id, $title, $text, $category) {
    $db = DbConnect();

    $sql = "update articles set title=:title, text=:text where id=:id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':title', $title);
    $statement->bindParam(':text', $text);
    $statement->bindParam(':id', $id);
    $statement->execute();

    echo $id;
}

function WriteArticle($title, $text, $category) {
    $db = DbConnect();

    $sql = "insert into articles (title, text) values(:title, :text)";
    $statement = $db->prepare($sql);
    $statement->bindParam(':title', $title);
    $statement->bindParam(':text', $text);
    $statement->execute();

    $id = $db->lastInsertId();

    $sql = "insert into article_categories (article_id, category_id)"
        . " values(:art_id, (select id from categories where title=:cat_title))";
    $statement = $db->prepare($sql);
    $statement->bindParam(':art_id', $id);
    $statement->bindParam(':cat_title', $category);
    $statement->execute();

    echo $id;
}

?>
