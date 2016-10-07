<div id="testimonial_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="testimonial_list_box">
    <h2><a href="/main/testimonial/view/<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Title']; ?></a></h2>
    <div class="testimonial_desc"><?php echo $data['content'][$i]['Author']; ?></div>
    <div class="testimonial_desc"><?php echo $data['content'][$i]['Message']; ?></div>
    <div class="testimonial_desc"><?php echo $data['content'][$i]['Rating']; ?></div>
    <div class="testimonial_date"><?php echo $data['content'][$i]['Status']; ?></div>
    <div class="testimonial_more"><a href="<?php echo $data['config']['SITE_URL']; ?>/main/testimonial/view/<?php echo $data['content'][$i]['ID']; ?>">Read more &raquo;</a></div>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No testimonials yet.</p>
  <?php } ?>
</div>

