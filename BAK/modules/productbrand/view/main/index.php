<div id="productbrand_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="productbrand_list_box">
    <h2><a href="/main/productbrand/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Name']; ?></a></h2>
    <div class="productbrand_date"><?php echo $data['content'][$i]['Name']; ?></div>
    <div class="productbrand_date"><?php echo $data['content'][$i]['FriendlyURL']; ?></div>
    <div class="productbrand_date"><?php echo $data['content'][$i]['Description']; ?></div>
    <div class="productbrand_desc"><?php echo $data['content'][$i]['ImageURL']; ?></div>
    <div class="productbrand_more"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/productbrand/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No Product Brands yet.</p>
  <?php } ?>
</div>
