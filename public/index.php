<?php
$then = microtime();
define('BASEPATH', __DIR__);
include 'system/__autoload.php';
Carbon::router();

$now = microtime();
echo sprintf("<span class='diagnostics'>Elapsed:  %f ms</span>", $now-$then);
