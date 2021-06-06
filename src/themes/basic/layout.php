<?php

if (! defined('BASE_DIR')) {
    exit('No direct script access allowed');
}

use function Cuttlefish\theme_path;

require('functions.php');

$body_class = preg_replace("/[^\w]/", "-", str_replace('.php', '', $_SERVER['PHP_SELF']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= Configuration::SITE_TITLE ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <link type="text/css" rel="stylesheet" href="/<?= theme_path('styles.css') ?>">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?= href('/feeds/posts') ?>">
</head>
<body id="body<?= $body_class ?>">

<header id="header">
    <h1 class="float-left"><a href="<?= href('/') ?>"><?= Configuration::SITE_TITLE ?></a></h1>
    <p class="float-right"><?= Configuration::SITE_MOTTO ?></p>
</header>

<div id="blank"></div>

<main id="content" class="float-left two-thirds"><?= $this->content->render() ?></main>

<aside id="sidebar" class="float-right one-third">
    <h3>Sidebar</h3>
    <ul><?= pages() ?></ul>
</aside>

<footer id="footer">
    <h3 class="hide">Footer Menu</h3>
    <ul>
        <li><a href="<?php echo href('/') ?>">Home</a></li>
        <li><a href="<?php echo href('/archive') ?>">Archive</a></li>
        <?php echo pages() ?>
    </ul>
</footer>

</body>
</html>
