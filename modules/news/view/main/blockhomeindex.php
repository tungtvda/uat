<h2>Corporate News</h2>
<div id="news_wrapper">
	<?php if ($data['content_param']['count']>0) { ?>
  <ul class="news_list_box">
	<?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
    <li class="news_list_box_right">
      <a href="/main/news/<?php echo $data['content'][$i]['FriendlyURL']; ?>"><?php echo $data['content'][$i]['Title']; ?></a>
    </li>
  	<?php } ?>
  </ul>
  <div class="text_right"><a href="/main/news/index">Read more &raquo;</a></div>
	<?php } else { ?>
	<p>
		No news yet.
	</p>
	<?php } ?>
</div>
