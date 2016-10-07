<div class="common_block member_block">
<!--<h1><?php //echo Helper::translate("Be a Member", "member-side-member"); ?></h1>
    <p><?php //echo Helper::translate("Register with us and start enjoy the following benefits:", "member-side-register"); ?></p>
    <ul>
        <li><?php //echo Helper::translate("Keep track of your orders", "member-side-order"); ?></li>
        <li><?php //echo Helper::translate("Get first-hand news on our latest events", "member-side-information"); ?></li>
    </ul>
    <br />-->
<?php if($_SESSION['language']=='zh_CN'){ ?>  
    
    <?php Core::getHook('cn-member-member-block'); ?>  
<?php }elseif($_SESSION['language']=='en'){ ?>
    
    <?php Core::getHook('member-member-block'); ?>     
<?php }elseif($_SESSION['language']=='ms'){ ?> 
    
    <?php Core::getHook('ms-member-member-block'); ?> 
<?php } ?>    
</div>
<!-- <div class="common_block member_block">
    <h1>Your Data is Secured</h1>
    <p>This website uses COMODO SSL to securely encrypt your data with us.</p>
    <img style="margin:0 auto; display:block;" src="<?php echo $data['config']['THEME_DIR']; ?>img/seal_positive_ssl.gif" />
</div> -->
<?php Core::getHook('left-column'); ?>