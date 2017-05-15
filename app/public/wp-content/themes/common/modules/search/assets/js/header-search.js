(function ($) {
    $(document).ready(function() {
        var body = $('body');
        var header = $('.main-header, .mobile-menu');
        var searchButton = $('.search-button', header);
        var searchInput = $('.search-input', header);
        var searchClear = $('.close-search-button', header);
        var keywords = $('.search-categories .category-name, .search-categories-mobile .category-name', header);
        var resultsContainer = $('.search-results, .search-results-mobile', header);
        var searchRequestInProgress = null;

        body.on('search.results', function(event, data) {
            processSearchResults(data);
        });

        body.on('search.doSearch', function(event, query) {
            doSearch(query);
        });

        $('.close-button', header).on('click', function(event) {
            resetHeaderState();
        });

        bindSearch();
        bindToggleMenus();

        function bindSearch() {
            searchInput.on('keyup', function(e) {
                var searchInput = $(this);
                var inputVal = searchInput.val();
                if(inputVal.length > 0) {
                    searchButton.addClass('hidden');
                    searchClear.removeClass('hidden');
                } else {
                    searchButton.removeClass('hidden');
                    searchClear.addClass('hidden');
                }
                setTimeout(function() {
                    if (searchInput.val() == inputVal)
                    {
                        $('body').trigger('search.doSearch', inputVal);
                    }
                }, 1000);
            });

            searchClear.on('click', function(e) {
                e.preventDefault();
                searchInput.val('');
                $('.search-categories, .search-categories-mobile').removeClass('hidden');
                resultsContainer.addClass('hidden').find('.result-list').html('');
                showActiveSearchControls();
            });

            keywords.on('click', function(e) {
                e.preventDefault();
                $('body').trigger('search.doSearch', searchInput.val($(this).text()).val());
                showActiveSearchControls();
            });
        }

        function bindToggleMenus() {
            $('.open-search, .close-search').click(function(e) {
                e.preventDefault();
                $('.open-search, .close-search, .search-area, .section-links, .search-container', header).toggleClass('hidden');
            });
            $('.open-search-mobile, .close-search-mobile').click(function(e) {
                e.preventDefault();
                $('.open-search-mobile, .close-search-mobile, .section-links-mobile, .search-area-mobile, .search-container-mobile', header).toggleClass('hidden');
            });
            $("a[data-target='#profile-menu']").click(function (){
                $("#extended-menu").modal('hide');
            });
            $("a[data-target='#extended-menu']").click(function (){
                $("#profile-menu").modal('hide');
            });
        }

        function resetHeaderState() {
            $('.open-search, .open-search-mobile, .close-search, .search-container, .close-search-button, .search-area, .search-area-mobile, .search-results, .search-results-mobile, .close-search-mobile, .search-container-mobile, .close-search-button-mobile', header).addClass('hidden');
            $('.section-links, .section-links-mobile, .open-search-mobile, .open-search, .search-button, .search-categories, .search-categories-mobile', header).removeClass('hidden');
            searchInput.val('');
        }

        function showActiveSearchControls() {
            searchButton.toggleClass('hidden');
            searchClear.toggleClass('hidden');
        }

        function doSearch(query) {
            if(query.length > 2) {
                $('.search-categories, .search-categories-mobile').addClass('hidden');
                $('.search-results, .search-results-mobile').removeClass('hidden').find('.loader').removeClass('hidden');
                $('.main-header .see-all').addClass('hidden');
                $('.search-results .result-list, .search-results-mobile .result-list').html('');
                var params = {
                    action: 'header_search',
                    query: query,
                    amount: 6
                };
                if(searchRequestInProgress && (searchRequestInProgress.readyState >= 0 && searchRequestInProgress.readyState < 4)) {
                    searchRequestInProgress.abort();
                }
                searchRequestInProgress = $.get(ajaxurl, params).done(function(data){
                    $('body').trigger('search.results', data.data);
                });
            }
        }

        function processSearchResults(results) {
            var articles = results.articles;
            var html = '';
            var counter = 0;
            if (Object.keys(articles).length > 0) {
                for(var article in articles) {
                    if(articles.hasOwnProperty(article)) {
                        counter++;
                        html += prepareArticleLayout(articles[article], results.query, counter);
                        if(counter % 2 === 0) {
                            html += '<div class="clearfix visible-lg"></div>';
                        }
                    }
                }
            } else {
                html = '<div class="col-xs-12 col-lg-6 no-results">Ingen resultater, prøv et nytt søk.</div>';
            }
            $('.result-list', resultsContainer).html(html).removeClass('hidden');
            $('.search-results .loader, .search-results-mobile .loader').addClass('hidden');
            if(results.total > Object.keys(results.articles).length) {
                var seeAllUrl = '/?s=' + results.query;
                $('.main-header .see-all').removeClass('hidden').find('a').attr('href', seeAllUrl);
            }
        }

        function prepareArticleLayout(article, query, counter) {
            // Underline search query in title if present
            var reg = new RegExp(query, 'gi');
            var title = article.title.replace(reg, function(str) {
                return '<span class="search-term">' + str + '</span>'
            });

            // Desktop and other layouts have different number of results
            return '<div class="article col-xs-12 col-lg-6' +
                    (counter > 3 ? " hidden-xs hidden-sm hidden-md" : "") + '"><a href="' + article.link + '" class="title">' + title + '</a>' +
                    '<div class="date">' + article.publish_date + '</div>' +
                    '<span class="site-logo logo-small"><img src="' + article.svg_category + '" alt="category image">' +
                    '</span></div>';
        }
    });
})(jQuery);
