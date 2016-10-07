<div id="app_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="app_list_box">
    <h2><a href="/main/app/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Name']; ?></a></h2>
    <div class="app_desc"><?php echo $data['content'][$i]['Name']; ?></div>
    <div class="app_desc"><?php echo $data['content'][$i]['Username']; ?></div>
    <div class="app_desc"><?php echo $data['content'][$i]['Password']; ?></div>
    <div class="app_desc"><?php echo $data['content'][$i]['Domain']; ?></div>
    <div class="app_more"><a href="<?php echo $data['config']['SITE_URL']; ?>/main/app/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No app yet.</p>
  <?php } ?>
</div>
