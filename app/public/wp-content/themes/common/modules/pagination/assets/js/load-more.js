(function($) {
    var nextSelector = '.navigation .next';
    var navSelector = '.navigation';
    var loadMoreBlockSelector = '.load-more';
    var loadMoreSelector = '.load-more-button';
    var contentSelector;
    var desturl;

    $(document).ready(function() {
        contentSelector = window.globalContentSelector;

        var next = $(nextSelector);
        if (next.length) {
            desturl = $(nextSelector).attr('href');
        } else {
            $(loadMoreSelector).hide();
        }


        $(navSelector).hide();
        $(loadMoreSelector).click(function(e) {
            e.preventDefault();
            loadNextPage();
        })
    });

    function loadNextPage() {
        $(loadMoreBlockSelector).addClass('loading');

        $.ajax({
            // params
            url: desturl,
            dataType: 'html',
            success: function (data) {

                var obj = $(data),
                    newContent = obj.find(contentSelector).html(),
                    next = obj.find(nextSelector);

                if (next.length) {
                    desturl = next.attr('href');
                }
                else {
                    $(loadMoreSelector).hide();
                }

                $(loadMoreBlockSelector).removeClass('loading');

                $(contentSelector).append(newContent);

                $( 'img[data-lazy-src]' ).bind( 'scrollin', { distance: 200 }, function() {
                    bt_lazy_load_image( this );
                });
            },
            error: function() {
                $(loadMoreBlockSelector).removeClass('loading');
                $(loadMoreSelector).hide();
            }
        });
    }

})(jQuery);