<?php if ($data['page']['block_delete']['ok']==1) { ?>
<div class="notify">Block deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/block/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['block_AdminIndex']['param']['Name']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Content</label></th>
	        <td><input name="Content" type="text" value="<?php echo $_SESSION['block_AdminIndex']['param']['Content']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Type</label></th>
	        <td><select name="TypeID" class="chosen">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['blocktype_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['blocktype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['blocktype_list'][$i]['ID']==$_SESSION['block_AdminIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['blocktype_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th><label>Enabled</label></th>
	        <td><select name="Enabled"  class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['block_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Area</label></th>
	        <td><select name="AreaID" class="chosen">
	            <option value="" selected="selected">All Areas</option>
	            <?php for ($i=0; $i<$data['content_param']['area_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['area_list'][$i]['ID']; ?>" <?php if ($data['content_param']['area_list'][$i]['ID']==$_SESSION['block_AdminIndex']['param']['AreaID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['area_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select>        </td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      <tr>
	        <th scope="row"><?php /*?><label>User ID</label><?php */?></th>
	        <td><?php /*?><input name="UserID" type="text" value="<?php echo $_SESSION['block_AdminIndex']['param']['UserID']; ?>" size="" /><?php */?></td>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/block/index?page=all">
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
  <div class="results_right"><a href='/admin/block/add/'>
    <input type="button" class="button" value="Create Block">
    </a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/block/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<?php if ($data['content_param']['sort']!=TRUE) { ?>
    <div class="sortable_tip">Drag-and-drop sorting is disabled. To enabled drag-and-drop sorting please <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/block/index?page=all">reset</a> the search filters.</div>
<?php } else { ?>
    <div class="sortable_tip">Drag-and-drop sorting is enabled. Tip: Drag any row to the desired position and release.</div>
<?php }?>
<table class="admin_table" id="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php /*?><th>User ID</th><?php */?>
    <th>Name</th>
    <th>Area</th>
    <th>Content</th>
    <th>Position</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <tbody <?php if ($data['content_param']['sort']==TRUE) { ?>class="sortable"<?php } ?>>
	<?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
	<tr data-id="<?php echo $data['content'][$i]['ID']; ?>">
    <?php /*?><td><?php echo $data['content'][$i]['UserID']; ?></td><?php */?>
    <td><div class="block_title"><?php echo $data['content'][$i]['Name']; ?></div>
       <div class="block_type"><?php echo $data['content'][$i]['TypeID']; ?></div>
    </td>
    <td><?php echo $data['content'][$i]['AreaID']; ?></td>
    <td class="content-cell"><?php echo $data['content'][$i]['Content']; ?></td>
    <td class="center"><span class="sortable_position" id="sortable_position_<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Position']; ?></span></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/block/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/block/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
