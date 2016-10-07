<?php if ($data['page']['dealer_add']['ok']==1) { ?>
<div class="notify">Dealer created successfully.</div>
<?php } ?>
<?php if ($data['page']['dealer_edit']['error']['count']>0) { ?>
    <div class="error">
        <ul>
            <?php if ($data['page']['dealer_edit']['error']['Username']==1) { ?><li>The username "<?php echo $data['form_param']['Username']; ?>" is taken. Please try again with another username.</li><?php } ?>
            <?php if ($data['page']['dealer_edit']['error']['NRIC']==1) { ?><li>The NRIC number <?php echo $data['form_param']['NRIC']; ?> exists in the database. Each dealer can only register once. Please try again with another NRIC number.</li><?php } ?>
            <?php if ($data['page']['dealer_edit']['error']['Passport']==1) { ?><li>The Passport number <?php echo $data['form_param']['Passport']; ?> exists in the database. Each dealer can only register once. Please try again with another Passport number.</li><?php } ?>
        </ul>
    </div>
<?php } else { ?>
    <?php if ($data['page']['dealer_edit']['ok']==1) { ?>
    <div class="notify">dealer edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_noMobile"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">
    <tr>
      <th scope="row"><label>Full Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo (($data['form_param']['Name']!="") ? $data['form_param']['Name'] : $data['content'][0]['Name']); ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Gender<span class="label_required">*</span></label></th>
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
    <tr>
      <th scope="row"><label>Date of Birth<span class="label_required">*</span></label></th>
      <td><input name="DOB" type="text" class="validate[required,custom[dmyDate]] datepicker mask_date" value="<?php echo (($data['form_param']['DOB']!="") ? $data['form_param']['DOB'] : $data['content'][0]['DOB']); ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Nationality<span class="label_required">*</span></label></th>
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
          <th scope="row"><label>NRIC<span class="label_required">*</span></label></th>
          <td><input name="NRIC" type="text" class="validate[required, custom[NRIC]] mask_nric" value="<?php echo (($data['form_param']['NRIC']!="") ? $data['form_param']['NRIC'] : $data['content'][0]['NRIC']); ?>" size="20" /><span class="label_hint">(e.g. 880101-14-5566)</span></td>
        </tr>
    </tbody>
    <tbody id="passport_box"
        <?php if ($data['form_param']['Nationality']!="") { ?>
        <?php if ($data['form_param']['Nationality']==151) { ?>class="invisible"<?php } ?>
        <?php } else { ?>              
        <?php if ($data['content'][0]['Nationality']==151) { ?>class="invisible"<?php } ?>
        <?php } ?>>
        <tr>
          <th scope="row"><label>Passport<span class="label_required">*</span></label></th>
          <td><input name="Passport" type="text" class="validate[required]" value="<?php echo (($data['form_param']['Passport']!="") ? $data['form_param']['Passport'] : $data['content'][0]['Passport']); ?>" size="20" /></td>
        </tr>
    </tbody>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Company</label></th>
      <td><input name="Company" type="text" class="validate[]" value="<?php echo (($data['form_param']['Company']!="") ? $data['form_param']['Company'] : $data['content'][0]['Company']); ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Username<span class="label_required">*</span></label></th>
      <td><input name="Username" type="text" class="validate[required]" value="<?php echo (($data['form_param']['Username']!="") ? $data['form_param']['Username'] : $data['content'][0]['Username']); ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><label><input name="NewPassword" id="NewPassword" type="checkbox" value="1" /> Create a new password</label></td>
    </tr>
    <tbody id="NewPasswordBox" class="invisible">
    <tr>
      <th scope="row"><label>New Password<span class="label_required">*</span></label></th>
      <td><input name="Password" id="Password" type="password" class="validate[required,minSize[8]]" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Confirm Password<span class="label_required">*</span></label></th>
      <td><input name="PasswordConfirm" id="PasswordConfirm" class="validate[required,equals[Password]]" type="password" value="" size="20" /></td>
    </tr>
    </tbody>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Mobile No<span class="label_required">*</span></label></th>
      <td><input name="MobileNo" type="text" class="validate[required,custom[mobileNo],minSize[9]]" value="<?php echo (($data['form_param']['MobileNo']!="") ? $data['form_param']['MobileNo'] : $data['content'][0]['MobileNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0192255667)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Phone No</label></th>
      <td><input name="PhoneNo" type="text" class="validate[custom[phoneNo],minSize[9]]" value="<?php echo (($data['form_param']['PhoneNo']!="") ? $data['form_param']['PhoneNo'] : $data['content'][0]['PhoneNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Fax No</label></th>
      <td><input name="FaxNo" type="text" class="validate[custom[faxNo],minSize[9]]" value="<?php echo (($data['form_param']['FaxNo']!="") ? $data['form_param']['FaxNo'] : $data['content'][0]['FaxNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Email<span class="label_required">*</span></label></th>
      <td><input name="Email" type="text" class="validate[required,custom[email]]" value="<?php echo (($data['form_param']['Email']!="") ? $data['form_param']['Email'] : $data['content'][0]['Email']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Prompt</label></th>
      <td><select name="Prompt" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" 
              <?php if ($data['form_param']['Prompt']!="") { ?>
              <?php if ($data['content_param']['enabled_list'][$i]['ID']==$data['form_param']['Prompt']) { ?>selected="selected"<?php } ?>
              <?php } else { ?>              
              <?php if ($data['content_param']['enabled_list'][$i]['ID']==$data['content'][0]['Prompt']) { ?>selected="selected"<?php } ?>
              <?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" 
              <?php if ($data['form_param']['Enabled']!="") { ?>
              <?php if ($data['content_param']['enabled_list'][$i]['ID']==$data['form_param']['Enabled']) { ?>selected="selected"<?php } ?>
              <?php } else { ?>              
              <?php if ($data['content_param']['enabled_list'][$i]['ID']==$data['content'][0]['Enabled']) { ?>selected="selected"<?php } ?>
              <?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
