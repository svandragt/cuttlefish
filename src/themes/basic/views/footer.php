<?php if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
} ?>

<ul>
    <li><a href="<?php echo href('/') ?>">Home</a></li>
    <li><a href="<?php echo href('/archive') ?>">Archive</a></li>
    <?php echo pages() ?>
    <?php if (is_logged_in()): ?>
        <li><a href="<?php echo href('/admin') ?>">Admin</a></li>
    <?php endif; ?>
</ul>
