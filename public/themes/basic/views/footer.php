<?php  if ( ! defined('THEME_DIR')) exit('No direct script access allowed'); ?>

<ul>
	<li><a href="<?= Theming::root() ?>">Home</a></li>
	<?= Theming::pages() ?>
	<li><a href="<?= Theming::root() ?>/admin/cache_clear">Clear Cache</a></li>
</ul>
