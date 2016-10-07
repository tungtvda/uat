<html>
<head></head>
<body style="background-color: #f5f5f5">
<div style="width: 550px; border:1px solid #ddd; padding:15px 20px 20px; margin:10px; border-radius:6px; background-color: #fff; font-family:Arial,sans-serif; font-size:12px; color:#333;">
  <table>
    <tbody>
      <tr>
        <td align="left"><img src="<?php echo $this->config['SITE_URL'].$reseller['Logo'];?>" /></td>
      </tr> 
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
          <td align="left"><?php echo Helper::translate("Hi", "member-mail-register-hi"); ?> <strong style="color:#c00;"><?php echo $request_data['Name']; ?></strong>,<br /><br /><?php echo Helper::translate("Congratulations on your new account! You are all set to get the best of what", "member-mail-register-message-1"); ?><a style="color:#c00;" href="<?php echo $reseller['Company']; ?>"><?php echo $reseller['Name']; ?></a><?php echo Helper::translate("can offer.", "member-mail-register-message-2"); ?><br /><br />
        <b><?php echo Helper::translate("Username:", "member-mail-register-username"); ?></b> <?php echo $request_data['Username']; ?><br /><br />
        <?php echo Helper::translate("To access your account, please visit our", "member-mail-register-message-3"); ?> <a style="color:#c00;" href="<?php echo $reseller['Company']; ?>"><?php echo $reseller['Name']; ?></a>.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo Helper::translate("Bonus:", "member-mail-register-message-4"); ?> <?php echo ($_POST['WelcomeBonus']!="") ? $_POST['WelcomeBonus'] : Helper::translate("None", "member-mail-register-message-5"); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo Helper::translate("Best Regards,", "member-mail-register-message-6"); ?><br />
            <strong><?php echo $reseller['Name']; ?></strong></td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>