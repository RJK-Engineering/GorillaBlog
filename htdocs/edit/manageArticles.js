/* CONFIGURATION */
var articleUrl = 'article.php';

jQuery(function ($) {
    addEventHandlers();
});

function addEventHandlers() {
    $('.delete-article').click(function() {
        var row = $(this).parents('tr');
        var articleID = row.data('id');
        deleteArticle(articleID);
        row.remove();
    });

    $('.disable-comments').click(function() {
        var row = $(this).parents('tr');
        var articleID = row.data('id');
        toggleCommentsDisabled(articleID);
        $(this).toggleClass('comments_disabled');
        if ($(this).hasClass('comments_disabled')) {
            $(this).text('Enable comments');
        } else {
            $(this).text('Disable comments');
        }
    });
}

function deleteArticle(id) {
    $.ajax({
        url: articleUrl,
        type: 'delete',
        data: 'id=' + id
    });
}

function toggleCommentsDisabled(articleId) {
    $.ajax({
        url: articleUrl,
        type: 'patch',
        data: 'id=' + articleId
    });
}
