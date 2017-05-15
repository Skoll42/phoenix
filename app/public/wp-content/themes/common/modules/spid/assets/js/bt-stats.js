(function ($) {

    $(document).ready(function() {
        ga('send', 'event', {
			eventCategory: 'Premium Message',
			eventAction: 'display',
			eventLabel: window.location.href
		});
		window.yaCounterGlobal.reachGoal('premium-message-displayed');

		$(document).trigger('intercom.trackHitPaywall');

		$(document).on('spid.doLogin', function() {
			ga('send', 'event', {
				eventCategory: 'Login Link',
				eventAction: 'click',
				eventLabel: window.location.href,
				transport: 'beacon'
			});
			window.yaCounterGlobal.reachGoal('login-button-clicked');
		});

		$(document).on('spid.doBuy', function() {
			ga('send', 'event', {
				eventCategory: 'Buy Link',
				eventAction: 'click',
				eventLabel: window.location.href,
				transport: 'beacon'
			});
			window.yaCounterGlobal.reachGoal('buy-button-clicked');
		});
    });

})(jQuery);
