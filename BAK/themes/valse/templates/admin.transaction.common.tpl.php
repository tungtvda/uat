<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include($data['config']['THEME_DIR_INC'].'inc/admin.meta_common.inc.php'); ?>
<title>
<?php include($data['config']['THEME_DIR_INC'].'inc/admin.title.inc.php'); ?>
</title>
<?php include($data['config']['THEME_DIR_INC'].'inc/admin.scripts_common.inc.php'); ?>
</head>
<body id="admin">
<div id="wrapper">
  <?php include($data['config']['THEME_DIR_INC'].'inc/admin.header.inc.php'); ?>
  <?php include($data['config']['THEME_DIR_INC'].'inc/admin.nav_main.inc.php'); ?>
  <div id="main">
    <!--<div class="admin_left">
        <?php (($data['block']['side_nav']!="") ? include($data['block']['side_nav']) : ""); ?>
        <?php (($data['block']['common']!="false") ? Core::getHook('left-column') : ""); ?>
        </div>-->
    <div class="admin_right">
      <?php echo $data['breadcrumb']; ?>
      <div id="admin_content_wrapper">
          <h1><?php echo $data['page']['title']; ?></h1>
          <?php require($this->view_location); ?>
          </div>
    </div>
    <div class="clear"></div>
  </div>
  <?php include($data['config']['THEME_DIR_INC'].'inc/admin.footer.inc.php'); ?>
</div>
</body>
</html>
