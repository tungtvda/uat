<?php if ($data['page']['staff_profile']['error']['count']>0) { ?>
    <?php if ($data['page']['staff_profile']['error']['Email']==1) { ?>
    <div class="error">The email address <?php echo $data['form_param']['Email']; ?> exists in the database. Each email can only be registered once. Please try again with another email address.</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['staff_profile']['ok']==1) { ?>
    <div class="notify">Profile updated successfully.</div>
    <?php } ?>
<?php } ?>
<form name="profile_form" class="admin_table_nocell"  id="profile_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/profileprocess/" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">
    <tr>
      <th scope="row"><label>Username</label></th>
      <td><input name="Username" type="text" class="validate[] disabled" value="<?php echo $data['content'][0]['Username']; ?>" size="20" readonly="readonly" /><span class="label_hint">(Your login username)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo (($data['form_param']['Name']!="") ? $data['form_param']['Name'] : $data['content'][0]['Name']); ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Mobile No<span class="label_required">*</span></label></th>
      <td><input name="MobileNo" type="text" class="validate[required,custom[mobileNo],minSize[9]]" value="<?php echo (($data['form_param']['MobileNo']!="") ? $data['form_param']['MobileNo'] : $data['content'][0]['MobileNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0192255667)</span></td>
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
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" /></td>
    </tr>
  </table>
</form>
