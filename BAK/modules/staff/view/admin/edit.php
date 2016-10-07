<?php if ($data['page']['staff_add']['ok']==1) { ?>
<div class="notify">Staff created successfully.</div>
<?php } ?>
<?php if ($data['page']['staff_edit']['error']['count']>0) { ?>
    <div class="error">
        <ul>
            <?php if ($data['page']['staff_edit']['error']['Username']==1) { ?><li>The username "<?php echo $data['form_param']['Username']; ?>" is taken. Please try again with another username.</li><?php } ?>
            <?php if ($data['page']['staff_edit']['error']['Email']==1) { ?><li>The email address <?php echo $data['form_param']['Email']; ?> exists in the database. Each email can only be registered once. Please try again with another email address.</li><?php } ?>
        </ul>
    </div>
<?php } else { ?>
    <?php if ($data['page']['staff_edit']['ok']==1) { ?>
    <div class="notify">Staff edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Full Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo (($data['form_param']['Name']!="") ? $data['form_param']['Name'] : $data['content'][0]['Name']); ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Profile<span class="label_required">*</span></label></th>
      <td><select name="Profile" <?php if ($data['content'][0]['ID']=='1') { ?>class="disabled" disabled="disabled"<?php } ?>>
          <?php for ($i=0; $i<$data['content_param']['profile_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['profile_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Profile']==$data['content_param']['profile_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['profile_list'][$i]['Profile']; ?></option>
          <?php } ?>
        </select>
        <?php if ($data['content'][0]['ID']=='1') { ?>
        <input type="hidden" value="1" name="Profile" />
        <?php } ?>
      </td>
    </tr>
    <tr>
      <th scope="row"><label>Mobile No<span class="label_required">*</span></label></th>
      <td><input name="MobileNo" type="text" class="validate[required,custom[mobileNo],minSize[9]]" value="<?php echo (($data['form_param']['MobileNo']!="") ? $data['form_param']['MobileNo'] : $data['content'][0]['MobileNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0192255667)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Email<span class="label_required">*</span></label></th>
      <td><input name="Email" class="validate[required, custom[email]]" type="text" value="<?php echo $data['content'][0]['Email']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Username<span class="label_required">*</span></label></th>
      <td><input name="Username" class="validate[required] <?php if ($data['content'][0]['ID']=='1') { ?>disabled<?php } ?>" type="text" value="<?php echo (($data['form_param']['Username']!="") ? $data['form_param']['Username'] : $data['content'][0]['Username']); ?>" size="20" <?php if ($data['content'][0]['ID']=='1') { ?>disabled="disabled"<?php } ?> />
        <?php if ($data['content'][0]['ID']=='1') { ?>
        <input type="hidden" value="<?php echo $data['content'][0]['Username']; ?>" name="Username" />
        <?php } ?></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><label><input name="NewPassword" id="NewPassword" type="checkbox" value="1" /> Create a new password</label></td>
    </tr>
    <tbody id="NewPasswordBox" class="invisible">
    <tr>
      <th scope="row"><label>Password<span class="label_required">*</span></label></th>
      <td><input name="Password" id="Password" class="validate[required, minSize[5]]" type="password" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Confirm Password<span class="label_required">*</span></label></th>
      <td><input name="PasswordConfirm" id="PasswordConfirm" class="validate[required, equals[Password]]" type="password" value="" size="20" /></td>
    </tr>
    </tbody>
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
      <td><select name="Enabled" <?php if ($data['content'][0]['ID']=='1') { ?>class="disabled" disabled="disabled"<?php } ?> class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select>
        <?php if ($data['content'][0]['ID']=='1') { ?>
        <input type="hidden" value="1" name="Enabled" />
        <?php } ?></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/viewall">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
