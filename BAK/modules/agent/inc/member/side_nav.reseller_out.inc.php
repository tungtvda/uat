<div class="common_block member_block">
    <h1>Be a Member</h1>
    <p>Register with us and start enjoy the following benefits:</p>
    <ul>
        <li>Keep track of your orders</li>
        <li>Get first-hand news on our latest events</li>
    </ul>
    <br />
    <?php if ($_GET['action']!="register") { ?>
    <div>Not registered with us yet?<br /><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/member/register">Register today!</a></div>
    <?php } ?>
</div>
<!-- <div class="common_block member_block">
    <h1>Your Data is Secured</h1>
    <p>This website uses COMODO SSL to securely encrypt your data with us.</p>
    <img style="margin:0 auto; display:block;" src="<?php echo $data['config']['THEME_DIR']; ?>img/seal_positive_ssl.gif" />
</div> -->
<?php Core::getHook('left-column'); ?>