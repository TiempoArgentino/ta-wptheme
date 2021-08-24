(($) => {

    function doSearch( { searchQuery = '', page = 1 } = {}){
        window.location.href = `${TASearchData.searchpageUrl}${searchQuery}/page/${page}`;
    }

    /**
    *   @DEPRECATED Wordpress pagination automatically stablishes the correct page in the URL
    *   When a pagination button is clicked, submit the form with the correct
    *   page number.
    */
    // $(document).on('click', '.pagination-articles .page-numbers:not(.dots):not(.current)', function(event) {
    //     let page = 1;
    //     event.preventDefault();
    //
    //     if( $(this).hasClass('prev') )
    //         page = parseInt($('.pagination-articles .page-numbers.current').text()) - 1;
    //     else if( $(this).hasClass('next') )
    //         page = parseInt($('.pagination-articles .page-numbers.current').text()) + 1;
    //     else
    //         page = parseInt($(this).text());
    //
    //     doSearch({
    //         searchQuery: TASearchQuery.s,
    //         page,
    //     });
    // });

    $(document).on('submit', '#searchform', function(e){
        e.preventDefault();
        var formData = new FormData(e.target);
        const searchQuery = formData.get('s');
        doSearch({
            searchQuery: formData.get('s'),
            page: 1
        });
    });

})(jQuery);
