<?php if ($data['page']['news_delete']['ok']==1) { ?>
<div class="notify">News deleted successfully.</div>
<?php } ?>
<?php if ($_SESSION['swap']==1) { ?>
<div class="notify">Language swapped successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
      <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
      <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/news/index" method="post">
        <input name="Trigger" type="hidden" value="search_form" />
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th scope="row"><label>Title</label></th>
            <td><input name="Title" type="text" value="<?php echo $_SESSION['news_AdminIndex']['param']['Title']; ?>" size="" /></td>
            <td>&nbsp;</td>
            <th scope="row"><label>Friendly URL</label></th>
            <td><input name="FriendlyURL" type="text" value="<?php echo $_SESSION['news_AdminIndex']['param']['FriendlyURL']; ?>" size="" /></td>
          </tr>
          <tr>
            <th scope="row"><label>Source</label></th>
            <td><input name="Source" type="text" value="<?php echo $_SESSION['news_AdminIndex']['param']['Source']; ?>" size="" /></td>
            <td>&nbsp;</td>
            <th>Description</th>
            <td><input name="Description" type="text" value="<?php echo $_SESSION['news_AdminIndex']['param']['Description']; ?>" /></td>
          </tr>
          <tr>
            <th scope="row"><label>Date of Article (From)</label></th>
            <td><input name="DateFrom" class="datepicker" type="text" value="<?php echo $_SESSION['news_AdminIndex']['param']['DateFrom']; ?>" size="10" />
              (dd-mm-yyyy)</td>
            <td>&nbsp;</td>
            <th>Content</th>
            <td><input name="Content" type="text" value="<?php echo $_SESSION['news_AdminIndex']['param']['Content']; ?>" /></td>
          </tr>
          <tr>
            <th scope="row"><label>Date of Article (To)</label></th>
            <td><input name="DateTo" class="datepicker" type="text" value="<?php echo $_SESSION['news_AdminIndex']['param']['DateTo']; ?>" size="10" />
              (dd-mm-yyyy)</td>
            <td>&nbsp;</td>
            <th>Enabled</th>
            <td><select name="Enabled" class="chosen_simple">
                <option value="" selected="selected">All Status</option>
                <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['news_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
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
              <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/news/index?page=all">
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
  <div class="results_right"><a href='/admin/news/add/'>
    <input type="button" class="button" value="Create News">
    </a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/news/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/news/defaultchange'>
    <input type="button" class="button" value="Swap Default Language">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Cover Image</th>
    <th>Title</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td class="news_cover"><img src="<?php echo $data['content'][$i]['CoverImage']; ?>" /></td>
    <td style="vertical-align: top"><div class="news_title"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/news/edit/<?php echo $data['content'][$i]['ID']; ?>'><?php echo $data['content'][$i]['Title']; ?></a></div>
      <div class="news_date"><?php echo $data['content'][$i]['Date']; ?>&nbsp;&nbsp;|&nbsp;&nbsp;By <span class="news_source"><?php echo $data['content'][$i]['Source']; ?></span></div>
      <div class="news_desc"><?php echo $data['content'][$i]['Description']; ?></div></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/main/news/<?php echo $data['content'][$i]['FriendlyURL']; ?>?preview=1' target='_blank'>Preview</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/news/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/news/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
