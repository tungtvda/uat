<?php if ($data['page']['listing_delete']['ok']==1) { ?>
<div class="notify">Listing deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/merchant/listing/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Merchant</label></th>
	        <td><select name="MerchantID" class="chosen_simple">
	            <option value="" selected="selected">All Merchants</option>
	            <?php for ($i=0; $i<$data['content_param']['merchant_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['merchant_list'][$i]['ID']; ?>" <?php if ($data['content_param']['merchant_list'][$i]['ID']==$_SESSION['listing_MerchantIndex']['param']['MerchantID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['merchant_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <td>Filter</td>
	        <td><select name="FilterID" class="chosen">
	            <option value="" selected="selected">All Listing Filters</option>
	            <?php for ($i=0; $i<$data['content_param']['listingfilter_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['listingfilter_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listingfilter_list'][$i]['ID']==$_SESSION['listing_MerchantIndex']['param']['FilterID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['listingfilter_list'][$i]['ID']; ?> - <?php echo $data['content_param']['listingfilter_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Brand Name</label></th>
	        <td><input name="BrandName" type="text" value="<?php echo $_SESSION['listing_MerchantIndex']['param']['BrandName']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <td>Filter Alt</td>
	        <td><select name="Filter2ID" class="chosen">
	            <option value="" selected="selected">All Listing Filter Alts</option>
	            <?php for ($i=0; $i<$data['content_param']['listingfiltertwo_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['listingfiltertwo_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listingfiltertwo_list'][$i]['ID']==$_SESSION['listing_MerchantIndex']['param']['Filter2ID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['listingfiltertwo_list'][$i]['ID']; ?> - <?php echo $data['content_param']['listingfiltertwo_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['listing_MerchantIndex']['param']['Name']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <td>Description</td>
	        <td><input name="Description" type="text" value="<?php echo $_SESSION['listing_MerchantIndex']['param']['Description']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Street</label></th>
	        <td><input name="Street1" type="text" value="<?php echo $_SESSION['listing_MerchantIndex']['param']['Street1']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>State</label></th>
	        <td><select name="State" class="chosen">
	            <option value="" selected="selected">All States</option>
	            <?php for ($i=0; $i<$data['content_param']['state_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['state_list'][$i]['ID']; ?>" <?php if ($data['content_param']['state_list'][$i]['ID']==$_SESSION['listing_MerchantIndex']['param']['State']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['state_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Street Alt</label></th>
	        <td><input name="Street2" type="text" value="<?php echo $_SESSION['listing_MerchantIndex']['param']['Street2']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Country</label></th>
	        <td><select name="Country" class="chosen_full">
	            <option value="" selected="selected">All Countries</option>
	            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$_SESSION['listing_MerchantIndex']['param']['Country']) { ?> selected="selected"<?php } ?>><?php echo Helper::truncate($data['content_param']['country_list'][$i]['Name'],35); ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Postcode</label></th>
	        <td><input name="Postcode" type="text" value="<?php echo $_SESSION['listing_MerchantIndex']['param']['Postcode']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>City</label></th>
	        <td><input name="City" type="text" value="<?php echo $_SESSION['listing_MerchantIndex']['param']['City']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Phone No</label></th>
	        <td><input name="PhoneNo" type="text" value="<?php echo $_SESSION['listing_MerchantIndex']['param']['PhoneNo']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <td>Type</td>
	        <td><select name="TypeID" class="chosen">
	            <option value="" selected="selected">All Listing Types</option>
	            <?php for ($i=0; $i<$data['content_param']['listingtype_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['listingtype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listingtype_list'][$i]['ID']==$_SESSION['listing_MerchantIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['listingtype_list'][$i]['ID']; ?> - <?php echo $data['content_param']['listingtype_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Enabled</label></th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['listing_MerchantIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <th scope="row"><?php /*?><label>Image URL</label><?php */?></th>
	        <td><?php /*?><input name="ImageURL" type="text" value="<?php echo $_SESSION['listing_AdminIndex']['param']['ImageURL']; ?>" size="" /><?php */?></td>
	      </tr>
	      <?php /*?><tr>
	        <th scope="row"><label>Cover</label></th>
	        <td><input name="Cover" type="text" value="<?php echo $_SESSION['listing_AdminIndex']['param']['Cover']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Position</label></th>
	        <td><input name="Position" type="text" value="<?php echo $_SESSION['listing_AdminIndex']['param']['Position']; ?>" size="" /></td>
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/listing/index?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
	      </tr>
	    </table>
	  </form>
  </div>
</div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<div class="admin_results">
  <div class="results_left">
    <h2><?php echo $data['content_param']['query_title']; ?></h2>
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right"><a href='/merchant/listing/add/'>
    <input type="button" class="button" value="Create Listing">
    </a><?php /*?><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/listing/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php */?><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php if ($data['content_param']['count']>0) { ?>
<table class="member_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Merchant</th>
    <th>Type</th>
    <th>Filter</th>
    <th>Filter Alt</th>
    <th>Name</th>
    <th>Brand Name</th>
    <th class="center">Brand Image</th>
    <th>Description</th>
    <th class="center">Image</th>
    <th>Street</th>
    <th>Street Alt</th>
    <th>City</th>
    <th>Postcode</th>
    <th>State</th>
    <th>Country</th>
    <th>Map X</th>
    <th>Map Y</th>
    <th>Phone No</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <tbody <?php if ($data['content_param']['sort']==TRUE) { ?>class="sortable"<?php } ?>>
	<?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  	<tr data-id="<?php echo $data['content'][$i]['ID']; ?>">
    <td><?php echo $data['content'][$i]['MerchantID']['Name']; ?></td>
    <td><?php echo $data['content'][$i]['TypeID']['Label']; ?></td>
    <td><?php echo $data['content'][$i]['FilterID']; ?></td>
    <td><?php echo $data['content'][$i]['Filter2ID']; ?></td>
    <td><?php echo $data['content'][$i]['Name']; ?></td>
    <td><?php echo $data['content'][$i]['BrandName']; ?></td>
    <td class="center"><img src="<?php echo $data['content'][$i]['BrandImageURL']; ?>" width="66" height="66" /></td>
    <td><?php echo $data['content'][$i]['Description']; ?></td>
    <td class="center"><img src="<?php echo $data['content'][$i]['ImageURL']; ?>" width="66" height="66" /></td>
    <td><?php echo $data['content'][$i]['Street1']; ?></td>
    <td><?php echo $data['content'][$i]['Street2']; ?></td>
    <td><?php echo $data['content'][$i]['City']; ?></td>
    <td><?php echo $data['content'][$i]['Postcode']; ?></td>
    <td><?php echo $data['content'][$i]['State']['Name']; ?></td>
    <td><?php echo $data['content'][$i]['Country']['Name']; ?></td>
    <td><?php echo $data['content'][$i]['MapX']; ?></td>
    <td><?php echo $data['content'][$i]['MapY']; ?></td>
    <td><?php echo $data['content'][$i]['PhoneNo']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/merchant/listing/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/merchant/listing/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
