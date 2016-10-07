<?php if ($_SESSION['superid']=='1') { ?>

<div id="member_forgotpassword_wrapper">
	<div class="row">
		<div class="small-12 medium-12 large-12 columns">
			<?php if ($data['page']['member_forgotpassword']['error']['count']>0) { ?>
			    <?php if ($data['page']['member_forgotpassword']['error']['NoMatch']==1) { ?>
			    <div class="alert-box alert radius"><?php echo Helper::translate("The username and email do not match. Please try again.", "member-forgotpassword-error"); ?></div>
			    <?php } ?>
			<?php } ?>
			<p><?php echo Helper::translate("Please enter your username below and submit to retrieve a new password. If you have also lost your username or registered email, please ", "member-forgotpassword-message-1"); ?> <a href="<?php echo $data['config']['SITE_DIR']; ?>/contact#form"><?php echo Helper::translate("contact us", "member-forgotpassword-contactus"); ?></a> <?php echo Helper::translate("for further assistance.", "member-forgotpassword-message-2"); ?></p>
	    </div>
		<div class="small-12 medium-12 large-12 end columns">
		    <form id="forgotpassword_form" name="forgotpassword_form" class="common_block common_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/forgotpasswordprocess">
			    <div class="row">
			    	<div class="small-12 medium-12 large-2 columns">
			    		<label for="Username" class="inline"><?php echo Helper::translate("Username", "member-forgotpassword-username"); ?></label>
			    	</div>
			    	<div class="small-12 medium-8 large-6 end columns">
			    		<input type="text" class="validate[required]" name="Username" id="Username" placeholder="" value="<?php echo $data['form_param']['Username']; ?>" />
			    	</div>
		    	</div>
		    	<div class="row">
			    	<div class="small-12 medium-12 large-2 columns">
			    		<label for="Email" class="inline"><?php echo Helper::translate("Email", "member-forgotpassword-email"); ?></label>
			    	</div>
			    	<div class="small-12 medium-8 large-6 end columns">
			    		<input type="text" class="validate[required,custom[email]]" name="Email" id="Email" placeholder="" value="<?php echo $data['form_param']['Email']; ?>" />
			    	</div>
		    	</div>
		    	<div class="row">
			    	<div class="small-12 medium-12 large-10 large-offset-2 columns">
			    	    <input type="hidden" name="FPTrigger" value="1" />
			    		<input type="text" name="HPot" value="" class="hide-for-small-up" />
          				<input class="button" type="submit" name="submit" id="submit" value="<?php echo Helper::translate("Submit", "member-forgotpassword-submit"); ?>" />
			    	</div>
		    	</div>
			</form>
	    </div>
	</div>
</div>
<?php } else { ?>
<?php if ($data['page']['member_forgotpassword']['error']['count']>0) { ?>
    <?php if ($data['page']['member_forgotpassword']['error']['NoMatch']==1) { ?>
    <div class="error"><?php echo Helper::translate("The username and email do not match. Please try again.", "member-forgotpassword-error"); ?></div>
    <?php } ?>
<?php } ?>
<p><?php echo Helper::translate("Please enter your username below and submit to retrieve a new password. If you have also lost your username or registered email, please ", "member-forgotpassword-message-1"); ?> <a href="<?php echo $data['config']['SITE_DIR']; ?>/contact#form"><?php echo Helper::translate("contact us", "member-forgotpassword-contactus"); ?></a> <?php echo Helper::translate("for further assistance.", "member-forgotpassword-message-2"); ?></p>
<form name="forgotpassword_form" class="admin_table_noMobile"  id="forgotpassword_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/member/forgotpasswordprocess" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">
    <tr>
        <th scope="row"><label><?php echo Helper::translate("Username", "member-forgotpassword-username"); ?></label></th>
      <td><input name="Username" class="validate[required]" type="text" value="<?php echo $data['form_param']['Username']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Email", "member-forgotpassword-email"); ?></label></th>
      <td><input name="Email" class="validate[required,custom[email]]" type="text" value="<?php echo $data['form_param']['Email']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="hidden" name="FPTrigger" value="1" />
          <input type="hidden" name="HPot" value="" />
          <input type="submit" name="submit" value="<?php echo Helper::translate("Submit", "member-forgotpassword-submit"); ?>" class="button" /></td>
    </tr>
  </table>
</form>

<?php } ?>
