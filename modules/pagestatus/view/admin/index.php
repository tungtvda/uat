<?php if ($data['page']['pagestatus_delete']['ok']==1) { ?>
<div class="notify">Page Status deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/pagestatus/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>ID</label></th>
	        <td><input name="ID" type="text" value="<?php echo $_SESSION['pagestatus_AdminIndex']['param']['ID']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Label</label></th>
	        <td><input name="Label" type="text" id="Label" value="<?php echo $_SESSION['pagestatus_AdminIndex']['param']['Name']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Color</label></th>
	        <td><input name="Color" type="text" value="<?php echo $_SESSION['pagestatus_AdminIndex']['param']['Color']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Background Color</label></th>
	        <td><input name="BGColor" type="text" value="<?php echo $_SESSION['pagestatus_AdminIndex']['param']['BGColor']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <?php /*?><th>Enabled</th>
	        <td><select name="Enabled">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['pagestatus_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr><?php */?>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/pagestatus/index?page=all">
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
  <div class="results_right"><a href='/admin/pagestatus/add/'>
    <input type="button" class="button" value="Create Page Status">
    </a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/pagestatus/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>ID</th>
    <th class="center">Label</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['ID']; ?></td>
    <td class="center"><span class="label label_long" style="background-color: <?php echo $data['content'][$i]['BGColor']; ?>; color: <?php echo $data['content'][$i]['Color']; ?>"><?php echo $data['content'][$i]['Label']; ?></span></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/pagestatus/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/pagestatus/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
