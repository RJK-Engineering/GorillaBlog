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

<?php

foreach (GetArticles() as $id => $article) {
    echo '<article class="article">';
    echo '<h3 class="title">' . $article['title'] . '</h3>';
    echo '<div class="blogtext">' . $article['text'] . '</div>';
    echo '</article>';
}

?>

    <hr>
    <div>Sources available on <a href="https://github.com/RJK-Engineering/GorillaBlog">GitHub</a></div>

    <script src="https://fastcdn.org/MooTools/1.5.2/MooTools-Core-compat-compressed.js"></script>
    <script src="Articles.js"></script>
    <script src="Components.js"></script>
</body>
</html>
