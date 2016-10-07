<?php if ($data['page']['product_delete']['ok']==1) { ?>
<div class="notify">Product deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/product/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Type</label></th>
	        <td><select name="TypeID" class="chosen">
	            <option value="" selected="selected">All Types</option>
	            <?php for ($i=0; $i<$data['content_param']['producttype_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['producttype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['producttype_list'][$i]['ID']==$_SESSION['product_AdminIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['producttype_list'][$i]['Label']; ?></option><?php } ?></select></td>
	        <td>&nbsp;</td>
	        <th><label>Play Link</label></th>
	        <td><input name="PlayLink" type="text" value="<?php echo $_SESSION['product_AdminIndex']['param']['PlayLink']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['product_AdminIndex']['param']['Name']; ?>" /></td>
	        <td>&nbsp;</td>
	        <th><label>Demo Link</label></th>
	        <td><input name="DemoLink" type="text" value="<?php echo $_SESSION['product_AdminIndex']['param']['DemoLink']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <!-- <th><label>Enabled</label></th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['product_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td> -->
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/product/index?page=all">
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
  <div class="results_right"><a href='/admin/product/add/'><input type="button" class="button" value="Create Product"></a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/product/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<?php /*if ($data['content_param']['sort']!=TRUE) { ?>
    <div class="sortable_tip">Drag-and-drop sorting is disabled. To enabled drag-and-drop sorting please <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/product/index?page=all">reset</a> the search filters.</div>
<?php } else { ?>
    <div class="sortable_tip">Drag-and-drop sorting is enabled. Tip: Drag any row to the desired position and release.</div>
<?php }*/?>
<table class="admin_table" id="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>ID</th>
    <th class="center">Type</th>
    <th class="center">Name</th>
    <th class="center">Links</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <tbody <?php if ($data['content_param']['sort']==TRUE) { ?>class="sortable"<?php } ?>>
	<?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  	<tr data-id="<?php echo $data['content'][$i]['ID']; ?>">
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['ID']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['TypeID']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Name']; ?></td>
    <td style="white-space:nowrap"><!-- <img src="<?php echo $data['content'][$i]['ImageURL']; ?>" width="350px" /><br /> -->
        Play Link: <b><?php echo $data['content'][$i]['PlayLink']; ?></b><br />
        Demo Link: <b><?php echo $data['content'][$i]['DemoLink']; ?></b>
    </td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/product/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/product/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
