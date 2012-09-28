<?php  if ( ! defined('THEME_DIR')) exit('No direct script access allowed'); 
$body_class = preg_replace("/[^\w]/","-", str_replace ( '.php' , '' , $_SERVER['PHP_SELF']) ); 
?><!DOCTYPE html>
<html>
<?= $this->head->render(); ?>
<body id="body<?=$body_class ?>">
<div id="header"><?= $this->header->render(); ?></div>
<div id="content" class="float-left two-thirds"><?= $this->articles->render() ?></div>
<div id="sidebar" class="float-right one-third"><?= $this->sidebar->render(); ?></div>
<div id="footer"><?= $this->footer->render(); ?></div>
</body>
</html>