
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i <$data['content_param']['count']; $i++) { ?>


  <table class="admin_table" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <!--<th>Member</th>-->
    <th>Product</th>
    <th>Username</th>
    <th class="text_right">Total (MYR)</th>
    <!--<th class="center">Enabled</th>-->
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <!--<td><?php echo $data['content'][$i]['MemberID']; ?></td>-->
    <td><?php echo $data['content'][$i]['ProductID']; ?></td>
    <td><?php echo $data['content'][$i]['Username']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Total']; ?></td>
    <!--<td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>-->
  </tr>
  <?php } ?>
</table>



  <? } ?>
  <?php } else { ?>
  <p>Member not found.</p>
  <?php } ?>

