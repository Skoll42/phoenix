jQuery(document).ready(function($) {

    $('.podcast-widget').each(function() {

        var widgetWrapper = $(this);
        var prevButton = $('.podcast-prev', widgetWrapper);
        var nextButton = $('.podcast-next', widgetWrapper);
        var tabsWrapper = $('.nav-wrapper', widgetWrapper);
        var listTabItems = $('.nav-tabs > li', tabsWrapper);

        var shouldScroll = false;
        var duration = 400;

        var showButtons = function() {
            var wrapperWidth = tabsWrapper.width();

            var childrenWidth = 0;
            listTabItems.each(function() {
                childrenWidth += $(this).outerWidth(true);
            });

            if (wrapperWidth < childrenWidth || window.innerWidth < 768) {
                shouldScroll = true;
                prevButton.show();
                nextButton.show();
            } else {
                shouldScroll = false;
                prevButton.hide();
                nextButton.hide();
            }

        };

        var setActiveTab = function(activeTab) {
            if (window.innerWidth < 768) return false;

            var shouldAnimate = activeTab ? true : false;
            activeTab = activeTab || $('.nav-tabs > .active', tabsWrapper);

            var wrapperWidth = tabsWrapper.width();

            var activeIndex = listTabItems.index(activeTab);
            var offset = 0, i = 0;
            listTabItems.each(function() {
                if (activeIndex < i) return false;
                offset += $(this).outerWidth(true);
                i++;
            });

            var tabsContainer = $('.nav-tabs', tabsWrapper);
            var marginLeft = offset > wrapperWidth ? wrapperWidth - offset  : 0;

            tabsContainer.stop(true, true);

            if (shouldAnimate && shouldScroll) {
                shouldScroll = false;
                tabsContainer.animate({marginLeft: marginLeft}, duration, function () {
                    shouldScroll = true;
                });
            } else {
                tabsContainer.css({marginLeft: marginLeft});
            }

        };

        var scrollTab = function(direction) {
            if (!shouldScroll) return false;

            var activeTab = $('.nav-tabs > .active', tabsWrapper);
            var targetElement, isReset;

            if (direction == 'next') {
                isReset = activeTab.is(':last-child');
                targetElement = (isReset) ? listTabItems.first() : activeTab.next('li');
            } else {
                isReset = activeTab.is(':first-child');
                targetElement = (isReset) ? listTabItems.last() : activeTab.prev('li');
            }

            setActiveTab(targetElement);

            targetElement.find('[data-target-id]').click();
        };

        $('[data-target-id]', widgetWrapper).click(function() {
            var id = $(this).attr('data-target-id');
            $('[data-id]', widgetWrapper).hide();
            $('[data-id="' + id + '"]', widgetWrapper).fadeIn(duration);
        });

        prevButton.click(function() {
            scrollTab('prev');
        });

        nextButton.click(function() {
            scrollTab('next');
        });

        $(window).resize(function() {
            showButtons();
            setActiveTab();
        });

        showButtons();

    });

});