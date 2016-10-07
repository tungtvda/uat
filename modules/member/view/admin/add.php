<?php if ($data['page']['member_add']['error']['count']>0) { ?>
    <div class="error">
        <ul>
            <?php if ($data['page']['member_add']['error']['Username']==1) { ?><li>The username "<?php echo $data['form_param']['Username']; ?>" is taken. Please try again with another username.</li><?php } ?>
            <?php if ($data['page']['member_add']['error']['NRIC']==1) { ?><li>The NRIC number <?php echo $data['form_param']['NRIC']; ?> exists in the database. Each member can only register once. Please try again with another NRIC number.</li><?php } ?>
            <?php if ($data['page']['member_add']['error']['Passport']==1) { ?><li>The Passport number <?php echo $data['form_param']['Passport']; ?> exists in the database. Each member can only register once. Please try again with another Passport number.</li><?php } ?>
            <?php if ($data['page']['member_add']['error']['Bank']==1) { ?><li>The Bank <?php echo $data['form_param']['Bank']; ?> exists in the database. Please try again with another username.</li><?php } ?>
        </ul>
    </div>
<?php } ?>
<form name="add_form" class="admin_table_noMobile" id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/member/addprocess" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">
    <tr>
      <th scope="row"><label>Agent<span class="label_required">*</span></label></th>
      <td><select name="Agent" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['agent_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['agent_list'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list'][$i]['ID']==$data['form_param']['agent_list']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list'][$i]['Name']; ?> - <?php echo $data['content_param']['agent_list'][$i]['ID']; ?> | <?php echo $data['content_param']['agent_list'][$i]['Company']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Full Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo $data['form_param']['Name']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Facebook ID</label></th>
      <td><input name="FacebookID" type="text" class="validate[]" value="<?php echo $data['form_param']['FacebookID']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Gender<span class="label_required">*</span></label></th>
      <td><select name="GenderID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>" <?php if ($data['content_param']['gender_list'][$i]['ID']==$data['form_param']['GenderID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
<!--<tr>
      <th scope="row"><label>Date of Birth</label></th>
      <td><input name="DOB" class="validate[custom[dmyDate]] datepicker mask_date" type="text" value="<?php echo $data['form_param']['DOB']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>-->
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
          <th scope="row"><label>NRIC<span class="label_required">*</span></label></th>
          <td><input name="NRIC" class="validate[required,custom[NRIC]] mask_nric" type="text" value="<?php echo $data['form_param']['NRIC']; ?>" size="20" /><span class="label_hint">(e.g. 880101-14-5566)</span></td>
        </tr>
    </tbody>
    <tbody id="passport_box" <?php if (($data['form_param']['Nationality']==151)||($data['form_param']['Nationality']=='')) { ?>class="invisible"<?php } ?>>
        <tr>
          <th scope="row"><label>Passport<span class="label_required">*</span></label></th>
          <td><input name="Passport" class="validate[required]" type="text" value="<?php echo $data['form_param']['Passport']; ?>" size="20" /></td>
        </tr>
    </tbody>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>    
    <tr>
      <th scope="row"><label>Company</label></th>
      <td><input name="Company" class="validate[]" type="text" value="<?php echo $data['form_param']['Company']; ?>" size="40" /></td>
    </tr>    
    <tr>
      <th scope="row"><label>Bank<span class="label_required">*</span></label></th>
      <td>
          <select name="Bank" class="validate[required] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if($data['form_param']['Bank']==$data['content_param']['bank_list'][$i]['Label']){ ?> selected="selected" <?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select>
          </td>
    </tr>    
    <tr>
      <th scope="row"><label>Bank Account No<span class="label_required">*</span></label></th>
      <td><input name="BankAccountNo" class="validate[required, custom[integer], minsize[2]]" type="text" value="<?php echo $data['form_param']['BankAccountNo']; ?>" size="40" /></td>
    </tr>
<!--<tr>
      <th scope="row"><label>Secondary Bank</label></th>
      <td><input name="SecondaryBank" class="validate[]" type="text" value="<?php echo $data['form_param']['Bank']; ?>" size="40" /></td>
    </tr>    
    <tr>
      <th scope="row"><label>Secondary Bank Account No</label></th>
      <td><input name="SecondaryBankAccountNo" class="validate[custom[integer], minsize[2]]" type="text" value="<?php echo $data['form_param']['BankAccountNo']; ?>" size="40" /></td>
    </tr>-->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Username<span class="label_required">*</span></label></th>
      <td><input name="Username" class="validate[required]" type="text" value="<?php echo $data['form_param']['Username']; ?>" size="20" /></td>
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
      <td><input name="MobileNo" class="validate[required,custom[mobileNo],minSize[9]]" type="text" value="<?php echo $data['form_param']['MobileNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0192255667)</span></td>
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
      <td><input name="Email" type="text" class="validate[required,custom[email]]" value="<?php echo $data['form_param']['Email']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Prompt</label></th>
      <td><select name="Prompt" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['form_param']['Prompt']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select><span class="label_hint">(This option forces the user to update his/her password on next login)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['form_param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/member/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
