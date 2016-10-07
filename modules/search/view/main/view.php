<div id="news_view_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <div class="news_view_box">
    <div class="news_date"><?php echo $data['content'][0]['Date']; ?>&nbsp;&nbsp;|&nbsp;&nbsp;By <span class="news_source"><?php echo $data['content'][0]['Source']; ?></span></div>
    <div class="news_social">
      <!-- AddThis Button BEGIN -->
      <div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5050e2b007d1353b"></script>
        <!-- AddThis Button END -->
      </div>
    </div>
    <div class="news_content"><?php echo $data['content'][0]['Content']; ?></div>
    <div><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/news">&laquo; Back</a></div>
  </div>
  <?php } else { ?>
  <p>News not found.</p>
  <?php } ?>
</div>
