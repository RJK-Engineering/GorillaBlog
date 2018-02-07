jQuery(function ($) {
    // set isotope grid
    $('.grid').isotope({
        itemSelector: '.grid-item',
    });

    // filter items on button click
    $('.filter-buttons').on('click', '.filter-button', function() {
        var filterValue = $(this).attr('data-filter');
        $('#articles').isotope({ filter: filterValue });
    });
});
