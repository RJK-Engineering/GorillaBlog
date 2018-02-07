<?php

class GorillaBlogDb {

    private $db;

    function getArticles() {
        $db = $this->connect();

        $sql = "select a.id, a.title, a.text, c.title category
                  from articles a
                  left join article_categories ac on ac.article_id = a.id
                  left join categories c on ac.category_id = c.id
                 order by a.id desc";
        $statement = $db->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
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
