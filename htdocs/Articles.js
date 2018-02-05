// MooTools domready function
window.addEvent('domready', function() {
    loadArticles();
    loadCategoryInput(categoryUrl);
    addEvents();
});

/* CONFIGURATION */
var articleUrl = 'article.php';
var categoryUrl = 'category.php';

function loadArticles(category) {
    var url = articleUrl;
    if (category && category != '') url += '?category=' + category;

    $$('#articles').set('text', '');

    new Request.JSON({
        url: url,
        onSuccess: function(articles) {
            articles.each(function (article) {
                addArticle(article);
            });
        }
    }).get();
}

function addEvents() {
    $$('#categoryInput').addEvent('change', function () {
        loadArticles($$('#category').get('value'));
    });
}

function addArticle(article) {
    var articleElem = new Element('article', { class: 'article' });
    $$('#articles').grab(articleElem);

    var header = new Element('h3', { class: 'title' });
    header.appendHTML(article.title);
    articleElem.grab(header);

    var text = formatText(article.text);
    articleElem.appendHTML(text);

    addEditButton(article, articleElem);
}

function addEditButton(article, articleElem) {
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
