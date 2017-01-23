<?php if (!defined('BASE_FILEPATH')) {
    exit('No direct script access allowed');
} ?>

<ul>
    <li><a href="<?= href('/') ?>">Home</a></li>
    <li><a href="<?= href('/archive') ?>">Archive</a></li>
    <?= pages() ?>
    <? if (is_loggedin()): ?>
        <li><a href="<?= href('/admin') ?>">Admin</a></li>
    <? endif; ?>
    <!-- <li class="credits" xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/" about="http://www.flickr.com/photos/godsofchaos/8100153534/"><span property="dct:title">Carbon Cubes</span> (<a rel="cc:attributionURL" property="cc:attributionName" href="http://www.flickr.com/photos/godsofchaos/">Chaos Inc.</a>) / <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.0/">CC BY-NC-ND 2.0</a></li> -->

</ul>
