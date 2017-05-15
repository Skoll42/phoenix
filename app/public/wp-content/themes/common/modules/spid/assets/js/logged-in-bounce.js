(function($) {
    
    var currentUser;
    var redirectToUrl = window['redirectToUrl'];
    var bouncePage = window['bouncePage'];
    
    $(document).on('spid.statusChanged', function (event, status, user) {
        currentUser = user;
    
        intercomDone = true;
        executeCallback();
    
        if (status == 'non-authorized') {
            trackMixpanel(user);
        }
    });
    
    $(document).on('spid.extendedUser', function (event, user) {
        trackMixpanel(user || currentUser);
    });
    
    function trackMixpanel(user) {
        $(document).trigger('mixpanel.exitLogIn', [user, bouncePage]);
    
        mixpanelDone = true;
        executeCallback();
    }
    
    $(document).on('intercom.booted', function (event, intercomSettings, user) {
        $(document).trigger('intercom.trackExitLogin', bouncePage);
    
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