<?php  if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

$body_class = preg_replace( "/[^\w]/", "-", str_replace( '.php', '', $_SERVER['PHP_SELF'] ) );
?><!DOCTYPE html>
<html>
<head>
    <title><?= Configuration::SITE_TITLE ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <link type="text/css" rel="stylesheet" href="<?= theme_dir() ?>styles/styles.css">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?= href( 'feeds/posts' ) ?>">
</head>
<body id="body<?= $body_class ?>">

<div id="header">
    <h1 class="float-left"><a href="<?= href( '/' ) ?>"><?= Configuration::SITE_TITLE ?></a></h1>
    <p class="float-right"><?= Configuration::SITE_MOTTO ?></p>
</div>

<div id="blank"></div>

<div id="content" class="float-left two-thirds"><?= $this->content->render() ?></div>

<div id="sidebar" class="float-right one-third">
    <h3>Sidebar</h3>
    <ul><?= pages() ?></ul>
</div>

<div id="footer">
    <ul>
        <li><a href="<?php echo href( '/' ) ?>">Home</a></li>
        <li><a href="<?php echo href( '/archive' ) ?>">Archive</a></li>
		<?php echo pages() ?>
		<?php if ( is_logged_in() ): ?>
            <li><a href="<?php echo href( '/admin' ) ?>">Admin</a></li>
		<?php endif; ?>
    </ul>
</div>

</body>
</html>