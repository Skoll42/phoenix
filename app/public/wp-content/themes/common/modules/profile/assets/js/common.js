(function ($) {

    var mainContainer = $('.profile-content');
    var spidClientId = window['spidClientId'];
    var originHost = window.location.origin ? window.location.origin : window.location.protocol + '//' + window.location.host;
    var spidUser;

    var listIds;
    try {
        listIds = jQuery.parseJSON(window['mailchimpLists']);
    } catch (e) {
        listIds = {};
    }

    var newsletterEmail;
    
    $(document).ready(function() {
        $('.profile-account-link', mainContainer).attr('href', SPiD_Uri.account(window.location, spidClientId));
        $('.profile-password-link', mainContainer).attr('href', SPiD_Uri.build('account/changepassword', {client_id: spidClientId}));
        $('.profile-history-link', mainContainer).attr('href', SPiD_Uri.purchaseHistory(window.location, spidClientId));
        $('.abonement-section .show-block .show-button a').attr('href', SPiD_Uri.products(window.location, spidClientId));

        $('.profile-apply-voucher', mainContainer).click(function (e) {
            e.preventDefault();

            if (!spidUser) {
                return;
            }

            $('.voucher-value').addClass('loading');
            $('.voucher-message').empty();

            var voucher_code = $('.profile-voucher-code', mainContainer).val();
            voucher_code = $.trim(voucher_code);
            $.post(ajaxurl, {
                action: 'spid_apply_voucher',
                user_id: spidUser.id,
                code: voucher_code
            }, function(data, textStatus, jqXHR) {
                $('.voucher-value').removeClass('loading');
                if (data && data.success) {
                    $('.voucher-message').removeClass('error').html('Voucher is applied.');

                    window.location.href = originHost + '/spid/paid?redirect_to=' + encodeURIComponent(window.location.toString()) + '&voucher_code=' + encodeURIComponent(voucher_code);
                } else {
                    var error_message;
                    switch (data.data) {
                        case 'error_empty_code':
                            error_message = 'Ingen voucherkode. Vennligst legg inn din kode.';
                            break;
                        case 'error_empty_user':
                            error_message = 'Din bruker er ikke autentisert. Prøv å logge ut og inn.';
                            break;
                        case 'error_user_without_email':
                            error_message = 'Feil: Denne brukeren har ikke en registrert epostadresse.';
                            break;
                        case 'error_already_has_product':
                            error_message = 'Du har allerede et aktivt abonnement.';
                            break;
                        case 'error_generate_limit_exceeded':
                        case 'error_generate_noname':
                        case 'error_handout_no_available':
                        case 'error_handout_noname':
                            error_message = 'Denne kupongkoden er ikke lenger gyldig eller er benyttet maksimalt antall ganger.';
                            break;
                        default:
                            error_message = 'Ugyldig voucherkode. Prøv igjen.';
                            break;
                    }
                    $('.voucher-message').addClass('error').html(error_message)
                }
            });
        });
    });

    $(document).on('spid.statusChanged', function (event, status, user) {
        if (!user) {
            return;
        }
        spidUser = user;

        $('.profile-username', mainContainer).html(user.givenName);
        $('.profile-email', mainContainer).html(user.email);
        $('.profile-photo', mainContainer).html('<img src="' + user.photo + '" alt="' + user.givenName + '" />');
    });

    $(document).on('spid.extendedUser', function (event, user) {
        newsletterEmail = user.email;
        $('.profile-email', mainContainer).html(newsletterEmail);
        getEmailSubscriptions();
        bindSubscriptionToggle();
    });

    function getEmailSubscriptions() {
        if (newsletterEmail) {
            var params = {
                action: 'mailchimp_subscribtions',
                email: newsletterEmail
            };
            $.get(ajaxurl, params, function (data, textStatus, jqXHR) {
                if (data.success) {
                    showSubscribedNewsletters(data.data.subscriptions.members);
                }
            });
        }
    }

    function showSubscribedNewsletters(subscriptions) {
        for (var subscription in subscriptions) {
            subscription = subscriptions[subscription];
            var isPredefinedNewsletter = $.inArray(subscription.list_id, Object.keys(listIds));
            var checkbox = $('.nyhetsbrev-section input[value="' + subscription.list_id + '"]');
            if (subscription.status == 'subscribed' && isPredefinedNewsletter) {
                checkbox.removeAttr('disabled'); // Fix Firefox cache for attributes.
                checkbox.attr('checked', true);
            }
        }
    }
    function bindSubscriptionToggle() {
        $('.nyhetsbrev-section input').click(function(e) {
            e.preventDefault();
            var checkbox = $(this);
            var isChecked = checkbox.is(':checked');
            var list = checkbox.val();
            isChecked ? subscribeToList(list, checkbox) : unsubscribeFromList(list, checkbox);
        });

        $('a.email-resend').click(function(e) {
            e.preventDefault();
            var link = $(this);
            subscribeToList(link.attr('data-list'), link.parent().find('input'));
        });
    }

    function subscribeToList(list, checkbox) {
        showLoader(checkbox.parent());
        if (list && spidUser) {
            var params = {
                action: 'mailchimp_subscribe',
                email: newsletterEmail,
                list: list
            };
            $.post(ajaxurl, params, function (data, textStatus, jqXHR) {
                if (data.success && data.data.subscribed) {
                    hideLoader(checkbox.parent());
                    checkbox.removeAttr('disabled'); // Fix Firefox cache for attributes.
                    checkbox.prop('checked', true);
                }
            });
        }
    }

    function unsubscribeFromList(list, checkbox) {
        var parent = checkbox.parent();
        showLoader(parent);
        parent.find('.cr').addClass('hidden');
        parent.find('.subscription-name').addClass('disabled');
        checkbox.attr('disabled', 'true');
        if (list && spidUser) {
            var params = {
                action: 'mailchimp_unsubscribe',
                email: newsletterEmail,
                list: list
            };
            $.post(ajaxurl, params, function (data, textStatus, jqXHR) {
                if (data.success && data.data.unsubscribed) {
                    hideLoader(checkbox.parent());
                    parent.find('.cr').removeClass('hidden');
                    parent.find('.subscription-name').removeClass('disabled');
                    checkbox.removeAttr('disabled');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
            });
        }
    }

    function showLoader(checkbox) {
        checkbox.find('.loader').removeClass('hidden');
    }

    function hideLoader(checkbox) {
        checkbox.find('.loader').addClass('hidden');
    }

})(jQuery);
