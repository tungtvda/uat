<div id="address_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="address_list_box">
    <h2><a href="/main/address/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Title']; ?></a></h2>
    <div class="address_desc"><?php echo $data['content'][$i]['Title']; ?></div>
    <div class="address_desc"><?php echo $data['content'][$i]['Street']; ?></div>
    <div class="address_desc"><?php echo $data['content'][$i]['Street2']; ?></div>
    <div class="address_desc"><?php echo $data['content'][$i]['City']; ?></div>
    <div class="address_desc"><?php echo $data['content'][$i]['State']; ?></div>
    <div class="address_desc"><?php echo $data['content'][$i]['Country']; ?></div>
    <div class="address_desc"><?php echo $data['content'][$i]['PhoneNo']; ?></div>
    <div class="address_desc"><?php echo $data['content'][$i]['FaxNo']; ?></div>
    <div class="address_desc"><?php echo $data['content'][$i]['Email']; ?></div>
    <div class="address_desc"><?php echo $data['content'][$i]['Postcode']; ?></div>
    <div class="address_more"><a href="<?php echo $data['config']['SITE_URL']; ?>/main/address/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No addresses yet.</p>
  <?php } ?>
</div>
