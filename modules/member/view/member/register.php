<?php if ($_SESSION['superid']=='1') { ?>

<div id="member_register_wrapper">
	<div class="row">
        <div class="small-12 medium-12 large-12 columns">
    	    <!--<img src="http://www.topsys777.com/images/safari.gif" width="100%" height="auto" />-->
        </div>
		<div class="small-12 medium-12 large-12 columns">
		    <?php if ($data['page']['member_register']['error']['count']>0) { ?>
			    <div class="alert-box alert radius">
			        <ul>
			            <?php if ($data['page']['member_register']['error']['Username']==1) { ?><li><?php echo Helper::translate("The username ", "member-register-username-1"); ?> "<?php echo $data['form_param']['Username']; ?>" <?php echo Helper::translate("is taken. Please try again with another username.", "member-register-username-2"); ?></li><?php } ?>
                                     <?php if ($data['page']['member_register']['error']['Email']==1) { ?><li><?php echo Helper::translate("The email ", "member-register-username-1"); ?> "<?php echo $data['form_param']['Email']; ?>" <?php echo Helper::translate("is taken. Please try again with another email.", "member-register-username-2"); ?></li><?php } ?>
			            <?php if ($data['page']['member_register']['error']['NRIC']==1) { ?><li><?php echo Helper::translate("The NRIC number ", "member-register-nric-1"); ?> <?php echo $data['form_param']['NRIC']; ?> <?php echo Helper::translate(" exists in our records. Each member can only register once. Please try again with another NRIC number. ", "member-register-nric-2"); ?></li><?php } ?>
			            <?php if ($data['page']['member_register']['error']['Passport']==1) { ?><li><?php echo Helper::translate("The Passport number", "member-register-passport-1"); ?> <?php echo $data['form_param']['Passport']; ?> <?php echo Helper::translate("exists in our records. Each member can only register once. Please try again with another Passport number.", "member-register-passport-2"); ?></li><?php } ?>
			            <?php if ($data['page']['member_register']['error']['SQ']==1) { ?><li><?php echo Helper::translate("The Security Question is answered incorrectly. Please try again.", "member-register-security"); ?></li><?php } ?>
                        <?php if ($data['page']['member_register']['error']['Bank']==1) { ?><li><?php echo Helper::translate("You had an existing account with us. Please contact our 24 hours service representative if you like to create additional account.", "member-register-bank-duplicated"); ?></li><?php } ?>
			        </ul>
			    </div>
			<?php } ?>
			<p><?php echo Helper::translate("Creating your account with us is easy! Start by filling up form below:", "member-register-message"); ?></p>
	    </div>
		<div class="small-12 medium-12 large-12 end columns">
		    <form id="add_form" name="add_form" class="common_block common_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/registerprocess">
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Name" class="inline-long"><?php echo Helper::translate("Full Name", "member-register-fullname"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<span class="red">(The name must match with your bank account name for withdrawal.)</span><br />
			    		<input type="text" class="validate[required]" name="Name" id="Name" placeholder="As in NRIC" value="<?php echo $data['form_param']['Name']; ?>" />
			    	</div>
		    	</div>
		    	<?php /* ?>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="FacebookID" class="inline-long"><?php echo Helper::translate("Facebook ID", "member-register-facebookID"); ?></label>
                    </div>
                    <div class="small-12 medium-12 large-9 columns">
                        <input type="text" class="validate[]" name="FacebookID" id="FacebookID" placeholder="Facebook Email or ID" value="<?php echo $data['form_param']['FacebookID']; ?>" />
                    </div>
                </div>
                <?php */ ?>
                <hr />
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="Bank" class="inline-long"><?php echo Helper::translate("Bank", "member-register-bank"); ?><span class="label_required">*</span></label>
                    </div>
                    <div class="small-12 medium-12 large-9 columns">
                        <select name="Bank" class="validate[required]">
                            <option value="">--Please select one--</option>
                            <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                            <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>"
                            <?php if ($data['form_param']['Bank']=="") { ?>
                            <?php if ($data['content_param']['bank_list'][$i]['Label']==$data['form_param']['Bank']) { ?> selected="selected"<?php } ?>
                            <?php } else { ?>
                            <?php if ($data['content_param']['bank_list'][$i]['Label']==$data['form_param']['Bank_list']) { ?> selected="selected"<?php } ?>
                            <?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="BankAccountNo" class="inline-long"><?php echo Helper::translate("Bank Account No", "member-register-bankaccountno"); ?><span class="label_required">*</span></label>
                    </div>
                    <div class="small-12 medium-12 large-9 columns">
                        <span><?php echo Helper::translate("(Bank Account must be real for future smooth withdrawal)", "member-register-bankaccountno-note"); ?></span><br />
                        <input type="text" class="validate[required, custom[integer]]" name="BankAccountNo" id="BankAccountNo" placeholder="" value="<?php echo $data['form_param']['FacebookID']; ?>" />
                    </div>
                </div>
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Username" class="inline"><?php echo Helper::translate("Username", "member-register-username"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[required]" name="Username" id="Username" placeholder="<?php echo Helper::translate("(You will use this to login)", "member-register-login-note"); ?>" value="<?php echo $data['form_param']['Username']; ?>" />
			    	</div>
		    	</div>
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Password" class="inline"><?php echo Helper::translate("New Password", "member-register-newpassword"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="password" class="validate[required,minSize[8]]" name="Password" id="Password" placeholder="" value="" />
			    	</div>
		    	</div>
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="PasswordConfirm" class="inline"><?php echo Helper::translate("Confirm Password", "member-register-confirmpassword"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="password" class="validate[required,equals[Password]]" name="PasswordConfirm" id="PasswordConfirm" placeholder="" value="" />
			    	</div>
		    	</div>
		    	<hr />
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        &nbsp;
                    </div>
                    <div class="small-12 medium-12 large-9 columns">
        		    	<!--<img src="http://www.topsys777.com/images/sms1.jpg" width="100%" height="auto" />-->
                    </div>
                </div>
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="MobileNo" class="inline"><?php echo Helper::translate("Mobile No", "member-register-mobileno"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    	    <?php echo Helper::translate("(E.g. 2255667.)", "member-register-mobileno-note"); ?><br />
			    		<select name="MobilePrefix" style="width:auto; display: inline-block">
                            <option value="6010"<?php if($data['form_param']['MobilePrefix']=='6010'){ ?> selected="selected"<?php } ?>>+6010</option>
                            <option value="6011"<?php if($data['form_param']['MobilePrefix']=='6011'){ ?> selected="selected"<?php } ?>>+6011</option>
                            <option value="6012"<?php if($data['form_param']['MobilePrefix']=='6012'){ ?> selected="selected"<?php } ?>>+6012</option>
                            <option value="6013"<?php if($data['form_param']['MobilePrefix']=='6013'){ ?> selected="selected"<?php } ?>>+6013</option>
                            <option value="6014"<?php if($data['form_param']['MobilePrefix']=='6014'){ ?> selected="selected"<?php } ?>>+6014</option>
                            <option value="6015"<?php if($data['form_param']['MobilePrefix']=='6015'){ ?> selected="selected"<?php } ?>>+6015</option>
                            <option value="6016"<?php if($data['form_param']['MobilePrefix']=='6016'){ ?> selected="selected"<?php } ?>>+6016</option>
                            <option value="6017"<?php if($data['form_param']['MobilePrefix']=='6017'){ ?> selected="selected"<?php } ?>>+6017</option>
                            <option value="6018"<?php if($data['form_param']['MobilePrefix']=='6018'){ ?> selected="selected"<?php } ?>>+6018</option>
                            <option value="6019"<?php if($data['form_param']['MobilePrefix']=='6019'){ ?> selected="selected"<?php } ?>>+6019</option>
                            <option value="65"<?php if($data['form_param']['MobilePrefix']=='65'){ ?> selected="selected"<?php } ?>>+65</option>
                        </select>
                        &nbsp;&nbsp;<input type="text" class="validate[required,custom[mobileNo],minSize[7]]" name="MobileNo" id="MobileNo" placeholder="" maxlength="15" value="<?php echo $data['form_param']['MobileNo']; ?>" style="width:100%; max-width:200px; display: inline-block" />
			    	</div>
		    	</div>
			    <div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Email" class="inline"><?php echo Helper::translate("Email", "member-register-email"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-12 large-9 columns">
			    		<input type="text" class="validate[custom[email]]" name="Email" id="Email" placeholder="(e.g. your.name@domain.com)" value="<?php echo $data['form_param']['Email']; ?>" />
			    	</div>
		    	</div>
		    	<hr />
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="SQ" class="inline-long"><?php echo Helper::translate("Security Question", "member-register-securityquestion"); ?><span class="label_required">*</span></label>
                    </div>
                    <div class="small-12 medium-12 large-9 columns">
                        <?php echo $data['captcha'][0]; ?> + <?php echo $data['captcha'][1]; ?> = <input name="SQ" class="validate[required,custom[number]]" type="text" value="" style="width:50px; display: inline-block" />
                        <input type="hidden" name="C1" value="<?php echo $data['captcha'][0]; ?>" />
                        <input type="hidden" name="C2" value="<?php echo $data['captcha'][1]; ?>" />
                    </div>
                </div>
                <hr />
			    <div class="row">
			    	<div class="small-2 medium-1 large-1 large-offset-3 columns">
			    		<input type="checkbox" class="validate[required]" name="TermsOK" id="TermsOK" value="1" <?php if ($data['form_param']['TermsOK']==1) { ?>checked="checked"<?php } ?> />
					</div>
			    	<div class="small-10 medium-11 large-8 columns">
			    		<label for="TermsOK"><?php echo Helper::translate("I agree that the information provided above is accurate, and I accept the", "member-register-agree-1"); ?> <a href="<?php echo $data['config']['SITE_DIR']; ?>/main/page/terms-of-use" target="_blank"><?php echo Helper::translate("terms of use", "member-register-agree-2"); ?></a> <?php echo Helper::translate("of the website.", "member-register-agree-3"); ?></label>
			    	</div>
		    	</div>
		    	<div class="row">
			    	<div class="small-12 medium-12 large-12 columns">
			    		&nbsp;
			    	</div>
		    	</div>
		    	<div class="row">
			    	<div class="small-12 medium-12 large-9 large-offset-3 columns">
                        <input type="hidden" id="RegisterTrigger" name="RegisterTrigger" value="1" />
                        <input type="hidden" id="form_token" name="form_token" value="<?php echo $_SESSION['form_token']; ?>" />
                        <input type="submit" name="submit" id="submit" value="<?php echo Helper::translate("Submit", "member-register-submit"); ?>" class="button" />
			    	</div>
		    	</div>
			</form>
	    </div>
	</div>
</div>
<?php } else { ?>
<?php if ($data['page']['member_register']['error']['count']>0) { ?>
    <div class="error">
        <ul>
            <?php if ($data['page']['member_register']['error']['Username']==1) { ?><li><?php echo Helper::translate("The username ", "member-register-username-1"); ?> "<?php echo $data['form_param']['Username']; ?>" <?php echo Helper::translate("is taken. Please try again with another username.", "member-register-username-2"); ?></li><?php } ?>
            <?php if ($data['page']['member_register']['error']['NRIC']==1) { ?><li><?php echo Helper::translate("The NRIC number ", "member-register-nric-1"); ?> <?php echo $data['form_param']['NRIC']; ?><?php echo Helper::translate(" exists in our records. Each member can only register once. Please try again with another NRIC number. ", "member-register-nric-2"); ?> </li><?php } ?>
            <?php if ($data['page']['member_register']['error']['Passport']==1) { ?><li><?php echo Helper::translate("The Passport number", "member-register-passport-1"); ?> <?php echo $data['form_param']['Passport']; ?> <?php echo Helper::translate("exists in our records. Each member can only register once. Please try again with another Passport number.", "member-register-passport-2"); ?></li><?php } ?>
            <?php if ($data['page']['member_register']['error']['SQ']==1) { ?><li><?php echo Helper::translate("The Security Question is answered incorrectly. Please try again.", "member-register-security"); ?></li><?php } ?>
            <?php if ($data['page']['member_register']['error']['Bank']==1) { ?><li><?php echo Helper::translate("You had an existing account with us. Please contact our 24 hours service representative if you like to create additional account.", "member-register-bank-duplicated"); ?></li><?php } ?>
        </ul>
    </div>
<?php } ?>
<div>
<p><?php echo Helper::translate("Creating your account with us is easy! Start by filling up form below:", "member-register-message"); ?></p>
<form name="add_form" class="admin_table_noMobile"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/registerprocess" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Full Name", "member-register-fullname"); ?><span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="<?php echo $data['form_param']['Name']; ?>" size="40" placeholder="As in NRIC" /><br /><span class="label_hint red">(<?php echo Helper::translate("The name must match with your bank account name for withdrawal.", "member-register-fullname-note"); ?>)</span></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Facebook ID", "member-register-facebookID"); ?></label></th>
      <td><input name="FacebookID" class="validate[]" type="text" value="<?php echo $data['form_param']['FacebookID']; ?>" size="40" placeholder="Facebook Email or ID" /></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Gender</label></th>
      <td><select name="GenderID" class="chosen_simple">
          <option
          <?php //for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
          <option value="<?php //echo $data['content_param']['gender_list'][$i]['ID']; ?>" <?php //if ($data['content_param']['gender_list'][$i]['ID']==$data['form_param']['GenderID']) { ?> selected="selected"<?php //} ?>><?php //echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
          <?php //} ?>
        </select></td>
    </tr> -->
    <!-- <tr>
      <th scope="row"><label>Date of Birth</th>
      <td><input name="DOB" id="DOB" class="validate[custom[dmyDate]] datepicker" type="text" value="<?php echo $data['form_param']['DOB']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr> -->
    <!-- <tr>
      <th scope="row"><label>Nationality</label></th>
      <td><select name="Nationality" id="Nationality" class="chosen">
            <?php //for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
            <option value="<?php //echo $data['content_param']['country_list'][$i]['ID']; ?>"
                <?php //if ($data['form_param']['Nationality']=="") { ?>
                <?php //if ($data['content_param']['country_list'][$i]['ID']==151) { ?> selected="selected"<?php //} ?>
                <?php //} else { ?>
                <?php //if ($data['content_param']['country_list'][$i]['ID']==$data['form_param']['Nationality']) { ?> selected="selected"<?php //} ?>
                <?php //} ?>><?php //echo $data['content_param']['country_list'][$i]['Name']; ?></option>
            <?php //} ?>
          </select></td>
    </tr> -->
    <!-- <tbody id="nric_box" <?php //if (($data['form_param']['Nationality']!=151)&&($data['form_param']['Nationality']!='')) { ?>class="invisible"<?php //} ?>>
        <tr>
          <th scope="row"><label>NRIC No</label></th>
          <td><input name="NRIC" id="NRIC" class="validate[custom[NRIC]]" type="text" value="<?php //echo $data['form_param']['NRIC']; ?>" size="20" /><span class="label_hint">(e.g. 880101-14-5566)</span></td>
        </tr>
    </tbody> -->
    <tbody id="passport_box" <?php if (($data['form_param']['Nationality']==151)||($data['form_param']['Nationality']=='')) { ?>class="invisible"<?php } ?>>
        <tr>
          <th scope="row"><label><?php echo Helper::translate("Passport No", "member-register-passportno"); ?></label></th>
          <td><input name="Passport" class="validate[]" type="text" value="<?php echo $data['form_param']['Passport']; ?>" size="20" /></td>
        </tr>
    </tbody>
    <!-- <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Street<span class="label_required">*</span></label></th>
      <td><input name="Street" class="validate[required]" type="text" value="<?php echo $data['form_param']['Street']; ?>" size="60" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Street (Additional Line)</label></th>
      <td><input name="Street2" class="validate[]" type="text" value="<?php echo $data['form_param']['Street2']; ?>" size="60" /></td>
    </tr>
    <tr>
      <th scope="row"><label>City<span class="label_required">*</span></label></th>
      <td><input name="City" class="validate[required]" type="text" value="<?php echo $data['form_param']['City']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Postcode<span class="label_required">*</span></label></th>
      <td><input name="Postcode" class="validate[required, custom[integer], minSize[5]]" type="text" value="<?php echo $data['form_param']['Postcode']; ?>" size="10" maxlength="5" /><span class="label_hint">(e.g. 50000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>State<span class="label_required">*</span></label></th>
      <td><select name="State" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['state_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['state_list'][$i]['ID']; ?>"
                <?php if ($data['form_param']['State']=="") { ?>
                <?php } else { ?>
                <?php if ($data['content_param']['state_list'][$i]['ID']==$data['form_param']['State']) { ?> selected="selected"<?php } ?>
                <?php } ?>><?php echo $data['content_param']['state_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Country<span class="label_required">*</span></label></th>
      <td><select name="Country" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>"
                <?php if ($data['form_param']['Country']=="") { ?>
                <?php if ($data['content_param']['country_list'][$i]['ID']==151) { ?> selected="selected"<?php } ?>
                <?php } else { ?>
                <?php if ($data['content_param']['country_list'][$i]['ID']==$data['form_param']['Country']) { ?> selected="selected"<?php } ?>
                <?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Company</label></th>
      <td><input name="Company" class="validate[]" type="text" value="<?php echo $data['form_param']['Company']; ?>" size="40" /></td>
    </tr> -->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Bank", "member-register-bank"); ?><span class="label_required">*</span></label></th>
      <td><select name="Bank" class="validate[required]">
              <option value="">--Please select one--</option>
            <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>"
                <?php if ($data['form_param']['Bank']=="") { ?>
                <?php if ($data['content_param']['bank_list'][$i]['Label']==$data['form_param']['Bank']) { ?> selected="selected"<?php } ?>
                <?php } else { ?>
                <?php if ($data['content_param']['bank_list'][$i]['Label']==$data['form_param']['Bank_list']) { ?> selected="selected"<?php } ?>
                <?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Bank Account No", "member-register-bankaccountno"); ?><span class="label_required">*</span></label></th>
      <td><input name="BankAccountNo" type="text" class="validate[required, custom[integer]]" value="<?php //echo ($data['form_param']['BankAccountNo']); ?>" size="40" /><span class="label_hint"><?php echo Helper::translate("(Bank Account must be real for future smooth withdrawal)", "member-register-bankaccountno-note"); ?></span></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Username", "member-register-username"); ?><span class="label_required">*</span></label></th>
      <td><input name="Username" class="validate[required]" type="text" value="<?php echo $data['form_param']['Username']; ?>" size="20" /><span class="label_hint"><?php echo Helper::translate("(You will use this to login)", "member-register-login-note"); ?></span></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("New Password", "member-register-newpassword"); ?><span class="label_required">*</span></label></th>
      <td><input name="Password" id="Password" class="validate[required,minSize[8]]" type="password" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row" class="white-space:nowrap;"><label><?php echo Helper::translate("Confirm Password", "member-register-confirmpassword"); ?><span class="label_required">*</span></label></th>
      <td><input name="PasswordConfirm" id="PasswordConfirm" class="validate[required,equals[Password]]" type="password" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><img src="http://www.0777.com/images/sms1.jpg" width="0" height="0" /></td>
    </tr>

    <tr>
      <th scope="row"><label><?php echo Helper::translate("Mobile No", "member-register-mobileno"); ?><span class="label_required">*</span></label></th>
      <td><select name="MobilePrefix">
            <option value="6010"<?php if($data['form_param']['MobilePrefix']=='6010'){ ?> selected="selected"<?php } ?>>+6010</option>
            <option value="6011"<?php if($data['form_param']['MobilePrefix']=='6011'){ ?> selected="selected"<?php } ?>>+6011</option>
            <option value="6012"<?php if($data['form_param']['MobilePrefix']=='6012'){ ?> selected="selected"<?php } ?>>+6012</option>
            <option value="6013"<?php if($data['form_param']['MobilePrefix']=='6013'){ ?> selected="selected"<?php } ?>>+6013</option>
            <option value="6014"<?php if($data['form_param']['MobilePrefix']=='6014'){ ?> selected="selected"<?php } ?>>+6014</option>
            <option value="6015"<?php if($data['form_param']['MobilePrefix']=='6015'){ ?> selected="selected"<?php } ?>>+6015</option>
            <option value="6016"<?php if($data['form_param']['MobilePrefix']=='6016'){ ?> selected="selected"<?php } ?>>+6016</option>
            <option value="6017"<?php if($data['form_param']['MobilePrefix']=='6017'){ ?> selected="selected"<?php } ?>>+6017</option>
            <option value="6018"<?php if($data['form_param']['MobilePrefix']=='6018'){ ?> selected="selected"<?php } ?>>+6018</option>
            <option value="6019"<?php if($data['form_param']['MobilePrefix']=='6019'){ ?> selected="selected"<?php } ?>>+6019</option>
            <option value="65"<?php if($data['form_param']['MobilePrefix']=='65'){ ?> selected="selected"<?php } ?>>+65</option>
          </select>
          <input name="MobileNo" class="validate[required,custom[mobileNo],minSize[7]]" type="text" value="<?php echo $data['form_param']['MobileNo']; ?>" size="20" maxlength="15" /><span class="label_hint"><?php echo Helper::translate("(E.g. 2255667. Compulsory for SMS verification)", "member-register-mobileno-note"); ?></span></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Phone No (optional)</label></th>
      <td><input name="PhoneNo" class="validate[custom[phoneNo],minSize[9]]" type="text" value="<?php //echo $data['form_param']['PhoneNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr> -->
    <!-- <tr>
      <th scope="row"><label>Fax No</label></th>
      <td><input name="FaxNo" class="validate[custom[faxNo],minSize[9]]" type="text" value="<?php //echo $data['form_param']['FaxNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr> -->
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Email", "member-register-email"); ?><span class="label_required">*</span></label></th>
      <td><input name="Email" class="validate[required,custom[email]]" type="text" value="<?php echo $data['form_param']['Email']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row" style="white-space:nowrap;"><label><?php echo Helper::translate("Security Question", "member-register-securityquestion"); ?><span class="label_required">*</span></label></th>
      <td><?php echo $data['captcha'][0]; ?> + <?php echo $data['captcha'][1]; ?> = <input name="SQ" class="validate[required,custom[number]]" type="text" value="" size="3" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="hidden" name="C1" value="<?php echo $data['captcha'][0]; ?>"  /><input type="hidden" name="C2" value="<?php echo $data['captcha'][1]; ?>"  /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><label><span class="terms_box"><input type="checkbox" class="validate[required]" name="TermsOK" id="TermsOK" value="1" <?php if ($data['form_param']['TermsOK']==1) { ?>checked="checked"<?php } ?> /></span><?php echo Helper::translate("I agree that the information provided above is accurate, and I accept the", "member-register-agree-1"); ?> <a href="<?php echo $data['config']['SITE_DIR']; ?>/main/page/terms-of-use" target="_blank"><?php echo Helper::translate("terms of use", "member-register-agree-2"); ?></a> <?php echo Helper::translate("of the website.", "member-register-agree-3"); ?></label></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <input type="hidden" id="RegisterTrigger" name="RegisterTrigger" value="1" />
      <input type="hidden" id="form_token" name="form_token" value="<?php echo $_SESSION['form_token']; ?>" />
      <td><input type="submit" name="submit" value="<?php echo Helper::translate("Submit", "member-register-submit"); ?>" class="button" /></td>
    </tr>
  </table>
</form>
</div>
<?php } ?>

