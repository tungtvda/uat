<?php if ($data['page']['merchant_forgotpassword']['error']['count']>0) { ?>
    <?php if ($data['page']['merchant_forgotpassword']['error']['NoMatch']==1) { ?>
    <div class="error">The username and email do not match. Please try again.</div>
    <?php } ?>
<?php } ?>
<p>Please enter your username below and submit to retrieve a new password. If you have also lost your username or registered email, please <a href="<?php echo $data['config']['SITE_URL']; ?>/contact#form">contact us</a> for further assistance.</p>
<form name="forgotpassword_form" class="admin_table_noMobile"  id="forgotpassword_form" action="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/forgotpasswordprocess" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">
    <tr>
      <th scope="row"><label>Username</label></th>
      <td><input name="Username" class="validate[required]" type="text" value="<?php echo $data['form_param']['Username']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Email</label></th>
      <td><input name="Email" class="validate[required,custom[email]]" type="text" value="<?php echo $data['form_param']['Email']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="hidden" name="FPTrigger" value="1" />
          <input type="hidden" name="HPot" value="" />
          <input type="submit" name="submit" value="Submit" class="button" /></td>
    </tr>
  </table>
</form>
