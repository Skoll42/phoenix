(function ($) {
    $(document).ready(function() {
        var inIframe = window.inIframe == 'true' ? 1 : 0;
        var pageType = oceanhubConfig && oceanhubConfig.hasOwnProperty('pageType') ? oceanhubConfig.pageType : '';
        $.get(ajaxurl, {action: 'get_oceanhub_widget', page_type: pageType, iniframe: inIframe}, function(response) {
            if(response && response.hasOwnProperty('data')) {
                $('.proff-block-widget').html(response.data.widget_html);
            }
            $('body').trigger('oceanhub.loaded');
        });

        $('body').on('oceanhub.loaded', function() {
            if(!inIframe) {
                $( 'img[data-lazy-src]' ).bind( 'scrollin', { distance: 200 }, function() {
                    bt_lazy_load_image( this );
                });
            }
        });
    });
})(jQuery);