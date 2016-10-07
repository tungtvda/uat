<div id="app_view_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <div class="app_view_box">
    <div class="app_desc"><?php echo $data['content'][0]['Name']; ?></div>
    <div class="app_desc"><?php echo $data['content'][0]['Username']; ?></div>
    <div class="app_desc"><?php echo $data['content'][0]['Password']; ?></div>
    <div class="app_desc"><?php echo $data['content'][0]['Domain']; ?></div>
    <div class="app_social">
      <!-- AddThis Button BEGIN -->
      <div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5050e2b007d1353b"></script>
        <!-- AddThis Button END -->
      </div>
    </div>
    <div><a href="<?php echo $data['config']['SITE_URL']; ?>/main/app">&laquo; Back</a></div>
  </div>
  <?php } else { ?>
  <p>App not found.</p>
  <?php } ?>
</div>
