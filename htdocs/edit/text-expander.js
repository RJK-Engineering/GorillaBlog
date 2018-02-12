function setupTextExpander(selector, textExpanderConf) {
    var textElem = $(selector);
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
