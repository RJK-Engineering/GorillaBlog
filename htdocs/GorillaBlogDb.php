<?php

function GetArticles() {
    $db = DbConnect();

    $sql = "select a.id, a.title, a.text, c.title category
              from articles a
              left join article_categories ac on ac.article_id = a.id
              left join categories c on ac.category_id = c.id
             order by a.id desc";
    $statement = $db->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function DbConnect() {
    $dbserver = getenv('GORILLABLOG_DBSERVER');
    $dbname = getenv('GORILLABLOG_DBNAME');
    $dbuser = getenv('GORILLABLOG_DBUSER');
    $dbpass = getenv('GORILLABLOG_DBPASS');

    $db = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpass);

    return $db;
}

?>
