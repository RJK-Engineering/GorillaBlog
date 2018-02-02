// MooTools domready function
window.addEvent('domready', function() {
    loadData();
    loadCategoryInput(categoryUrl);
});

/* CONFIGURATION */
var articleUrl = 'article.php';
var categoryUrl = 'category.php';

function loadData() {
    getArticlesRequest.get();
}

var getArticlesRequest = new Request.JSON({
    url: articleUrl,
    onSuccess: function(articles) {
        articles.each(function (article) {
            addArticle(article);
        });
    }
});

function addArticle(article) {
    var articleElem = new Element('article', { class: 'article' });
    $$('#articles').grab(articleElem);

    var header = new Element('h3', { class: 'title' });
    header.appendHTML(article.title);
    articleElem.grab(header);

    var text = formatText(article.text);
    articleElem.appendHTML(text);

    var editButton = new Element('button', {
        class: 'editButton',
        events: {
            click: function () {
                window.location.href = 'edit/?id=' + article.id;
            }
        }
    });
    editButton.appendText('Edit');
    articleElem.grab(editButton);
}

function formatText(text) {
    text = '<p>' + text + '</p>';
    text = text.replace(/\n\n/g, '</p><p>');
    return text;
}
