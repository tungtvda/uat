	<?php if($_SESSION['manual']['merchant']['status']!=""){ ?>
    <?php if ($_SESSION['manual']['merchant']['status']=="1") { ?>
    <div class="notify">Manual payment paid successfully.</div>
    <?php }else{ ?>
    <div class="error">Manual payment paid unsuccessfully.</div>
    <?php }
	unset($_SESSION['manual']['merchant']['status']);
	 ?>
	 <?php } ?>
    
<div class="member_results">
  <div class="results_left">
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right"><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="member_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="white-space:nowrap; text-align: center">Order No</th>
    <th>Item</th>
    <th class="center">Payment Method</th>
    <th class="text_right">Total (RM)</th>
    <th class="center">Status</th>
    <th class="center">Download</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="white-space:nowrap; text-align: center"><?php echo $data['content'][$i]['ID']; ?></td>
    <td>
        <strong><?php echo $data['content'][$i]['Item']; ?></strong><br />
        <?php echo $data['content'][$i]['Description']; ?>        
        <div style="font-size:11px; margin-top:5px; color:#777; font-style: italic"><?php echo $data['content'][$i]['OrderDate']; ?></div>
    </td>
    <td class="center"><?php echo $data['content'][$i]['PaymentMethod']['Name']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Total']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Status']['Label']; ?></td>
    <td class="center"><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/order/export/<?php echo $data['content'][$i]['ID']; ?>">Download Order</a></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
