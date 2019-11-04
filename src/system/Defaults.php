<?php

namespace Mana;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Defaults {

	const SITE_MOTTO = 'Something clever for the internets';
	const SITE_TITLE = 'Your site';
	const THEME = 'basic';

	const CACHE_ENABLED = false;
	const DEBUG_ENABLED = false;
	const CONTENT_EXT = 'md';
	const INDEX_PAGE = '';
	const POSTS_HOMEPAGE = 10;

	const HOME_PAGE = '/home';
	const APPLICATION_FOLDER = 'application';
	const CACHE_FOLDER = '../_cache';
	const CONTENT_FOLDER = 'content';
	const LOGS_FOLDER = '../_logs';
	const THEMES_FOLDER = 'themes';
}