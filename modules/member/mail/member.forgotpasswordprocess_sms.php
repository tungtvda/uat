<html>
<head></head>
<body style="background-color: #f5f5f5">
<div style="width: 550px; border:1px solid #ddd; padding:15px 20px 20px; margin:10px; border-radius:6px; background-color: #fff; font-family:Arial,sans-serif; font-size:12px; color:#333;">
  <table>
    <tbody>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left"><?php echo Helper::translate("Hi", "member-mail-forgotpassword-hi"); ?> <strong style="color:#c00;"><?php echo $result[0]['Name']; ?></strong>,<br /><br /><?php echo Helper::translate("We have received your request for a new password:", "member-mail-forgotpassword-message-1"); ?><br /><br />
        <b><?php echo Helper::translate("Username:", "member-mail-forgotpassword-username"); ?></b> <?php echo $request_data['Username']; ?><br />
        <b><?php echo Helper::translate("Password:", "member-mail-forgotpassword-password"); ?></b> <?php echo $new_password; ?><br /><br />
        <?php echo Helper::translate("To protect your account, please login to your account immediately at your register live game website and change your password. Thank you.", "member-mail-forgotpassword-message-2"); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo Helper::translate("Best Regards,", "member-mail-forgotpassword-message-3"); ?><br />
            <strong><?php echo $this->config['COMPANY_NAME']; ?></strong></td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>