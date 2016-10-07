<html>
<head></head>
<body style="background-color: #f5f5f5">
<div style="width: 550px; border:1px solid #ddd; padding:15px 20px 20px; margin:10px; border-radius:6px; background-color: #fff; font-family:Arial,sans-serif; font-size:12px; color:#333;">
  <table>
    <tbody>
      <tr>
        <td align="left"><img src="<?php echo $param['config']['SITE_URL'].$_SESSION['agent']['Logo'];?>" /></td>
      </tr> 
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left"><?php echo Helper::translate("New Member", "member-mail-register-agent-messg-1"); ?>,
        <?php echo Helper::translate("Member Name", "member-mail-register-agent-messg-2"); ?>: <strong style="color:#c00;"><?php echo $param['content']['Name']; ?></strong><br /><br />
        <?php echo Helper::translate("Member Username", "member-mail-register-agent-messg-3"); ?>: <strong style="color:#c00;"><?php echo $param['content']['Username']; ?></strong><br /><br />
        <?php echo Helper::translate("Please visit your", "member-mail-register-message-4"); ?> <a style="color:#c00;" href="<?php echo $param['reseller']['Company']; ?>"><?php echo $param['reseller']['Company']; ?></a>.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>     
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo Helper::translate("Best Regards,", "member-mail-register-message-6"); ?><br />
            <strong><?php echo $param['reseller']['Company']; ?></strong></td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>