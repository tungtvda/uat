<?php if ($data['page']['staff_delete']['ok']==1) { ?>
<div class="notify">Staff deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/viewall" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row">ID</th>
	        <td><input name="ID" type="text" value="<?php echo $_SESSION['staff_AdminViewAll']['param']['ID']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>Profile</th>
	        <td><select name="Profile" class="chosen">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['profile_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['profile_list'][$i]['ID']; ?>" <?php if ($data['content_param']['profile_list'][$i]['ID']==$_SESSION['staff_AdminViewAll']['param']['Profile']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['profile_list'][$i]['Profile']; ?></option>
	            <?php } ?>
	          </select>
	        </td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Username</label></th>
	        <td><input name="Username" type="text" value="<?php echo $_SESSION['staff_AdminViewAll']['param']['Username']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['staff_AdminViewAll']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row">Email</th>
	        <td><input name="Email" type="text" value="<?php echo $_SESSION['staff_AdminViewAll']['param']['Email']; ?>" /></td>
	        <td>&nbsp;</td>
	        <th>&nbsp;</th>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/viewall?page=all">
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
  <div class="results_right"><a href='/admin/staff/add/'>
    <input type="button" class="button" value="Create Staff">
    </a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/export/AdminViewAll'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Profile</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['ID']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['Username']; ?></td>
    <td><?php echo $data['content'][$i]['Profile']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='/admin/staff/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><?php if ($data['content'][$i]['ID']=="1") { ?><a href='javascript:void(0);' onclick="deny(1);">Delete</a><?php } else if ($data['content'][$i]['ID']==$_SESSION['admin']['ID']) { ?><a href='javascript:void(0);' onclick="deny(2);">Delete</a><?php } else { ?><a href='/admin/staff/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a><?php } ?></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
