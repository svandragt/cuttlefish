<?php
define('BASE_FILEPATH', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . '/');
define('BASE_PATH', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
include 'system/autoload.php';
$carbon = new Request();
