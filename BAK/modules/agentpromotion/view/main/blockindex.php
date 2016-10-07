<div class="widget">
    <h1>Latest Testimonial</h1>
    <?php if ($data['content_param']['count']>0) { ?>
      <ul>
        <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
        <li>
          <a href="/main/testimonial/<?php echo $data['content'][$i]['FriendlyURL']; ?>"><?php echo $data['content'][$i]['Message']; ?></a>
        </li>
        <?php } ?>
      </ul>
      <div class="text-right more_link"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/testimonial/index">More testimonials &raquo;</a></div>
      <?php } else { ?>
      <p>
          No testimonial yet.
      </p>
    <?php } ?>
</div>
