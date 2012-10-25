<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul>
	<li><a href="<?= href('/') ?>">Home</a></li>
	<li><a href="<?= href('/archive') ?>">Archive</a></li>
	<?= pages() ?>
	<? if (Security::is_loggedin()): ?>
	<li><a href="<?= href('/admin') ?>">Admin</a></li>
	<? endif; ?>

</ul>
