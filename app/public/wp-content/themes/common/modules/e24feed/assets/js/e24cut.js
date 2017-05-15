jQuery(document).ready(function(){
    var maine24Container = jQuery('.e24-widget');
    jQuery('.article-excerpt', maine24Container).each(function() {
        jQuery(this).dotdotdot({
            ellipsis : ' ... '
        });
    });
});
