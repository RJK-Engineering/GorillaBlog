// MooTools domready function
window.addEvent('domready', function() {
    addEvents();
    loadData();
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

function loadData() {
    getCategoriesRequest.get();
}

var getCategoriesRequest = new Request.JSON({
    url: categoryUrl,
    onSuccess: function(categories) {
        createCategoryInput(categories);
    }
});

function createCategoryInput(categories) {
    var div = $$('#categoryInput');
    div.set('text', '');

    var input = new Element('input',
        { type: 'text', list: 'categories', name: 'category' });
    div.grab(input);

    var datalist = new Element('datalist', { id: 'categories', } );
    categories.each(function (category) {
        datalist.grab(new Element('option', { value: category.title }));
    });
    div.grab(datalist);
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
