<?php if ($data['page']['merchant_register']['error']['count']>0) { ?>
    <div class="error">
        <ul>
            <?php if ($data['page']['merchant_register']['error']['Username']==1) { ?><li>The username "<?php echo $data['form_param']['Username']; ?>" is taken. Please try again with another username.</li><?php } ?>
            <?php if ($data['page']['merchant_register']['error']['NRIC']==1) { ?><li>The NRIC number <?php echo $data['form_param']['NRIC']; ?> exists in our records. Each merchant can only register once. Please try again with another NRIC number.</li><?php } ?>
            <?php if ($data['page']['merchant_register']['error']['Passport']==1) { ?><li>The Passport number <?php echo $data['form_param']['Passport']; ?> exists in our records. Each merchant can only register once. Please try again with another Passport number.</li><?php } ?>
        </ul>
    </div>
<?php } ?>
<p>Creating your account with us is easy! Start by filling up form below:</p>
<form name="add_form" class="admin_table_noMobile"  id="add_form" action="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/registerprocess" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">
    <tr>
      <th scope="row"><label>Full Name (as in NRIC / Passport)<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="<?php echo $data['form_param']['Name']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Gender</label></th>
      <td><select name="GenderID" class="chosen_simple">
          <option 
          <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>" <?php if ($data['content_param']['gender_list'][$i]['ID']==$data['form_param']['GenderID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Date of Birth<span class="label_required">*</span></label></th>
      <td><input name="DOB" id="DOB" class="validate[custom[dmyDate]] datepicker" type="text" value="<?php echo $data['form_param']['DOB']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Nationality<span class="label_required">*</span></label></th>
      <td><select name="Nationality" id="Nationality" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" 
                <?php if ($data['form_param']['Nationality']=="") { ?>                
                <?php if ($data['content_param']['country_list'][$i]['ID']==151) { ?> selected="selected"<?php } ?>
                <?php } else { ?>
                <?php if ($data['content_param']['country_list'][$i]['ID']==$data['form_param']['Nationality']) { ?> selected="selected"<?php } ?>
                <?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tbody id="nric_box" <?php if (($data['form_param']['Nationality']!=151)&&($data['form_param']['Nationality']!='')) { ?>class="invisible"<?php } ?>>
        <tr>
          <th scope="row"><label>NRIC No<span class="label_required">*</span></label></th>
          <td><input name="NRIC" id="NRIC" class="validate[required, custom[NRIC]]" type="text" value="<?php echo $data['form_param']['NRIC']; ?>" size="20" /><span class="label_hint">(e.g. 880101-14-5566)</span></td>
        </tr>
    </tbody>
    <tbody id="passport_box" <?php if (($data['form_param']['Nationality']==151)||($data['form_param']['Nationality']=='')) { ?>class="invisible"<?php } ?>>
        <tr>
          <th scope="row"><label>Passport No<span class="label_required">*</span></label></th>
          <td><input name="Passport" class="validate[required]" type="text" value="<?php echo $data['form_param']['Passport']; ?>" size="20" /></td>
        </tr>
    </tbody>
    <tr>
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
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Username<span class="label_required">*</span></label></th>
      <td><input name="Username" class="validate[required]" type="text" value="<?php echo $data['form_param']['Username']; ?>" size="20" /><span class="label_hint">(You will use this to login)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>New Password<span class="label_required">*</span></label></th>
      <td><input name="Password" id="Password" class="validate[required,minSize[8]]" type="password" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Confirm Password<span class="label_required">*</span></label></th>
      <td><input name="PasswordConfirm" id="PasswordConfirm" class="validate[required,equals[Password]]" type="password" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Mobile No<span class="label_required">*</span></label></th>
      <td><input name="MobileNo" class="validate[required,custom[mobileNo],minSize[10]]" type="text" value="<?php echo $data['form_param']['MobileNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0192255667)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Phone No</label></th>
      <td><input name="PhoneNo" class="validate[custom[phoneNo],minSize[9]]" type="text" value="<?php echo $data['form_param']['PhoneNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Fax No</label></th>
      <td><input name="FaxNo" class="validate[custom[faxNo],minSize[9]]" type="text" value="<?php echo $data['form_param']['FaxNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Email<span class="label_required">*</span></label></th>
      <td><input name="Email" class="validate[required,custom[email]]" type="text" value="<?php echo $data['form_param']['Email']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><label><span class="terms_box"><input type="checkbox" class="validate[required]" name="TermsOK" id="TermsOK" value="1" <?php if ($data['form_param']['TermsOK']==1) { ?>checked="checked"<?php } ?> /></span>I agree that the information provided above is accurate, and I accept the <a href="<?php echo $data['config']['SITE_URL']; ?>/main/page/terms-of-use" target="_blank">terms of use</a> of the website.</label></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Submit" class="button" /></td>
    </tr>
  </table>
</form>
