<div class="admin_common_block">
    <h1>Orders</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/order/index">View All Orders</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/order/add">Create Order</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Order</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/order/edit/<?php echo $data['parent']['id']; ?>">Edit Order</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Transactions</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/orderindex/<?php echo $data['parent']['id']; ?>">View All Transactions</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/orderadd/<?php echo $data['parent']['id']; ?>">Create Transaction</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Items</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/orderitem/orderindex/<?php echo $data['parent']['id']; ?>">View All Order Items</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/orderitem/orderadd/<?php echo $data['parent']['id']; ?>">Create Order Item</a></li>
    </ul>
</div>