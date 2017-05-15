(function ($){
    $('body').on('adnexus.loaded', function() {
        var skySelector = $('.nexus-skyscrapper');
        function stickSkycrapper() {
            if (typeof skySelector.stickit !== 'function') return;
            skySelector.is(":visible") && $(window).width() >= 1600 ? skySelector.stickit({scope: StickScope.Document, top: 85}) : skySelector.stickit('destroy');
        }
        stickSkycrapper();
        $(window).resize(function(){
            stickSkycrapper();
        });
    });
})(jQuery);