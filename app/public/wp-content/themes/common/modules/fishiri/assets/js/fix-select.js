(function ($){
    $( document ).ready(function() {
        $('.rwmb-select-all-none a[data-type="none"]').click(function() {
            $(this).closest('#mentioned_ships').find('.select2-search-choice').remove();
        });
    });
})(jQuery);