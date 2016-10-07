<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include($data['config']['THEME_DIR_INC'].'inc/meta_common.inc.php'); ?>
<title>
<?php include($data['config']['THEME_DIR_INC'].'inc/title.inc.php'); ?>
</title>
<?php include($data['config']['THEME_DIR_INC'].'inc/scripts_common.inc.php'); ?>
</head>
<body>
<div id="wrapper">
  <?php include($data['config']['THEME_DIR_INC'].'inc/header.inc.php'); ?>
  <?php include($data['config']['THEME_DIR_INC'].'inc/nav_main.inc.php'); ?>
  <div id="main">
    <div class="main_left">
      <?php echo $data['breadcrumb']; ?>
      <div id="common_content_wrapper">
        <?php require($this->view_location); ?>
      </div>
    </div>
    <div class="main_right">
      <?php (($data['block']['side_nav']!="") ? include($data['block']['side_nav']) : ""); ?>
      <?php (($data['block']['common']!="false") ? include($data['config']['THEME_DIR_INC'].'inc/side_nav.common.inc.php') : ""); ?>
    </div>
    <div class="clear"></div>
  </div>
  <?php include($data['config']['THEME_DIR_INC'].'inc/footer.inc.php'); ?>
</div>
</body>
</html>
