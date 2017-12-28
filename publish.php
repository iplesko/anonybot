<?php
require_once 'init.php';
$guard->authorize();
$facebookClient->publish();
