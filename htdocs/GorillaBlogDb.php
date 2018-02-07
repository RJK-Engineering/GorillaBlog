<?php

class GorillaBlogDb {

    private $db;
    private $articles = [];
    private $categories = [];

    function getArticles () {
        if (!count($this->articles)) $this->loadArticles();
        return $this->articles;
    }

    function getCategories () {
        if (!count($this->articles)) $this->loadArticles();
        return $this->categories;
    }

    function loadArticles() {
        $db = $this->connect();

        $sql = "select a.id, a.title, a.text, c.title category
                  from articles a
                  left join article_categories ac on ac.article_id = a.id
                  left join categories c on ac.category_id = c.id
                 order by a.id desc";
        $statement = $db->prepare($sql);
        $statement->execute();

        // build list of available categories and a list of categories for each article
        $categoryIndex = [];
        $prevId = 0;
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $currId = $row['id'];
            if ($currId == $prevId) {
                if ($row['category']) {
                    array_push($this->articles[$currId]['category'], $row['category']);
                    $categoryIndex[$row['category']] = 1;
                }
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

    function connect() {
        if ($this->db) {
            return $this->db;
        }
        $host = getenv('GORILLABLOG_DBSERVER');
        $name = getenv('GORILLABLOG_DBNAME');
        $user = getenv('GORILLABLOG_DBUSER');
        $pass = getenv('GORILLABLOG_DBPASS');

        return $this->db = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
    }

    function __toString() {
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
