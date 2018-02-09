<?php

class GorillaBlogDb {

    private $db;
    private $articles = [];
    private $categories = [];

    public function __construct() {
        $this->connect();
    }

    public function getArticles () {
        if (!count($this->articles)) $this->loadArticles();
        return $this->articles;
    }

    public function getCategories () {
        if (!count($this->articles)) $this->loadArticles();
        return $this->categories;
    }

    private function loadArticles() {
        $sql = "select a.id, a.title, a.text, c.title category
                  from articles a
                  left join article_categories ac on ac.article_id = a.id
                  left join categories c on ac.category_id = c.id
                 order by a.id desc";
        $statement = $this->db->prepare($sql);
        $statement->execute();

        // build list of available categories and a list of categories for each article
        $categoryIndex = [];
        $prevId = 0;
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $currId = $row['id'];
            if ($currId == $prevId) {
                array_push($this->articles[$currId]['category'], $row['category']);
                $categoryIndex[$row['category']] = 1;
            } else {
                if ($row['category']) {
                    $category = $row['category'];
                    $row['category'] = [ $category ];
                    $categoryIndex[$category] = 1;
                } else {
                    $row['category'] = [];
                }
                $this->articles[$currId] = $row;
            }
            $prevId = $currId;
        }

        $this->categories = array_keys($categoryIndex);
        sort($this->categories);
    }

    public function insertArticle($title, $text) {
        $sql = "insert into articles (title, text)
            values(:title, :text)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':text', $text);
        $statement->execute();
    }

    public function updateArticle($id, $title, $text) {
        $sql = "update articles
                   set title=:title, text=:text
                 where id=:id";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':text', $text);
        $statement->bindParam(':id', $id);
        $statement->execute();
    }

    public function setCategories($articleId, $categories) {
        foreach ($categories as $category) {
            $sql = "insert into article_categories (article_id, category_id)
                values(:aid, (select id from categories where title=:cat))";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':aid', $articleId);
            $statement->bindParam(':cat', $category);
            $statement->execute();
        }
    }

    public function getAllCategories() {
        $sql = "select *
                  from categories
                 order by title";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComments($articleId) {
        $sql = "select *
                  from comments
                 where article_id=:aid
                 order by id desc";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':aid', $articleId);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertComment($articleId, $comment) {
        $sql = "insert into comments (article_id, comment)
            values(:aid, :comment)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':aid', $articleId);
        $statement->bindParam(':comment', $comment);
        $statement->execute();
    }

    public function lastInsertId() {
        return $this->db->lastInsertId();
    }

    private function connect() {
        $host = getenv('GORILLABLOG_DBSERVER');
        $name = getenv('GORILLABLOG_DBNAME');
        $user = getenv('GORILLABLOG_DBUSER');
        $pass = getenv('GORILLABLOG_DBPASS');

        return $this->db = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
    }

    public function __toString() {
        try {
            if ($this->db) {
                $errorInfo = $this->db->errorInfo()[2];
                return $errorInfo ? $errorInfo : "No errors";
            } else {
                return "Not connected";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

?>
