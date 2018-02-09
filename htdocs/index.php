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
                <h5 class="headerLeft">Menu</h5>
                <div class="menu" id="mainMenu">
                    <div class="menuitem">Read Articles</div>
                    <div class="menuitem"><a href="edit/newArticle.php">New Article</a></div>
                </div>
                <h5 class="headerLeft">Categories</h5>
                <div class="filter-buttons">
                    <?php PrintCategories($db); ?>
                </div>
            </div>
            <div class="col-6">
                <h1>GorillaBlog Articles</h1>

                <div id="articles" class="grid">
                    <?php PrintArticles($db) ?>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div>Sources available on <a href="https://github.com/RJK-Engineering/GorillaBlog">GitHub</a></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="main.js"></script>
    <script src="comments.js"></script>
</body>
</html>

<?php

function PrintArticles($db) {
    foreach ($db->getArticles() as $article) {
        echo '<article id="article-' . $article['id'] . '" class="article';
        foreach ($article['category'] as $category) {
            echo ' ' . GetCategoryClassName($category);
        }
        echo ' grid-item">';

        PrintBlogText($article);
        PrintCommentForm($article['id']);
        PrintCommentSection($article['id']);

        echo '</article>';
    }
}

function PrintBlogText($article) {
    echo '<h3 class="title">' . $article['title'] . '</h3>';
    echo '<div class="blogtext">' . $article['text'] . '</div>';
}

function PrintCommentForm($articleId) {
    echo '<form class="comment-form">';
    echo '<textarea name="comment" required></textarea><br>';
    echo '<input type="hidden" name="articleId" value="' . $articleId . '">';
    echo '<button>Add Comment</button>';
    echo '</form>';
}

function PrintCommentSection($articleId) {
    echo '<div id="comments-' . $articleId , '" class="comment-section" data-article-id="' . $articleId . '"></div>';
}

?>
