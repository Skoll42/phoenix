jQuery('body').on('oceanhub.loaded dockedships.loaded', function() {
    var advRatio = 0.4;
    var turnOffRatio = 1.5;

    var content = jQuery('.article-content .row .post');
    var adv = jQuery('.article-content .sidebar .adv-block');
    var block = jQuery('.article-content .sidebar .proff-block-widget');
    var checkAdvRatio = function() {
        var wrapper = jQuery('.sticky-wrapper');

        if (jQuery(window).width() < 992) {
            wrapper.css('height', 'auto');
            return false;
        }

        var contentHeight = content.height();
        var advHeight = contentHeight * advRatio;
        var blockHeight = contentHeight * (1-advRatio);

        if (!content.length || !adv.length || !block.length) return false;

        var enableSticky = ( contentHeight > turnOffRatio * (adv.height() + block.height()) );

        if (!enableSticky) {
            if(jQuery(window).scrollTop() > contentHeight) {
                block.show();
            } else {
                block.hide();
            }
            wrapper.css('height', 'auto');
            return false;
        }

        var calcStickyRegions = function() {
            contentHeight = content.height();
            advHeight = contentHeight * advRatio;
            blockHeight = contentHeight * (1-advRatio);
            block.stop(true, true);
            if (jQuery(window).scrollTop() > advHeight && jQuery(window).scrollTop() <= blockHeight && jQuery(window).width() >= 992) {
                block.fadeIn('slow').stickit('destroy').stickit({top: 85, zIndex: 10});
            } else if(jQuery(window).width() >= 992 && jQuery(window).scrollTop() > blockHeight) {
                block.stickit('destroy').show();
            } else {
                block.fadeOut('slow');
            }
        };

        var setWrapperHeight = function(elem, wrapperHeight) {
            var parent = elem.parent('.sticky-wrapper');
            if (parent) {
                if (elem.height() < wrapperHeight) {
                    parent.height(wrapperHeight);
                } else {
                    parent.css('height', 'auto');
                }
            }
        };

        setWrapperHeight(adv, advHeight);
        setWrapperHeight(block, blockHeight);

        adv.stickit('destroy').stickit({top: 85});

        jQuery(window).scroll(function() {
            calcStickyRegions();
        });

        calcStickyRegions();
    };

    jQuery(window).resize(function() {
        checkAdvRatio();
    });

    checkAdvRatio();

});
