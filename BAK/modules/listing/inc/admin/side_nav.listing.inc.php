<div class="admin_common_block">
    <h1>Listings</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/listing/index">View All Listings</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/listing/add">Create Listing</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Listing</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/listing/edit/<?php echo $data['parent']['id']; ?>">Edit Listing</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Photos</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/listingphoto/listingindex/<?php echo $data['parent']['id']; ?>">View All Photos</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/listingphoto/listingadd/<?php echo $data['parent']['id']; ?>">Create Photo</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Merchant Deals</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantdeal/listingindex/<?php echo $data['parent']['id']; ?>">View All Merchant Deals</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantdeal/listingadd/<?php echo $data['parent']['id']; ?>">Create Merchant Deal</a></li>
    </ul>
</div>
<div class="admin_common_block">
    <h1>Manage Bookings</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/booking/listingindex/<?php echo $data['parent']['id']; ?>">View All Bookings</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/admin/booking/listingadd/<?php echo $data['parent']['id']; ?>">Create Booking</a></li>
    </ul>
</div>