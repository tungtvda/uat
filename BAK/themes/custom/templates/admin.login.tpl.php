<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include($data['config']['THEME_DIR_INC'].'inc/admin.meta_common.inc.php'); ?>
<title>
<?php include($data['config']['THEME_DIR_INC'].'inc/admin.title.inc.php'); ?>
</title>
<?php include($data['config']['THEME_DIR_INC'].'inc/admin.scripts_common.inc.php'); ?>
<?php if($_GET['section']!='main' && $_GET['controller']!='staticpage' && $_GET['action']!='javascriptdisabled'){ ?>
<noscript>
  <meta http-equiv="refresh" content="0;url=<?php echo $data['config']['SITE_DIR']; ?>/main/staticpage/javascriptdisabled">
</noscript>
<?php } ?>       
</head>
<body id="admin">
<div id="wrapper">
  <?php include($data['config']['THEME_DIR_INC'].'inc/admin.header.inc.php'); ?>
  <div id="main">
    <div class="admin_login">
      <?php require($this->view_location); ?>
    </div>
  </div>
  <?php include($data['config']['THEME_DIR_INC'].'inc/admin.footer.inc.php'); ?>
</div>
</body>
</html>
