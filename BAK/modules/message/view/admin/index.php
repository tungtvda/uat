<?php if ($data['page']['message_delete']['ok']==1) { ?>
<div class="notify">Message deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/message/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['message_AdminIndex']['param']['Name']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Contact No</label></th>
	        <td><input name="ContactNo" type="text" value="<?php echo $_SESSION['message_AdminIndex']['param']['ContactNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Company</label></th>
	        <td><input name="Company" type="text" value="<?php echo $_SESSION['message_AdminIndex']['param']['Company']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Email</label></th>
	        <td><input name="Email" type="text" value="<?php echo $_SESSION['message_AdminIndex']['param']['Email']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Subject</label></th>
	        <td><input name="Subject" type="text" value="<?php echo $_SESSION['message_AdminIndex']['param']['Subject']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Message</label></th>
	        <td><input name="Message" type="text" value="<?php echo $_SESSION['message_AdminIndex']['param']['Message']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date Posted (From)</label></th>
	        <td><input name="DatePostedFrom" class="datepicker" type="text" value="<?php echo $_SESSION['message_AdminIndex']['param']['DatePostedFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label>Status</label></th>
            <td><select name="Status" class="chosen_simple">
                <option value="" selected="selected">All Status</option>
                <?php for ($i=0; $i<$data['content_param']['messagestatus_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['messagestatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['messagestatus_list'][$i]['ID']==$_SESSION['message_AdminIndex']['param']['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['messagestatus_list'][$i]['Label']; ?></option>
                <?php } ?>
            </select></td>
	      <tr>
	        <th scope="row"><label>Date Posted (To)</label></th>
	        <td><input name="DatePostedTo" class="datepicker" type="text" value="<?php echo $_SESSION['message_AdminIndex']['param']['DatePostedTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/message/index?page=all">
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
  <div class="results_right">
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <a href='/admin/message/add/'><input type="button" class="button" value="Create Message"></a>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']!='2') { ?>
    <a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/message/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a>
    <?php } ?>
    <?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Message</th>
    <th>Visitor Information</th>
    <th style="text-align: center">Status</th>
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <th>&nbsp;</th>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <th>&nbsp;</th>
    <?php } ?>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="vertical-align: top;"><div class="message_title"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/message/edit/<?php echo $data['content'][$i]['ID']; ?>'><?php echo $data['content'][$i]['Subject']; ?></a></div>
        <div class="message_date">Posted on <?php echo $data['content'][$i]['DatePosted']; ?></div>
        <?php echo $data['content'][$i]['Message']; ?></td>
    <td style="vertical-align: top; white-space: nowrap;"><span class="message_inner_header">Name:</span><?php echo $data['content'][$i]['Name']; ?></span><br />
        <span class="message_inner_header">Company:</span><?php echo $data['content'][$i]['Company']; ?></span><br />
        <span class="message_inner_header">Contact No:</span><?php echo $data['content'][$i]['ContactNo']; ?></span><br />
        <span class="message_inner_header">Email:</span><?php echo $data['content'][$i]['Email']; ?></span></td>
    <td style="text-align: center"><?php echo $data['content'][$i]['Status']; ?></td>
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/message/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/message/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
    <?php } ?>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
