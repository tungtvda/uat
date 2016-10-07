<?php if ($data['page']['merchantdeal_delete']['ok']==1) { ?>
<div class="notify">Merchant Deal deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantdeal/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Date Expiry (From)</label></th>
            <td><input name="DateExpiryFrom" class="datepicker" type="text" value="<?php echo $_SESSION['merchantdeal_AdminIndex']['param']['DateExpiryFrom']; ?>" size="20" />
              (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <td>Listing</td>
	        <td><select name="ListingID" class="chosen">
	            <option value="" selected="selected">All Listings</option>
	            <?php for ($i=0; $i<$data['content_param']['listing_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['listing_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listing_list'][$i]['ID']==$_SESSION['merchantdeal_AdminIndex']['param']['ListingID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['listing_list'][$i]['ID']; ?> - <?php echo $data['content_param']['listing_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date Expiry (To)</label></th>
            <td><input name="DateExpiryTo" class="datepicker" type="text" value="<?php echo $_SESSION['merchantdeal_AdminIndex']['param']['DateExpiryTo']; ?>" size="20" />
              (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <td>Merchant</td>
	        <td><select name="MerchantID" class="chosen">
	            <option value="" selected="selected">All Merchants</option>
	            <?php for ($i=0; $i<$data['content_param']['merchant_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['merchant_list'][$i]['ID']; ?>" <?php if ($data['content_param']['merchant_list'][$i]['ID']==$_SESSION['merchantdeal_AdminIndex']['param']['MerchantID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['merchant_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><?php /*?>Enabled<?php */?></th>
	        <td><?php /*?><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['merchantdeal_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select><?php */?></td>
	        <td>&nbsp;</td>
	        <th scope="row"><?php /*?><label>Image URL</label><?php */?></th>
	        <td><?php /*?><input name="ImageURL" type="text" value="<?php echo $_SESSION['merchantdeal_AdminIndex']['param']['ImageURL']; ?>" size="" /><?php */?></td>
	      </tr>
	      <?php /*?><tr>
	        <th scope="row"><label>Cover</label></th>
	        <td><input name="Cover" type="text" value="<?php echo $_SESSION['merchantdeal_AdminIndex']['param']['Cover']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Position</label></th>
	        <td><input name="Position" type="text" value="<?php echo $_SESSION['merchantdeal_AdminIndex']['param']['Position']; ?>" size="" /></td>
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantdeal/index?page=all">
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
  <div class="results_right"><a href='/admin/merchantdeal/add/'>
    <input type="button" class="button" value="Create Merchant Deal">
    </a><?php /*?><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/merchantdeal/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php */?><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Listing</th>
    <th>Merchant</th>
    <th class="center">Image</th>
    <th class="center">Date Expiry</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <tbody <?php if ($data['content_param']['sort']==TRUE) { ?>class="sortable"<?php } ?>>
	<?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  	<tr data-id="<?php echo $data['content'][$i]['ID']; ?>">
    <td><?php echo $data['content'][$i]['ListingID']; ?></td>
    <td><?php echo $data['content'][$i]['MerchantID']; ?></td>
    <td class="center"><img src="<?php echo $data['content'][$i]['ImageURL']; ?>" width="66" height="66" /></td>
    <td class="center"><?php echo $data['content'][$i]['DateExpiry']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/merchantdeal/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/merchantdeal/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
