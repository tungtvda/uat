<html>
<head></head>
<body style="background-color: #f5f5f5">
<div style="width: 550px; border:1px solid #ddd; padding:15px 20px 20px; margin:10px; border-radius:6px; background-color: #fff; font-family:Arial,sans-serif; font-size:12px; color:#333;">
  <table>
    <tbody>
      <tr>
        <td colspan="2" align="left"><img src="<?php echo $param['config']['SITE_URL']; ?>/themes/custom/img/cgame-logo.png" /></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">You have received a message from your website contact form.</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="90" valign="top"><strong>Name:</strong></td>
        <td valign="top"><?php echo $param['form_param']['Name']; ?></td>
      </tr>
      <tr>
        <td width="90" valign="top"><strong>Company:</strong></td>
        <td valign="top"><?php echo $param['form_param']['Company']; ?></td>
      </tr>
      <tr>
        <td valign="top"><strong>Contact No:</strong></td>
        <td valign="top"><?php echo $param['form_param']['ContactNo']; ?></td>
      </tr>
      <tr>
        <td valign="top"><strong>Email:</strong></td>
        <td valign="top"><?php echo $param['form_param']['Email']; ?></td>
      </tr>
      <tr>
        <td valign="top"><strong>Subject:</strong></td>
        <td valign="top"><?php echo $param['form_param']['Subject']; ?></td>
      </tr>
      <tr>
        <td valign="top"><strong>Message:</strong></td>
        <td valign="top"><?php echo $param['form_param']['Message']; ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">Best Regards,<br />
            <strong><?php echo $param['config']['COMPANY_NAME']; ?></strong></td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>
