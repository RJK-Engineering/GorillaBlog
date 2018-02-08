/* CONFIGURATION */
var articleUrl = 'article.php';
var categoryUrl = '../category.php';

jQuery(function ($) {
    addEvents();
});

function addEvents() {
    var request;
    $("form#newArticle").submit(function(event) {
        displayStatus('Submitting...');

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
        // Abort any pending request
        if (request) {
            request.abort();
        }
        // setup some local variables
        var form = $(this);
        // Let's select and cache all the fields
        var inputs = form.find("input, select, button, textarea");
        // Serialize the data in the form
        var serializedData = form.serialize();

        // Let's disable the inputs for the duration of the Ajax request.
        // Note: we disable elements AFTER the form data has been serialized.
        // Disabled form elements will not be serialized.
        inputs.prop("disabled", true);

        var idInput = $("form#newArticle")[0].id;
        if (idInput.value) {
            request = $.ajax({
                url: articleUrl,
                type: "post",
                data: serializedData
            });
        } else {
            request = $.ajax({
                url: articleUrl,
                type: "put",
                data: serializedData
            });
        }

        request.done(function (response, textStatus, jqXHR){
            displayStatus('Article stored succesfully' + response.info);
            idInput.value = response.id;
        }).fail(function (jqXHR, textStatus, errorThrown){
            displayStatus('Error submitting article: ' + textStatus);
        }).always(function () {
            // Reenable the inputs
            inputs.prop("disabled", false);
        });
    });
}

function displayStatus(text) {
    $('#status').text(text);
}
