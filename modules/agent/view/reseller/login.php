<div id="member_login_wrapper">
  <?php if ($data['page']['reseller_register']['ok']==1) { ?>
  <div class="notify">Registration is complete! You may now login below.</div>
  <?php } ?>
  <?php if ($data['page']['reseller_password']['ok']==1) { ?>
  <div class="notify">Your new password has been saved. Please login again to continue.</div>
  <?php } ?>
  <?php if ($data['page']['reseller_logout']['ok']==1) { ?>
  <div class="notify">You have logged out successfully.</div>
  <?php } ?>
  <?php if ($data['page']['reseller_forgotpassword']['ok']==1) { ?>
  <div class="notify">A new password has been generated and sent to your registered email.</div>
  <?php } ?>
  <?php if ($data['page']['reseller_login']['error']['count']>0) { ?>
    <?php if ($data['page']['reseller_login']['error']['Login']==1) { ?>
    <div class="error">The username and/or password entered is invalid. Please try again.</div>
    <?php } ?>
  <?php } ?>
  <form name="login_form" id="login_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/loginprocess">
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th scope="row"><label>Username:</label></th>
        <td><input type="text" class="validate[required]" name="Username" id="Username" value="<?php echo $data['form_param']['Username']; ?>" /></td>
      </tr>
      <tr>
        <th scope="row"><label>Password:</label></th>
        <td><input type="password" class="validate[required]" name="Password" id="Password" value="" /></td>
      </tr>
      <!-- <tr>
        <th scope="row">&nbsp;</th>
        <td class='subtext'><label><input type="checkbox" name="AutoLogin" value="1" <?php if (($data['page']['member_auth']==1)&&($_GET['autologin']==1)) { ?>checked="checked"<?php } ?> /> Keep me logged in</label></td>
      </tr> -->
      <tr>
        <th scope="row">&nbsp;</th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th scope="row">&nbsp;</th>
        <td><input class="button" type="submit" name="submit" value="Login" /></td>
      </tr>
      <tr>
        <th scope="row">&nbsp;</th>
        <td class='subtext'><div class="forgot_password"><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/forgotpassword">Forgot your password?</a></div></td>
      </tr>
    </table>
  </form>
</div>
