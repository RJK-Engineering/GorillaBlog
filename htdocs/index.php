<?php

require_once 'GorillaBlog.php';
require_once 'GorillaBlogDb.php';

$db = new GorillaBlogDb();

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GorillaBlog</title>
    <link rel="stylesheet" href="GorillaBlog.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-auto">
                <h5 class="header-left">Menu</h5>
                <div>
                    <div>Front Page</div>
                    <div><a href="edit/newArticle.php">New Article</a></div>
                </div>
                <h5 class="header-left">Categories</h5>
                <div class="filter-buttons">
                    <?php PrintCategories($db); ?>
                </div>
            </div>
            <div class="col-6">
                <h1>GorillaBlog Front Page</h1>
                <div id="articles" class="grid">
                    <?php PrintArticles($db); ?>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div>Sources available on <a href="https://github.com/RJK-Engineering/GorillaBlog">GitHub</a></div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="autosize.min.js"></script>
    <script src="index.js"></script>
    <script src="comments.js"></script>
</body>
</html>

<?php

function PrintArticles($db) {
    foreach ($db->getArticles() as $article) {
        echo '<div class="article';
        foreach ($article['category'] as $category) {
            echo ' ' . GetCategoryClassName($category);
        }
        echo ' grid-item">';
        PrintGritItem($article);
        echo '</div>';
    }
}

function PrintGritItem($article) {
    echo '<div class="container">';
        echo '<div class="row">';
            echo '<div class="col content minimized">';
                PrintArticle($article);
            echo '</div>';
        echo '</div>';

        echo '<div class="row">';
            echo '<div class="col">';
                echo '<div class="show-more">Read more</div>';
                PrintCommentSection($article['id']);
            echo '</div>';
        echo '</div>';
    echo '</div>';
}

function PrintArticle($article) {
    echo '<article>';
        echo '<h3>' . $article['title'] . '</h3>';
        echo '<p>' . $article['text'] . '</p>';
    echo '</article>';
}

function PrintCommentSection($articleId) {
    echo '<div class="comment-section">';
        echo '<span class="link show-comments">Show comments</span> | ';
        echo '<span class="link leave-comment">Leave a comment</span>';
        echo '<form class="comment-form hidden">';
            echo '<textarea name="comment" required></textarea><br>';
            echo '<input type="hidden" name="articleId" value="' . $articleId . '">';
            echo '<button>Comment</button>';
        echo '</form>';
        echo '<div class="comments" data-article-id="' . $articleId . '"></div>';
    echo '</div>';
}

?>
