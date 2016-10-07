<div id="career_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="career_list_box">
    <h2><a href="/main/career/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Title']; ?></a></h2>
    <div class="career_desc"><?php echo $data['content'][$i]['Code']; ?></div>
    <div class="career_date"><?php echo $data['content'][$i]['DatePosted']; ?></div>
    <div class="career_desc"><?php echo $data['content'][$i]['Description']; ?></div>
    <div class="career_more"><a href="<?php echo $data['config']['SITE_URL']; ?>/main/career/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No careers yet.</p>
  <?php } ?>
</div>
