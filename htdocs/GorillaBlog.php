<?php

function PrintCategories($db) {
    echo '<ul>';
    echo '<li class="filter-button" data-filter="article">All</li>';
    foreach ($db->getCategories() as $category) {
        echo '<li class="filter-button" data-filter=".';
        echo GetCategoryClassName($category) . '">';
        echo $category . '</li>';
    }
    echo '</ul>';
}

function GetCategoryClassName($category) {
    return preg_replace('/\s+/', '-', strtolower($category));
}

?>
