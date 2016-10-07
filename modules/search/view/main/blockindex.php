<div class="common_block">
    <h1>Latest News</h1>
    <?php if ($data['content_param']['count']>0) { ?>
      <ul>
        <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
        <li>
          <a href="/main/news/<?php echo $data['content'][$i]['FriendlyURL']; ?>"><?php echo $data['content'][$i]['Title']; ?></a>
        </li>
        <?php } ?>
      </ul>
      <div class="more_link"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/news/index">More news &raquo;</a></div>
      <?php } else { ?>
      <p>
          No news yet.
      </p>
    <?php } ?>
</div>
