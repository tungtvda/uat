<div id="merchantaddress_wrapper">
  <?php if ($data['content_param']['count']>0) { ?>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <div class="merchantaddress_list_box">
      <table cellpadding="0" cellspacing="0" border="0">
          <tr>
              <td class="address"><h2><?php echo $data['content'][$i]['Title']; ?></h2>
                <?php echo $data['content'][$i]['Street']; ?><br />
                <?php if ($data['content'][$i]['Street2']!="") { ?>
                <?php echo $data['content'][$i]['Street2']; ?><br />
                <?php } ?>
                <?php echo $data['content'][$i]['Postcode']; ?> <?php echo $data['content'][$i]['City']; ?>, <?php echo $data['content'][$i]['State']; ?><br />
                <?php echo $data['content'][$i]['Country']; ?></td>
              <td class="info" style="white-space:nowrap">
                <span class="merchantaddress_inner_header">Phone No:</span><?php echo $data['content'][$i]['PhoneNo']; ?><br />
                <span class="merchantaddress_inner_header">Fax No:</span><?php echo $data['content'][$i]['FaxNo']; ?><br />
                <span class="merchantaddress_inner_header">Email:</span><?php echo $data['content'][$i]['Email']; ?></td>
          </tr>
      </table>
  </div>
  <?php } ?>
  <?php echo $data['content_param']['paginate']; ?>
  <?php } else { ?>
  <p>No addresses yet.</p>
  <?php } ?>
</div>
