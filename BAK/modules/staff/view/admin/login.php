<?php if ($data['page']['staff_password']['ok']==1) { ?>
<div class="notify">Your new password has been saved. Please login again to continue.</div>
<?php } ?>
<?php if ($data['page']['staff_logout']['ok']==1) { ?>
<div class="notify">You have logged out successfully.</div>
<?php } ?>
<?php if ($data['page']['staff_forgotpassword']['ok']==1) { ?>
<div class="notify">A new password has been generated and sent to your registered email.</div>
<?php } ?>
<?php if ($data['page']['staff_login']['error']['count']>0) { ?>
  <?php if ($data['page']['staff_login']['error']['Login']==1) { ?>
  <div class="error">The username and/or password, TAC entered is invalid. Please try again.</div>
  <?php } ?>
<?php } ?>
<div id="staff_login_wrapper" class="admin_common_block">
  <form class="admin_table_nocell" name="login_form" id="login_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/loginprocess">
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th scope="row"><label>Username:</label></th>
        <td><input type="text" class="validate[required]" name="Username" id="Username" value="<?php echo $data['form_param']['Username']; ?>" /></td>
      </tr>
      <tr>
        <th scope="row"><label>TAC:</label></th>
        <td><input type="text" class="validate[required, minSize[6], maxSize[6]]" name="TAC" id="TAC" value="<?php echo $data['form_param']['TAC']; ?>" /></td>
      </tr>
      <tr>
        <th scope="row"><label>Password:</label></th>
        <td><input type="password" class="validate[required]" name="Password" id="Password" value="" /></td>
      </tr>
      <tr>
        <th scope="row">&nbsp;</th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th scope="row">&nbsp;</th>
        <td class="text_left"><input class="button" type="submit" name="submit" value="Login" /></td>
      </tr>
      <tr>
        <th scope="row">&nbsp;</th>
        <td class='subtext'><div class="forgot_password"><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/forgotpassword">Forgot your password?</a></div></td>
      </tr>
    </table>
  </form>
</div>
