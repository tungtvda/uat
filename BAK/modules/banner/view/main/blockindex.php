<?php if ($data['content_param']['count']>0) { ?>
<div id="banner_wrapper">
	<div class="slider-wrapper theme-default">
		<div id="slider" class="nivoSlider">
			<?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
            <?php if ($data['content'][$i]['Link']!='') { ?>
			<a href="<?php echo $data['content'][$i]['Link']; ?>" <?php if ($data['content'][$i]['Target']=='1') { ?>target="_blank"<?php } ?>><img src="<?php echo $data['content'][$i]['ImageURL']; ?>" data-thumb="<?php echo $data['content'][$i]['ImageURL']; ?>" alt="<?php echo $data['content'][$i]['AltTitle']; ?>" title="" /></a>
			<?php } else { ?>
			<img src="<?php echo $data['config']['SITE_DIR']; ?><?php echo $data['content'][$i]['ImageURL']; ?>" data-thumb="<?php echo $data['content'][$i]['ImageURL']; ?>" alt="<?php echo $data['content'][$i]['AltTitle']; ?>" title="" />
			<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/nivo-slider/jquery.nivo.slider.js"></script>
<script type="text/javascript">
	$(window).load(function() {
		$('#slider').nivoSlider();
	}); 
</script>
<?php } ?>