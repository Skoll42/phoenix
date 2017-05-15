(function($) {

    var currentUser;
    var redirectToUrl = window['redirectToUrl'];

    $(document).on('spid.statusChanged', function (event, status, user) {
        if (!user) {
            var originHost = window.location.origin ? window.location.origin : window.location.protocol + '//' + window.location.host;
            window.location.replace(originHost);
            return;
        }

        currentUser = user;

        $(document).trigger('intercom.createUser', {
            action: 'login',
            status: status,
            user: user,
            callback: function() {
                intercomDone = true;
                executeCallback();
            }
        });
    });

    $(document).on('spid.extendedUser', function (event, user) {
        $(document).trigger('mixpanel.userLoggedIn', user || currentUser);

        mixpanelDone = true;
        executeCallback();
    });

    $(document).on('intercom.booted', function (event, intercomSettings, user) {
        $(document).trigger('intercom.trackLogin');

        intercomEventDone = true;
        executeCallback();
    });

    var mixpanelDone, intercomDone, intercomEventDone;
    function executeCallback() {
        if (mixpanelDone && intercomDone && intercomEventDone) {
            setTimeout(function() {
                window.location.replace(redirectToUrl);
            }, 1000);
        }
    }

})(jQuery);
