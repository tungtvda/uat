<?php /* ?><!-- <div class="common_block member_block">
    <h1>My Orders</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/order/index">Order History</a></li>
    </ul>
</div> -->
<div class="common_block member_block">
    <h1>Reseller's Member Transactions</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/member/index">My Members</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/transaction/index">Member Transactions</a></li>

    </ul>
</div>
<div class="common_block member_block">
    <h1>My Credit Transactions</h1>
    <ul>
    	<li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/resellercredit/index">My Transactions</a></li>
        <!--<li>RM <?php echo ($_SESSION['reseller']['Credit'] =='')?'No Credit': Helper::displayCurrency($_SESSION['reseller']['Credit']); ?></li>-->
        <!--<li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/profile">My Profile</a></li>-->
        <!-- <li><a href="<?php //echo $data['config']['SITE_DIR']; ?>/member/memberaddress/index">My Addresses</a></li> -->
        <!--<li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/password">Change Password</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/logout">Log Out</a></li>-->
    </ul>
</div>
<div class="common_block member_block">
    <h1>My Account</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/dashboard">Dashboard</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/profile">My Profile</a></li>
        <!-- <li><a href="<?php //echo $data['config']['SITE_DIR']; ?>/member/memberaddress/index">My Addresses</a></li> -->
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/password">Change Password</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/logout">Log Out</a></li>
    </ul>
</div>
<!--<div class="common_block member_block">
<?php //Core::getHook('block-tutorial'); ?>
</div>-->
<?php */ ?>
<?php Core::getHook('left-column'); ?>