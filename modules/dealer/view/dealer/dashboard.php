<div id="dealer_dashboard">
    <p>Welcome to your dashboard! Here you can view and manage all aspects of your account.</p>
    <div class="dealer_dashboard_box">
        <h2>Manage My Orders</h2>
        <ul>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/order/index">Order History</a></li>        
        </ul>
    </div>
    <div class="dealer_dashboard_box">
        <h2>Manage My Account</h2>
        <ul>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/dealer/dashboard">Dashboard</a></li>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/dealer/profile">My Profile</a></li>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/dealeraddress/index">My Addresses</a></li>
            <li><a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/dealer/password">Change Password</a></li>
        </ul>
    </div>
</div>