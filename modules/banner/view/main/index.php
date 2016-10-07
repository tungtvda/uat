<div id="banner_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="banner_list_box">
    <h2><a href="/main/banner/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Name']; ?></a></h2>
    <div class="banner_desc"><?php echo $data['content'][$i]['Name']; ?></div>
    <div class="banner_desc"><?php echo $data['content'][$i]['ImageURL']; ?></div>
    <div class="banner_desc"><?php echo $data['content'][$i]['Link']; ?></div>
    <div class="banner_desc"><?php echo $data['content'][$i]['AltTitle']; ?></div>
    <div class="banner_desc"><?php echo $data['content'][$i]['Target']; ?></div>
    <div class="banner_desc"><?php echo $data['content'][$i]['Position']; ?></div>
    <div class="banner_more"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/banner/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No banners yet.</p>
  <?php } ?>
</div>
