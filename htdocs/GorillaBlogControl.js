// MooTools domready function
window.addEvent('domready', function() {
    addEvents();
});

/* CONFIGURATION */
var apiUrl = 'article.php';

function addEvents() {
    $$('#submitArticle').addEvents({
        click: function() {
            submitArticle();
        }
    });
}

function submitArticle(id, title, text) {
    var article = {
        id: $$('#id').get('value'),
        title: $$('#title').get('value'),
        text: $$('#text').get('value')
    };
    submitArticleRequest.post(article);
}

var submitArticleRequest = new Request.JSON({
    url: apiUrl,
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
