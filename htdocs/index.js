jQuery(function ($) {
    initGrid();
    addFilterEventHandlers();
    addCommentEventHandlers();
    setupTextareaAutosize();
    minimize();
    layout();
});

function addCommentEventHandlers() {
    $('.show-comments').click(function() {
        var section = $(this).siblings('.comments');
        section.toggleClass('show');
        if (section.hasClass('show')) {
            loadComments(section, layout);
            $(this).text('Hide comments');
        } else {
            section.text('');
            $(this).text('Show comments');
            layout();
        }
    });

    $('.leave-comment').click(function() {
        var form = $(this).siblings('.comment-form');
        form.toggleClass('hidden');
        if (form.hasClass('hidden')) {
            $(this).text('Leave a comment');
        } else {
            $(this).text('Hide comment form');
        }
        layout();
    });
}

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

function setupTextareaAutosize() {
    autosize($("textarea"));
    addEventListener('autosize:resized', function() {
        layout();
    });
}

function minimize() {
    // minimize and show "Read more" for long articles
    $('.content').each(function () {
        var content = $(this);
        var article = content.children('article');
        var showMore = content.parents('.article').find('.show-more');
        if (article.height() > content.height()) {
            content.addClass('minimized');
            showMore.addClass('enabled');
            showMore.click(function () {
                toggleGridItemSize($(this));
            });
        } else {
            content.removeClass('minimized');
            showMore.removeClass('enabled');
        }
    });
}

function toggleGridItemSize(showMore) {
    var content = showMore.parents('.article').find('.content');
    content.toggleClass('minimized');
    if (content.hasClass('minimized')) {
        showMore.text('Read more');
    } else {
        showMore.text('Minimize');
    }
    scrollToTop(content);
    layout();
}

function scrollToTop(elem) {
    $('html, body').animate({
        scrollTop: elem.offset().top
    }, 'slow');
}
