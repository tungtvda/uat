<html>
<head></head>
<body style="background-color: #f5f5f5">
<div style="width: 550px; border:1px solid #ddd; padding:15px 20px 20px; margin:10px; border-radius:6px; background-color: #fff; font-family:Arial,sans-serif; font-size:12px; color:#333;">
  <table>
    <tbody>
      <tr>
        <td align="left"><img src="<?php echo $param['config']['SITE_URL'].$param['config']['THEME_DIR']; ?>img/cgame-logo.png" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left">Hi <strong style="color:#c00;"><?php echo $param['content'][0]['Name']; ?></strong>,<br /><br />We have received your request for a new password:<br /><br />
        <b>Username:</b> <?php echo $param['content'][0]['Username']; ?><br />
        <b>Password:</b> <?php echo $param['content_param']['new_password']; ?><br /><br />
        To protect your account, please login to your account immediately at <a style="color:#c00;" href="<?php echo $param['config']['SITE_URL']; ?><?php echo $param['config']['SITE_DIR']; ?>"><?php echo $param['config']['SITE_URL']; ?><?php echo $param['config']['SITE_DIR']; ?></a> and change your password. Thank you.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Best Regards,<br />
            <strong><?php echo $param['config']['COMPANY_NAME']; ?></strong></td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>