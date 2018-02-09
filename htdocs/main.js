jQuery(function ($) {
    initGrid();

    // filter items on button click
    $('.filter-buttons').on('click', '.filter-button', function() {
        var filterValue = $(this).attr('data-filter');
        $('#articles').isotope({ filter: filterValue });
    });
});

function initGrid() {
    $('.grid').isotope({
        itemSelector: '.grid-item',
    });
}
