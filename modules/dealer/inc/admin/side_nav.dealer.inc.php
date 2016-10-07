<div class="admin_common_block">
    <h1>Dealers</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/index">View All Dealers</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/add">Create Dealer</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Dealer</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealer/edit/<?php echo $data['parent']['id']; ?>">Edit Dealer</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Addresses</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealeraddress/dealerindex/<?php echo $data['parent']['id']; ?>">View All Addresses</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealeraddress/dealeradd/<?php echo $data['parent']['id']; ?>">Create Address</a></li>
    </ul>
</div>