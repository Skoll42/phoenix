(function($) {

    var currentUser;
    var voucherCode = window['voucherCode'];
    var redirectToUrl = window['redirectToUrl'];
    
    $(document).on('spid.statusChanged', function (event, status, user) {
        if (!user) {
            var originHost = window.location.origin ? window.location.origin : window.location.protocol + '//' + window.location.host;
            window.location.replace(originHost);
            return;
        }

        currentUser = user;

        mixpanelProductId = user.productId;
        sendDataToMixpanel();

        $(document).trigger('intercom.createUser', {
            action: 'purchase',
            status: status,
            user: user,
            product_id: user.productId,
            voucher_code: voucherCode,
            callback: function() {
                intercomDone = true;
                executeCallback();
            }
        });
    });

    $(document).on('spid.extendedUser', function (event, user) {
        mixpanelUser = user || currentUser;
        sendDataToMixpanel();

        mixpanelDone = true;
        executeCallback();
    });

    $(document).on('intercom.booted', function (event, intercomSettings, user) {
        $(document).trigger('intercom.trackPurchase', [mixpanelProductId, voucherCode]);

        intercomEventDone = true;
        executeCallback();
    });

    var mixpanelUser, mixpanelProductId;
    function sendDataToMixpanel() {
        if (mixpanelUser && mixpanelProductId) {
            $(document).trigger('mixpanel.productBought', [mixpanelUser, mixpanelProductId, voucherCode]);
        }
    }

    var mixpanelDone, intercomDone, intercomEventDone;
    function executeCallback() {
        if (mixpanelDone && intercomDone && intercomEventDone) {
            setTimeout(function() {
                window.location.replace(redirectToUrl);
            }, 1000);
        }
    }
})(jQuery);