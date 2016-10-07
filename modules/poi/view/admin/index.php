<?php if ($data['page']['poi_delete']['ok']==1) { ?>
<div class="notify">POI deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/poi/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Type</label></th>
	        <td><select name="TypeID" class="chosen">
	            <option value="" selected="selected">All Types</option>
	            <?php for ($i=0; $i<$data['content_param']['poitype_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['poitype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['poitype_list'][$i]['ID']==$_SESSION['poi_AdminIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['poitype_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
            <th>Name</th>
            <td><input name="Name" type="text" value="<?php echo $_SESSION['poi_AdminIndex']['param']['Name']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Map X</label></th>
	        <td><input name="MapX" type="text" value="<?php echo $_SESSION['poi_AdminIndex']['param']['MapX']; ?>" /></td>
	        <td>&nbsp;</td>
            <th>Description</th>
            <td><input name="Description" type="text" value="<?php echo $_SESSION['poi_AdminIndex']['param']['Description']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Map Y</label></th>
	        <td><input name="MapY" type="text" value="<?php echo $_SESSION['poi_AdminIndex']['param']['MapY']; ?>" /></td>
	        <td>&nbsp;</td>
	        <th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['poi_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/poi/index?page=all">
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
  <div class="results_right"><a href='/admin/poi/add/'>
    <input type="button" class="button" value="Create POI">
    </a><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/poi/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Type</th>
    <th>Name</th>
    <th>Address</th>
    <th>Map X</th>
    <th>Map Y</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['TypeID']; ?></td>
    <td><?php echo $data['content'][$i]['Name']; ?></td>
    <td><?php echo $data['content'][$i]['Address']; ?></td>
    <td><?php echo $data['content'][$i]['MapX']; ?></td>
    <td><?php echo $data['content'][$i]['MapY']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/poi/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/poi/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
