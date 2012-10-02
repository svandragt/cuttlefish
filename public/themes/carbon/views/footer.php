<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul>
	<li><a href="<?= Theming::content_url('/') ?>">Home</a></li>
	<li><a href="<?= Theming::content_url('/archive') ?>">Archive</a></li>
	<?= Theming::pages() ?>
	<? if (Security::is_admin()) { ?>
	<li><a href="<?= Theming::content_url('/admin/cache') ?>">Clear Cache</a></li>
	<li><a href="<?= Theming::content_url('/admin/logout') ?>">Logout</a></li>
	<? }  else { ?>
	<li><a href="<?= Theming::content_url('/admin') ?>">Login</a></li>
	<? }?>

</ul>
