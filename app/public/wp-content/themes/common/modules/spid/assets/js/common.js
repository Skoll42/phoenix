(function ($) {

    var mainContainer = $('.user-section');
    var originHost = window.location.origin ? window.location.origin : window.location.protocol + '//' + window.location.host;

    var spidClientId = window['spidClientId'];
    var spidServer = window['spidServer'];
    var spidProductsIds = window['spidProductsIds'];

    var spidUser;
    var months = ['januar', 'februar', 'mars', 'april', 'mai', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'desember'];

    $(document).ready(function() {
        $('.spid-do-login').click(function(e) {
            e.preventDefault();
            $(document).trigger('spid.doLogin');
        });
        $('.spid-accept-agreement').click(function(e) {
            e.preventDefault();
            $(document).trigger('spid.doAccept');
        });
        $('.spid-buy-product-by-id').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            $(document).trigger('spid.doBuy', [productId]);
        });
        $('.spid-do-logout').click(function(e) {
            e.preventDefault();
            $(document).trigger('spid.doLogout');
        });
    });

    $(document).on('spid.doLogin', function() {
        var redirectUrl = originHost + '/spid/logged_in?redirect_to=' + window.location.toString();
        window.location.href = SPiD_Uri.auth(redirectUrl, spidClientId);
    });
    $(document).on('spid.doAccept', function() {
        SPiD.acceptAgreement(function (err, response) {
            // console.log('SPiD.acceptAgreement', arguments);
            processSession(err, response);
        });
    });
    $(document).on('spid.doBuy', function(e, productId) {
        var redirectUrl = originHost + '/spid/paid?redirect_to=' + encodeURIComponent(window.location.toString());
        window.location.href = SPiD_Uri.purchaseProduct(productId, redirectUrl);
    });
    $(document).on('spid.doLogout', function() {
        var user = spidUser;
        SPiD.logout(function (data) {
            SPiD.sessionCache.clear();
            $.removeCookie('doNotShowFloatingNewsletter', {path: '/'});

            processSession();
            $(document).trigger('intercom.trackLogout');
            $(document).trigger('mixpanel.userLoggedOut', user);

            setTimeout(function() {
                window.location.reload();
            }, 1000);
        });
    });
    $(document).on('spid.statusChanged', function(e, status, response) {
        renderUserBlock(status, response);
    });

    $(document).on('spid.showSubscriptions', function (event, subscriptions) {
        showSubscriptions(subscriptions);
    });

    //Initiate SDK
    SPiD.init({
        // logging: true,
        client_id: spidClientId,
        server: spidServer
    });

    SPiD_Uri.init({
        client_id: spidClientId,
        server: spidServer
    });

    SPiD.hasSession(function(err, response) {
        processSession(err, response);
    });

    function processSession(err, response) {
        // console.log('hasSession', arguments);

        spidUser = response;

        if (!response || !response.result) {
            changeStatus('non-authorized', response);
            return;
        }

        if (response.userId) {
            $.get('/spid/userinfo/' + response.userId + '/', function (data, textStatus, jqXHR) {
                if (data.success) {
                    $(document).trigger('spid.extendedUser', data.data.user);
                    $(document).trigger('spid.showSubscriptions', data.data.subscriptions);
                }
            });
        }

        if (response.defaultAgreementAccepted == false && !response.clientAgreementAccepted) {
            changeStatus('agreement', response);
            return;
        }

        if (spidProductsIds.length == 0) {
            changeStatus('authorized', response);
            return;
        }

        var authorizedResponse = response;

        var missedProducts = [];
        for (var i = 0; i < spidProductsIds.length; i++ ) {
            var productId = spidProductsIds[i];
            SPiD.hasSubscription(productId, (function(productId) {
                return function(err, response) {
                    // console.log('hasSubscription ' + productId, arguments);

                    if (!response.result) {
                        missedProducts.push(productId);
                        if (missedProducts.length == spidProductsIds.length) {
                            changeStatus('authorized', authorizedResponse);
                        }
                        return;
                    }

                    changeStatus('subscribed', response);
                }
            })(productId));
        }
    }

    function changeStatus(status, response) {
        if (status == 'subscribed') {
            $.cookie('pwa', 's', {path: '/', expires: 7});
        } else if (status == 'authorized' || status == 'agreement') {
            $.cookie('pwa', 'a', {path: '/', expires: 7});
        } else {
            $.removeCookie('pwa', {path: '/'});
        }

        $(document).trigger('spid.statusChanged', [status, response]);
    }

    function renderUserBlock(status, response) {
        if (status == 'agreement') {
            toggleMainStatus('agreement');
        } else if (status == 'authorized') {
            toggleMainStatus('buy');
        } else if (status == 'subscribed') {
            toggleMainStatus('ok');
        } else {
            toggleMainStatus('default');
        }
        if (response && response.givenName) {
            $('.user-name', mainContainer).html(response.givenName);
        }
    }

    function toggleMainStatus(status) {
        if(status == 'default') {
            $('.buy-subscription, .spid-do-login', mainContainer).removeClass('hidden');
        }
        mainContainer.removeClass('spid-user-status-default spid-user-status-agreement spid-user-status-buy spid-user-status-ok');
        mainContainer.addClass('spid-user-status-' + status);
    }

    function showSubscriptions(subscriptions) {
        if (typeof subscriptions !== 'undefined' && !$.isEmptyObject(subscriptions)) {
            var activeSubscribtion = getActiveSubscription(subscriptions);
            if (activeSubscribtion != -1) {
                $('.abonement-section .buy-block').addClass('hidden');
                $('.abonement-section .show-block').removeClass('hidden');
                $('.abonement-section .show-block-note').html(formatSubscription(activeSubscribtion));
            }
        }
    }

    function getActiveSubscription(subscriptions) {
        var returnValue = -1;
        for (var subscription in subscriptions) {
            var subscriptionObj = subscriptions[subscription];
            if (subscriptionObj.status != -1) {
                returnValue = subscriptionObj;
                break;
            }
        }
        if (returnValue == -1) {
            showSubscriptionNotification();
        }
        return returnValue;
    }

    function showSubscriptionNotification() {
        $('.user-profile .expire-message').removeClass('hidden');
        $('.user-notifier', mainContainer).removeClass('hidden');
    }

    function formatSubscription(subscriptionObj) {
        var dateSplit = subscriptionObj.expires.split(' ')[0].split('-');
        return subscriptionObj.product.name + ' - ' + (subscriptionObj.autoRenew ? 'fornyer ' : 'endene ') + dateSplit[2] + ', ' + months[parseInt(dateSplit[1], 10) - 1] + ' ' + dateSplit[0];
    }

})(jQuery);