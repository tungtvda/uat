<img src="http://www.winlive2u.com/images/sms.png" width="652" height="146" />
<div id="member_login_wrapper">
	
  <?php if ($_SESSION['member']['activation_code_incorrect'] == '1') { ?>

    <div class="error"><?php echo Helper::translate("The SMS activation code entered is invalid. Please try again.", "member-mobilesms-error"); ?></div>

  <?php
    unset($_SESSION['member']['activation_code_wrong']);
    unset($_SESSION['member']['activation_code_incorrect']);
  } ?>

  <?php if ($_SESSION['resend'] == '1') { ?>

    <div class="notify"><?php echo Helper::translate("Your SMS code has been resent successfully.", "member-mobilesms-resent"); ?></div>
     <?php unset($_SESSION['resend']); ?>
  <?php } ?>


  <?php if ($_SESSION['update'] == '1') { ?>

    <div class="notify"><?php echo Helper::translate("Updated your mobile number successfully.", "member-mobilesms-updated"); ?></div>
     <?php unset($_SESSION['update']); ?>
  <?php } ?>
  <p><?php echo Helper::translate("Please enter your activation code.", "member-mobilesms-activation-1"); ?><?php echo Helper::translate(" It is sent to ", "member-mobilesms-activation-2"); ?>  <?php echo $_SESSION['member']['MobileNo']; ?></p>
  <form name="activation_form" id="activation_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/activationprocess">
      <!--<tr>
        <th scope="row"><label>Username:</label></th>
        <td><input type="text" class="validate[required]" name="Username" id="Username" value="<?php echo $data['form_param']['Username']; ?>" /></td>
      </tr>-->
      <label><?php echo Helper::translate("SMS Activation Code:", "member-mobilesms-activationcode"); ?></label>
        <input type="text" class="validate[required,custom[integer], minsize[6]]" name="ActivationCode" id="ActivationCode" value="" />
        <input type="hidden" id="SubmitTrigger" name="SubmitTrigger" value="1" />
        <input class="button" type="submit" name="submit" value="<?php echo Helper::translate("Submit", "member-mobilesms-submit"); ?>" />
  </form>
  <br />
  <hr />
	
  <?php /*echo $data['content_param']['elapsed_time'];*/  if ($data['content_param']['elapsed_time']>="60") { ?>
  <p><?php echo Helper::translate("If you have not receive your code, you may click resend or insert a new mobile number", "member-mobilesms-update-message"); ?></p>
  <form name="resend_form" id="resend_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/resendactivationprocess">
          <label><?php echo Helper::translate("Resend Activation Code:", "member-mobilesms-resend-activationcode"); ?></label>
          <input type="hidden" id="ResendActivationTrigger" name="ResendActivationTrigger" value="1" />
	      <input class="button" type="submit" name="send" value="<?php echo Helper::translate("Send", "member-mobilesms-send"); ?>" />
  </form>
  <br />
  <?php } else { ?>
  	
  <p><?php echo Helper::translate("You have recently requested for the activation code. Please wait for at least one minute to request for another code.", "member-mobilesms-activationcode-requested"); ?><br />
      <a style="color: #f90;" href="/member/member/activation"><?php echo Helper::translate("Click here to refresh page", "member-mobilesms-refresh"); ?></a></p>
  <?php } ?>



  <form name="mobile_form" id="mobile_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/updateactivationprocess">
  	      <label><?php echo Helper::translate("Update Mobile Number:", "member-mobilesms-update-number"); ?></label>
              <input type="hidden" id="UpdateTrigger" name="UpdateTrigger" value="1" />
              <select name="MobilePrefix">
            <option value="6010"<?php if($data['form_param']['MobilePrefix']=='6010'){ ?> selected="selected"<?php } ?>>+6010</option>
            <option value="6011"<?php if($data['form_param']['MobilePrefix']=='6011'){ ?> selected="selected"<?php } ?>>+6011</option>
            <option value="6012"<?php if($data['form_param']['MobilePrefix']=='6012'){ ?> selected="selected"<?php } ?>>+6012</option>
            <option value="6013"<?php if($data['form_param']['MobilePrefix']=='6013'){ ?> selected="selected"<?php } ?>>+6013</option>
            <option value="6014"<?php if($data['form_param']['MobilePrefix']=='6014'){ ?> selected="selected"<?php } ?>>+6014</option>
            <option value="6015"<?php if($data['form_param']['MobilePrefix']=='6015'){ ?> selected="selected"<?php } ?>>+6015</option>
            <option value="6016"<?php if($data['form_param']['MobilePrefix']=='6016'){ ?> selected="selected"<?php } ?>>+6016</option>
            <option value="6017"<?php if($data['form_param']['MobilePrefix']=='6017'){ ?> selected="selected"<?php } ?>>+6017</option>
            <option value="6018"<?php if($data['form_param']['MobilePrefix']=='6018'){ ?> selected="selected"<?php } ?>>+6018</option>
            <option value="6019"<?php if($data['form_param']['MobilePrefix']=='6019'){ ?> selected="selected"<?php } ?>>+6019</option>
            <option value="65"<?php if($data['form_param']['MobilePrefix']=='65'){ ?> selected="selected"<?php } ?>>+65</option>
          </select>
  	      <input type="text" class="validate[required, custom[mobileNo],minSize[7]]" name="MobileNo" id="MobileNo" value="" />&nbsp;&nbsp;<input class="button" type="submit" name="update" value="<?php echo Helper::translate("Update", "member-mobilesms-update"); ?>" /><span class="label_hint"><?php echo Helper::translate("(If you entered a wrong mobile number and want to update your mobile number for a resend of activation code. E.g. 2255667)", "member-mobilesms-update-note"); ?></span>

  </form>
</div>
