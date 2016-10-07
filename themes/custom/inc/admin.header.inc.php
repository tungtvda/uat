<div id="header">
  <!--<div class="logo"><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/">Casino 9 Club</a></div>-->
  <?php if ($_SESSION['admin']['ID']!='') { ?>
  <div class="admin_links"><b>Administrative Panel</b> &nbsp;|&nbsp; Welcome, you are logged in as <strong><?php echo $_SESSION['admin']['Name']; ?></strong>. (<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/logout">Logout</a>)&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $data['config']['SITE_URL']; ?>" target="_blank">Back to Site</a></div>
  <?php } ?>
  <?php /* ?>
  <div class="clear"></div>
  <div class="admin_title">Administrative Panel</div>
  <?php */ ?>
</div>
