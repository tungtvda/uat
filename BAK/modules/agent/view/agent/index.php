<?php if ($data['page']['agent_delete']['ok']==1) { ?>
<div class="notify">Agent deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_noMobile"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" Mobilespacing="0" Mobilepadding="0">
	      <tr>
	        <!--<th scope="row"><label>Agent</label></th>
	        <td><input name="Agent" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Agent']; ?>" size="" /></td>-->
	        <th scope="row"><label>Week</label></th>
	        <td><span class="this-week">This week</span> | <span class="last-week">Last Week</span></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <!--<th scope="row"><label>Agent</label></th>
	        <td><input name="Agent" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Agent']; ?>" size="" /></td>-->
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
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if ($data['content_param']['bank_list'][$i]['Label']==$_SESSION['agent_AdminIndex']['param']['Bank']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select>                
                </td>
	        <td>&nbsp;</td>
	        
	        <th scope="row"><label>Mobile No</label></th>
	        <td><input name="MobileNo" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['MobileNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	      	<th scope="row"><label>Secondary Bank</label></th>
            <td><select name="Bank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if ($data['content_param']['bank_list'][$i]['Label']==$_SESSION['agent_AdminIndex']['param']['SecondaryBank']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select></td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Bank Account No</label></th>
            <td><input name="BankAccountNo" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['BankAccountNo']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Phone No</label></th>
	        <td><input name="PhoneNo" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['PhoneNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	      	<th scope="row"><label>Secondary Bank Account No</label></th>
            <td><input name="SecondaryBankAccountNo" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['SecondaryBankAccountNo']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Gender</label></th>
	        <td><select name="GenderID" class="chosen_simple">
	            <option value="" selected="selected">All Gender</option>
	            <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>" <?php if ($_SESSION['agent_AdminIndex']['param']['GenderID']==$data['content_param']['gender_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Fax No</label></th>
	        <td><input name="FaxNo" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['FaxNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
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
	      </tr>
	      <tr>
	        <th scope="row"><label>Date of Birth (To)</label></th>
	        <td><input name="DOBTo" class="defaultdatepicker" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['DOBTo']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Passport</label></th>
	        <td><input name="Passport" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['Passport']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>NRIC</label></th>
	        <td><input name="NRIC" type="text" value="<?php echo $_SESSION['agent_AdminIndex']['param']['NRIC']; ?>" size="" /></td>
            <td>&nbsp;</td>
            <th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['agent_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
	      </tr>
	      <!--<tr>
	      	
	      </tr>-->
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/index?page=all">
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
    <a href='/agent/agent/add/'>
    <input type="button" class="button" value="Create Agent">
    </a><a href='/agent/agent/manage?page=all'>
    <input type="button" class="button" value="Bulk Update">
    </a>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']!='2') { ?>
    <a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/export/AdminIndex'>
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
    <th>Information</th>
    <th class="center">Prompt</th>
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
    <td style="vertical-align: top"><div><a class="member_title" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/edit/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Name']; ?></a> <span class="member_dob">(<?php echo $data['content'][$i]['GenderID']; ?>)</span></div>
        <strong>Username:</strong><br /><?php echo $data['content'][$i]['Username']; ?><br /><br />
        <strong>Company URL:</strong><br /><?php echo $data['content'][$i]['Company']; ?><br /><br />
        <strong>Bank:</strong><br /><?php echo $data['content'][$i]['Bank']; ?> | <?php echo $data['content'][$i]['BankAccountNo']; ?><br /><br />
        <strong>Secondary Bank:</strong><br /><?php echo $data['content'][$i]['SecondaryBank']; ?> | <?php echo $data['content'][$i]['SecondaryBankAccountNo']; ?><br /><br />
        <strong>My Link:</strong><br /><a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/register?rid=<?php echo urlencode(base64_encode($data['content'][$i]['ID'])); ?>" target="_blank"><?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/register?rid=<?php echo urlencode(base64_encode($data['content'][$i]['ID'])); ?></a><br /><br />
    </td>
    <td style="vertical-align: top">
        <span class="member_inner_header">Date of Birth:</span> <?php echo $data['content'][$i]['DOB']; ?><br />
        <span class="member_inner_header">Nationality:</span> <?php echo $data['content'][$i]['Nationality']; ?><br />
        <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
        <span class="member_inner_header">NRIC No:</span> <?php echo $data['content'][$i]['NRIC']; ?><br />
        <?php } else { ?>
        <span class="member_inner_header">Passport No:</span> <?php echo $data['content'][$i]['Passport']; ?><br />
        <?php } ?>
        <br />
        <span class="member_inner_header">Mobile No:</span> <?php echo $data['content'][$i]['MobileNo']; ?><br />
        <span class="member_inner_header">Phone No:</span> <?php echo $data['content'][$i]['PhoneNo']; ?><br />
        <span class="member_inner_header">Fax No:</span> <?php echo $data['content'][$i]['FaxNo']; ?><br />
        <span class="member_inner_header">Email:</span> <?php echo $data['content'][$i]['Email']; ?><br /><br />
        <span class="member_inner_header">Profit Sharing:</span> <?php echo $data['content'][$i]['Report']['Profitsharing']; ?>%</td><br />
        
    <td class="center"><?php echo $data['content'][$i]['Prompt']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td class="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/agent/<?php echo $data['content'][$i]['ID']; ?>'>View Transaction</a></td>
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php } ?>
    <!--<?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>-->
    <?php } ?>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
