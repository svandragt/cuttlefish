<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul>
	<li><a href="<?= Theming::content_url('/') ?>">Home</a></li>
	<li><a href="<?= Theming::content_url('/archive') ?>">Archive</a></li>
	<?= Theming::pages() ?>
	<? if (Security::is_loggedin()) { ?>
	<li><a href="<?= Theming::content_url('/admin') ?>">Admin</a></li>
	<? }?>

</ul>
