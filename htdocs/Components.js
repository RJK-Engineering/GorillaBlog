function loadCategoryInput(categoryUrl) {
    var getCategoriesRequest = new Request.JSON({
        url: categoryUrl,
        onSuccess: function(categories) {
            createCategoryInput(categories);
        }
    }).get();
}

function createCategoryInput(categories) {
    var div = $$('#categoryInput');
    div.set('text', '');

    var input = new Element('input', {
        id : 'category',
        type: 'text',
        list: 'categories',
        name: 'category'
    });
    div.grab(input);

    var datalist = new Element('datalist', { id: 'categories', } );
    categories.each(function (category) {
        datalist.grab(new Element('option', { value: category.title }));
    });
    div.grab(datalist);
}
