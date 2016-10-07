<?php if ($data['page']['page_run']==1) { ?>
<div class="notify">Htaccess file generated successfully.</div>
<?php } else if ($data['page']['page_run']==2) { ?>
<div class="error">Htaccess file could not be generated. Please ensure that the base htaccess file exists.</div>
<?php } ?>
<p>Htaccess files are generated here to cater to modules with friendly URLs.</p>
<!-- Page -->
<div class="result_box">
<div class="admin_results">
  <div class="results_left">
    <h2>Pages</h2>
    <?php if ($data['content']['page']['count']>0) { ?>
    <div>Total: <?php echo $data['content']['page']['count']; ?></div>
    <?php } ?>
  </div>
  <div class="clear"></div>
</div>
<?php if ($data['content']['page']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Title</th>
    <th>Category</th>
    <th>Friendly URL</th>
    <th>Link</th>
  </tr>
  <?php for ($i=0; $i<$data['content']['page']['count']; $i++) { ?>
  <tr>
    <td><strong><?php echo $data['content']['page'][$i]['Title']; ?></strong></td>
    <td><?php echo $data['content']['page'][$i]['CategoryID']; ?></td>
    <td><?php echo $data['content']['page'][$i]['FriendlyURL']; ?></td>
    <td><a href="<?php echo $data['content']['page'][$i]['Link']; ?>" target="_blank"><?php echo $data['content']['page'][$i]['Link']; ?></a></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
</div>
<div class="button_box"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/generator/run'><input type="button" class="button" value="Generate Now"></a></div>
<!-- Page END -->
<!-- News -->
<!-- <div class="result_box">
<div class="admin_results">
  <div class="results_left">
    <h2>News</h2>
    <?php if ($data['content']['news']['count']>0) { ?>
    <div>Total: <?php echo $data['content']['news']['count']; ?></div>
    <?php } ?>
  </div>
  <div class="clear"></div>
</div>
<?php if ($data['content']['news']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Title</th>
    <th>Friendly URL</th>
    <th>Link</th>
  </tr>
  <?php for ($i=0; $i<$data['content']['news']['count']; $i++) { ?>
  <tr>
    <td><strong><?php echo $data['content']['news'][$i]['Title']; ?></strong></td>
    <td><?php echo $data['content']['news'][$i]['FriendlyURL']; ?></td>
    <td><a href="<?php echo $data['content']['news'][$i]['Link']; ?>" target="_blank"><?php echo $data['content']['news'][$i]['Link']; ?></a></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
</div>
<div class="button_box"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/generator/run'><input type="button" class="button" value="Generate Now"></a></div> -->
<!-- News END -->