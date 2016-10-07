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
  <div id="main">
  	<?php if(($this->section=='main' && $this->controller=='forumtopic' && $this->action=='index') || $this->controller=='forumpost'){ echo $data['breadcrumbmulti']; }else{ ?>
  	<?php echo $data['breadcrumb'];} ?>
    <div class="main_left">
      <div id="common_content_wrapper">
        <h1><?php echo $data['page']['title']; ?></h1>
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
