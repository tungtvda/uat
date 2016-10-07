<?php if ($data['page']['booking_delete']['ok']==1) { ?>
<div class="notify">Booking deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Member</label></th>
	        <td><select name="MemberID" class="chosen_simple">
	            <option value="" selected="selected">All Members</option>
	            <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>" <?php if ($data['content_param']['member_list'][$i]['ID']==$_SESSION['booking_DealerIndex']['param']['MemberID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['member_list'][$i]['Name']; ?> | <?php echo $data['content_param']['member_list'][$i]['Username']; ?> | <?php echo $data['content_param']['member_list'][$i]['AgentURL']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <td>Name</td>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['booking_DealerIndex']['param']['Name']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Listing</label></th>
	        <td><select name="ListingID" class="chosen_simple">
	            <option value="" selected="selected">All Listings</option>
	            <?php for ($i=0; $i<$data['content_param']['listing_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['listing_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listing_list'][$i]['ID']==$_SESSION['booking_DealerIndex']['param']['ListingID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['listing_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <td>Mobile No</td>
	        <td><input name="MobileNo" type="text" value="<?php echo $_SESSION['booking_DealerIndex']['param']['MobileNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Pax</label></th>
	        <td><input name="Pax" type="text" value="<?php echo $_SESSION['booking_DealerIndex']['param']['Pax']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <td>Date Booked (From)</td>
            <td><input name="DateBookedFrom" class="datepicker" type="text" value="<?php echo $_SESSION['booking_DealerIndex']['param']['DateBookedFrom']; ?>" size="20" />
              (dd-mm-yyyy hh:mm:ss)</td>
	      </tr>
          <tr>
            <th scope="row"><label>Date Arrival (From)</label></th>
            <td><input name="DateArrivalFrom" class="datepicker" type="text" value="<?php echo $_SESSION['booking_DealerIndex']['param']['DateArrivalFrom']; ?>" size="20" />
              (dd-mm-yyyy hh:mm:ss)</td>
            <td>&nbsp;</td>
            <th>Date Booked (To)</th>
            <td><input name="DateBookedTo" class="datepicker" type="text" value="<?php echo $_SESSION['booking_DealerIndex']['param']['DateBookedTo']; ?>" size="20" />
              (dd-mm-yyyy hh:mm:ss)</td>
          </tr>
          <tr>
            <th scope="row"><label>Date Arrival (To)</label></th>
            <td><input name="DateArrivalTo" class="datepicker" type="text" value="<?php echo $_SESSION['booking_DealerIndex']['param']['DateArrivalTo']; ?>" size="20" />
              (dd-mm-yyyy hh:mm:ss)</td>
            <td>&nbsp;</td>
            <th>Special Remarks</th>
            <td><input name="Remarks" type="text" value="<?php echo $_SESSION['booking_DealerIndex']['param']['Remarks']; ?>" /></td>
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/index?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
	      </tr>
	    </table>
	  </form>
  </div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<div class="admin_results">
  <div class="results_left">
    <h2><?php echo $data['content_param']['query_title']; ?></h2>
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right"><a href='/dealer/booking/add/'>
    <input type="button" class="button" value="Create Booking">
    </a><a href='<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="member_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Member</th>
    <th>Listing</th>
    <th>Name</th>
    <th>Mobile No</th>
    <th>Pax</th>
    <th>Special Remarks</th>
    <th>Pass Code</th>
    <th>Date Booked</th>
    <th class="center">Date Arrival</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['MemberID']; ?></td>
    <td><?php echo $data['content'][$i]['ListingID']; ?></td>
    <td><?php echo $data['content'][$i]['Name']; ?></td>
    <td><?php echo $data['content'][$i]['MobileNo']; ?></td>
    <td><?php echo $data['content'][$i]['Pax']; ?></td>
    <td><?php echo $data['content'][$i]['Remarks']; ?></td>
    <td><?php echo $data['content'][$i]['PassCode']; ?></td>
    <td><?php echo $data['content'][$i]['DateBooked']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['DateArrival']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
