<?php if ($_SESSION['superid']=='1') { ?>
<header id="header_wrapper">
    <nav class="hide-for-large-up tab-bar">
      <?php if ($_SESSION['member']['ID']!='') { ?>
      <section class="left-small">
        <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
      </section>
      <?php } ?>
      <section class="middle tab-bar-section">
        <h1 class="title">Member Area</h1>
      </section>
      <?php /* ?>
      <section class="right-small">
        <a class="right-off-canvas-toggle menu-icon" href="#"><span></span></a>
      </section>
      <?php */ ?>
    </nav>
    <?php if ($_SESSION['member']['ID']!='') { ?>
    <aside class="left-off-canvas-menu">
      <ul class="off-canvas-list">
        <li><label>Get Started</label></li>
        <li><a href="/member/wallet/index"><?php echo Helper::translate("Wallet", "member-wallet-nav"); ?></a></li>
        <li><a href="/member/transaction/deposit"><?php echo Helper::translate("Deposit", "member-deposit-title"); ?></a></li>
        <li><a href="/member/transaction/transfer"><?php echo Helper::translate("Transfer", "member-transfer-title"); ?></a></li>
        <li><a href="/member/transaction/withdrawal"><?php echo Helper::translate("Withdrawal", "member-withdrawal-title"); ?></a></li>
        <li><a href="/member/transaction/index"><?php echo Helper::translate("History", "member-history-nav"); ?></a></li>
        <li><a href="/member/member/profile"><?php echo Helper::translate("My Profile", "member-profile-title"); ?></a></li>
        <li><a href="/member/member/password"><?php echo Helper::translate("Change Password", "member-password-title"); ?></a></li>
        <li><a href="/member/member/logout"><?php echo Helper::translate("Log Out", "member-logout"); ?></a></li>
      </ul>
    </aside>
    <?php } ?>
    <?php /* ?>
    <aside class="right-off-canvas-menu">
      <ul class="off-canvas-list">
        <li><label>Client Area</label></li>
        <?php if ($_SESSION['member']['ID']!='') { ?>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member"><i class="fa fa-user"></i>&nbsp;&nbsp; My Account</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/member/logout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Logout</a></li>
        <?php } else { ?>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/member/login"><i class="fa fa-sign-in"></i>&nbsp;&nbsp; Login</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/member/register"><i class="fa fa-user"></i>&nbsp;&nbsp; Register</a></li>
        <?php } ?>
        <?php /* ?><li><a href="<?php echo $data['config']['SITE_DIR']; ?>/merchant"><i class="fa fa-users"></i>&nbsp;&nbsp; Merchant Area</a></li><?php  ?>
      </ul>
    </aside>
    <?php */ ?>


	<div class="row" id="header">
        <div class="small-12 small-text-center medium-12 medium-text-right large-12 large-text-right show-for-large-up columns">
            <?php if ($_SESSION['member']['ID']!='') { ?>
            <span id="welcome"><?php echo Helper::translate("Welcome", "member-header-welcome"); ?>, <strong><?php echo $_SESSION['member']['Name']; ?></strong>.</span><span class="separator">|</span><?php echo Helper::translate("Main Wallet Balance", "member-header-wallet-balance"); ?> (MYR): <?php Core::getHook('welcome-block'); ?>

            <div id="<?php echo (empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE) ? 'overriden_member_in_box' : 'member_in_box';?>"><a href="/member/wallet/index"><?php echo Helper::translate("Wallet", "member-wallet-nav"); ?></a>&nbsp;<a href="/member/transaction/deposit"><?php echo Helper::translate("Deposit", "member-deposit-title"); ?></a>&nbsp;<a href="/member/transaction/transfer"><?php echo Helper::translate("Transfer", "member-transfer-title"); ?></a>&nbsp;<a href="/member/transaction/withdrawal"><?php echo Helper::translate("Withdrawal", "member-withdrawal-title"); ?></a>&nbsp;<a href="/member/transaction/index"><?php echo Helper::translate("History", "member-history-nav"); ?></a>&nbsp;<a href="/member/member/profile"><?php echo Helper::translate("My Profile", "member-profile-title"); ?></a>&nbsp;<a href="/member/member/password"><?php echo Helper::translate("Change Password", "member-password-title"); ?></a>&nbsp;<a href="/member/member/logout"><?php echo Helper::translate("Log Out", "member-logout"); ?></a></div>
            <?php } else { ?>
            <?php } ?>
        </div>
        <div class="small-12 small-text-center medium-12 medium-text-right columns hide-for-large-up">
            <?php if ($_SESSION['member']['ID']!='') { ?>
            <span><?php echo Helper::translate("Welcome", "member-header-welcome"); ?>, <strong><?php echo $_SESSION['member']['Name']; ?></strong>.</span><span class="separator">|</span><?php echo Helper::translate("Main Wallet Balance", "member-header-wallet-balance"); ?> (MYR): <?php Core::getHook('welcome-block'); ?>
            <?php } ?>
        </div>
    </div>
</header>

<?php } else { ?>



<!-- <div id="header">  -->

	<div class="bg-header">

		<!--<a href="/">System<img style="padding: 18px 0 0 26px;" src="<?php echo $data['config']['THEME_DIR']; ?>img/cgame-logo.png" />--></a>

		<!-- <a href="/"><img src="<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_01.jpg" border="0" /></a> -->
<div id="home-input" style="float: right;padding: 0px 40px 15px 15px;">
	<?php if($_SESSION['member']['ID']=="") { ?>
	<!-- <form name="login_form" id="login_form" action="/member/member/loginprocess" method="post">
  <input type="text" name="Username" placeholder="Username">
  <input type="password" name="Password" placeholder="Password">
  <input type="submit" value="Login">
  <a href="/member/member/register" class="join">Join Now</a><br />
  <a style="float: right;" href="/member/member/forgotpassword">Forgot Password ?</a>
</form> -->
<?php } else { ?>
<div class="welcome"><?php echo Helper::translate("Welcome", "member-header-welcome"); ?>, <b><?php echo $_SESSION['member']['Name']; ?></b>.&nbsp;&nbsp;&nbsp;<?php echo Helper::translate("Main Wallet Balance", "member-header-wallet-balance"); ?> (MYR): <?php Core::getHook('welcome-block'); ?></div>
<div id="<?php echo (empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE) ? 'overriden_member_in_box' : 'member_in_box';?>" style="margin: 20px 0 0 0;float: right;"><a href="/member/wallet/index"><?php echo Helper::translate("Wallet", "member-wallet-nav"); ?></a>&nbsp;<a href="/member/transaction/deposit"><?php echo Helper::translate("Deposit", "member-deposit-title"); ?></a>&nbsp;<a href="/member/transaction/transfer"><?php echo Helper::translate("Transfer", "member-transfer-title"); ?></a>&nbsp;<a href="/member/transaction/withdrawal"><?php echo Helper::translate("Withdrawal", "member-withdrawal-title"); ?></a>&nbsp;<a href="/member/transaction/index"><?php echo Helper::translate("History", "member-history-nav"); ?></a>&nbsp;<a href="/member/member/profile"><?php echo Helper::translate("My Profile", "member-profile-title"); ?></a>&nbsp;<a href="/member/member/password"><?php echo Helper::translate("Change Password", "member-password-title"); ?></a>&nbsp;<a href="/member/member/logout"><?php echo Helper::translate("Log Out", "member-logout"); ?></a></div>
<?php } ?>
</div>


	</div>
<div>
<?php //if($_SERVER['REMOTE_ADDR']=='1.9.124.44'){ ?>   
    <!--<select id="language">
  <option value="en"<?php if($_SESSION['language']=='en'){ ?> selected="selected" <?php }?>>English</option>
  <option value="zhCN"<?php if($_SESSION['language']=='zh_CN'){ ?> selected="selected" <?php }?>>Chinese</option>
  <option value="ms"<?php if($_SESSION['language']=='ms'){ ?> selected="selected" <?php }?>>Malay</option>
</select>-->
<?php //} ?>    
</div>
<?php } ?>