<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul>
	<li><a href="<?= Theming::content_url('/') ?>">Home</a></li>
	<?= Theming::pages() ?>
	<li><a href="<?= Theming::content_url('/archive') ?>">Archive</a></li>
	<li><a href="<?= Theming::content_url('/admin/cache') ?>">Clear Cache</a></li>
</ul>
