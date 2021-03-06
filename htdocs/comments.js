/* CONFIGURATION */
var commentsUrl = 'comments.php';

jQuery(function ($) {
    addOnsubmitEventHandlers(function (form, id) {
        var comments = form.parents('.comment-section').find('.comments');
        addComment(comments, {
            id: id,
            comment: form[0].comment.value
        });
        if (comments.hasClass('show')) layout();
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
        }).done(function (response) {
            if (onSuccess) onSuccess(form, response.id);
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
    var div = $('<div class="comment">');
    div.text(comment.comment);
    div.attr('data-id', comment.id);
    div.prependTo(section);

    del = $('<span class="link delete-comment">');
    del.text('Delete');
    del.click(function () {
        deleteComment($(this).parent().data('id'));
        $(this).parent().remove();
        layout();
    });
    del.appendTo(div);

    div.appendTo(section);
}

function clearText(section) {
    if (section.children().length == 0) {
        section.text('');
    }
}

function deleteComment(id) {
    $.ajax({
        url: commentsUrl,
        type: 'delete',
        data: 'commentId=' + id
    });
}
