<?php  if ( ! defined('BASE_FILEPATH')) exit('No direct script access allowed');

$body_class = preg_replace("/[^\w]/","-", str_replace ( '.php' , '' , $_SERVER['PHP_SELF']) ); 
?><!DOCTYPE html>
<html>
<?= $this->head->render(); ?>
<body id="body<?=$body_class ?>">
<div id="blank"></div>
<div id="header"><?= $this->header->render(); ?></div>
<div id="content"><?= $this->content->render() ?></div>
<div id="footer"><?= $this->footer->render(); ?></div>
</body>
</html>