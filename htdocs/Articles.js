// MooTools domready function
window.addEvent('domready', function() {
    loadCategoryInput(categoryUrl);
});

/* CONFIGURATION */
var categoryUrl = 'category.php';

function addArticle(article) {
    var articleElem = new Element('article', { class: 'article' });
    $$('#articles').grab(articleElem);

    var header = new Element('h3', { class: 'title' });
    header.appendHTML(article.title);
    articleElem.grab(header);

    var text = formatText(article.text);
    articleElem.appendHTML(text);
}

function formatText(text) {
    // paragraphs
    text = '<p>' + text + '</p>';
    text = text.replace(/\n\n/g, '</p><p>');

    // bold
    text = text.replace(/\*.+\*/g, function (x) {
        return '<b>' + x.replace(/\*/g, '') + '</b>';
    });

    // italic
    text = text.replace(/_.+_/g, function (x) {
        return '<i>' + x.replace(/_/g, '') + '</i>';
    });

    return text;
}
