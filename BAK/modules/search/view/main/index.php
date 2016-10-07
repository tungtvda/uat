<div id="news_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="news_list_box">
    <div class="news_list_box_left"><img src="<?php echo $data['content'][$i]['CoverImage']; ?>" /></div>
    <div class="news_list_box_right">
      <h2><a href="/main/news/<?php echo $data['content'][$i]['FriendlyURL']; ?>"><?php echo $data['content'][$i]['Title']; ?></a></h2>
      <div class="news_date"><?php echo $data['content'][$i]['Date']; ?>&nbsp;&nbsp;|&nbsp;&nbsp;By <span class="news_source"><?php echo $data['content'][$i]['Source']; ?></span></div>
      <div class="news_desc"><?php echo $data['content'][$i]['Description']; ?></div>
      <div class="news_more"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/news/<?php echo $data['content'][$i]['FriendlyURL']; ?>">Read more &raquo;</a></div>
    </div>
    <div class="clear"></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No news yet.</p>
  <?php } ?>
</div>
