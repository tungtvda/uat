<?php if ($data['page']['pointtransaction_delete']['ok']==1) { ?>
<div class="notify">Point Transaction deleted successfully.</div>
<?php } ?>
<div id="total_points_box">Balance Points:<span id="total_points"><?php echo $data['content']['TotalPoint']; ?></span></div>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="member_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/member/pointtransaction/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Type</label></th>
	        <td><select name="TypeID" class="chosen">
	            <option value="" selected="selected">All Types</option>
	            <?php for ($i=0; $i<$data['content_param']['pointtype_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['pointtype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['pointtype_list'][$i]['ID']==$_SESSION['pointtransaction_MemberIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['pointtype_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th>Date Posted (From)</th>
	        <td><input name="DatePostedFrom" class="datepicker" type="text" value="<?php echo $_SESSION['pointtransaction_MemberIndex']['param']['DatePostedFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Amount</label></th>
	        <td><input name="Amount" type="text" value="<?php echo $_SESSION['pointtransaction_MemberIndex']['param']['Amount']; ?>" /></td>
	        <td>&nbsp;</td><th scope="row"><label>Date Posted (To)</label></th>
	        <td><input name="DatePostedTo" class="datepicker" type="text" value="<?php echo $_SESSION['pointtransaction_MemberIndex']['param']['DatePostedTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	          <?php /*?><th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['pointtransaction_MemberIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td><?php */?>
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/member/pointtransaction/index?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
	      </tr>
	    </table>
	  </form>
  </div>
</div>
<div class="member_results">
  <div class="results_left">
    <h2><?php echo $data['content_param']['query_title']; ?></h2>
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right"><a href='/member/pointtransaction/add/'></a>
  	<?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>

<?php if ($data['content_param']['count']>0) { ?>
<table class="member_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Date Posted</th>
    <th class="center">Type</th>
    <th>Description</th>
    <th class="text_right">Points</th>

  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['DatePosted']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['TypeID']; ?></td>
    <td><?php echo $data['content'][$i]['Description']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Amount']; ?></td>

  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
