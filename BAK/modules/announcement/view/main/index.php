<div id="announcement_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="announcement_list_box">
    <h2><a href="/main/announcement/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Title']; ?></a></h2>
    <div class="announcement_date"><?php echo $data['content'][$i]['Date']; ?></div>
    <div class="announcement_desc"><?php echo $data['content'][$i]['Description']; ?></div>
    <div class="announcement_desc"><?php echo $data['content'][$i]['Content']; ?></div>
    <div class="announcement_more"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/announcement/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No announcements yet.</p>
  <?php } ?>
</div>
