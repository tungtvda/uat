<div id="pagecategory_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="pagecategory_list_box">
    <h2><a href="/main/pagecategory/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Name']; ?></a></h2>
    <div class="pagecategory_date"><?php echo $data['content'][$i]['ParentID']; ?></div>
    <div class="pagecategory_desc"><?php echo $data['content'][$i]['Position']; ?></div>
    <div class="pagecategory_more"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/pagecategory/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No page categories yet.</p>
  <?php } ?>
</div>
