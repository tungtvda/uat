<div class="common_block dealer_block">
    <h1>My Orders</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/order/index">Order History</a></li>
    </ul>
</div>
<div class="common_block dealer_block">
    <h1>My Points</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/pointtransaction/index">Point Transactions</a></li>
    </ul>
</div>
<div class="common_block dealer_block">
    <h1>My Store</h1>
    <ul>
    	<li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/merchant/index">Manage Merchants</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/listing/index">Manage Merchant Directory Listings</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/merchantdeal/index">Manage Merchant Deals</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/ad/index">Manage Merchant Ads</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/index">Manage Merchant Bookings</a></li>
    </ul>
</div>
<div class="common_block dealer_block">
    <h1>My Account</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/dealer/dashboard">Dashboard</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/dealer/profile">My Profile</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/dealeraddress/index">My Addresses</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/dealer/password">Change Password</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/dealer/logout">Log Out</a></li>
    </ul>
</div>
<?php Core::getHook('left-column'); ?>