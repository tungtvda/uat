Hi <?php echo $param['content'][0]['Name']; ?>,


We have received your request for a new password:

Username: <?php echo $param['content'][0]['Username']; ?>
Password: <?php echo $param['content_param']['new_password']; ?>


To protect your account, please login to your account immediately at <?php echo $param['config']['SITE_URL']; ?><?php echo $param['config']['SITE_DIR']; ?>/admin and change your password. Thank you.
 
 
Best Regards,
<?php echo $param['config']['COMPANY_NAME']; ?>