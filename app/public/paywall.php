<?php

use voku\db\DB;

$next_monday_diff = date('U', strtotime("next Monday")) - time();

define('APP_PATH', dirname(__FILE__));
define('BT_FRAMEWORK_ROOT', APP_PATH . '/wp-content/mu-plugins/bt-framework');
require_once(APP_PATH . '/../vendor/autoload.php');
require_once(BT_FRAMEWORK_ROOT . '/wp-config/pre.php');
require_once(BT_FRAMEWORK_ROOT . '/wp-config/default.php');
require_once(APP_PATH . '/wp-content/SuperSession2DB.php');

session_name('PWQSNS');
session_set_cookie_params($next_monday_diff, '/', false, false);
$db = DB::getInstance(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, '', '', '', '', '', '', true);
$session = new SuperSession2DB('', $next_monday_diff);
$next_monday_diff = date('U', strtotime("next Monday")) - time();
$remaining = isset($_SESSION['paywall_articles_left']) ? $_SESSION['paywall_articles_left'] : 3;

$pwq = isset($_SERVER['HTTP_X_PWQ']) ? $_SERVER['HTTP_X_PWQ'] : isset($_GET['pwq']) ? $_GET['pwq'] : false;
if ($pwq != 'TA') {
    $remaining = max(-1, --$remaining);
}

$_SESSION['paywall_articles_left'] = $remaining;
header('Content-Type: application/json');
echo json_encode(['remainingArticles' => $_SESSION['paywall_articles_left']]);