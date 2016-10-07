<?php if ($data['content_param']['status']==1) { ?>
    <?php if ($data['content_param']['method']=='membership-upgrade') { ?>        
        <p>Thank you for your payment!</p>
        <p>Your account has been upgraded to Paid Member.</p>
    <?php } ?>
    <?php if ($data['content_param']['method']=='membership-renew') { ?>        
        <p>Thank you for your payment!</p>
        <p>Your Membership has been renewed.</p>
    <?php } ?>
    <?php if($data['content'] == "1"){ ?>
    <p>Please visit <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/order/index">Order History</a> to view more details.</p>
    <?php }else{ ?>
    <p>Please visit <a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/order/index">Order History</a> to view more details.</p>	
    <?php } ?>	
<?php } else { ?>
Order has not been processed successfully.</p>
<p>Please try again or <a href="<?php echo $data['config']['SITE_URL']; ?>/contact">contact us for assistance</a>. 
<?php } ?>