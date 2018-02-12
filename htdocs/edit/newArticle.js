/* CONFIGURATION */
var articleUrl = 'article.php';
var textExpanderConf = {
    "cg" : "CodeGorilla",
    "gn" : "Groningen"
};

jQuery(function ($) {
    addAddCategoryEventHandler();
    addSubmitEventHandler();
    setupHelpDialogs();
    setupTextExpander(".blogtext", textExpanderConf);
    setupAutosize();
});

function setupAutosize() {
    autosize($("textarea"));
}

var selectedCategories = {};

function addAddCategoryEventHandler() {
    $("#addCategory").on('click', function() {
        var categoryElem = $("#category")[0];
        var category = categoryElem.value;
        if (category && !selectedCategories[category]) {
            addCategory(category);
            categoryElem.value = '';
            selectedCategories[category] = 1;
        }
        return false; // do not submit form
    });
}

function addCategory(category) {
    // add visible element
    var span = $('<span />');
    span.attr('class', 'selected-category');
    span.html(category);
    span.appendTo($('.category-selection'));

    // add hidden input
    var input = $('<input>');
    input.attr('type', 'hidden');
    input.attr('name', 'categories[]');
    input.attr('value', category);
    input.appendTo($("form#newArticle"));
}

function addSubmitEventHandler() {
    var request;
    $("form#newArticle").submit(function(event) {
        displayStatus('Submitting...');

        event.preventDefault();
        if (request) request.abort();

        var form = $(this);
        var inputs = form.find("input, select, button, textarea");
        var serializedData = form.serialize();

        // disable inputs while waiting for response
        inputs.prop("disabled", true);

        var idElem = $("form#newArticle")[0].id;
        var method = idElem.value ? "post" : "put";

        request = $.ajax({
            url: articleUrl,
            type: method,
            data: serializedData
        }).done(function (response) {
            displayStatus('Article stored succesfully');
            idElem.value = response.id;
        }).fail(function (jqXHR, textStatus) {
            displayStatus('Error submitting article: ' + textStatus);
        }).always(function () {
            // reenable inputs
            inputs.prop("disabled", false);
        });
    });
}

function setupHelpDialogs() {
    $("#formattingHelp").dialog({ autoOpen: false });
    $("#openFormattingHelp").on("click", function() {
        $("#formattingHelp").dialog("open");
        return false;
    });

    $("#expanderHelp").dialog({ autoOpen: false });
    $("#openExpanderHelp").on("click", function() {
        $("#expanderHelp").dialog("open");
        return false;
    });
    var help = '';
    $.each(textExpanderConf, function(abbrev, expanded) {
        help += abbrev + ': ' + expanded + '<br>';
    });
    $("#expanderHelp").html(help);
}

function displayStatus(text) {
    $('#status').text(text);
}
