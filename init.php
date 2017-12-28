<?php
session_start();

require_once 'config.php';

require_once 'vendor/autoload.php';
$fb = new \Facebook\Facebook([
    'app_id' => $APP_ID,
    'app_secret' => $APP_SECRET,
    'default_graph_version' => 'v2.11'
]);

require_once 'classes/Guard.php';
$guard = new Guard($fb, $GROUP_ID, $BOT_TOKEN);

require_once 'classes/FacebookClient.php';
$facebookClient = new FacebookClient($fb, $FULL_ROOT, $APP_ID, $GROUP_ID, $BOT_TOKEN);

require_once 'classes/Renderer.php';
$renderer = new Renderer();
