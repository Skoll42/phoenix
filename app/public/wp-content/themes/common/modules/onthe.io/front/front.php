<?php

add_action('wp_head', function() {
    echo <<<GA_CODE
        <script async src="https://cdn.onthe.io/io.js/OS7DgooRAg4T"></script>
GA_CODE;
}, 5);
