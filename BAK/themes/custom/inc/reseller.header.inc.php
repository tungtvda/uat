<!-- <div id="header">  -->

	<div class="bg-header">
		<!--<a href="/">System<img style="padding: 18px 0 0 26px;" src="<?php echo $data['config']['THEME_DIR']; ?>img/cgame-logo.png" />--></a>

		<!-- <a href="/"><img src="<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_01.jpg" border="0" /></a> --><div id="home-input" style="float: right;padding: 0px 40px 15px 15px;">
	<?php if($_SESSION['reseller']['ID']=="") { ?>
	<!-- <form name="login_form" id="login_form" action="/member/member/loginprocess" method="post">
  <input type="text" name="Username" placeholder="Username">
  <input type="password" name="Password" placeholder="Password">
  <input type="submit" value="Login">
  <a href="/member/member/register" class="join">Join Now</a><br />
  <a style="float: right;" href="/member/member/forgotpassword">Forgot Password ?</a>
</form> -->
<?php } else { ?>
<div class="welcome">Welcome, <b><?php echo $_SESSION['reseller']['Name']; ?></b>.&nbsp;&nbsp;&nbsp;My Credit Balance (MYR): <?php echo ($_SESSION['reseller']['Credit'] =='')?'No Credit': Core::getHook('Credit-Balance'); ?></div>
<div id="member_in_box" style="margin: 20px 0 0 0;float: right;"><a href="/reseller/reseller/dashboard">Dashboard</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/member/index">My Members</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/transaction/index">Member Transactions</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/resellercredit/index">My Transactions</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/profile">My Profile</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/password">Change Password</a>&nbsp;<a href="/reseller/reseller/logout">Log Out</a></div>
<?php } ?>
</div>


	</div>