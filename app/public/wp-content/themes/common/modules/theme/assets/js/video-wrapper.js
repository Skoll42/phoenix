(function($) {
    function resizeVids() {
        $('.videoWrapper').fitVids();
    }

    $(document).ready(function(){
        resizeVids();
        setTimeout(resizeVids, 1500); // timeout is fix for video loading (the video loads via js)
    });
})(jQuery);