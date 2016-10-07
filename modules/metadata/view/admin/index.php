<?php if ($data['page']['metadata_delete']['ok']==1) { ?>
<div class="notify">Meta Data deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/metadata/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Module</label></th>
	        <td><select name="ModuleID" class="chosen">
	            <option value="" selected="selected">All Modules</option>
	            <?php for ($i=0; $i<$data['content_param']['module_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['module_list'][$i]['ID']; ?>" <?php if ($data['content_param']['module_list'][$i]['ID']==$_SESSION['metadata_AdminIndex']['param']['ModuleID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['module_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th>Key</th>
	        <td><input name="Key" type="text" value="<?php echo $_SESSION['metadata_AdminIndex']['param']['Key']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Value</label></th>
	        <td><input name="Value" type="text" value="<?php echo $_SESSION['metadata_AdminIndex']['param']['Value']; ?>" /></td>
	        <td>&nbsp;</td>
	        <th>Section</th>
	        <td><input name="Section" type="text" value="<?php echo $_SESSION['metadata_AdminIndex']['param']['Section']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Controller</label></th>
	        <td><input name="Controller" type="text" value="<?php echo $_SESSION['metadata_AdminIndex']['param']['Controller']; ?>" /></td>
	        <td>&nbsp;</td>
	        <th>Action</th>
	        <td><input name="Action" type="text" value="<?php echo $_SESSION['metadata_AdminIndex']['param']['Action']; ?>" /></td>
	      </tr>
	      <!-- <tr>
	        <th scope="row"><label>Enabled</label></th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['metadata_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr> -->
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/metadata/index?page=all">
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
  <div class="results_right"><a href='/admin/metadata/add/'>
    <input type="button" class="button" value="Create Meta Data">
    </a><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/metadata/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Module</th>
    <th>Section</th>
    <th>Controller</th>
    <th>Action</th>
    <th>Key</th>
    <th class="center">Value</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['ModuleID']; ?></td>
    <td><?php echo $data['content'][$i]['Section']; ?></td>
    <td><?php echo $data['content'][$i]['Controller']; ?></td>
    <td><?php echo $data['content'][$i]['Action']; ?></td>
    <td><?php echo $data['content'][$i]['Key']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Value']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/metadata/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/metadata/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
