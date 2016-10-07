<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
      <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
      <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/stafflog/index" method="post">
        <input name="Trigger" type="hidden" value="search_form" />
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th scope="row"><label>Date Logged (From)</label></th>
            <td><input name="DateLoggedFrom" class="datepicker" type="text" value="<?php echo $_SESSION['stafflog_AdminIndex']['param']['DateLoggedFrom']; ?>" size="10" />
              (dd-mm-yyyy)</td>
            <td>&nbsp;</td>
            <th scope="row"><label>User ID</label></th>
            <td><input name="UserID" type="text" value="<?php echo $_SESSION['stafflog_AdminIndex']['param']['UserID']; ?>" size="" /></td>
          </tr>
          <tr>
            <th scope="row"><label>Date Logged (To)</label></th>
            <td><input name="DateLoggedFrom" class="datepicker" type="text" value="<?php echo $_SESSION['stafflog_AdminIndex']['param']['DateLoggedFrom']; ?>" size="10" />
              (dd-mm-yyyy)</td>
            <td>&nbsp;</td>
            <th scope="row"><label>User</label></th>
            <td><input name="User" type="text" value="<?php echo $_SESSION['stafflog_AdminIndex']['param']['User']; ?>" size="" /></td>
          </tr>
          <tr>
            <th>IP Address</th>
            <td><input name="IP" type="text" value="<?php echo $_SESSION['stafflog_AdminIndex']['param']['IP']; ?>" /></td>
            <td>&nbsp;</td>
            <th>Description</th>
            <td><input name="Description" type="text" value="<?php echo $_SESSION['stafflog_AdminIndex']['param']['Description']; ?>" /></td>
          </tr>
          <tr>
            <th scope="row">&nbsp;</th>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <th scope="row"><label></label></th>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
              <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/stafflog/index?page=all">
              <input type="button" value="Reset" class="button" />
              </a></td>
          </tr>
        </table>
      </form>
  </div>
</div>
<div class="admin_results">
  <div class="results_left">
    <h2><?php echo $data['content_param']['query_title']; ?></h2>
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/stafflog/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="white-space: nowrap">Date Logged</th>
    <th style="white-space: nowrap" class="center">IP Address</th>
    <th style="white-space: nowrap;" class="center">User ID</th>
    <th>User</th>
    <th>Description</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="white-space: nowrap"><?php echo $data['content'][$i]['DateLogged']; ?></td>
    <td style="white-space: nowrap" class="center"><?php echo $data['content'][$i]['IP']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['UserID']; ?></td>
    <td><?php echo $data['content'][$i]['User']; ?></td>
    <td><?php echo $data['content'][$i]['Description']; ?></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
