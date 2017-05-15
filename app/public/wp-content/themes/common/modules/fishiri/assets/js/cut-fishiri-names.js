(function ($) {
    $(document).ready(function () {
        $('.dropdown-toggle').removeClass('hidden');
        $('.rig-name, .felt-name').each(function () {
            if ($(this).html().length > 17) {
                var text = $(this).text();
                text = text.substr(0, 17) + '...';
                $(this).text(text);
            }
        });
    });
})(jQuery);