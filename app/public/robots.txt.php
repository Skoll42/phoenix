<?php

$env = isset($argv[1]) ? $argv[1] : null;
if (!in_array($env, array('local', 'prod', 'stage'))) {
    $env = 'prod';
}
define('IS_ENV_LOCAL', $env == 'local');
define('IS_ENV_STAGE', $env == 'stage');
define('IS_ENV_PROD', $env == 'prod');

if (IS_ENV_PROD) {
    $domain = getenv('DOMAIN_NAME');
    $content = <<<"ROBOTS"
User-agent: *
Allow: /
Disallow: /wp/

Sitemap: http://{$domain}/sitemap/?type=news
Sitemap: http://{$domain}/sitemap/?type=index
Sitemap: http://{$domain}/sitemap/?type=jobb
ROBOTS;
} else {
    $content = <<<"ROBOTS"
User-agent: *
Disallow: /
ROBOTS;
}

file_put_contents(__DIR__ . '/robots.txt', $content);
