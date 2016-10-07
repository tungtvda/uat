<div class="common_block">
    <h1>Latest Page</h1>
    <?php if ($data['content_param']['count']>0) { ?>
      <ul>
        <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
        <li>
          <a href="/main/page/<?php echo $data['content'][$i]['FriendlyURL']; ?>"><?php echo $data['content'][$i]['Title']; ?></a>
        </li>
        <?php } ?>
      </ul>
      <?php } else { ?>
      <p>
          No page yet.
      </p>
    <?php } ?>
</div>
