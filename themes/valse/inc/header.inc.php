<div id="header">
	<div class="logo">
		<a href="/"><img src="<?php echo $data['config']['THEME_DIR']; ?>img/logo.gif" border="0" /></a>
	</div>
	<div id="social">
		<a target="_blank" href="http://socials.valse.com.my/?s=facebook"><img src="<?php echo $data['config']['THEME_DIR']; ?>img/icon_fb.png" /></a><a target="_blank" href="http://socials.valse.com.my/?s=twitter"><img src="<?php echo $data['config']['THEME_DIR']; ?>img/icon_twitter.png" /></a><a target="_blank" href="http://socials.valse.com.my/?s=google.plus"><img src="<?php echo $data['config']['THEME_DIR']; ?>img/icon_gplus.png" /></a>
	</div>
	<div id="social_text">
		Connect to us:
	</div>
	<div id="member_links">
	    <?php if ($_SESSION['member']['ID']!='') { ?>
        Welcome, <strong><?php echo $_SESSION['member']['Name']; ?></strong>.&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $data['config']['SITE_URL']; ?>/member">My Account</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $data['config']['SITE_URL']; ?>/member/member/logout">Logout</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $data['config']['SITE_URL']; ?>/cart/order/index">Cart ()</a>
		<?php } else { ?>
        <a href="<?php echo $data['config']['SITE_URL']; ?>/member/member/login">Login</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $data['config']['SITE_URL']; ?>/member/member/register">Register</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $data['config']['SITE_URL']; ?>/cart/order/index">Cart (<?php echo (($_SESSION['cart']['quantity']!="") ? $_SESSION['cart']['quantity'] : '0'); ?> items)</a>
        <?php } ?>
	</div>
	<div class="clear"></div>
</div>