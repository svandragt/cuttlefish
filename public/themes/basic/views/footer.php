<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul>
	<li><a href="<?= Url::index('/') ?>">Home</a></li>
	<li><a href="<?= Url::index('/archive') ?>">Archive</a></li>
	<?= Url::pages() ?>
	<? if (Security::is_loggedin()): ?>
	<li><a href="<?= Url::index('/admin') ?>">Admin</a></li>
	<? endif; ?>

</ul>
