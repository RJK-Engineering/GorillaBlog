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

                <div class="input">
                    <label for="title">Title:</label> <input type="text" name="title" id="title">
                </div>
                <div class="input">
                    <label for="title">Category:</label> <div id="categoryInput"></div>
                </div>
                <div class="input">
                    <textarea rows="20" cols="100" name="text" id="text"></textarea>
                    <input type="hidden" name="id" id="id" value="0">
                </div>

                <div class="buttons">
                    <button id="submitArticle">Submit</button>
                </div>

                <div id="status"></div>
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
