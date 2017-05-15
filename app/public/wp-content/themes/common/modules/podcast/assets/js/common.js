(function($) {
    var delay = 400;

    $(document).ready(function() {
        $('.podcast-menu .button').click(function() {
            var button = $(this);
            var wrapper = button.parents('.podcast-menu-wrapper');
            var content = $('.podcast-menu-content', wrapper);

            if (wrapper.hasClass('podcast-menu-collapsed')) {
                button.removeClass('category-background');
                wrapper.removeClass('category-background');
                content.css({opacity: 0}).animate({opacity: 1}, delay + 200);
            } else {
                content.css({opacity: 1}).animate({opacity: 0}, delay);

            }

            wrapper.addClass('podcast-menu-animated');

            $('.podcast-menu-inner', wrapper).slideToggle(delay, function () {
                if (!wrapper.hasClass('podcast-menu-collapsed')) {
                    wrapper.addClass('category-background');
                    button.addClass('category-background');
                }
                wrapper.toggleClass('podcast-menu-collapsed');
                wrapper.removeClass('podcast-menu-animated');
            });
        });
    });
})(jQuery);