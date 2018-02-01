// MooTools domready function
window.addEvent('domready', function() {
    loadArticles();
});

/* CONFIGURATION */
var articlesUrl = 'articles.php';

function loadArticles() {
    getArticlesRequest.get();
}

var getArticlesRequest = new Request.JSON({
    url: articlesUrl,
    method: 'get',
    onSuccess: function(articles) {
        articles.each(function (article) {
            addArticle(article);
        });
    }
});

function addArticle(article) {
    var div = $$('#articles');
    div.appendHTML('<h3 class="title">' + article.title + '</h3>');
    div.appendHTML('<div class="article">' + article.text + '</div>');
}
