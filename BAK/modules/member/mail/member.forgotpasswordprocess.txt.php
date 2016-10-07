<?php echo Helper::translate("Hi", "member-mail-forgotpassword-hi"); ?> <?php echo $param['content'][0]['Name']; ?>,


<?php echo Helper::translate("We have received your request for a new password:", "member-mail-forgotpassword-message-1"); ?>

<?php echo Helper::translate("Username:", "member-mail-forgotpassword-username"); ?> <?php echo $param['content'][0]['Username']; ?>
<?php echo Helper::translate("Password:", "member-mail-forgotpassword-password"); ?> <?php echo $param['content_param']['new_password']; ?>


<?php echo Helper::translate("To protect your account, please login to your account immediately at your register live game website and change your password. Thank you.", "member-mail-forgotpassword-message-2"); ?>
 
 
<?php echo Helper::translate("Best Regards,", "member-mail-forgotpassword-message-3"); ?>
<?php echo $param['config']['COMPANY_NAME']; ?>