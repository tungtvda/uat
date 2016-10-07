<?php if ($data['page']['dealeraddress_delete']['ok']==1) { ?>
<div class="notify">Dealer Address deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/dealeraddress/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Dealer</label></th>
	        <td><select name="DealerID" class="chosen_simple">
	            <option value="" selected="selected">All Dealers</option>
	            <?php for ($i=0; $i<$data['content_param']['dealer_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['dealer_list'][$i]['ID']; ?>" <?php if ($data['content_param']['dealer_list'][$i]['ID']==$_SESSION['dealeraddress_AdminIndex']['param']['DealerID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['dealer_list'][$i]['FirstName']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Title</label></th>
	        <td><input name="Title" type="text" value="<?php echo $_SESSION['dealeraddress_AdminIndex']['param']['Title']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Street</label></th>
	        <td><input name="Street" type="text" value="<?php echo $_SESSION['dealeraddress_AdminIndex']['param']['Street']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>State</label></th>
	        <td><select name="State" class="chosen">
	            <option value="" selected="selected">All States</option>
	            <?php for ($i=0; $i<$data['content_param']['state_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['state_list'][$i]['ID']; ?>" <?php if ($data['content_param']['state_list'][$i]['ID']==$_SESSION['dealeraddress_AdminIndex']['param']['State']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['state_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Postcode</label></th>
	        <td><input name="Postcode" type="text" value="<?php echo $_SESSION['dealeraddress_AdminIndex']['param']['Postcode']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Country</label></th>
	        <td><select name="Country" class="chosen_full">
	            <option value="" selected="selected">All Countries</option>
	            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$_SESSION['dealeraddress_AdminIndex']['param']['Country']) { ?> selected="selected"<?php } ?>><?php echo Helper::truncate($data['content_param']['country_list'][$i]['Name'],35); ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Street 2</label></th>
	        <td><input name="Street2" type="text" value="<?php echo $_SESSION['dealeraddress_AdminIndex']['param']['Street2']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>City</label></th>
	        <td><input name="City" type="text" value="<?php echo $_SESSION['dealeraddress_AdminIndex']['param']['City']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Phone No</label></th>
	        <td><input name="PhoneNo" type="text" value="<?php echo $_SESSION['dealeraddress_AdminIndex']['param']['PhoneNo']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Fax No</label></th>
	        <td><input name="FaxNo" type="text" value="<?php echo $_SESSION['dealeraddress_AdminIndex']['param']['FaxNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Enabled</label></th>
	        <td><select name="Enabled"  class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['dealeraddress_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Email</label></th>
	        <td><input name="Email" type="text" value="<?php echo $_SESSION['dealeraddress_AdminIndex']['param']['Email']; ?>" size="" /></td>
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealeraddress/index?page=all">
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
  <div class="results_right"><a href='/admin/dealeraddress/add/'>
    <input type="button" class="button" value="Create Dealer Address">
    </a><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/dealeraddress/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Dealer</th>
    <th>Title</th>
    <th>Street</th>
    <th>Street 2</th>
    <th>City</th>
    <th>State</th>
    <th>Postcode</th>
    <th>Country</th>
    <th>Phone No</th>
    <th>Fax No</th>
    <th>Email</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['DealerID']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['Title']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['Street']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['Street2']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['City']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['State']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['Postcode']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['Country']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['PhoneNo']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['FaxNo']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['Email']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/dealeraddress/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/dealeraddress/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
