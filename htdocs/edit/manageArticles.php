<?php

require_once '../GorillaBlog.php';
require_once '../GorillaBlogDb.php';

$db = new GorillaBlogDb();

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GorillaBlog</title>
    <link rel="stylesheet" href="../GorillaBlog.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-auto">
                <h5 class="header-left">Menu</h5>
                <div>
                    <div><a href="..">Front Page</a></div>
                    <div><a href="newArticle.php">New Article</a></div>
                    <div>Manage Articles</div>
                </div>
            </div>
            <div class="col-auto">
                <h1>Articles</h1>
                <table class="article-list">
                    <?php PrintArticleTable($db); ?>
                </table>
            </div>
        </div>
    </div>

    <hr>
    <div>Sources available on <a href="https://github.com/RJK-Engineering/GorillaBlog">GitHub</a></div>

    <div class="dialog" id="formattingHelp" title="Formatting Help">
        <p>*Bold* = <b>Bold</b></p>
        <p>_Italic_ = <i>Italic</i></p>
    </div>

    <div class="dialog" id="expanderHelp" title="Text Expander Help">
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="manageArticles.js"></script>
</body>
</html>

<?php

function PrintArticleTable($db) {
    echo '<tr><th>Title</th><th>Comments</th><th colspan="2"></th></tr>';
    foreach ($db->getArticles() as $article) {
        echo '<tr data-id="' . $article['id'] . '">';
        echo '<td>' . $article['title'] . '</td>';
        echo '<td>' . $article['comment_count'] . '</td>';
        echo '<td class="link disable-comments';
            if ($article['comments_disabled']) echo ' comments_disabled';
            echo '">' . ($article['comments_disabled'] ? 'Enable' : 'Disable');
            echo ' comments</td>';
        echo '<td class="link delete-article">Delete</td>';
        echo '</tr>';
    };
}

?>
