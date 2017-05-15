(function ($) {
    $(document).on('mixpanel.userLoggedIn', function(event, user) {
        if (user) {
            setMixpanelProfile(user);
        }

        mixpanel.track("Login", {
            "Website": window.location.host
        });

    });

    $(document).on('mixpanel.userLoggedOut', function(event, user) {
        if (user) {
            setMixpanelProfile(user);
        }

        mixpanel.track("Logout", {
            "Website": window.location.host
        });

    });

    $(document).on('mixpanel.productBought', function(event, user, productId, voucherCode) {
        if (user) {
            setMixpanelProfile(user);
        }

        mixpanel.track("Purchase", {
            "Website": window.location.host,
            "Product ID": productId,
            "Voucher Code": voucherCode
        });
    });

    $(document).on('mixpanel.exitLogIn', function(event, user, page) {
        if (user) {
            setMixpanelProfile(user);
        }

        mixpanel.track("Exit LogIn", {
            "Website": window.location.host,
            "Exit SPiD Page" : page
        });

    });

    $(document).on('mixpanel.exitPurchase', function(event, user, page) {
        console.log(user, page);
        if (user) {
            setMixpanelProfile(user);
        }

        mixpanel.track("Exit Purchase", {
            "Website": window.location.host,
            "Exit SPiD Page" : page
        });

    });

    $(document).on('mixpanel.gaVariationShowed', function(event, variationId) {
        mixpanel.track("PremiumVariationShowed", {
            "Website": window.location.host,
            "Premium Variation ID": variationId
       });
    });

    function setMixpanelProfile(user) {
        if (typeof user.userId != 'undefined') {
            mixpanel.identify(user.userId);
            mixpanel.people.set({
                "$first_name": user.givenName || user.name.givenName,
                "$last_name": user.familyName || user.name.familyName,
                "$email": user.email
            });
        }
    }

})(jQuery);