<?php



if (!defined('BASE_FILEPATH'))
{
	exit('No direct script access allowed');
}

class Configuration extends Mana\Defaults
{

	const SITE_TITLE = 'Your site';
	const SITE_MOTTO = 'Example theme of <a href="https://vandragt.com/tag/mana/">Mana</a>, the hackable web framework.';
	const CACHE_ENABLED = FALSE;

	// const INDEX_PAGE     = '/index.php';

    // support port forwarding where local HTTP_HOST is different from developer (eg vagrant)
    // const SERVER_HTTP_HOST = 'localhost';
}