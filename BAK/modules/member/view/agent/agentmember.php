<?php if($data['paramParent']!='0'){ ?>
<a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/agent/agent/agentlist/<?php echo $data['paramParent']; ?>">
    &laquo; Back To Parent
</a>
<br>&nbsp;
<?php } ?>
<div class="admin_results">
  <div class="results_left">
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right">    
<!--<a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a>--><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th>Name</th>
    <th>Username</th>
    <th>Gender</th>
    <!-- <th>Company</th> -->
    <th>Bank</th>
    <th>Bank Account No</th>
<!--<th>Secondary Bank</th>
    <th>Secondary Bank Account No</th>
    <th>Date Of Birth</th>
    <th>NRIC</th>
    <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
    <th>Nationality</th>
    <?php } else { ?>
    <th>Passport</th>
    <?php } ?>
    <th>Phone No</th>
    <th>Fax No</th>-->
    <th>Mobile No</th>
    <th>Email</th>
    <th>Facebook ID</th>
    <th class="center">Enabled</th>
    <th>Date Registered</th>
    <th>Wallet</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['Name']; ?></td>
    <td><?php echo $data['content'][$i]['Username']; ?></td>
    <td><?php echo $data['content'][$i]['GenderID']; ?></td>
    <!-- <td><?php echo $data['content'][$i]['Company']; ?></td> -->
    <td><?php echo $data['content'][$i]['Bank']; ?></td>
    <td><?php echo $data['content'][$i]['BankAccountNo']; ?></td>
<!--<td><?php echo $data['content'][$i]['SecondaryBank']; ?></td>
    <td><?php echo $data['content'][$i]['SecondaryBankAccountNo']; ?></td>
    <td><?php echo $data['content'][$i]['DOB']; ?></td>
    <td><?php echo $data['content'][$i]['Nationality']; ?></td>
    <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
        <td><?php echo $data['content'][$i]['NRIC']; ?></td>
    <?php } else { ?>
        <td><?php echo $data['content'][$i]['Passport']; ?></td>
    <?php } ?>
    <td><?php echo $data['content'][$i]['PhoneNo']; ?></td>
    <td><?php echo $data['content'][$i]['FaxNo']; ?></td>-->
    <td><?php echo $data['content'][$i]['MobileNo']; ?></td>
    <td><?php echo $data['content'][$i]['Email']; ?></td>
    <td><?php echo $data['content'][$i]['FacebookID']; ?></td>
    <td><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><?php echo $data['content'][$i]['DateRegistered']; ?></td>
    <td><div align="center">
    <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/wallet/view/<?php echo $data['content'][$i]['ID']; ?>">View
    </a></div>
    </td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
