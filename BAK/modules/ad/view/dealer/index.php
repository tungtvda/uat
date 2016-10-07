<?php if ($data['page']['ad_delete']['ok']==1) { ?>
<div class="notify">Ad deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/dealer/ad/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Date Expiry (From)</label></th>
            <td><input name="DateExpiryFrom" class="datepicker" type="text" value="<?php echo $_SESSION['ad_DealerIndex']['param']['DateExpiryFrom']; ?>" size="20" />
              (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <td>Type</td>
	        <td><select name="TypeID" class="chosen">
	            <option value="" selected="selected">All Ad Types</option>
	            <?php for ($i=0; $i<$data['content_param']['adtype_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['adtype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['adtype_list'][$i]['ID']==$_SESSION['ad_DealerIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['adtype_list'][$i]['ID']; ?> - <?php echo $data['content_param']['adtype_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date Expiry (To)</label></th>
            <td><input name="DateExpiryTo" class="datepicker" type="text" value="<?php echo $_SESSION['ad_DealerIndex']['param']['DateExpiryTo']; ?>" size="20" />
              (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <td>Merchant</td>
	        <td><select name="MerchantID" class="chosen">
	            <option value="" selected="selected">All Merchants</option>
	            <?php for ($i=0; $i<$data['content_param']['merchant_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['merchant_list'][$i]['ID']; ?>" <?php if ($data['content_param']['merchant_list'][$i]['ID']==$_SESSION['ad_DealerIndex']['param']['MerchantID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['merchant_list'][$i]['ID']; ?> - <?php echo $data['content_param']['merchant_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
            <th scope="row"><label>Ad Name</label></th>
            <td><select name="ID" class="chosen">
	            <option value="" selected="selected">All Ads</option>
	            <?php for ($i=0; $i<$data['content_param']['ad_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['ad_list'][$i]['ID']; ?>" <?php if ($data['content_param']['ad_list'][$i]['ID']==$_SESSION['ad_DealerIndex']['param']['ID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['ad_list'][$i]['ID']; ?> - <?php echo $data['content_param']['ad_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	          <td>&nbsp;</td>
	        <th scope="row"><label>Ad Link</label></th>
            <td><input name="AdLink" class="" type="text" value="<?php echo $_SESSION['ad_DealerIndex']['param']['AdLink']; ?>" size="20" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><?php /*?>Enabled<?php */?></th>
	        <td><?php /*?><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['ad_DealerIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select><?php */?></td>
	        <td>&nbsp;</td>
	        <th scope="row"><?php /*?><label>Image URL</label><?php */?></th>
	        <td><?php /*?><input name="ImageURL" type="text" value="<?php echo $_SESSION['ad_DealerIndex']['param']['ImageURL']; ?>" size="" /><?php */?></td>
	      </tr>
	      <?php /*?><tr>
	        <th scope="row"><label>Cover</label></th>
	        <td><input name="Cover" type="text" value="<?php echo $_SESSION['ad_DealerIndex']['param']['Cover']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Position</label></th>
	        <td><input name="Position" type="text" value="<?php echo $_SESSION['ad_DealerIndex']['param']['Position']; ?>" size="" /></td>
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/ad/index?page=all">
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
  <div class="results_right"><a href='/dealer/ad/add/'>
    <input type="button" class="button" value="Create Ad">
    </a><?php /*?><a href='<?php echo $data['config']['SITE_URL']; ?>/dealer/ad/export/DealerIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php */?><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="member_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Type</th>
    <th>Merchant</th>
    <th>Name</th>
    <th>Ad Link</th>
    <th class="center">Image</th>
    <th class="center">Date Expiry</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <tbody <?php if ($data['content_param']['sort']==TRUE) { ?>class="sortable"<?php } ?>>
	<?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  	<tr data-id="<?php echo $data['content'][$i]['ID']; ?>">
    <td><?php echo $data['content'][$i]['TypeID']; ?></td>
    <td><?php echo $data['content'][$i]['MerchantID']; ?></td>
    <td><?php echo $data['content'][$i]['Name']; ?></td>
    <td><?php echo $data['content'][$i]['AdLink']; ?></td>
    <td class="center"><img src="<?php echo $data['content'][$i]['ImageURL']; ?>" width="66" height="66" /></td>
    <td class="center"><?php echo $data['content'][$i]['DateExpiry']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/dealer/ad/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/dealer/ad/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
