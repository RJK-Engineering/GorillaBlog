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
</head>
<body>
    <div class="menu" id="mainMenu">
        Read Articles |
        <a href="edit">New Article</a>
    </div>

    <h1>GorillaBlog Articles</h1>

    <div class="input">
        <label for="title">Category:</label> <div id="categoryInput"></div>
    </div>

    <div class="filter-buttons">
        <button data-filter="article">All</button>
        <button data-filter="economics">Economics</button>
    </div>

    <div id="articles" class="grid">
<?php

foreach (GetArticles() as $id => $article) {
    echo '<article class="article ' . GetCategoryClassName($article) . ' grid-item">';
    echo '<h3 class="title">' . $article['title'] . '</h3>';
    echo '<div class="blogtext">' . $article['text'] . '</div>';
    echo '</article>';
}

function GetCategoryClassName($article) {
    return preg_replace('/\s+/', '-', strtolower($article['category']));
}

?>
    </div>

    <hr>
    <div>Sources available on <a href="https://github.com/RJK-Engineering/GorillaBlog">GitHub</a></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="main.js"></script>
</body>
</html>
