<?php
$then = microtime();
include 'system/__autoload.php';
define('BASEPATH', __DIR__);
Carbon::router();

$now = microtime();
echo sprintf("<span class='diagnostics'>Elapsed:  %f ms</span>", $now-$then);
