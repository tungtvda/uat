<?php if ($data['page']['page_delete']['ok']==1) { ?>
<div class="notify">Page deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/page/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Category</label></th>
	        <td><select name="CategoryID" class="chosen">
	            <option value="" selected="selected">All Categories</option>
	            <?php for ($i=0; $i<$data['content_param']['pagecategory_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['pagecategory_list'][$i]['ID']; ?>" <?php if ($data['content_param']['pagecategory_list'][$i]['ID']==$_SESSION['page_AdminIndex']['param']['CategoryID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['pagecategory_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th><label>Date Posted (From)</label></th>
	        <td><input name="DatePostedFrom" class="datepicker" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['DatePostedFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Title</label></th>
	        <td><input name="Title" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['Title']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th><label>Date Posted (To)</label></th>
	        <td><input name="DatePostedTo" class="datepicker" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['DatePostedTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Heading</label></th>
	        <td><input name="Heading" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['Heading']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th><label>Last Updated (From)</label></th>
	        <td><input name="LastUpdatedFrom" class="datepicker" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['LastUpdatedFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Friendly URL</label></th>
	        <td><input name="FriendlyURL" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['FriendlyURL']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th><label>Last Updated (To)</label></th>
	        <td><input name="LastUpdatedTo" class="datepicker" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['LastUpdatedTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Description</label></th>
	        <td><input name="Description" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['Description']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Template</label></th>
	        <td><select name="TemplateID" class="chosen">
	            <option value="" selected="selected">All Templates</option>
	            <?php for ($i=0; $i<$data['content_param']['template_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['template_list'][$i]['ID']; ?>" <?php if ($data['content_param']['template_list'][$i]['ID']==$_SESSION['page_AdminIndex']['param']['TemplateID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['template_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Content</label></th>
	        <td><input name="Content" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['Content']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th><label>Enabled</label></th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['page_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Meta Keyword</label></th>
	        <td><input name="MetaKeyword" type="text" value="<?php echo $_SESSION['page_AdminIndex']['param']['MetaKeyword']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Status</label></th>
	        <td><select name="Status" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['pagestatus_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['pagestatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['pagestatus_list'][$i]['ID']==$_SESSION['page_AdminIndex']['param']['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['pagestatus_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/page/index?page=all">
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
  <div class="results_right"><a href='/admin/page/add/'><input type="button" class="button" value="Create Page"></a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/page/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php /*?><th>Category</th><?php*/ ?>
    <th>Title</th>
    <th>Meta Keyword</th>
    <th>Status</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <?php /*?><td><?php echo $data['content'][$i]['CategoryID']; ?></td><?php*/ ?>
    <td><div class="page_title"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/blog/edit/<?php echo $data['content'][$i]['ID']; ?>'><?php echo $data['content'][$i]['Title']; ?></a></div>
      <div class="page_date">Posted on <?php echo $data['content'][$i]['DatePosted']; ?></div>
      <div class="page_desc"><?php echo $data['content'][$i]['Description']; ?></div>
      <div class="page_update">Last updated: <?php echo $data['content'][$i]['LastUpdated']; ?></div></td>
    <td><?php echo $data['content'][$i]['MetaKeyword']; ?></td>
    <td><?php echo $data['content'][$i]['Status']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/main/page/<?php echo $data['content'][$i]['FriendlyURL']; ?>?preview=1' target='_blank'>Preview</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/page/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/page/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
