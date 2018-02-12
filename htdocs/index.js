jQuery(function ($) {
    initGrid();
    addFilterEventHandlers();
    minimize();
});

function initGrid() {
    $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'vertical'
    });
}

function layout() {
    $('.grid').isotope('layout');
}

function addFilterEventHandlers() {
    $('.filter-buttons').on('click', '.filter-button', function() {
        var filterValue = $(this).attr('data-filter');
        $('#articles').isotope({ filter: filterValue });
    });
}

function minimize() {
    // minimize and show "Read more" for long articles
    $('.content').each(function () {
        var content = $(this);
        var article = content.children('article');
        if (article.height() > 400) {
            content.addClass('minimized');
            content.siblings('.show-more').addClass('enabled');
        };
    });

    $('.show-more').on('click', function () {
        toggleGridItemSize($(this));
    });
}

function toggleGridItemSize(showMore) {
    var content = showMore.siblings('.content')
    if (content.hasClass('minimized')) {
        content.removeClass('minimized');
        showMore.text('Read less');
    } else {
        content.addClass('minimized');
        showMore.text('Read more');
    }
    scrollToTop(content);
    layout();
}

function scrollToTop(elem) {
    $('html, body').animate({
        scrollTop: elem.offset().top - 20
    }, 'slow');
}
