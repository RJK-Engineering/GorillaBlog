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
                <h5 class="headerLeft">Menu</h5>
                <div class="menu" id="mainMenu">
                    <div class="menuitem"><a href="..">Read Articles</a></div>
                    <div class="menuitem">New Article</div>
                </div>
            </div>
            <div class="col-6">
                <h1>Edit GorillaBlog Article</h1>
                <form id="newArticle">
                    <div class="input">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" required>
                        <!-- <input type="text" name="title" id="title"> -->
                    </div>
                    <div class="input">
                        <label for="title">Add Category:</label>
                        <div id="categoryInput"><?php PrintCategoryInput($db); ?></div>
                        <button id="addCategory">Add</button>
                        <div class="category-selection"></div>
                    </div>
                    <div class="input">
                        <textarea name="text" id="blogtext" required></textarea>
                        <!-- <textarea name="text" id="blogtext"></textarea> -->
                        <input type="hidden" name="id" id="id">
                    </div>

                    <div class="buttons">
                        <input type="submit" id="submitArticleButton">
                    </div>
                    <div id="status"></div>
                </form>
            </div>
        </div>
    </div>

    <hr>
    <div>Sources available on <a href="https://github.com/RJK-Engineering/GorillaBlog">GitHub</a></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="newArticle.js"></script>
</body>
</html>

<?php

function PrintCategoryInput($db) {
    echo '<input id="category" type="text" list="categories" name="category">';
    echo '<datalist id="categories">';
    foreach ($db->getAllCategories() as $category) {
        echo '<option value="' . $category['title'] . '">';
    };
    echo '</datalist>';
}

?>
