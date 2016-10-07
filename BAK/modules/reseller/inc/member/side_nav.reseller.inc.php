<!-- <div class="common_block member_block">
    <h1>My Orders</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/order/index">Order History</a></li>
    </ul>
</div> -->
<div class="common_block member_block">
    <h1>View My Members and Member Transactions</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/transaction/transfer">My Members</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/transaction/withdrawal">My Members' Wallet</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/transaction/index">My Members' Transaction</a></li>
    </ul>
</div>
<div class="common_block member_block">
    <h1>My Account</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/member/dashboard">Dashboard</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/member/profile">My Profile</a></li>
        <!-- <li><a href="<?php //echo $data['config']['SITE_DIR']; ?>/member/memberaddress/index">My Addresses</a></li> -->
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/member/password">Change Password</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/member/logout">Log Out</a></li>
    </ul>
</div>
<div class="common_block member_block">
<?php Core::getHook('block-tutorial'); ?>
</div>
<?php Core::getHook('left-column'); ?>