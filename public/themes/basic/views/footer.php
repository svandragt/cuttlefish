<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul>
	<li><a href="<?= Theming::root() ?>">Home</a></li>
	<?= Theming::pages() ?>
	<li><a href="<?= Theming::root() ?>/admin/cache">Clear Cache</a></li>
</ul>
