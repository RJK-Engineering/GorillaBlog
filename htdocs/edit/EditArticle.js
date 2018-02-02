// MooTools domready function
window.addEvent('domready', function() {
    addEvents();
    loadCategoryInput(categoryUrl);
});

/* CONFIGURATION */
var articleUrl = 'article.php';
var categoryUrl = '../category.php';

function addEvents() {
    $$('#submitArticle').addEvents({
        click: function() {
            submitArticle();
        }
    });
    $$('#newArticle').addEvents({
        click: function() {
            newArticle();
        }
    });
}

function submitArticle(id, title, text) {
    var article = {
        id: $$('#id').get('value'),
        title: $$('#title').get('value'),
        text: $$('#text').get('value'),
        category: $$('#category').get('value')
    };
    submitArticleRequest.post(article);
}

function newArticle() {
    $$('#id').set('value', '');
    $$('#title').set('value', '');
    $$('#text').set('value', '');
    displayStatus('');
}

var submitArticleRequest = new Request.JSON({
    url: articleUrl,
    method: 'post',
    onRequest: function() {
        displayStatus('Submitting...');
    },
    onSuccess: function(id) {
        displayStatus('Article stored succesfully');
        $$('#id').set('value', id);
    },
    onFailure: function(request) {
        displayStatus('Error submitting article, please try again');
    }
});

function displayStatus(text) {
    $$('#status').set('text', text);
}
