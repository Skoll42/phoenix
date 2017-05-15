(function ($) {

    var mainContainer = $('.newsletter-block');
    var newsletterEmail;

    var listIds;
    try {
        listIds = jQuery.parseJSON(window['mailchimpLists']);
    } catch (e) {
        listIds = {};
    }

    $('.newsletter-email', mainContainer)
        .on("invalid", function(event) {
            event.target.setCustomValidity('');
            if (!event.target.validity.valid) {
                event.target.setCustomValidity('Vennligst skriv inn en gyldig e postadresse');
            }
        })
        .on("input", function(event) {
            event.target.setCustomValidity('');
        });

    $(document).on('spid.extendedUser', function (event, user) {
        var emailEl = $('.newsletter-email', mainContainer);
        if (!emailEl.val()) {
            newsletterEmail = user.email;
            emailEl.val(newsletterEmail);
        }

        bindEmailSubscriptions();
    });

    $('.newsletter-form', mainContainer).submit(function(e) {
        e.preventDefault();
        var container = $(this).parents('.newsletter-block');
        var emailEl = $('.newsletter-email', container);
        // TODO: we will need this variable later
        // var agreeEl = $('.newsletter-agree', container);
        var messageEl = $('.subscribe-message', container);
        var lists = $('.subscribe-list :checkbox:enabled:checked', container).map(function() {return this.value;}).get();
        var email = jQuery.trim(emailEl.val());

        messageEl.html('<span class="loader"></span>');

        /* TODO: we will need this block later
        if (!agreeEl.is(':checked')) {
            var message = '<div class="error">Vennligst bekreft at du har lest og aksepterer vilkårene for bruk og retningslinjer for personvern.</div>';
            messageEl.html(message);
            return;
        }
        */

        var params = {
            action: 'bt_newsletter_subscribe',
            email: email,
            lists: lists
        };
        
        $.post(ajaxurl, params, function (data) {
            var message = '';
            if (data.success) {
                message = '<div clsass="successful">Epost-adressen "' + email + '" er lagt til i ' + lists.length + ' nyhetsbrevlister</div>';
                emailEl.val('');
                for (var i=0, len=lists.length; i<len; i++) {
                    var checkbox = $('.subscribe-list input[value="' + lists[i] + '"]');
                    checkbox.attr('checked', true);
                    checkbox.attr('disabled', true);
                }
            } else {
                var errorText = '';
                switch (data.data) {
                    case 'error_empty_list_parameter':
                        errorText = 'Ingen elementer valgt';
                        break;
                    case 'error_something_went_wrong':
                        errorText = 'Vennligst skriv inn en gyldig e postadresse';
                        break;
                    default:
                        errorText = 'Error';
                }
                message = '<div class="error">' + errorText + '</div>';
            }
            messageEl.html(message)
        });

    });

    function bindEmailSubscriptions() {
        if (newsletterEmail) {
            var params = {
                action: 'mailchimp_subscribtions',
                email: newsletterEmail
            };
            $.get(ajaxurl, params, function (response) {
                if (response.success) {
                    showSubscribedNewsletters(response.data.subscriptions.members);
                }
            });
        }
    }

    function showSubscribedNewsletters(subscriptions) {
        for (var key in subscriptions) {
            if (!subscriptions.hasOwnProperty(key)) continue;

            var subscription = subscriptions[key];
            var listId = subscription['list_id'];
            var isPredefinedNewsletter = $.inArray(listId, Object.keys(listIds));
            var checkbox = $('.subscribe-list input[value="' + listId + '"]');

            if (subscription.status == 'subscribed' && isPredefinedNewsletter) {
                checkbox.attr('checked', true);
                checkbox.attr('disabled', true);
            }
        }
    }

})(jQuery);
