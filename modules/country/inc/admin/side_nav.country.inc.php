<div class="admin_common_block">
    <h1>Countries</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/country/index">View All Countries</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/country/add">Create Country</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Country</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/country/edit/<?php echo $data['parent']['id']; ?>">Edit Country</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage States</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/state/countryindex/<?php echo $data['parent']['id']; ?>">View All States</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/state/countryadd/<?php echo $data['parent']['id']; ?>">Create State</a></li>
    </ul>
</div>