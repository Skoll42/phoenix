(function ($) {

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
        if (user && user.userId) {
            window.intercomSettings = {
                app_id: "ctfx6kzw",
                name: user.name && user.name.givenName,
                email: user.email,
                user_id: user.userId
            };
        } else {
            window.intercomSettings = {
                app_id: "ctfx6kzw"
            };
        }

        var w = window;
        var d = document;
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.innerHTML = "(function(){var w=window;var ic=w.Intercom;if(typeof ic==='function'){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/ctfx6kzw';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    }

})(jQuery);
