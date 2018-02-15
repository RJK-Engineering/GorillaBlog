/* CONFIGURATION */
var commentsUrl = 'comments.php';

jQuery(function ($) {
    addOnsubmitEventHandlers(function (form) {
        var comments = form.parents('.comment-section').find('.comments');
        if (comments.hasClass('show')) {
            addComment(comments, {comment: form[0].comment.value});
            layout();
        }
    });
});

function addOnsubmitEventHandlers(onSuccess) {
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
            if (onSuccess) onSuccess(form);
            form[0].comment.value = '';
        }).fail(function () {
            alert('Error submitting comment');
        }).always(function () {
            // reenable inputs
            inputs.prop("disabled", false);
        });
    });
}

function loadComments(section, onSuccess) {
    $.ajax({
        url: commentsUrl,
        type: 'get',
        data: 'articleId=' + section.data('article-id')
    }).done(function (response) {
        if (response.comments.length == 0) {
            section.text('No comments');
        }
        $.each(response.comments, function(i, comment) {
            addComment(section, comment);
        });
        if (onSuccess) onSuccess();
    });
}

function addComment(section, comment) {
    clearText(section); // "No comments" text
    var comment = $('<div class="comment">');
    comment.text(comment.comment);
    // comment.attr('data-id', comment.id);
    comment.prependTo(section);

    del = $('<span class="link delete-comment">');
    del.text('Delete');
    del.click(function () {
        deleteComment(comment.id);
        comment.remove();
        if (comment.parent().children.length == 0) {
            section.text('No comments');
        }
        layout();
    });
    del.appendTo(comment);

    comment.appendTo(section);
}

function clearText(section) {
    if (section.children().length == 0) {
        section.text('');
    }
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
