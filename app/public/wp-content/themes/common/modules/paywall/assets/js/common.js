(function ($) {
	var postAccessLevel = window['postAccessLevel'];
	var serviceUrl = paywallSettings && paywallSettings.service_url;

	$(document).on('spid.statusChanged', function(event, status, user) {
		$.removeCookie('pwq', {path: '/'});

		if (/redirected_no_cookies=1/i.test(window.location.href)) {
			$(document).trigger('paywall.enableCookiesMessage');
			return;
		} else {
			if (!document.cookie) {
				window.location.href = window.location.href + '?redirected_no_cookies=1';
			}
		}

		if (postAccessLevel == 'metered' && status != 'subscribed') {
			checkLimit();
		}
	});

	function checkLimit() {
		var url = serviceUrl + '?pwq=' + $.cookie('pwq') + '&_time=' + (new Date()).getTime();
		$.get(url, function(response) {
			var remaining = -1;
			var key = $.cookie('pwq');
			if(response && response.hasOwnProperty('remainingArticles')) {
				remaining = response.remainingArticles;
			}
			setRemaining(key, remaining);
		});
	}

	function setRemaining(key, remaining) {
		if (key == 'TA') {
			$(document).trigger('paywall.remainArticles', Math.max(0, remaining));
			return;
		}

		$(document).trigger('paywall.remainArticles', remaining);

		if (remaining >= 0) {
			$.cookie('pwq', 'TA', {expires: getCookieExpireDate(), path: window.location.pathname});
		} else {
			if ($.cookie('pwqc') != 'MA') {
				$.cookie('pwqc', 'MA', {expires: getCookieExpireDate(), path: '/'});
				window.location.reload(true);
			}
		}
	}

	function getCookieExpireDate() {
		return getNextMonday();
	}

	function getNextMonday() {
		var d = new Date();
		var diff = d.setDate(d.getDate() + (d.getDay() == 0 ? 1 : 8 - d.getDay()));
		var diff_zero = new Date(diff).setHours(0,0,0,0);
		return new Date(diff_zero);
	}

})(jQuery);