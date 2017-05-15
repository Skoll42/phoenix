(function ($) {
    var mainContainer = $('.search-bar');
    var navBar = $('.navbar-bt');
    var xhr = null;
    var oldS = null;
    var timer = null;

    $('.search-button').on('click', function(e){
        e.preventDefault();
        showSearchPopup();
    });
    $('.search-form', mainContainer).on('submit', function(e, forceSubmit){
        if (!forceSubmit) {
            e.preventDefault();
        }

    });
    $('.see-all', mainContainer).on('click', function(e) {
        e.preventDefault();
        $('.search-form', mainContainer).trigger('submit', [true]);
    });
    $('.close-button, .search-bar').on('click', function(e){
        if( $(e.target).is('.close-button') || $(e.target).is('.search-bar') ) {
            e.preventDefault();
            hideSearchPopup();
        }
    });
    $(document).keyup(function(e){
        var escCode = 27;
        if (e.which == escCode){
            hideSearchPopup();
        }
    });

    function showSearchPopup() {
        navBar.addClass('search-opened');
        mainContainer.addClass('show');
        timer = setInterval(performSearch, 500);
    }

    function hideSearchPopup() {
        navBar.removeClass('search-opened');
        mainContainer.removeClass('show');
        clearInterval(timer);
    }

    function performSearch() {
        var s = $('.search-input', mainContainer).val();
        var listEl = $('.search-result-list', mainContainer);
        if (oldS == s) {
            return;
        }
        oldS = s;

        if (xhr) {
            xhr.abort();
        }

        var is_search = (s != '');
        $('.search-result', mainContainer)[is_search ? 'addClass' : 'removeClass']('in-searching');
        listEl.empty();

        var options = (is_search) ? {action: 'site-search-result', s: s} : {action: 'site-search-popular'};
        mainContainer.addClass('loading');
        xhr = $.post(site_search.ajax_url, options, function (data, textStatus, jqXHR) {
            var html = '';
            for (var i = 0; i < data.length; i++) {
                var post = data[i];
                var post_title = post.title;
                if (is_search) {
                    post_title = post_title.replace(new RegExp('(' + s + ')', 'gim'), "<span>$1</span>");
                }
                html += '<li><a href="' + post.permalink + '">' + post_title + '</a></li>';
            }
            if (data.length == 0) {
                html += '<li class="no-result">Sorry, nothing found.</li>';
            }
            listEl.html(html);
            mainContainer.removeClass('loading');
        });
    }

})(jQuery);