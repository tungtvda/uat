<div id="productcategory_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="productcategory_list_box">
    <h2><a href="/main/productcategory/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Name']; ?></a></h2>
    <div class="productcategory_date"><?php echo $data['content'][$i]['ParentID']; ?></div>
    <div class="productcategory_date"><?php echo $data['content'][$i]['FriendlyURL']; ?></div>
    <div class="productcategory_desc"><?php echo $data['content'][$i]['Position']; ?></div>
    <div class="productcategory_date"><?php echo $data['content'][$i]['Description']; ?></div>
    <div class="productcategory_desc"><?php echo $data['content'][$i]['ImageURL']; ?></div>
    <div class="productcategory_more"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/productcategory/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No Product Categories yet.</p>
  <?php } ?>
</div>
