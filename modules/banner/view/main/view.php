<div id="banner_view_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <div class="banner_view_box">
    <div class="banner_date"><?php echo $data['content'][0]['Name']; ?></div>
    <div class="banner_date"><?php echo $data['content'][0]['ImageURL']; ?></div>
    <div class="banner_date"><?php echo $data['content'][0]['Link']; ?></div>
    <div class="banner_date"><?php echo $data['content'][0]['AltTitle']; ?></div>
    <div class="banner_date"><?php echo $data['content'][0]['Target']; ?></div>
    <div class="banner_date"><?php echo $data['content'][0]['Position']; ?></div>
    <div class="banner_social">
      <!-- AddThis Button BEGIN -->
      <div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5050e2b007d1353b"></script>
        <!-- AddThis Button END -->
      </div>
    </div>
    <div class="banner_content"><?php echo $data['content'][0]['Content']; ?></div>
    <div><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/banner">&laquo; Back</a></div>
  </div>
  <?php } else { ?>
  <p>Banner not found.</p>
  <?php } ?>
</div>