<?php echo Helper::translate("Hi", "member-mail-forgotpassword-hi"); ?> <?php echo $request_data['Name']; ?>,


<?php echo Helper::translate("We have received your request for a new password:", "member-mail-forgotpassword-message-1"); ?>

<?php echo Helper::translate("Username:", "member-mail-forgotpassword-username"); ?> <?php echo $request_data['Username']; ?>
<?php echo Helper::translate("Password:", "member-mail-forgotpassword-password"); ?> <?php echo $new_password; ?>


<?php echo Helper::translate("To protect your account, please login to your account immediately at your register live game website and change your password. Thank you.", "member-mail-forgotpassword-message-2"); ?>
 
 
<?php echo Helper::translate("Best Regards,", "member-mail-forgotpassword-message-3"); ?>
<?php echo $this->config['COMPANY_NAME']; ?>