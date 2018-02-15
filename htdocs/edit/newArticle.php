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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-auto">
                <h5 class="header-left">Menu</h5>
                <div>
                    <div><a href="..">Front Page</a></div>
                    <div>New Article</div>
                    <div><a href="manageArticles.php">Manage Articles</a></div>
                </div>
            </div>
            <div class="col-6">
                <form id="newArticle">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h1>Edit GorillaBlog Article</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label for="title">Title:</label>
                            </div>
                            <div class="col">
                                <input type="text" name="title" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label for="title">Categories:</label>
                            </div>
                            <div class="col">
                                <?php PrintCategoryInput($db); ?>
                                <button id="addCategory">Add</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="category-selection"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <textarea name="text" class="blogtext" required></textarea>
                                <input type="hidden" name="id">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button id="openFormattingHelp">Formatting Help</button>
                                <button id="openExpanderHelp">Text Expander Help</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" id="submitArticleButton">Submit</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" id="status">
                        </div>
                    </div>
                </form>
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

    <script src="../autosize.min.js"></script>
    <script src="text-expander.js"></script>
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
