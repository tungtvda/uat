<?php if ($data['page']['dealer_delete']['ok']==1) { ?>
<div class="notify">Dealer deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_noMobile"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" Mobilespacing="0" Mobilepadding="0">
	      <tr>
	        <th scope="row"><label>Full Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['Name']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Email</label></th>
	        <td><input name="Email" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['Email']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Company</label></th>
            <td><input name="Company" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['Company']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Mobile No</label></th>
	        <td><input name="MobileNo" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['MobileNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Gender</label></th>
	        <td><select name="GenderID" class="chosen_simple">
	            <option value="" selected="selected">All Gender</option>
	            <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>" <?php if ($_SESSION['dealer_AdminIndex']['param']['GenderID']==$data['content_param']['gender_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Phone No</label></th>
	        <td><input name="PhoneNo" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['PhoneNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date of Birth (From)</label></th>
	        <td><input name="DOBFrom" class="datepicker" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['DOBFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Fax No</label></th>
	        <td><input name="FaxNo" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['FaxNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date of Birth (To)</label></th>
	        <td><input name="DOBTo" class="datepicker" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['DOBTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Nationality</label></th>
	        <td><select name="Nationality" class="chosen_full">
	            <option value="" selected="selected">All Nationality</option>
	            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$_SESSION['dealer_AdminIndex']['param']['Nationality']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['NameShort']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>NRIC</label></th>
	        <td><input name="NRIC" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['NRIC']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Passport</label></th>
	        <td><input name="Passport" type="text" value="<?php echo $_SESSION['dealer_AdminIndex']['param']['Passport']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['dealer_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
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
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/index?page=all">
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
  <div class="results_right"><a href='/admin/dealer/add/'>
    <input type="button" class="button" value="Create Dealer">
    </a><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" Mobilespacing="0" Mobilepadding="0">
  <tr>
    <th>Name</th>
    <th>Information</th>
    <th class="center">Prompt</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="vertical-align: top"><div><a class="dealer_title" href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/edit/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Name']; ?></a> <span class="dealer_dob">(<?php echo $data['content'][$i]['GenderID']; ?>)</span></div>
        <strong>Username:</strong><br /><?php echo $data['content'][$i]['Username']; ?><br /><br />
        <strong>Company:</strong><br /><?php echo $data['content'][$i]['Company']; ?>
    </td>
    <td style="vertical-align: top">
        <span class="dealer_inner_header">Date of Birth:</span> <?php echo $data['content'][$i]['DOB']; ?><br />
        <span class="dealer_inner_header">Nationality:</span> <?php echo $data['content'][$i]['Nationality']; ?><br />
        <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
        <span class="dealer_inner_header">NRIC No:</span> <?php echo $data['content'][$i]['NRIC']; ?><br />
        <?php } else { ?>
        <span class="dealer_inner_header">Passport No:</span> <?php echo $data['content'][$i]['Passport']; ?><br />
        <?php } ?>
        <br />
        <span class="dealer_inner_header">Mobile No:</span> <?php echo $data['content'][$i]['MobileNo']; ?><br />
        <span class="dealer_inner_header">Phone No:</span> <?php echo $data['content'][$i]['PhoneNo']; ?><br />
        <span class="dealer_inner_header">Fax No:</span> <?php echo $data['content'][$i]['FaxNo']; ?><br />
        <span class="dealer_inner_header">Email:</span> <?php echo $data['content'][$i]['Email']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Prompt']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
