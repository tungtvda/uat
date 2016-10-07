<div class="admin_common_block">
    <h1>Menus</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/menu/index">View All Menus</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/menu/add">Create Menu</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Menu</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/menu/edit/<?php echo $data['parent']['id']; ?>">Edit Menu</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Menu Items</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/menuitem/menuindex/<?php echo $data['parent']['id']; ?>">View All Menu Items</a></li>
        <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/menuitem/menuadd/<?php echo $data['parent']['id']; ?>">Create Menu Item</a></li>
    </ul>
</div>