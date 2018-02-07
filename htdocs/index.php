<?php

require_once 'GorillaBlogDb.php';

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
                    <div class="menuitem"><a href="edit">New Article</a></div>
                </div>
                <h5 class="headerLeft">Categories</h5>
                <div class="menu" id="mainMenu">
                </div>
            </div>
            <div class="col-6">
                <h1>GorillaBlog Articles</h1>

                <div class="filter-buttons">
                    <button data-filter="article">All</button>
                    <button data-filter="economics">Economics</button>
                </div>

                <div id="articles" class="grid">
                    <?php PrintArticles() ?>
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
</body>
</html>

<?php

function PrintArticles() {
    foreach (GetArticles() as $id => $article) {
        echo '<article id="article' . $id . '" class="article ' . GetCategoryClassName($article) . ' grid-item">';
        echo '<h3 class="title">' . $article['title'] . '</h3>';
        echo '<div class="blogtext">' . $article['text'] . '</div>';
        echo '</article>';
    }
}

function GetCategoryClassName($article) {
    return preg_replace('/\s+/', '-', strtolower($article['category']));
}

?>
