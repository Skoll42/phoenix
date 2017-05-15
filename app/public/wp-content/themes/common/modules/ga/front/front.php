<?php

add_action('wp_head',function() {
        $is_premium_message_displays = is_single() && !spid_is_content_accessable() && !spid_cookies_disabled();
        $premium_message_location = "location.pathname + 'abonnementsmelding/'";

        $pageview_code = $is_premium_message_displays
                ? "ga('send', 'pageview', {$premium_message_location});"
                : "ga('send', 'pageview');";

        $global_pageview_code = $is_premium_message_displays
                ? "ga('global.send', 'pageview', {$premium_message_location});"
                : "ga('global.send', 'pageview');";

        echo <<<GA_CODE
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-71819005-3', 'auto');
    ga('set', 'anonymizeIp', true);
    {$pageview_code}
    
    ga('create', 'UA-71819005-1', 'auto', 'global');
    ga('global.set', 'anonymizeIp', true);
    ga('global.require', 'linker');
    ga('global.linker:autoLink', ['sysla.no','syslagronn.no','maritime.no','offshore.no']);
    {$global_pageview_code}
</script>

GA_CODE;
}, 5);

add_action('wp_footer',function() {
        echo <<<TRACK_INCOGNITO_GA_CODE
<script>
    var fs = window.RequestFileSystem || window.webkitRequestFileSystem;
    if (fs) {
        fs(window.TEMPORARY, 100, function(fs) {
        }, function(err) {
            ga('send','event', 'Incognito Mode', 'paveview', location.pathname);
        });
    }
</script>

TRACK_INCOGNITO_GA_CODE;
}, 5);
