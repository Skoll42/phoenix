<?php

add_action('wp_head',function() {
    $tracking_code = '35631145';
    echo <<<CODE
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter{$tracking_code} = new Ya.Metrika({
                    id:{$tracking_code},
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/{$tracking_code}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
CODE;

    echo <<<"CODE"
<script>
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            w.yaCounterGlobal = w.yaCounter{$tracking_code};
        });
    })(document, window, "yandex_metrika_callbacks");
</script>
CODE;
});
