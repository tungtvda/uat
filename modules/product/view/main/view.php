<div id="product_view_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <div class="product_view_box">  	<div class="product-frame">  		<div class="product-button">  		<div class="product-title-style"><?php echo $data['content'][0]['Name']; ?></div>  		<img src="/themes/custom/img/playnow.png" />  		<img src="/themes/custom/img/viewdemo.png" />  		</div>  		<div class="product-frame-img"><img src="<?php echo $data['config']['SITE_URL'].$data['content'][0]['ImageURL']; ?>" /></div>  	</div>    <div class="product_desc"><?php echo $data['content'][0]['TypeID']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['FriendlyURL']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['CategoryID']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['ShortDesc']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['LongDesc']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['RRP']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['Price']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['SKU']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['Brand']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['Weight']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['Position']; ?></div>
    <div class="product_date"><?php echo $data['content'][0]['Tags']; ?></div>
    <div class="product_social">
      <!-- AddThis Button BEGIN -->
      <div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5050e2b007d1353b"></script>
        <!-- AddThis Button END -->
      </div>
    </div>
    <div class="product_content"><?php echo $data['content'][0]['Content']; ?></div>
    <div><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/product">&laquo; Back</a></div>
  </div>
  <?php } else { ?>
  <p>Product not found.</p>
  <?php } ?>
</div>
