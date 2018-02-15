jQuery(function ($) {
    addFilterEventHandlers();
    addCommentEventHandlers();
    setupTextareaAutosize();
    minimize();
    initGrid();
});

function addCommentEventHandlers() {
    $('.show-comments').click(function() {
        var commentSection = $(this).parents('.comment-section')
        var comments = commentSection.find('.comments');
        commentSection.find('.leave-comment').toggleClass('hidden');
        comments.toggleClass('show');
        if (comments.hasClass('show')) {
            loadComments(comments, layout);
            $(this).text('Hide comments');
        } else {
            comments.text('');
            $(this).text('Show comments');
            commentSection.find('.comment-form').addClass('hidden');
            commentSection.find('.leave-comment').text('Leave a comment');
            layout();
        }
    });

    $('.leave-comment').click(function() {
        var form = $(this).parents('.comment-section').find('.comment-form');
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
