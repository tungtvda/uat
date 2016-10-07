<?php //Debug::displayArray($data); exit; ?>
<?php if ($_GET['param']==="successd") { ?>
<div class="notify">Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be credited to your account within 5 - 10 minutes.</div>
<?php } elseif ($_GET['param']==="successw") { ?>
<div class="notify">Thank you. Your transaction has been requested successfully and is under processing. The amount will be banked in to your designated bank account within 10 minutes.</div>
<?php } elseif ($_GET['param']==="successt") { ?>
<div class="notify">Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be transferred within 5 - 10 minutes.</div>
<?php } elseif ($_GET['param']==="failure") { ?>
<div class="error">Transaction error occurred.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/reseller/member/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Username</label></th>
	        <td><input type="text" name="Username" value="<?php echo $_SESSION['member_ResellerIndex']['param']['Username']; ?>" /></td>
	        <!--<td>&nbsp;</td>
            <th scope="row"><label>&nbsp;</label></th>-->
            <td>&nbsp;</td>
            <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/member/index?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
  	      </tr>
	      <!--<tr>
	      	<th scope="row"><label>&nbsp;</label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
            <th scope="row"><label>&nbsp;</label></th>
            <td>&nbsp;</td>
	      </tr>-->
	    <!--<tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>-->
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>

	      </tr>
	    </table>
	  </form>
  </div>
</div>
<div class="admin_results">
  <div class="results_left">
    <h2><?php echo $data['content_param']['query_title']; ?></h2>
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right"><!-- <a href='/admin/transaction/add/'>
    <input type="button" class="button" value="Create Transaction">
    </a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a>--><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th>Member</th>
    <th class="center">Product</th>
    <!-- <th>Username</th>
    <th style="text-align: right">Password</th> -->
    <th class="center">Enabled </th>
    <th class="center">Wallet </th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="vertical-align: top"><div class="member_title"><?php echo $data['content'][$i]['Name']; ?> <span class="member_dob">(<?php echo $data['content'][$i]['GenderID']; ?>)</span></div>
        <strong>Username:</strong><br /><?php echo $data['content'][$i]['Username']; ?><br /><br />
        <strong>Company:</strong><br /><?php echo $data['content'][$i]['Company']; ?><br /><br />
        <!--<strong>Reseller:</strong><br /><?php echo $data['content'][$i]['Reseller']; ?><br /><br />-->
        <strong>Bank:</strong><br /><?php echo $data['content'][$i]['Bank']; ?> | <?php echo $data['content'][$i]['BankAccountNo']; ?><br /><br />
        <strong>Secondary Bank:</strong><br /><?php echo $data['content'][$i]['SecondaryBank']; ?> | <?php echo $data['content'][$i]['SecondaryBankAccountNo']; ?><br /><br />
    </td>
    <td style="vertical-align: top">
        <span class="member_inner_header">Date of Birth:</span> <?php echo $data['content'][$i]['DOB']; ?><br />
        <span class="member_inner_header">Nationality:</span> <?php echo $data['content'][$i]['Nationality']; ?><br />
        <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
        <span class="member_inner_header">NRIC No:</span> <?php echo $data['content'][$i]['NRIC']; ?><br />
        <?php } else { ?>
        <span class="member_inner_header">Passport No:</span> <?php echo $data['content'][$i]['Passport']; ?><br />
        <?php } ?>
        <!-- <br />
        <span class="member_inner_header">Mobile No:</span> <?php echo $data['content'][$i]['MobileNo']; ?><br />
        <span class="member_inner_header">Phone No:</span> <?php echo $data['content'][$i]['PhoneNo']; ?><br />
        <span class="member_inner_header">Fax No:</span> <?php echo $data['content'][$i]['FaxNo']; ?><br />
        <span class="member_inner_header">Email:</span> <?php echo $data['content'][$i]['Email']; ?> --></td>
    <!-- <td class="center"><?php echo $data['content'][$i]['Prompt']; ?></td> -->
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td>
    <a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/wallet/view/<?php echo $data['content'][$i]['ID']; ?>">View
	          </a>
	</td>
  </tr>
  <?php } ?>

  <!--<tr>
    <td><?php echo $data['content'][$i][$j]['MemberID']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['ProductID']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Username']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Password']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Total']; ?></td>-->
    <!--<td>
        <?php if ($data['content'][$i][$j]['TypeID']=='Withdrawal') { ?>
        <?php echo $data['content'][$i][$j]['Bank']; ?><br />
        <?php } ?>
        <?php if ($data['content'][$i][$j]['TypeID']!='Transfer') { ?>
            <?php echo $data['content'][$i][$j]['Description']; ?>
        <?php } ?>
        <?php if ($data['content'][$i][$j]['TypeID']=='Deposit') { ?>
        (Deposit Channel: <?php echo $data['content'][$i][$j]['DepositChannel']; ?> - <?php echo $data['content'][$i][$j]['Bank']; ?>)
        <?php } ?>
        <?php if ($data['content'][$i][$j]['TypeID']=='Transfer') { ?>
            <?php echo $data['content'][$i][$j]['TransferFrom']; ?> -> <?php echo $data['content'][$i][$j]['TransferTo']; ?>
        <?php } else { ?>
            <?php if ($data['content'][$i][$j]['ReferenceCode']!="") { ?>
            <div style="margin-top:5px;">Reference Code: <?php echo $data['content'][$i][$j]['ReferenceCode']; ?>
            <?php } else { ?>
            <div style="margin-top:5px;">Reference Code: N/A
            <?php } ?>
        <?php } ?>
        </div></td>
    <td style="white-space:nowrap; text-align: right">

        <?php if ($data['content'][$i][$j]['TypeID']=='Deposit') { ?>
        <?php echo Helper::displayCurrency($data['content'][$i][$j]['In']); ?>
        <?php } ?>
        <?php if ($data['content'][$i][$j]['TypeID']=='Withdrawal') { ?>
        <?php echo Helper::displayCurrency($data['content'][$i][$j]['Out']); ?>
        <?php } ?>
        <?php if ($data['content'][$i][$j]['TypeID']=='Transfer') { ?>
        <?php echo Helper::displayCurrency($data['content'][$i][$j]['Amount']); ?>
        <?php } ?>
    </td>
    <td class="center"><?php echo $data['content'][$i][$j]['Status']; ?></td>-->
  <!--</tr>-->


</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
