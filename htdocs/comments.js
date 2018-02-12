/* CONFIGURATION */
var commentsUrl = 'comments.php';

jQuery(function ($) {
    addOnsubmitEventHandlers();
    setupAutosize();
    loadComments();
});

function setupAutosize() {
    autosize($("textarea"));
    addEventListener('autosize:resized', function() {
        layout();
    });
}

function addOnsubmitEventHandlers() {
    var request;
    $("form.comment-form").submit(function(event) {
        event.preventDefault();
        if (request) request.abort();

        var form = $(this);
        var inputs = form.find("input, select, button, textarea");
        var serializedData = form.serialize();

        // disable inputs while waiting for response
        inputs.prop("disabled", true);

        request = $.ajax({
            url: commentsUrl,
            type: 'put',
            data: serializedData
        }).done(function () {
            addComment(form[0].articleId.value, form[0].comment.value);
            form[0].comment.value = '';
        }).fail(function () {
            alert('Error submitting comment');
        }).always(function () {
            // reenable inputs
            inputs.prop("disabled", false);
        });
    });
}

function loadComments() {
    $.ajax({
        url: commentsUrl,
        type: 'get'
    }).done(function (response) {
        $.each($(".comment-section"), function() {
            var articleId = $(this).attr('data-article-id');
            if (response.comments[articleId]) {
                setComments($(this), response.comments[articleId]);
            }
        });
    });
}

function setComments(elem, comments) {
    var html = '';
    $.each(comments, function(i, comment) {
        html += '<div>' + comment + '</div>';
    });
    elem.html(html);
    layout();
}

function addComment(articleId, comment) {
    var div = $('<div>' + comment + '</div>');
    div.appendTo($('#comments-'+articleId));
    layout();
}

function deleteComment(commentId) {
    $.ajax({
        url: commentsUrl,
        type: 'delete',
        data: 'commentId=' + commentId
    }).done(function (response) {
        alert(JSON.stringify(response));
    });
}
