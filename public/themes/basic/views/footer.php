<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul>
	<li><a href="<?= Url::content_url('/') ?>">Home</a></li>
	<li><a href="<?= Url::content_url('/archive') ?>">Archive</a></li>
	<?= Url::pages() ?>
	<? if (Security::is_loggedin()) { ?>
	<li><a href="<?= Url::content_url('/admin') ?>">Admin</a></li>
	<? }?>

</ul>
