<?php

use VanDragt\Carbon\Sys;

if (!defined('BASE_FILEPATH'))
{
	exit('No direct script access allowed');
}

class Configuration extends Sys\Defaults
{

	const SITE_TITLE = 'Your site';
	const SITE_MOTTO = 'Example theme of <a href="http://carbon.vandragt.com/">Carbon</a>, the hackable performant (semi) static blogging system.';
	const CACHE_ENABLED = FALSE;

	// const INDEX_PAGE     = '/index.php';
	// const ADMIN_PASSWORD = "carbon";
}