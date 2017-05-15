(function ($) {
	var postAccessLevel = window['postAccessLevel'];
	var mainContainer = $('.sticky-footer');
	var isUserSubscribed = false;

    $(document).ready(function () {
    	drawProgressBar();

        $('.to-top', mainContainer).click(function(e) {
            e.preventDefault();
            $(window).scrollTop(0);
        });
	});

	$(document).on('spid.statusChanged', function(event, status, user) {
		if (status == 'subscribed') {
			// toggleMainStatus('premium');
		} else if (status == 'authorized') {
			$('.username', mainContainer).html(user.givenName);
			toggleUserdataStatus('authorized');
		} else if (status == 'agreement') {
			$('.username', mainContainer).html(user.givenName);
			toggleUserdataStatus('agreement');
		} else {
			toggleUserdataStatus('default');
		}

		isUserSubscribed = (status == 'subscribed');
	});

	$(document).on('paywall.enableCookiesMessage', function() {
		toggleMainStatus('cookies');
		$('.sticky-footer-content', mainContainer).removeClass('hidden');
	});
	
	$(document).on('paywall.remainArticles', function(event, remainingArticles) {
		if (isUserSubscribed) {
			return;
		}

		if (remainingArticles < 0) {
			$('.paywall-articles-remained-counter', mainContainer).addClass('hidden');
			$('.paywall-articles-remained-empty', mainContainer).removeClass('hidden');
		} else {
			$('.paywall-articles-remained', mainContainer).html(remainingArticles);
		}

		toggleMainStatus('remains');
	});

	$(window).on('scroll', function(e) {
		drawProgressBar();
	});

	function drawProgressBar() {
		var post = $('.post');
		var contentBottom = post.offset().top + post.height();
		var scrollTop = $(window).scrollTop();
		var percent = Math.min(100, 100 * scrollTop / contentBottom);

		$('.progress', mainContainer).width(percent.toFixed(2) + '%');
	}

	function toggleMainStatus(status) {
		var el = $('.footer-status', mainContainer);
		el.removeClass('footer-status-announce footer-status-remains footer-status-premium footer-status-cookies');
		el.addClass('footer-status-' + status);

		$('.sticky-footer-content', mainContainer)[status == 'remains' ? 'removeClass' : 'addClass']('hidden');
	}

	function toggleUserdataStatus(status) {
		var el = $('.userdata-status', mainContainer);
		el.removeClass('userdata-status-default userdata-status-authorized userdata-status-agreement');
		el.addClass('userdata-status-' + status);
	}

})(jQuery);