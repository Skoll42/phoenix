(function ($){
    var adManager;
    var currentCategory = adCategory.categoryName;

    $(document).ready(function() {        
        adManager = new AdManager();
        adManager.insertAds(function() {
            $('body').trigger('adnexus.loaded');
        });
        showAd();
        $(window).resize(function(){
            showAd();
        });        

        function showAd() {            
            if( adManager.shouldLoadAds('desktop') ) {
                loadDesktopAds();
            }

            if( adManager.shouldLoadAds('tablet') ) {
                loadTabletAds();
            }

            if( adManager.shouldLoadAds('mobile') ) {
                loadMobileAds();
            }
        };

        function loadDesktopAds() {
            apntag.anq.push(function() {
                apntag.setPageOpts({
                    member: 3296,
                    disablePsa: true,
                    keywords: {
                        'aa-sch-country_code': 'no',
                        'aa-sch-supply_type': 'web_desktop',
                        'aa-sch-publisher': 'no-' + currentCategory,
                        'aa-sch-page_type': adManager.pageType,
                        'aa-sch-inventory_type': 'editorial',
                        'no-sno-publishergroup': 'schibsted',
                        'no-sno-news-section': currentCategory + '_okonomi'
                    }
                });                
                /* Top board */
                if(adManager.checkAd(currentCategory + '-wde-front-topboard')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wde-front_topboard',
                        sizes: [[980,300],[980,150]],
                        targetId: currentCategory + '-wde-front-topboard',
                        keywords: {'no-sno-adformat':'topboard'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wde-article-topboard')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wde-article_topboard',
                        sizes: [[980,300],[980,150]],
                        targetId: currentCategory + '-wde-article-topboard',
                        keywords: {'no-sno-adformat':'topboard'}
                    });
                }              

                /* Front page */
                if(adManager.checkAd(currentCategory + '-wde-front-netboard-1')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wde-front_netboard_1',
                        sizes: [580,400],
                        targetId: currentCategory + '-wde-front-netboard-1',
                        keywords: {'no-sno-adformat':'netboard_1'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wde-front-netboard-2')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wde-front_netboard_2',
                        sizes: [580,400],
                        targetId: currentCategory + '-wde-front-netboard-2',
                        keywords: {'no-sno-adformat':'netboard_2'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wde-front-skyscraperright-1')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wde-front_skyscraperright_1',
                        sizes: [180,500],
                        targetId: currentCategory + '-wde-front-skyscraperright-1',
                        keywords: {'no-sno-adformat':'skyscraperright_1'}
                    });
                }

                /* Article page */
                if(adManager.checkAd(currentCategory + '-wde-article-netboard-1')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wde-article_netboard_1',
                        sizes: [580,400],
                        targetId: currentCategory + '-wde-article-netboard-1',
                        keywords: {'no-sno-adformat':'netboard_1'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wde-article-netboard-2')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wde-article_netboard_2',
                        sizes: [580,400],
                        targetId: currentCategory + '-wde-article-netboard-2',
                        keywords: {'no-sno-adformat':'netboard_2'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wde-article-skyscraperright-1')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wde-article_skyscraperright_1',
                        sizes: [180,500],
                        targetId: currentCategory + '-wde-article-skyscraperright-1',
                        keywords: {'no-sno-adformat':'skyscraperright_1'}
                    });
                }

                apntag.loadTags();
                
                adManager.desktopFilled = true;
            });
        }

        function loadTabletAds() {
            apntag.anq.push(function() {
                apntag.setPageOpts({
                    member: 3296,
                    disablePsa: true,
                    keywords: {
                        'aa-sch-country_code': 'no',
                        'aa-sch-supply_type': 'web_tablet',
                        'aa-sch-publisher': 'no-' + currentCategory,
                        'aa-sch-page_type': adManager.pageType,
                        'aa-sch-inventory_type': 'editorial',
                        'no-sno-publishergroup': 'schibsted',
                        'no-sno-news-section': currentCategory + '_okonomi'
                    }
                });
                
                /* Top board */
                if(adManager.checkAd(currentCategory + '-wtb-front-topboard')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wtb-front_topboard',
                        sizes: [980,300],
                        targetId: currentCategory + '-wtb-front-topboard',
                        keywords: {'no-sno-adformat':'topboard'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wtb-article-topboard')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wtb-article_topboard',
                        sizes: [980,300],
                        targetId: currentCategory + '-wtb-article-topboard',
                        keywords: {'no-sno-adformat':'topboard'}
                    });
                }

                /* Front page */
                if(adManager.checkAd(currentCategory + '-wtb-front-netboard-1')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wtb-front_netboard_1',
                        sizes: [580,400],
                        targetId: currentCategory + '-wtb-front-netboard-1',
                        keywords: {'no-sno-adformat':'netboard_1'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wtb-front-netboard-2')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wtb-front_netboard_2',
                        sizes: [580,400],
                        targetId: currentCategory + '-wtb-front-netboard-2',
                        keywords: {'no-sno-adformat':'netboard_2'}
                    });
                }

                /* Article page */
                if(adManager.checkAd(currentCategory + '-wtb-article-netboard-1')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wtb-article_netboard_1',
                        sizes: [580,400],
                        targetId: currentCategory + '-wtb-article-netboard-1',
                        keywords: {'no-sno-adformat':'netboard_1'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wtb-article-netboard-2')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wtb-article_netboard_2',
                        sizes: [580,400],
                        targetId: currentCategory + '-wtb-article-netboard-2',
                        keywords: {'no-sno-adformat':'netboard_2'}
                    });
                }

                apntag.loadTags();

                adManager.tabletFilled = true;
            });
        }

        function loadMobileAds() {
            apntag.anq.push(function() {
                apntag.setPageOpts({
                    member: 3296,
                    disablePsa: true,
                    keywords: {
                        'aa-sch-country_code': 'no',
                        'aa-sch-supply_type': 'web_phone',
                        'aa-sch-publisher': 'no-' + currentCategory,
                        'aa-sch-page_type': adManager.pageType,
                        'aa-sch-inventory_type': 'editorial',
                        'no-sno-publishergroup': 'schibsted',
                        'no-sno-news-section': currentCategory + '_okonomi'
                    }
                });

                /* Front page */
                if(adManager.checkAd(currentCategory + '-wph-front-board-1')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wph-front_board_1',
                        sizes: [320,250],
                        targetId: currentCategory + '-wph-front-board-1',
                        keywords: {'no-sno-adformat':'board_1'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wph-front-board-2')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wph-front_board_2',
                        sizes: [320,250],
                        targetId: currentCategory + '-wph-front-board-2',
                        keywords: {'no-sno-adformat':'board_2'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wph-front-board-3')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wph-front_board_3',
                        sizes: [320,250],
                        targetId: currentCategory + '-wph-front-board-3',
                        keywords: {'no-sno-adformat':'board_3'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wph-front-board-backfill-1')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wph-front_board_backfill_1',
                        sizes: [320,250],
                        targetId: currentCategory + '-wph-front-board-backfill-1',
                        keywords: {'no-sno-adformat':'board_backfill_1'}
                    });
                }

                /* Article page */
                if(adManager.checkAd(currentCategory + '-wph-article-board-1')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wph-article_board_1',
                        sizes: [320,250],
                        targetId: currentCategory + '-wph-article-board-1',
                        keywords: {'no-sno-adformat':'board_1'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wph-article-board-2')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wph-article_board_2',
                        sizes: [320,250],
                        targetId: currentCategory + '-wph-article-board-2',
                        keywords: {'no-sno-adformat':'board_2'}
                    });
                }
                if(adManager.checkAd(currentCategory + '-wph-article-board-3')) {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wph-article_board_3',
                        sizes: [320,250],
                        targetId: currentCategory + '-wph-article-board-3',
                        keywords: {'no-sno-adformat':'board_3'}
                    });
                }

                apntag.loadTags();

                adManager.mobileFilled = true;
            });
        }
    });

})(jQuery);