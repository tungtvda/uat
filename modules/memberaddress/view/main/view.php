<div id="address_view_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <div class="address_view_box">
    <div class="address_date"><?php echo $data['content'][0]['Title']; ?></div>
    <div class="address_date"><?php echo $data['content'][0]['Street']; ?></div>
    <div class="address_date"><?php echo $data['content'][0]['Street2']; ?></div>
    <div class="address_date"><?php echo $data['content'][0]['City']; ?></div>
    <div class="address_date"><?php echo $data['content'][0]['State']; ?></div>
    <div class="address_date"><?php echo $data['content'][0]['Country']; ?></div>
    <div class="address_date"><?php echo $data['content'][0]['PhoneNo']; ?></div>
    <div class="address_date"><?php echo $data['content'][0]['FaxNo']; ?></div>
    <div class="address_date"><?php echo $data['content'][0]['Email']; ?></div>
    <div class="address_date"><?php echo $data['content'][0]['Postcode']; ?></div>
    <div class="address_social">
      <!-- AddThis Button BEGIN -->
      <div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5050e2b007d1353b"></script>
        <!-- AddThis Button END -->
      </div>
    </div>
    <div><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/address">&laquo; Back</a></div>
  </div>
  <?php } else { ?>
  <p>Address not found.</p>
  <?php } ?>
</div>
