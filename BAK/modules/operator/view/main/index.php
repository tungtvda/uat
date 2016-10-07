<div class="left">
  <h1>What's New</h1>
  <?php if ($data['content_param']['count']>0) { ?>
    <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
    <div class="news_box">
    <h2><a href="/main/news/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Title']; ?></a></h2>
    <div class="news_date"><?php echo $data['content'][$i]['Date']; ?></div>
    <div class="news_desc"><?php echo $data['content'][$i]['Description']; ?></div>
    <div class="news_more"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/news/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
    </div>
    <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>Coming soon...</p>
  <?php } ?>
</div>
<div class="right">
  <?php include($data['config']['THEME_DIR_INC'].'inc/side_add.inc.php'); ?>
</div>
<div class="clear"></div>
