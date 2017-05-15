function AdManager() {}

(function ($){

	AdManager.prototype.desktopFilled = false;
	AdManager.prototype.tabletFilled = false;
	AdManager.prototype.mobileFilled = false;
	AdManager.prototype.pageType = adPage.pageName;
    AdManager.prototype.pageAds = $('.ad-nexus-ad');

    AdManager.prototype.checkAd = function(ad_id) {
        return $('#' + ad_id).length;
    };

    AdManager.prototype.shouldLoadAds = function(version) {
        switch(version) {
            case 'mobile':
                return this.shouldLoadMobileAds();
            case 'tablet':
                return this.shouldLoadTabletAds();
            case 'desktop':
                return this.shouldLoadDesktopAds();
        }
    };

    AdManager.prototype.shouldLoadDesktopAds = function(version) {
        return $(window).width() >= 992 && !this.desktopFilled;
    };

    AdManager.prototype.shouldLoadTabletAds = function(version) {
        var windowWidth = $(window).width();
        return windowWidth >= 768 && windowWidth < 992 && !this.tabletFilled;
    };

    AdManager.prototype.shouldLoadMobileAds = function(version) {
        return $(window).width() < 768 && !this.mobileFilled;
    };

    AdManager.prototype.insertAds = function(callback) {
        var self = this;
        self.pageAds.each(function(index) {
            self.insertAd($(this).data('id'));
        });
        callback();
    };

    AdManager.prototype.insertAd = function(id) {
        $('[data-id="' + id + '"]').html(this.prepareAdScript(id));
    };

    AdManager.prototype.prepareAdScript = function(id) {
        return '<div class="nexus-wrapper">' +
                    '<div class="ad-title">Annonse</div>' +
                    '<div id="' + id + '" class="nexus-ad">' +
                        '<div class="nexus-body">' +
                            '<script type="text/javascript">apntag.anq.push(function() {apntag.showTag("' + id + '");});</script>' +
                        '</div>' +
                    '</div>' +
                '</div>';
    };
})(jQuery);
