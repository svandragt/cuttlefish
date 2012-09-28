<?php
$then = microtime();
include 'system/__autoload.php';
define('BASE_DIR', __DIR__);
Carbon::router();

$now = microtime();
echo sprintf("<span class='diagnostics'>Elapsed:  %f ms</span>", $now-$then);
