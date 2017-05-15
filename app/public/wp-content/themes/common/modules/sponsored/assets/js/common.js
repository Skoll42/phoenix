(function($) {
    var adManager;
    var sponsoredData = window['sponsoredData'];
    var pageType = sponsoredData && typeof sponsoredData['pageType'] !== 'undefined' ? sponsoredData['pageType'] : '';
    var currentCategory = sponsoredData && typeof sponsoredData['currentCategory'] !== 'undefined' ? sponsoredData['currentCategory'] : '';

    var insertAdNexus = function(blocks, blockId) {
        var adId = (blockId == 'e24')
            ? currentCategory + '-wph-' + ( pageType == 'front' ? (pageType + '-board-backfill-1') : (pageType + '-board-1') )
            : currentCategory + '-wph-' + pageType + '-board-2';

        blocks.each(function() {
            var block = $(this);
            var visible = block.is(":visible");

            block.replaceWith(
                '<div class="visible-sm visible-md visible-lg">' +
                    '<div class="nexus-content-wrapper nexus-sponsored">' +
                        '<div class="ad-nexus-ad visible-sm visible-md visible-lg" data-' + (!visible ? 'fake-' : '') + 'id="' + adId + '"></div>' +
                    '</div>' +
                '</div>'
            );
        });

        adManager = new AdManager();
        adManager.pageAds = $('.ad-nexus-ad');
        adManager.insertAds(function() {
            $('body').trigger('adnexus.loaded');
        });

        showAd(blockId);

        $(window).resize(function() {
            var fakeBlocks = $('[data-fake-id]');

            if (fakeBlocks.length) {
                var adIds = [];
                fakeBlocks.each(function() {
                    var fakeBlock = $(this);
                    var adId = fakeBlock.attr('data-fake-id');

                    if (jQuery.inArray(adId, adIds) == -1) {
                        adIds.push(adId);
                    }
                });

                $.each(adIds, function(index, adId) {
                    $('[data-fake-id="' + adId + '"], [data-id="' + adId + '"]').each(function() {
                        var block = $(this);

                        if (block.is(':visible')) {
                            block.attr('data-id', adId).removeAttr('data-fake-id');
                            block.html(adManager.prepareAdScript(adId));
                        } else {
                            block.attr('data-fake-id', adId).removeAttr('data-id');
                            block.html('');
                        }
                    });
                });

            }

            showAd(blockId);
        });
    };

    var showAd = function(blockId) {
        apntag.anq.push(function() {
            apntag.setPageOpts({
                member: 3296,
                disablePsa: true,
                keywords: {
                    'aa-sch-country_code': 'no',
                    'aa-sch-supply_type': 'web_phone',
                    'aa-sch-publisher': 'no-' + currentCategory,
                    'aa-sch-page_type': pageType,
                    'aa-sch-inventory_type': 'editorial'
                }
            });

            if (blockId == 'e24') {
                if (pageType == 'front') {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wph-' + pageType + '_board_backfill_1',
                        sizes: [320,250],
                        targetId: currentCategory + '-wph-' + pageType + '-board-backfill-1',
                        keywords: {'no-sno-adformat':'board_backfill_1'}
                    });
                } else {
                    apntag.defineTag({
                        invCode: 'no-' + currentCategory + '-wph-' + pageType + '_board_1',
                        sizes: [320,250],
                        targetId: currentCategory + '-wph-' + pageType + '-board-1',
                        keywords: {'no-sno-adformat':'board_1'}
                    });
                }
            } else {
                apntag.defineTag({
                    invCode: 'no-' + currentCategory + '-wph-' + pageType + '_board_2',
                    sizes: [320,250],
                    targetId: currentCategory + '-wph-' + pageType + '-board-2',
                    keywords: {'no-sno-adformat':'board_2'}
                });
            }

            apntag.loadTags();
            adManager.mobileFilled = true;
        });
    };

    $('body').on('sponsored.ready', function() {
        $.each(['e24', 'internal'], function(index, blockId) {
            var blocks = $('.sponsor-block-' + blockId);
            if (blocks.length) {
                var ids = sponsoredData[blockId + 'Ids'];
                var cookiePosKey = 'sponsored_pos_' + blockId;
                var pos = parseInt($.cookie(cookiePosKey));
                var nextPos = (typeof pos == 'undefined' || typeof ids[pos + 1] == 'undefined') ? 0 : pos + 1;
                var articleId = ids[nextPos];
                if (articleId) {
                    $.get('/bt_e24/article/' + articleId + '/', function(data) {
                        if (data) {
                            $.cookie(cookiePosKey, nextPos, {path: '/', expires: 30});
                            blocks.replaceWith(data);
                            $( 'img[data-lazy-src]' ).bind( 'scrollin', { distance: 200 }, function() {
                                bt_lazy_load_image( this );
                            });
                        } else {
                            insertAdNexus(blocks, blockId);
                        }
                    });
                } else {
                    insertAdNexus(blocks, blockId);
                }
            }
        });
    });

    $(document).ready(function() {
        if (pageType == 'front') {
            $('body').trigger('sponsored.ready');
        }
    });
})(jQuery);