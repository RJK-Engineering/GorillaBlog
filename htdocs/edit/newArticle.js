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
    setupTextExpander();
});

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

        var idElem = $("form#newArticle")[0].id;
        if (idElem.value) {
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
            displayStatus('Article stored succesfully');
            idElem.value = response.id;
        }).fail(function (jqXHR, textStatus, errorThrown){
            displayStatus('Error submitting article: ' + textStatus);
        }).always(function () {
            // Reenable the inputs
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

function setupTextExpander() {
    var textElem = $("#blogtext");
    var re = new RegExp("\\b(" + Object.keys(textExpanderConf).join("|") + ")\\b", "g");
    var updateBlogText = function() {
        textElem[0].value = textElem[0].value.replace(re, function($0, $1) {
            return textExpanderConf[$1.toLowerCase()];
        });
    };

    var timer = 0;
    textElem.on('keydown', function() {
        clearTimeout(timer);
        timer = setTimeout(updateBlogText, 200);
    });
}

function displayStatus(text) {
    $('#status').text(text);
}
