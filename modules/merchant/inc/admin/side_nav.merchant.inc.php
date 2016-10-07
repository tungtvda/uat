<div class="admin_common_block">
    <h1>Merchants</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchant/index">View All Merchants</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchant/add">Create Merchant</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Merchant</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchant/edit/<?php echo $data['parent']['id']; ?>">Edit Merchant</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Addresses</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantaddress/merchantindex/<?php echo $data['parent']['id']; ?>">View All Addresses</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantaddress/merchantadd/<?php echo $data['parent']['id']; ?>">Create Address</a></li>
    </ul>
</div>