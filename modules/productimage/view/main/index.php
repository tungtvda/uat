<div id="productimage_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="productimage_list_box">
    <h2><a href="/main/productimage/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Title']; ?></a></h2>
    <div class="productimage_desc"><?php echo $data['ProductID'][$i]['ProductID']; ?></div>
    <div class="productimage_desc"><?php echo $data['ImageURL'][$i]['ImageURL']; ?></div>
    <div class="productimage_desc"><?php echo $data['Cover'][$i]['Cover']; ?></div>
    <div class="productimage_desc"><?php echo $data['Position'][$i]['Position']; ?></div>
    <div class="productimage_more"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/productimage/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No product images yet.</p>
  <?php } ?>
</div>
