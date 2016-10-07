<?php if ($_SESSION['superid']=='1') { ?>
<div id="member_profile_wrapper">
	<div class="row">
		<div class="small-12 medium-12 large-12 columns">
			<?php if ($data['page']['member_register']['error']['count']>0) { ?>
			    <?php if ($data['page']['member_register']['error']['count']>0) { ?>
				    <div class="alert-box alert radius">
				        <ul>
				            <?php if ($data['page']['member_register']['error']['NRIC']==1) { ?><li><?php echo Helper::translate("The NRIC number ", "member-profile-nric-1"); ?> <?php echo $data['form_param']['NRIC']; ?> <?php echo Helper::translate("exists in our records. Each member can only register once. Please try again with another NRIC number.", "member-profile-nric-2"); ?></li><?php } ?>
				            <?php if ($data['page']['member_register']['error']['Passport']==1) { ?><li><?php echo Helper::translate("The Passport number ", "member-profile-passport-1"); ?> <?php echo $data['form_param']['Passport']; ?> <?php echo Helper::translate("exists in our records. Each member can only register once. Please try again with another Passport number.", "member-profile-passport-2"); ?></li><?php } ?>
				        </ul>
				    </div>
				<?php } ?>
			<?php } else { ?>
                <?php if ($data['page']['member_profile']['ok']==1) { ?>
                    <div class="alert-box success radius"><?php echo Helper::translate("Profile updated successfully.", "member-profile-updated"); ?></div>
                <?php } ?>
            <?php } ?>
	    </div>
		<div class="small-12 medium-12 large-12 end columns">
		    <form id="profile_form" name="profile_form" class="common_block common_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/profileprocess">
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Username" class="inline"><?php echo Helper::translate("Username", "member-profile-username"); ?></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[required] disabled" name="Username" id="Username" placeholder="(You will use this to login)" value="<?php echo (($data['form_param']['Username']!="") ? $data['form_param']['Username'] : $data['content'][0]['Username']); ?>" readonly="readonly" />
			    	</div>
		    	</div>
		    	<hr />
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Name" class="inline-long"><?php echo Helper::translate("Full Name", "member-profile-fullname"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[required] disabled" name="Name" id="Name" placeholder="" value="<?php echo (($data['form_param']['Name']!="") ? $data['form_param']['Name'] : $data['content'][0]['Name']); ?>" readonly="readonly" />
			    	</div>
		    	</div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="FacebookID" class="inline-long"><?php echo Helper::translate("Facebook ID", "member-profile-facebookID"); ?></label>
                    </div>
                    <div class="small-12 medium-12 large-9 columns">
                        <input type="text" class="validate[required]" name="FacebookID" id="FacebookID" placeholder="Facebook Email or ID" value="<?php echo (($data['form_param']['FacebookID']!="") ? $data['form_param']['FacebookID'] : $data['content'][0]['FacebookID']); ?>" />
                    </div>
                </div>
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="GenderID" class="inline"><?php echo Helper::translate("Gender", "member-profile-gender"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<select name="GenderID" class="chosen_simple_full">
				        	<?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
				            <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>"
				            	<?php if ($data['form_param']['GenderID']!="") { ?>
				            	<?php if ($data['content_param']['gender_list'][$i]['ID']==$data['form_param']['GenderID']) { ?>selected="selected"<?php } ?>
				                <?php } else { ?>
				                <?php if ($data['content_param']['gender_list'][$i]['ID']==$data['content'][0]['GenderID']) { ?>selected="selected"<?php } ?>
				                <?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
				            <?php } ?>
				        </select>
			    	</div>
		    	</div>
			   
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Nationality" class="inline"><?php echo Helper::translate("Nationality", "member-profile-nationality"); ?></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<select name="Nationality" id="Nationality" class="chosen_full">
				        	<?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
				        	<option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>"
				            	<?php if ($data['form_param']['Nationality']!="") { ?>
				            	<?php if ($data['content_param']['country_list'][$i]['ID']==$data['form_param']['Nationality']) { ?>selected="selected"<?php } ?>
				            	<?php } else { ?>
				            	<?php if ($data['content_param']['country_list'][$i]['ID']==$data['content'][0]['Nationality']) { ?> selected="selected"<?php } ?>
				            	<?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
			          		<?php } ?>
				        </select>
			    	</div>
		    	</div>
			    <div id="nric_box" class="row
				    <?php if ($data['form_param']['Nationality']!="") { ?>
			        <?php if ($data['form_param']['Nationality']!=151) { ?>disappear<?php } ?>
			        <?php } else { ?>
			        <?php if ($data['content'][0]['Nationality']!=151) { ?>disappear<?php } ?>
			        <?php } ?>">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="NRIC" class="inline"><?php echo Helper::translate("NRIC", "member-profile-nric"); ?></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[custom[NRIC]]" name="NRIC" id="NRIC" placeholder="(e.g. 880101-14-5566)" value="<?php echo (($data['form_param']['NRIC']!="") ? $data['form_param']['NRIC'] : $data['content'][0]['NRIC']); ?>" />
			    	</div>
		    	</div>
			    <div id="passport_box" class="row
					<?php if ($data['form_param']['Nationality']!="") { ?>
			        <?php if ($data['form_param']['Nationality']==151) { ?>disappear<?php } ?>
			        <?php } else { ?>
			        <?php if ($data['content'][0]['Nationality']==151) { ?>disappear<?php } ?>
			        <?php } ?>">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Passport" class="inline"><?php echo Helper::translate("Passport", "member-profile-passport"); ?></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[]" name="Passport" id="Passport" placeholder="" value="<?php echo (($data['form_param']['Passport']!="") ? $data['form_param']['Passport'] : $data['content'][0]['Passport']); ?>" />
			    	</div>
		    	</div>
                <hr />
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Company" class="inline"><?php echo Helper::translate("Company", "member-profile-company"); ?></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[]" name="Company" id="Company" placeholder="" value="<?php echo (($data['form_param']['Company']!="") ? $data['form_param']['Company'] : $data['content'][0]['Company']); ?>" />
			    	</div>
		    	</div>
		    	<hr />

                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="Bank" class="inline"><?php echo Helper::translate("Bank", "member-profile-bank"); ?></label>
                    </div>
                    <div class="small-12 medium-12 large-9 columns">
                        <input type="text" class="validate[] disabled" name="Bank" id="Bank" placeholder="" value="<?php echo (($data['form_param']['Bank']!="") ? $data['form_param']['Bank'] : $data['content'][0]['Bank']); ?>" readonly="readonly" />
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="BankAccountNo" class="inline"><?php echo Helper::translate("Bank Account No", "member-profile-bankaccountno"); ?></label>
                    </div>
                    <div class="small-12 medium-12 large-9 columns">
                        <input type="text" class="validate[] disabled" name="BankAccountNo" id="BankAccountNo" placeholder="" value="<?php echo (($data['form_param']['BankAccountNo']!="") ? $data['form_param']['BankAccountNo'] : $data['content'][0]['BankAccountNo']); ?>" readonly="readonly" />
                    </div>
                </div>
                
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="MobileNo" class="inline"><?php echo Helper::translate("Mobile No", "member-profile-mobileno"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[required,custom[mobileNo],minSize[10]]" name="MobileNo" id="MobileNo" placeholder="(e.g. 019225XXXX. Compulsory for SMS verification)" maxlength="15" value="<?php echo (($data['form_param']['MobileNo']!="") ? $data['form_param']['MobileNo'] : $data['content'][0]['MobileNo']); ?>" />
			    	</div>
		    	</div>
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="PhoneNo" class="inline"><?php echo Helper::translate("Phone No", "member-profile-phoneno"); ?></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[custom[phoneNo],minSize[9]]" name="PhoneNo" id="PhoneNo" placeholder="(e.g. 032054XXXX)" maxlength="15" value="<?php echo (($data['form_param']['PhoneNo']!="") ? $data['form_param']['PhoneNo'] : $data['content'][0]['PhoneNo']); ?>" />
			    	</div>
		    	</div>
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="FaxNo" class="inline"><?php echo Helper::translate("Fax No", "member-profile-faxno"); ?></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[custom[faxNo],minSize[9]]" name="FaxNo" id="FaxNo" placeholder="(e.g. 032054XXXX)" maxlength="15" value="<?php echo (($data['form_param']['FaxNo']!="") ? $data['form_param']['FaxNo'] : $data['content'][0]['FaxNo']); ?>" />
			    	</div>
		    	</div>
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Email" class="inline"><?php echo Helper::translate("Email", "member-profile-email"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[required,custom[email]]" name="Email" id="Email" placeholder="(e.g. your.name@domain.com)" value="<?php echo (($data['form_param']['Email']!="") ? $data['form_param']['Email'] : $data['content'][0]['Email']); ?>" />
			    	</div>
		    	</div>
		    	<div class="row">
			    	<div class="small-12 medium-12 large-12 columns">
			    		&nbsp;
			    	</div>
		    	</div>
		    	<div class="row">
			    	<div class="small-12 medium-12 large-9 large-offset-3 columns">
                        <input type="hidden" id="ProfileTrigger" name="ProfileTrigger" value="1" />
			            <input class="button" type="submit" name="submit" id="submit" value="Update" />
			    	</div>
		    	</div>
			</form>
	    </div>
	</div>
</div>
<?php } else { ?> 
<?php if ($data['page']['member_profile']['error']['count']>0) { ?>
    <div class="error">
        <ul>
            <?php if ($data['page']['member_profile']['error']['NRIC']==1) { ?><li><?php echo Helper::translate("The NRIC number ", "member-profile-nric-1"); ?> <?php echo $data['form_param']['NRIC']; ?> <?php echo Helper::translate("exists in our records. Each member can only register once. Please try again with another NRIC number.", "member-profile-nric-2"); ?></li><?php } ?>
            <?php if ($data['page']['member_profile']['error']['Passport']==1) { ?><li><?php echo Helper::translate("The Passport number ", "member-profile-passport-1"); ?> <?php echo $data['form_param']['Passport']; ?> <?php echo Helper::translate("exists in our records. Each member can only register once. Please try again with another Passport number.", "member-profile-passport-2"); ?></li><?php } ?>
        </ul>
    </div>
<?php } else { ?>
    <?php if ($data['page']['member_profile']['ok']==1) { ?>
    <div class="notify"><?php echo Helper::translate("Profile updated successfully.", "member-profile-updated"); ?></div>
    <?php } ?>
<?php } ?>
<form name="profile_form" class="admin_table_nocell"  id="profile_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/profileprocess/" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Username", "member-profile-username"); ?></label></th>
      <td><input name="Username" type="text" class="validate[] disabled" value="<?php echo $data['content'][0]['Username']; ?>" size="20" readonly="readonly" placeholder="As in NRIC" /><span class="label_hint"><?php echo Helper::translate("(Your login username)", "member-profile-username-note"); ?></span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Full Name", "member-profile-fullname"); ?><span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required] disabled" value="<?php echo (($data['form_param']['Name']!="") ? $data['form_param']['Name'] : $data['content'][0]['Name']); ?>" readonly="readonly" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Facebook ID", "member-profile-facebookID"); ?></label></th>
      <td><input name="FacebookID" type="text" class="validate[]" value="<?php echo $data['content'][0]['FacebookID']; ?>" size="40"  placeholder ="Facebook Email or ID" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Gender", "member-profile-gender"); ?><span class="label_required">*</span></label></th>
      <td><select name="GenderID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>"
              <?php if ($data['form_param']['GenderID']!="") { ?>
              <?php if ($data['content_param']['gender_list'][$i]['ID']==$data['form_param']['GenderID']) { ?>selected="selected"<?php } ?>
              <?php } else { ?>
              <?php if ($data['content_param']['gender_list'][$i]['ID']==$data['content'][0]['GenderID']) { ?>selected="selected"<?php } ?>
              <?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
<!--    <tr>
      <th scope="row"><label><?php echo Helper::translate("Date of Birth", "member-profile-dateofbirth"); ?></label></th>
      <td><input name="DOB" id="DOB" type="text" class="validate[custom[dmyDate]] datepicker" value="<?php echo (($data['form_param']['DOB']!="") ? $data['form_param']['DOB'] : $data['content'][0]['DOB']); ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>-->
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Nationality", "member-profile-nationality"); ?></label></th>
      <td><select name="Nationality" id="Nationality" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>"
              <?php if ($data['form_param']['Nationality']!="") { ?>
              <?php if ($data['content_param']['country_list'][$i]['ID']==$data['form_param']['Nationality']) { ?>selected="selected"<?php } ?>
              <?php } else { ?>
              <?php if ($data['content_param']['country_list'][$i]['ID']==$data['content'][0]['Nationality']) { ?> selected="selected"<?php } ?>
              <?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tbody id="nric_box"
        <?php if ($data['form_param']['Nationality']!="") { ?>
        <?php if ($data['form_param']['Nationality']!=151) { ?>class="invisible"<?php } ?>
        <?php } else { ?>
        <?php if ($data['content'][0]['Nationality']!=151) { ?>class="invisible"<?php } ?>
        <?php } ?>>
        <tr>
          <th scope="row"><label><?php echo Helper::translate("NRIC", "member-profile-nric"); ?></label></th>
          <td><input name="NRIC" id="NRIC" type="text" class="validate[custom[NRIC]]" value="<?php echo (($data['form_param']['NRIC']!="") ? $data['form_param']['NRIC'] : $data['content'][0]['NRIC']); ?>" size="20" /><span class="label_hint">(e.g. 880101-14-5566)</span></td>
        </tr>
    </tbody>
    <tbody id="passport_box"
        <?php if ($data['form_param']['Nationality']!="") { ?>
        <?php if ($data['form_param']['Nationality']==151) { ?>class="invisible"<?php } ?>
        <?php } else { ?>
        <?php if ($data['content'][0]['Nationality']==151) { ?>class="invisible"<?php } ?>
        <?php } ?>>
        <tr>
          <th scope="row"><label><?php echo Helper::translate("Passport", "member-profile-passport"); ?></label></th>
          <td><input name="Passport" type="text" class="validate[]" value="<?php echo (($data['form_param']['Passport']!="") ? $data['form_param']['Passport'] : $data['content'][0]['Passport']); ?>" size="20" /></td>
        </tr>
    </tbody>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Company", "member-profile-company"); ?></label></th>
      <td><input name="Company" type="text" class="validate[]" value="<?php echo (($data['form_param']['Company']!="") ? $data['form_param']['Company'] : $data['content'][0]['Company']); ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Bank", "member-profile-bank"); ?></label></th>
      <td><input name="Bank" type="text" class="validate[] disabled" value="<?php echo (($data['form_param']['Bank']!="") ? $data['form_param']['Bank'] : $data['content'][0]['Bank']); ?>" size="40" readonly="readonly" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Bank Account No", "member-profile-bankaccountno"); ?></label></th>
      <td><input name="BankAccountNo" type="text" class="validate[] disabled" value="<?php echo (($data['form_param']['BankAccountNo']!="") ? $data['form_param']['BankAccountNo'] : $data['content'][0]['BankAccountNo']); ?>" size="40" readonly="readonly" /></td>
    </tr>
<!--    <tr>
      <th scope="row"><label><?php echo Helper::translate("Secondary Bank", "member-profile-secondarybank"); ?></label></th>
      <td><input name="SecondaryBank" type="text" class="validate[] disabled" value="<?php echo (($data['form_param']['SecondaryBank']!="") ? $data['form_param']['SecondaryBank'] : $data['content'][0]['SecondaryBank']); ?>" size="40" readonly="readonly" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Secondary Bank Account No", "member-profile-secondarybankaccountno"); ?></label></th>
      <td><input name="SecondaryBankAccountNo" type="text" class="validate[] disabled" value="<?php echo (($data['form_param']['SecondaryBankAccountNo']!="") ? $data['form_param']['SecondaryBankAccountNo'] : $data['content'][0]['SecondaryBankAccountNo']); ?>" size="40" readonly="readonly" /></td>
    </tr>-->
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Mobile No", "member-profile-mobileno"); ?><span class="label_required">*</span></label></th>
      <td><input name="MobileNo" type="text" class="validate[required,custom[mobileNo],minSize[9]]" value="<?php echo (($data['form_param']['MobileNo']!="") ? $data['form_param']['MobileNo'] : $data['content'][0]['MobileNo']); ?>" size="20" maxlength="15" /><span class="label_hint"><?php echo Helper::translate("(E.g. 2255667. Compulsory for SMS verification)", "member-profile-mobileno-sms"); ?></span></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Phone No", "member-profile-phoneno"); ?></label></th>
      <td><input name="PhoneNo" type="text" class="validate[custom[phoneNo],minSize[9]]" value="<?php echo (($data['form_param']['PhoneNo']!="") ? $data['form_param']['PhoneNo'] : $data['content'][0]['PhoneNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Fax No", "member-profile-faxno"); ?></label></th>
      <td><input name="FaxNo" type="text" class="validate[custom[faxNo],minSize[9]]" value="<?php echo (($data['form_param']['FaxNo']!="") ? $data['form_param']['FaxNo'] : $data['content'][0]['FaxNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Email", "member-profile-email"); ?><span class="label_required">*</span></label></th>
      <td><input name="Email" type="text" class="validate[required,custom[email]]" value="<?php echo (($data['form_param']['Email']!="") ? $data['form_param']['Email'] : $data['content'][0]['Email']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <input type="hidden" id="ProfileTrigger" name="ProfileTrigger" value="1" />
      <td><input type="submit" name="submit" value="<?php echo Helper::translate("Update", "member-profile-update"); ?>" class="button" /></td>
    </tr>
  </table>
</form>   
<?php } ?>    
    
    
