<div id="merchant_dashboard">
    <p>Welcome to your dashboard! Here you can view and manage all aspects of your account.</p>
    <div class="merchant_dashboard_box">
        <h2>Manage My Orders</h2>
        <ul>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/order/index">Order History</a></li>        
        </ul>
    </div>
    <div class="merchant_dashboard_box">
        <h2>Manage My Account</h2>
        <ul>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/dashboard">Dashboard</a></li>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/profile">My Profile</a></li>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchantaddress/index">My Addresses</a></li>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/password">Change Password</a></li>
        </ul>
    </div>
</div>