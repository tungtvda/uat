<?php if ($_SESSION['superid']=='1') { ?>
<div id="member_password_wrapper">
	<div class="row">
		<div class="small-12 medium-12 large-12 columns">
			<?php if ($_SESSION['member']['Prompt']==1) { ?>
			<div class="alert-box success radius"><?php echo Helper::translate("To protect your account, please enter a new password.", "member-password-prompt"); ?></div>
			<?php } ?>
			<?php if ($data['page']['member_password']['error']['count']>0) { ?>
			    <?php if ($data['page']['member_password']['error']['Password']==1) { ?>
			    <div class="alert-box alert radius"><?php echo Helper::translate("Current password entered is incorrect. Please try again.", "member-password-error"); ?></div>
			    <?php } ?>
			<?php } ?>
	    </div>
		<div class="small-12 medium-12 large-12 end columns">
		    <form id="password_form" name="password_form" class="common_block common_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/passwordprocess">
		    	<div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Company" class="inline"><?php echo Helper::translate("Current Password", "member-password-currentpassword"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-8 large-6 end columns">
			    		<input type="password" class="validate[required]" name="Password" id="Password" placeholder="" />
			    	</div>
		    	</div>
		    	<div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Company" class="inline"><?php echo Helper::translate("New Password", "member-password-newpassword"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-8 large-6 end columns">
			    		<input type="password" class="validate[required,minSize[5]]" name="PasswordNew" id="PasswordNew" placeholder="" />
			    	</div>
		    	</div>
		    	<div class="row">
			    	<div class="small-12 medium-12 large-3 columns">
			    		<label for="Company" class="inline"><?php echo Helper::translate("Confirm New Password", "member-password-confirmnewpassword"); ?><span class="label_required">*</span></label>
			    	</div>
			    	<div class="small-12 medium-8 large-6 end columns">
			    		<input type="password" class="validate[required,equals[PasswordNew]]" name="PasswordConfirm" id="PasswordConfirm" placeholder="" />
			    	</div>
		    	</div>
		    	<div class="row">
			    	<div class="small-12 medium-12 large-9 large-offset-3 columns">
                        <input type="hidden" id="PasswordTrigger" name="PasswordTrigger" value="1" />
			            <input class="button" type="submit" name="submit" id="submit" value="<?php echo Helper::translate("Submit", "member-password-submit"); ?>" />
			    	</div>
		    	</div>
			</form>
	    </div>
	</div>
</div>
<?php } else { ?> 
<?php if ($_SESSION['member']['Prompt']==1) { ?>
<div class="notify"><?php echo Helper::translate("To protect your account, please enter a new password.", "member-password-prompt"); ?></div>
<?php } ?>
<?php if ($data['page']['member_password']['error']['count']>0) { ?>
    <?php if ($data['page']['member_password']['error']['Password']==1) { ?>
    <div class="error"><?php echo Helper::translate("Current password entered is incorrect. Please try again.", "member-password-error"); ?></div>
    <?php } ?>
<?php } ?>
<form class="admin_table_nocell" name="password_form" id="password_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/passwordprocess">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Current Password", "member-password-currentpassword"); ?><span class="label_required">*</span></label></th>
      <td><input type="password" class="validate[required]" name="Password" id="Password" value="" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("New Password", "member-password-newpassword"); ?><span class="label_required">*</span></label></th>
      <td><input type="password" class="validate[required],minSize[5]" name="PasswordNew" id="PasswordNew" value="" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Confirm New Password", "member-password-confirmnewpassword"); ?><span class="label_required">*</span></label></th>
      <td><input type="password" class="validate[required],equals[PasswordNew]" name="PasswordConfirm" id="PasswordConfirm" value="" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <input type="hidden" id="PasswordTrigger" name="PasswordTrigger" value="1" />
      <td><input class="button" type="submit" name="submit" value="<?php echo Helper::translate("Submit", "member-password-submit"); ?>" /></td>
    </tr>
  </table>
</form>    
<?php } ?>    
