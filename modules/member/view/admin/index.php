<?php if ($data['page']['member_delete']['ok']==1) { ?>
<div class="notify">Member deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_noMobile"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/member/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" Mobilespacing="0" Mobilepadding="0">
	      <tr>
	      	<th scope="row"><label>Agent</label></th>
<!--	      	<td><select name="Agent" class="chosen_full">
	            <option value="">All Agents</option>
	            <?php for ($i=0; $i<$data['content_param']['agent_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['agent_list'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list'][$i]['ID']== $_SESSION['member_AdminIndex']['param']['Agent']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list'][$i]['Name']; ?> - <?php echo $data['content_param']['agent_list'][$i]['ID']; ?></option>
	            <?php } ?>
	          </select></td>-->

                  <td>
                    <select name="Agent" class="chosen_full">
                    <option value="">--Select All--</option>
                    <?php for ($g=0; $g<$data['content_param']['agent_list1']['count']; $g++) { ?>
                    <option value="<?php echo $data['content_param']['agent_list1'][$g]['ID']; ?>" <?php if($data['content_param']['agent_list1'][$g]['ID']==$_SESSION['member_AdminIndex']['param']['Agent']){ ?>selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list1'][$g]['Name']; ?> - <?php echo $data['content_param']['agent_list1'][$g]['ID']; ?> | <?php echo $data['content_param']['agent_list1'][$g]['Company']; ?></option>
	            <?php Helper::agentOptionList($data['content_param']['agent_list1'][$g]['Child'], $_SESSION['member_AdminIndex']['param']['Agent']); ?>
                    <?php } ?>
                    <?php for ($i=0; $i<$data['content_param']['agent_list2']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['agent_list2'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list2'][$i]['ID']==$_SESSION['member_AdminIndex']['param']['Agent']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list2'][$i]['Name']; ?> - <?php echo $data['content_param']['agent_list2'][$i]['ID']; ?> | <?php echo $data['content_param']['agent_list2'][$i]['Company']; ?></option>
	            <?php } ?>
                    </select>
                </td>

	        <!--<td><input name="Reseller" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['Reseller']; ?>" size="" /></td>-->
	        <td>&nbsp;</td>
	        <th scope="row"><label>Email</label></th>
	        <td><input name="Email" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['Email']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Full Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['Name']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Username</label></th>
	        <td><input name="Username" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['Username']; ?>" size="" /></td>
	      </tr>
          <tr>
            <th scope="row"><label>Date Registered (From)</label></th>
            <td><input name="DateRegisteredFrom" class="datepicker" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['DateRegisteredFrom']; ?>" size="" />(dd-mm-yyyy hh:mm:ss)</td>
            <td>&nbsp;</td>
            <th scope="row"><label>Date Registered (To)</label></th>
            <td><input name="DateRegisteredTo" class="defaultdatepicker" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['DateRegisteredTo']; ?>" size="" />(dd-mm-yyyy hh:mm:ss)</td>
          </tr>
	      <tr>
	        <th scope="row"><label>Bank</label></th>
            <td>
                <select name="Bank" class="validate[] chosen">
                    <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if ($data['content_param']['bank_list'][$i]['Label']==$_SESSION['member_AdminIndex']['param']['Bank']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select>
                </td>
	        <td>&nbsp;</td>

	        <th scope="row"><label>Mobile No</label></th>
	        <td><input name="MobileNo" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['MobileNo']; ?>" size="" /></td>
	      </tr>
              <!--<tr>
	      	<th scope="row"><label>Secondary Bank</label></th>
            <td><input name="SecondaryBank" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['SecondaryBank']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	      </tr>-->
	      <tr>
	        <th scope="row"><label>Bank Account No</label></th>
            <td><input name="BankAccountNo" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['BankAccountNo']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Phone No</label></th>
	        <td><input name="PhoneNo" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['PhoneNo']; ?>" size="" /></td>
	      </tr>
              <!--<tr>
	      	<th scope="row"><label>Secondary Bank Account No</label></th>
            <td><input name="SecondaryBankAccountNo" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['SecondaryBankAccountNo']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	      </tr>-->
	      <tr>
	        <th scope="row"><label>Gender</label></th>
	        <td><select name="GenderID" class="chosen_simple">
	            <option value="" selected="selected">All Gender</option>
	            <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>" <?php if ($_SESSION['member_AdminIndex']['param']['GenderID']==$data['content_param']['gender_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Fax No</label></th>
	        <td><input name="FaxNo" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['FaxNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
              <!--<th scope="row"><label>Date of Birth (From)</label></th>
	        <td><input name="DOBFrom" class="datepicker" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['DOBFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>-->

	        <th scope="row"><label>Nationality</label></th>
	        <td><select name="Nationality" class="chosen_full">
	            <option value="" selected="selected">All Nationality</option>
	            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$_SESSION['member_AdminIndex']['param']['Nationality']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['NameShort']; ?></option>
	            <?php } ?>
	          </select></td>
                  <td>&nbsp;</td>
                  <th scope="row"><label>Facebook ID</label></th>
	        <td><input name="FacebookID" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['FacebookID']; ?>" size="" /></td>
	      </tr>
	      <tr>
                  <th scope="row"><label>Company</label></th>
	        <td><input name="Company" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['Company']; ?>" size="" /></td>
              <!--<th scope="row"><label>Date of Birth (To)</label></th>
	        <td><input name="DOBTo" class="datepicker" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['DOBTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>-->
	        <td>&nbsp;</td>
	        <th scope="row"><label>Passport</label></th>
	        <td><input name="Passport" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['Passport']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>NRIC</label></th>
	        <td><input name="NRIC" type="text" value="<?php echo $_SESSION['member_AdminIndex']['param']['NRIC']; ?>" size="" /></td>
            <td>&nbsp;</td>
            <th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['member_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
	      </tr>
	      <tr>
	      	<td>&nbsp;</td>
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
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/member/index?page=all">
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
    <a href='/admin/member/add/'>
    <input type="button" class="button" value="Create Member">
    </a>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']!='2') { ?>
    <a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/member/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a>
    <?php } ?>
    <?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" Mobilespacing="0" Mobilepadding="0">
  <tr>
    <th>Agent</th>
    <th>Name</th>
    <th>Username</th>
    <th>Gender</th>
    <!-- <th>Company</th> -->
    <th>Bank</th>
    <th>Bank Account No</th>
    <!--<th>Secondary Bank</th>
    <th>Secondary Bank Account No</th>-->
    <!--<th>Date Of Birth</th>
    <th>NRIC</th>
    <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
    <th>Nationality</th>
    <?php } else { ?>
    <th>Passport</th>
    <?php } ?>
    <th>Phone No</th>
    <th>Fax No</th>-->
    <th>Mobile No</th>
    <th>Email</th>
    <th>Facebook ID</th>
    <th class="center">Enabled</th>
    <th>Date Registered</th>
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <th>&nbsp;</th>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <!--<th>&nbsp;</th>-->
    <?php } ?>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['Agent']; ?></td>
    <td><?php echo $data['content'][$i]['Name']; ?></td>
    <td><?php echo $data['content'][$i]['Username']; ?></td>
    <td><?php echo $data['content'][$i]['GenderID']; ?></td>
    <!-- <td><?php echo $data['content'][$i]['Company']; ?></td> -->
    <td><?php echo $data['content'][$i]['Bank']; ?></td>
    <td><?php echo $data['content'][$i]['BankAccountNo']; ?></td>
<!--<td><?php echo $data['content'][$i]['SecondaryBank']; ?></td>
    <td><?php echo $data['content'][$i]['SecondaryBankAccountNo']; ?></td>
    <td><?php echo $data['content'][$i]['DOB']; ?></td>
    <td><?php echo $data['content'][$i]['Nationality']; ?></td>
    <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
        <td><?php echo $data['content'][$i]['NRIC']; ?></td>
    <?php } else { ?>
        <td><?php echo $data['content'][$i]['Passport']; ?></td>
    <?php } ?>
    <td><?php echo $data['content'][$i]['PhoneNo']; ?></td>
    <td><?php echo $data['content'][$i]['FaxNo']; ?></td>-->
    <td><?php echo $data['content'][$i]['MobileNo']; ?></td>
    <td><?php echo $data['content'][$i]['Email']; ?></td>
    <td><?php echo $data['content'][$i]['FacebookID']; ?></td>
    <td><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><?php echo $data['content'][$i]['DateRegistered']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/member/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <!--<td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/member/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>-->
    <?php } ?>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
