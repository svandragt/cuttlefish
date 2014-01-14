<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Configuration extends Defaults {
		const SITE_TITLE    = 'Your site';
		const SITE_MOTTO    = 'Example theme of <a href="http://carbon.vandragt.com/">Carbon</a>, the hackable performant (semi) static blogging system.';
		const CACHE_ENABLED = false;

		// const INDEX_PAGE     = '/index.php'; // compatibility for thos without mod_rewrite		
		// const LOCAL_HTTP_HOST = '127.0.0.1:80'; // compatibility for port forwarding situations

		const ADMIN_PASSWORD = "carbon";

}