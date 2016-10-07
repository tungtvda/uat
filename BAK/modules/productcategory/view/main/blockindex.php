<div class="common_block">
    <h1>Latest Product Category</h1>
    <?php if ($data['content_param']['count']>0) { ?>
      <ul>
        <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
        <li>
          <a href="/main/productcategory/<?php echo $data['content'][$i]['FriendlyURL']; ?>"><?php echo $data['content'][$i]['Name']; ?></a>
        </li>
        <?php } ?>
      </ul>
      <div class="more_link"><a href="<?php echo $data['config']['SITE_DIR']; ?>/main/productcategory/index">More product categories &raquo;</a></div>
      <?php } else { ?>
      <p>
          No product category yet.
      </p>
    <?php } ?>
</div>
