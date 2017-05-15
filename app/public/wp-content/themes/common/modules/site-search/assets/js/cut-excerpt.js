(function ($) {
$(document).ready(function(){
    cutExcerpt();
    $(window).resize(function(){
        cutExcerpt();
    });
    function cutExcerpt() {
        $('.search-excerpt').each(function() {
            $(this).dotdotdot({
                ellipsis : ' ... '
            });
        });
    }
});
})(jQuery);