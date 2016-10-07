<?php echo Helper::translate("Hi", "member-mail-register-hi"); ?> <?php echo $param['content']['Name']; ?>,


<?php echo Helper::translate("Congratulations on your new account! You're all set to get the best of what", "member-mail-register-message-1"); ?> <?php echo $param['config']['SITE_NAME']; ?> <?php echo Helper::translate("can offer.", "member-mail-register-message-2"); ?>

<?php echo Helper::translate("Username:", "member-mail-register-username"); ?> <?php echo $param['content']['Username']; ?>

<?php echo Helper::translate("To access your account, please visit our", "member-mail-register-message-3"); ?> <?php echo $param['config']['SITE_URL']; ?><?php echo $param['config']['SITE_DIR']; ?>.
 
 
<?php echo Helper::translate("Best Regards,", "member-mail-register-message-6"); ?>
<?php echo $param['config']['COMPANY_NAME']; ?>