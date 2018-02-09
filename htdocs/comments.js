/* CONFIGURATION */
var commentsUrl = 'comments.php';

jQuery(function ($) {
    addEventHandlers();
});

function addEventHandlers() {
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
        }).done(function (response, textStatus, jqXHR){
            // idElem.value = response.id;
        }).fail(function (jqXHR, textStatus, errorThrown){
            alert('Error submitting comment');
        }).always(function () {
            // reenable inputs
            inputs.prop("disabled", false);
        });
    });
}
