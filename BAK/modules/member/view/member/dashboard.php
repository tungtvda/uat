<div id="member_dashboard">
    <p><?php echo Helper::translate("Welcome to your dashboard! Here you can view and manage all aspects of your account.", "member-dashboard-message"); ?></p>
    <br />
    <div id="member_dashboard_box">
    	<div class="member_dashboard_box">
        <h2><?php echo Helper::translate("Manage My Account", "member-dashboard-manage-title"); ?></h2>
        <ul>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/member/dashboard"><?php echo Helper::translate("Dashboard", "member-dashboard-title"); ?></a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/member/profile"><?php echo Helper::translate("My Profile", "member-dashboard-profile"); ?></a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/member/password"><?php echo Helper::translate("Change Password", "member-dashboard-changepassword"); ?></a></li>
        </ul>
    </div>
    <div class="member_dashboard_box">
        <h2><?php echo Helper::translate("Manage My Transactions", "member-dashboard-managemytransactions"); ?></h2>
        <ul>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/wallet/index"><?php echo Helper::translate("Wallet", "member-dashboard-wallet"); ?></a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/transfer"><?php echo Helper::translate("Transfer", "member-dashboard-transfer"); ?></a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/deposit"><?php echo Helper::translate("Deposit", "member-dashboard-deposit"); ?></a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/withdrawal"><?php echo Helper::translate("Withdrawal", "member-dashboard-withdrawal"); ?></a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index"><?php echo Helper::translate("Transaction History", "member-dashboard-transactionhistory"); ?></a></li>
        </ul>
    </div>
    </div>
</div>
<p>&nbsp;</p>