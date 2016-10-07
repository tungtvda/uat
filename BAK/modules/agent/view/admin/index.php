<?php if ($data['page']['agent_delete']['ok']==1) { ?>
<div class="notify">Agent deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_noMobile"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" Mobilespacing="0" Mobilepadding="0">
	      <tr>
	        <!--<th scope="row"><label>Reseller</label></th>
	        <td><input name="Reseller" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Reseller']; ?>" size="" /></td>-->
	        <th scope="row"><label>Week</label></th>
	        <td><span class="this-week">This week</span> | <span class="last-week">Last Week</span></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <!--<th scope="row"><label>Reseller</label></th>
	        <td><input name="Reseller" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Reseller']; ?>" size="" /></td>-->
	        <th scope="row"><label>Company</label></th>
	        <td><input name="Company" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Company']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Email</label></th>
	        <td><input name="Email" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Email']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Full Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Name']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Username</label></th>
	        <td><input name="Username" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Username']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Bank</label></th>
            <td>
                <select name="Bank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if ($data['content_param']['bank_list'][$i]['Label']==$_SESSION['reseller_AdminIndex']['param']['Bank']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select>                
                </td>
	        <td>&nbsp;</td>
	        
	        <th scope="row"><label>Mobile No</label></th>
	        <td><input name="MobileNo" type="text" value="<?php echo $_SESSION['reseller_AdminIndex']['param']['MobileNo']; ?>" size="" /></td>
	      </tr>
	      <!--<tr>
	      	<th scope="row"><label>Secondary Bank</label></th>
            <td><select name="Bank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if ($data['content_param']['bank_list'][$i]['Label']==$_SESSION['agent_AdminIndex']['param']['SecondaryBank']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select></td>
	        <td>&nbsp;</td>
	      </tr>-->
	      <tr>
	        <!--<th scope="row"><label>Bank Account No</label></th>
            <td><input name="BankAccountNo" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['BankAccountNo']; ?>" size="" /></td>-->
	        
	        <th scope="row"><label>Phone No</label></th>
	        <td><input name="PhoneNo" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PhoneNo']; ?>" size="" /></td>
                <td>&nbsp;</td>
                <th scope="row"><label>Fax No</label></th>
	        <td><input name="FaxNo" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['FaxNo']; ?>" size="" /></td>
	      </tr>
	      <!--<tr>
	      	<th scope="row"><label>Secondary Bank Account No</label></th>
            <td><input name="SecondaryBankAccountNo" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['SecondaryBankAccountNo']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	      </tr>-->
	      <!--<tr>
	        <th scope="row"><label>Gender</label></th>
	        <td><select name="GenderID" class="chosen_simple">
	            <option value="" selected="selected">All Gender</option>
	            <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>" <?php if ($_SESSION['agent_AdminIndex']['param']['GenderID']==$data['content_param']['gender_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
	        <td>&nbsp;</td>
	        
	      </tr>-->
	      <!--<tr>
	        <th scope="row"><label>Date of Birth (From)</label></th>
	        <td><input name="DOBFrom" class="datepicker" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['DOBFrom']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Nationality</label></th>
	        <td><select name="Nationality" class="chosen_full">
	            <option value="" selected="selected">All Nationality</option>
	            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$_SESSION['agent_AdminIndex']['param']['Nationality']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['NameShort']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>-->
	      <!--<tr>
	        <th scope="row"><label>Date of Birth (To)</label></th>
	        <td><input name="DOBTo" class="defaultdatepicker" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['DOBTo']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Passport</label></th>
	        <td><input name="Passport" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Passport']; ?>" size="" /></td>
	      </tr>-->
	      <tr>
	        <!--<th scope="row"><label>NRIC</label></th>
	        <td><input name="NRIC" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['NRIC']; ?>" size="" /></td>-->
                  <th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['agent_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
                <td>&nbsp;</td>
                <th scope="row"><label>Platform Email 1</label></th>
	        <td><input name="PlatformEmail1" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail1']; ?>" size="" /></td>
	      </tr>
	      <!--<tr>
	      	
	      </tr>-->
	      <tr>
	        <th scope="row"><label>Platform Email 2</label></th>
	        <td><input name="PlatformEmail2" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail2']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Platform Email 3</label></th>
	        <td><input name="PlatformEmail3" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail3']; ?>" size="" /></td>
	      </tr>
              <tr>
	        <th scope="row"><label>Platform Email 4</label></th>
	        <td><input name="PlatformEmail4" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail4']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Platform Email 5</label></th>
	        <td><input name="PlatformEmail5" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail5']; ?>" size="" /></td>
	      </tr>
              <tr>
	        <th scope="row"><label>Platform Email 6</label></th>
	        <td><input name="PlatformEmail6" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail6']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Platform Email 7</label></th>
	        <td><input name="PlatformEmail7" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail7']; ?>" size="" /></td>
	      </tr>
              <tr>
	        <th scope="row"><label>Platform Email 8</label></th>
	        <td><input name="PlatformEmail8" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail8']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Platform Email 9</label></th>
	        <td><input name="PlatformEmail9" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail9']; ?>" size="" /></td>
	      </tr>
              <tr>
	        <th scope="row"><label>Platform Email 10</label></th>
	        <td><input name="PlatformEmail10" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PlatformEmail10']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Remark</label></th>
	        <td><textarea name="Remark" rows="4" class="validate[] full_width"><?php echo $_SESSION['agent_AdminIndex']['param']['Remark']; ?></textarea></td>
	      </tr>
              <tr>
	        <th scope="row"><label>Host</label></th>
	        <td><input name="Host" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Host']; ?>" size="" /></td>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/index?page=all">
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
    <a href='/admin/agent/add/'>
    <input type="button" class="button" value="Create Agent">
    </a><a href='/admin/agent/manage?page=all'>
    <input type="button" class="button" value="Bulk Update">
    </a>
<!--    <a href='/admin/agent/manage/'>
    <input type="button" class="button" value="Bulk Update">
    </a>  -->
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']!='2') { ?>
    <a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a>
    <?php } ?>
    <?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" Mobilespacing="0" Mobilepadding="0">
  <tr>
    <th>Name</th>
    <th>Username</th>
    <!--<th>Gender</th>-->
    <th>Company URL</th>
    <th>Host</th>
<!--    <th>Register Link</th>
    <th>Member Link</th>-->
    <th>Bank</th>
    <th>Bank Account No</th>
<!--<th>Secondary Bank</th>
    <th>Secondary Bank Account No</th>
    <th>Date Of Birth</th>-->
    <!--<th>NRIC</th>-->
    <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
    <!--<th>Nationality</th>-->  
    <?php } else { ?>
    <!--<th>Passport</th>-->
    <?php } ?>
    <th>Phone No</th>
    <th>Fax No</th>
    <th>Mobile No</th>
    <th>Email</th>
    <th>Remark</th>
<!--    <th>Platform Email 1</th>
    <th>Platform Email 2</th>
    <th>Platform Email 3</th>
    <th>Platform Email 4</th>
    <th>Platform Email 5</th>
    <th>Platform Email 6</th>
    <th>Platform Email 7</th>
    <th>Platform Email 8</th>
    <th>Platform Email 9</th>
    <th>Platform Email 10</th>-->
    <th>Profit Sharing</th>
    <th class="center">Enabled</th>
    <th class="center">View Transactions</th>

    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <th>&nbsp;</th>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <th>&nbsp;</th>
    <?php } ?>

  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
      <td><div><a class="member_title" href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/edit/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Name']; ?></a></div></td>
    <td><?php echo $data['content'][$i]['Username']; ?></td>
    <!--<td><?php echo $data['content'][$i]['GenderID']; ?></td>-->
    <td><?php echo $data['content'][$i]['Company']; ?></td>
    <td><?php echo $data['content'][$i]['Host']; ?></td>
<!--    <td><a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/register?rid=<?php echo urlencode(base64_encode($data['content'][$i]['ID'])); ?>" target="_blank"><?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/register?rid=<?php echo urlencode(base64_encode($data['content'][$i]['ID'])); ?></a></td>
    <td><a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/login?rid=<?php echo urlencode(base64_encode($data['content'][$i]['ID'])); ?>" target="_blank"><?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/login?rid=<?php echo urlencode(base64_encode($data['content'][$i]['ID'])); ?></a></td>-->
    <td><?php echo $data['content'][$i]['Bank']; ?></td>
    <td><?php echo $data['content'][$i]['BankAccountNo']; ?></td>
    <!--<td><?php echo $data['content'][$i]['SecondaryBank']; ?></td>-->
    <!--<td><?php echo $data['content'][$i]['SecondaryBankAccountNo']; ?></td>-->
    <!--<td><?php echo $data['content'][$i]['DOB']; ?></td>-->
    <!--<td><?php echo $data['content'][$i]['Nationality']; ?></td>-->
    <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
        <!--<td><?php echo $data['content'][$i]['NRIC']; ?></td>-->
    <?php } else { ?>
        <!--<td><?php echo $data['content'][$i]['Passport']; ?></td>-->
    <?php } ?>
    <td><?php echo $data['content'][$i]['PhoneNo']; ?></td> 
    <td><?php echo $data['content'][$i]['FaxNo']; ?></td> 
    <td><?php echo $data['content'][$i]['MobileNo']; ?></td>
    <td><?php echo $data['content'][$i]['Email']; ?></td>
    <td><?php echo $data['content'][$i]['Remark']; ?></td>
<!--    <td><?php echo $data['content'][$i]['PlatformEmail1']; ?></td>
    <td><?php echo $data['content'][$i]['PlatformEmail2']; ?></td>
    <td><?php echo $data['content'][$i]['PlatformEmail3']; ?></td>
    <td><?php echo $data['content'][$i]['PlatformEmail4']; ?></td>
    <td><?php echo $data['content'][$i]['PlatformEmail5']; ?></td>
    <td><?php echo $data['content'][$i]['PlatformEmail6']; ?></td>
    <td><?php echo $data['content'][$i]['PlatformEmail7']; ?></td>
    <td><?php echo $data['content'][$i]['PlatformEmail8']; ?></td>
    <td><?php echo $data['content'][$i]['PlatformEmail9']; ?></td>
    <td><?php echo $data['content'][$i]['PlatformEmail10']; ?></td>-->
    <td><?php echo $data['content'][$i]['Profitsharing']; ?>%</td>
    <td><?php echo $data['content'][$i]['Enabled']; ?></td>
    
    <td class="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/agent/<?php echo $data['content'][$i]['ID']; ?>'>View Transaction</a></td>
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php } ?>
    <!--<?php if ($_SESSION['admin']['Profile']=='1') { ?>
<td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>-->
    <?php } ?>    
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
