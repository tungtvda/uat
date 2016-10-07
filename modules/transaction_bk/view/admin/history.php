<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Date & Reseller</th>
    <th>Member | Username</th>
    <th class="center">Type</th>

    <!--<th>Rejected Remark</th>-->
    <th>Details</th>
    <th style="text-align: right">Amount (MYR)</th>
    <th style="text-align: right">Promotions</th>
    <th class="text_right">Bank Slip</th>
    <th class="text_right">Bonus (MYR)</th>
    <th class="text_right">Commission (MYR)</th>
    <th class="center">Status</th>
    <th class="text_right">Main Wallet (MYR)</th>
    <th class="center">Game Username</th>
    <th class="center">First Updated | Last Updated</th>
    <th class="center">Remark</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
      <td><?php echo $data['content'][$i]['Date']; ?><br/>
          Reseller:<span style="color: <?php echo $data['content'][$i]['Colour'][0]['Colour']; ?>; font-size: 11px"> <?php echo $data['content'][$i]['Reseller']; ?></span>
      </td>
      <td><?php echo $data['content'][$i]['MemberID']; ?> (<?php echo $data['content'][$i]['MemberUsername']; ?>)
        
    </td>
    <td class="center"><?php echo $data['content'][$i]['TypeID']; ?></td>
    <!--<td class="center"><?php echo $data['content'][$i]['RejectedRemark']; ?></td>-->
    <td>
        <?php echo $data['content'][$i]['Description']; ?>

        <?php if ($data['content'][$i]['TypeID']=='Deposit') { ?>
        (Deposit Channel: <?php echo $data['content'][$i]['DepositChannel']; ?> - <?php echo $data['content'][$i]['Bank']; ?>)
        <?php } ?>

        <?php if ($data['content'][$i]['TypeID']=='Transfer') { ?><br />
            <?php echo $data['content'][$i]['TransferFrom']; ?> -> <?php echo $data['content'][$i]['TransferTo']; ?>
        <?php } else { ?>

            <?php if ($data['content'][$i]['ReferenceCode']!="") { ?>
            	<?php if ($data['content'][$i]['TypeID']=='Withdrawal') { ?>
        <?php echo '<br />'.$data['content'][$i]['Bank']; ?><br />
        <?php } ?>
            <div style="margin-top:5px;">Reference Code: <?php echo $data['content'][$i]['ReferenceCode']; ?>
            <?php } else { ?>
            	<?php if ($data['content'][$i]['TypeID']=='Withdrawal') { ?>
        <?php echo '<br />'.$data['content'][$i]['Bank']; ?><br />
        <?php } ?>
            <div style="margin-top:5px;">Reference Code: N/A</div>
            <?php } ?>

        <?php } ?>
		<?php //if ($data['content'][$i]['Status']=='Rejected') { ?>
			<!--<div  class="error">Rejected Remark: </div>-->
		<?php //} ?>
        

        </div></td>
    <td style="white-space:nowrap; text-align: right">
        <?php if ($data['content'][$i]['TypeID']=='Deposit') { ?>
        <?php echo $data['content'][$i]['In']; ?>
        <?php } ?>
        <?php if ($data['content'][$i]['TypeID']=='Withdrawal') { ?>
        <?php echo $data['content'][$i]['Out']; ?>
        <?php } ?>
        <?php if ($data['content'][$i]['TypeID']=='Transfer') { ?>
        <?php echo $data['content'][$i]['Amount']; ?>
        <?php } ?>
    </td>
    <td class="text_right"><?php echo $data['content'][$i]['Promotion']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['BankSlip']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Bonus']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Commission']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Status']; ?></td>
    <td class="center"><?php echo ($data['content'][$i]['MainWallet']=="")? '0.00' : $data['content'][$i]['MainWallet']; ?></td>
    <td class="center"><?php echo ($data['content'][$i]['GameUsername']!="")?$data['content'][$i]['GameUsername'] : 'Non Applicable'; ?></td>
    <td class="center"><?php if (($data['content'][$i]['StaffID']!="")&&($data['content'][$i]['StaffID']!="0")) { ?>
        <div style="margin-top:5px; font-size:11px; font-style:italic; color: #777;">First Updated: <?php echo $data['content'][$i]['ModifiedDate']; ?> <?php echo $data['content'][$i]['StaffID'][0]['Email']; ?><br />Last Updated: <?php echo $data['content'][$i]['UpdatedDate']; ?> <?php echo $data['content'][$i]['StaffIDUpdated'][0]['Email']; ?></div>
        <?php } ?></td>
    <td class="center"><?php echo $data['content'][$i]['RejectedRemark']; ?></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>