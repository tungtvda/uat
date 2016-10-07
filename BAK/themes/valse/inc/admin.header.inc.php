<div id="header">
  <div class="logo"><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/"><span style="text-transform: lowercase">asean</span>F&B Hotspot</a></div>
  <?php if ($_SESSION['admin']['ID']!='') { ?>
  <div class="admin_links">Welcome, you are logged in as <strong><?php echo $_SESSION['admin']['Name']; ?></strong>. (<a href="<?php echo $data['config']['SITE_URL']; ?>/admin/staff/logout">Logout</a>)&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $data['config']['SITE_URL']; ?>" target="_blank">Back to Site</a></div>
  <?php } ?>
  <div class="clear"></div>
  <div class="admin_title">Administrative Panel</div>
</div>
