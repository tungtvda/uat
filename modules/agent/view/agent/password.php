<?php if ($_SESSION['agent']['Prompt']==1) { ?>
<div class="notify">To protect your account, please enter a new password.</div>
<?php } ?>
<?php if ($data['page']['agent_password']['error']['count']>0) { ?>
    <?php if ($data['page']['agent_password']['error']['Password']==1) { ?>
    <div class="error">Current password entered is incorrect. Please try again.</div>
    <?php } ?>
<?php } ?>
<form class="admin_table_nocell" name="password_form" id="password_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/passwordprocess">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Current Password<span class="label_required">*</span></label></th>
      <td><input type="password" class="validate[required]" name="Password" id="Password" value="" /></td>
    </tr>
    <tr>
      <th scope="row"><label>New Password<span class="label_required">*</span></label></th>
      <td><input type="password" class="validate[required],minSize[5]" name="PasswordNew" id="PasswordNew" value="" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Confirm New Password<span class="label_required">*</span></label></th>
      <td><input type="password" class="validate[required],equals[PasswordNew]" name="PasswordConfirm" id="PasswordConfirm" value="" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input class="button" type="submit" name="submit" value="Submit" /></td>
    </tr>
  </table>
</form>
