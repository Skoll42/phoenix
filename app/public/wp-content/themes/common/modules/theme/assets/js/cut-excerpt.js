jQuery(document).ready(function(){
    jQuery('.article .excerpt').each(function() {
        jQuery(this).dotdotdot({
            ellipsis : ' ... '
        });
    });
});