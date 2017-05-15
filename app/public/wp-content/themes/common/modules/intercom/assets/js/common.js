(function ($) {
    var appId = window['appId'];
    var shouldShowChat = window['showChat'];

    $(document).ready(function() {
        onCompanyStartNewMessage();
    });

    $(document).on('intercom.createUser', function (event, data) {
        var action = data.action || 'login';
        var user = data.user;

        var params = {
            action: 'intercom_create_user',
            type: action,
            spid_user_id: user.userId,
            spid_product_id: (action == 'purchase') ? data.product_id : null,
            spid_voucher_code: (action == 'purchase') ? data.voucher_code : null
        };

        $.post(ajaxurl, params, function() {
            data.callback && data.callback();
        });
    });

    $(document).on('intercom.trackLogin', function (event) {
        Intercom('trackEvent', 'Log in', {
            website: window.location.host
        });
    });

    $(document).on('intercom.trackLogout', function (event) {
        Intercom('trackEvent', 'Log out', {
            website: window.location.host
        });
    });

    $(document).on('intercom.trackPurchase', function (event, product_id, voucher_code) {
        Intercom('trackEvent', 'Purchase', {
            product_id: product_id,
            voucher_code: voucher_code,
            website: window.location.host
        });
    });

    $(document).on('intercom.trackExitLogin', function (event, bounce_page) {
        Intercom('trackEvent', 'Exit Log in', {
            website: window.location.host,
            bounce_page: bounce_page
        });
    });

    $(document).on('intercom.trackExitPurchase', function (event, bounce_page) {
        Intercom('trackEvent', 'Exit Purchase', {
            website: window.location.host,
            bounce_page: bounce_page
        });
    });

    $(document).on('intercom.trackHitPaywall', function (event) {
        Intercom('trackEvent', 'Hit Paywall', {
            website: window.location.host
        });
    });

    var currentUser;
    $(document).on('spid.statusChanged', function (event, status, user) {
        if(status == 'non-authorized') {
            insertIntercomChat(user);
        } else {
            currentUser = user;
        }
    });

    $(document).on('spid.extendedUser', function (event, user) {
        insertIntercomChat(user||currentUser);
    });

    function insertIntercomChat(user) {
        window.intercomSettings = {
            app_id: appId,
            hide_default_launcher: !shouldShowChat
        };

        if (user && user.email) {
            intercomSettings['email'] = user.email;
            if (user.userId) {
                intercomSettings['user_id'] = user.userId;
            }
        }

        Intercom('boot', intercomSettings);

        $(document).trigger('intercom.booted', [intercomSettings, user]);
    }

    function onCompanyStartNewMessage() {
        $('.contact-button', $('.price-block.price-block-third, .plan-body.plan-third')).click(function(e) {
            e.preventDefault();
            window.Intercom('showNewMessage');
        });
    }

})(jQuery);