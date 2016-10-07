<?php if ($data['page']['moduletranslation_delete']['ok']==1) { ?>
<div class="notify">Module Translation deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/moduletranslation/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Module</label></th>
	        <td><select name="ModuleID" class="chosen_simple">
	            <option value="" selected="selected">All Modules</option>
	            <?php for ($i=0; $i<$data['content_param']['module_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['module_list'][$i]['ID']; ?>" <?php if ($data['content_param']['module_list'][$i]['ID']==$_SESSION['moduletranslation_AdminIndex']['param']['ModuleID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['module_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th>Row ID</th>
	        <td><input name="RowID" type="text" id="Label" value="<?php echo $_SESSION['moduletranslation_AdminIndex']['param']['RowID']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Language</label></th>
	        <td><select name="LanguageID" class="chosen_simple">
	            <option value="" selected="selected">All Languages</option>
	            <?php for ($i=0; $i<$data['content_param']['language_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['language_list'][$i]['ID']; ?>" <?php if ($data['content_param']['language_list'][$i]['ID']==$_SESSION['moduletranslation_AdminIndex']['param']['LanguageID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['language_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th>Content</th>
	        <td><input name="Content" type="text" id="Label" value="<?php echo $_SESSION['moduletranslation_AdminIndex']['param']['Content']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <?php /*?><th>Enabled</th>
	        <td><select name="Enabled">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['moduletranslation_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr><?php */?>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/moduletranslation/index?page=all">
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
  <div class="results_right"><a href='/admin/moduletranslation/add/'>
    <input type="button" class="button" value="Create Module Translation">
    </a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/moduletranslation/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Module</th>
    <th>Language</th>
    <th>Row</th>
    <th class="center">Content</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['ModuleID']; ?></td>
    <td><?php echo $data['content'][$i]['LanguageID']; ?></td>
    <td><?php echo $data['content'][$i]['RowID']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Content']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/moduletranslation/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/moduletranslation/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
