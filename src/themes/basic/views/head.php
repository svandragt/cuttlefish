<?php if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
} ?>
<head>
    <title><?= Configuration::SITE_TITLE ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <link type="text/css" rel="stylesheet" href="<?= theme_dir() ?>styles/styles.css">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?= href( 'feeds/posts' ) ?>">
</head>
