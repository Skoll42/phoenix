window.contentIterator = 0;
(function($) {

    var currentPost;
    var nextPosts = window.nextPosts;
    var maxTop = $('#sliding-header').height();

    function scroll() {
        var els = $('.fake_placeholder');
        var visibleChanged = false;
        var next;

        for (var i = 0; i < els.length; i++) {
            var fakeEl = $(els[i]);
            var el = $('#' + fakeEl.attr('data-id'));
            el.removeClass('next');

            if (!visibleChanged) {
                if (el.css('position') != 'absolute') {
                    el.css({position: 'absolute', top: fakeEl.offset().top});
                }
                visibleChanged = fakeEl.offset().top + fakeEl.height() > window.scrollY + maxTop;
                if (visibleChanged) {
                    next = (typeof els[i+1] != 'undefined') ? $('#' + $(els[i+1]).attr('data-id')) : null;
                    var pos = el.attr('data-pos');
                    var post = (pos == -1) ? currentPost : nextPosts[pos];
                    if (window.location.href != post['permlink']) {
                        document.title = post['page_title'];
                        window.history.pushState(null, post['page_title'], post['permlink']);
                    }
                }
            } else {
                if (el.css('position') != 'fixed') {
                    el.css({position: 'fixed', top: maxTop});
                }
            }
        }
        next && next.addClass('next');
    }

    function reset() {
        var els = $('.fake_placeholder');

        for (var i = els.length - 1; i >= 0; i--) {
            resetById( $(els[i]).attr('data-id') );
        }
    }

    function resetById(id) {
        var el = $('#' +  id);
        var fakeEl = $('#' +  id + '_fake');

        el.css({position: 'static', width: 'auto', height: 'auto', top: 'auto', left: 'auto'});
        fakeEl.css({position: 'static', width: 0, height: 0});
    }

    function loadNextPage() {
        var content = $('#dynamic_content');
        var maxBottom = window.pageYOffset + $(window).height();
        var bottom = content.offset().top + content.height();

        if (bottom - maxBottom < 1200 && !content.hasClass('loading')) {
            if (typeof nextPosts[contentIterator] == 'undefined') {
                return;
            }

            var nextPostUrl = nextPosts[contentIterator]['permlink'];

            if (typeof nextPostUrl == 'undefined') {
                return;
            }

            var id = 'frame' + contentIterator;
            var isLast = (contentIterator == nextPosts.length - 1);
            var iframeSelector = '#dynamic_content' + ' ' + '#' + id + 'content' + ' ' + 'iframe';

            content.addClass('loading');
            content.append('<div id="' + id + 'content" data-pos="' + contentIterator + '" class="' + (isLast ? 'last' : '') + '" style="z-index:' + (1000 - contentIterator * 10) + '"><div class="wrapper"><iframe id="' + id + '" src="' + nextPostUrl + '?iniframe=1" width="100%" height="' + $(window).height() + 'px" scrolling="no" style="display:block; margin-top:30px; border:0;"></iframe></div></div>');

            $(iframeSelector).iFrameResize({
                initCallback: function(iframe) {
                    content.removeClass('loading');
                },
                resizedCallback: function(iframe) {
                    resetById(iframe.id + 'content');
                    scroll();
                }
            });
            contentIterator++;

        }
    }

    function resize() {
        reset();
        scroll();
    }

    $(window).scroll(function () {
        scroll();
        loadNextPage();
    });

    $(window).resize(function () {
        resize();
    });

    $(window).on('load.stillinger', function () {
        resize();
    });

    $(document).ready(function() {
        currentPost = {page_title: document.title, permlink: window.location.href};
        $('#article_page_content').css({'z-index': 1010}).attr('data-pos', -1);
        scroll();

        $('.iframeWrapper').iFrameResize({maxHeight: '800px', maxWidth: '100%'});

        $(window).bind('orientationchange', function(event) {
            $('.iframeWrapper').iFrameResize({maxHeight: '800px', maxWidth: '100%'});
        });


    });

})(jQuery);