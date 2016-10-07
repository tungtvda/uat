
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
<?php if ($_SESSION['agent']['quick_edit']=="succeed") { ?>
<div class="notify">Transaction updated successfully.</div>
<?php } ?>
<?php if ($_SESSION['agent']['quick_edit']=="failed") { ?>
<div class="alert">Transaction failed to update.</div>
<?php } ?>
<?php unset($_SESSION['agent']['quick_edit']); ?>

<!--<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0" style="width:100%">
	      <tr>
	        <th scope="row"><label>Week</label></th>
	        <td><span class="this-week">This week</span> | <span class="last-week">Last Week</span></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date (From)</label></th>
	        <td><input name="DateFrom" class="validate[custom[dmyDateTime]] datepicker" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.DateFrom']; ?>" size="20" />
	          (yyyy-mm-dd hh:mm:ss)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label>Type</label></th>
            <td><select name="TypeID" class="chosen">
                <option value="" selected="selected">All Types</option>
                <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$_SESSION['transaction_AgentIndex']['param']['t.TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select>
            </td>

  	      </tr>
	      <tr>
	      	<th scope="row"><label>Date (To)</label></th>
	        <td><input name="DateTo" class="validate[custom[dmyDateTime]] defaultdatepicker" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.DateTo']; ?>" size="20" />
	          (yyyy-mm-dd hh:mm:ss)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label>Status</label></th>
            <td><select name="Status" class="chosen_simple">
                <option value="" selected="selected">All Statuses</option>
                <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$_SESSION['transaction_AgentIndex']['param']['t.Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select></td>
	      </tr>
	      <tr>
	      	<th scope="row"><label>Member</label></th>
            <td><select name="MemberID" class="chosen">
                <option value="" selected="selected">All Member</option>
                <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>" <?php if ($data['content_param']['member_list'][$i]['ID']==$_SESSION['transaction_AgentIndex']['param']['t.MemberID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['member_list'][$i]['Name']; ?> | <?php echo $data['content_param']['member_list'][$i]['Username']; ?> | <?php echo $data['content_param']['member_list'][$i]['AgentURL']; ?></option>
                <?php } ?>
              </select>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>

	      <tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/index?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
	      </tr>
	    </table>
	  </form>
  </div>
</div>-->

<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <!--<th scope="row"><label>Reseller</label></th>
	        <td><input name="Reseller" type="text" value="<?php echo $_SESSION['reseller_AdminIndex']['param']['Reseller']; ?>" size="" /></td>-->
	        <th scope="row"><label>Week</label></th>
	        <td><span class="this-week">This week</span> | <span class="last-week">Last Week</span></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Type</label></th>
	        <td><select name="TypeID" class="chosen">
	            <option value="" selected="selected">All Types</option>
	            <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$_SESSION['transaction_AgentIndex']['param']['t.TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th>Description</th>
            <td><input name="Description" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.Description']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Member</label></th>
	        <td><input type="text" id="search_bar" placeholder="Member" name="Member" size="45" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['Member']; ?>"><input type="hidden" id="ajaxMemberID" name="MemberID" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.MemberID']; ?>"></td>
	        <td>&nbsp;</td>
                <th scope="row"><label>Status</label></th>
	        <td><select name="Status" class="chosen_simple">
	            <option value="" selected="selected">All Statuses</option>
	            <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$_SESSION['transaction_AgentIndex']['param']['t.Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.Name']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>In (MYR)</th>
	        <td><input name="Debit" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.Debit']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date (From)</label></th>
	        <td><input name="DateFrom" class="validate[custom[dmyDateTime]] datepicker" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.DateFrom']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <th>Out (MYR)</th>
	        <td><input name="Credit" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.Credit']; ?>" /></td>
	      </tr>
	      <tr>
	      	<th scope="row"><label>Date (To)</label></th>
	        <td><input name="DateTo" class="validate[custom[dmyDateTime]] defaultdatepicker" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.DateTo']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <th>Transfer To</th>
	        <td><input name="TransferTo" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.TransferTo']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Deposit Bonus</label></th>
	        <td><input name="DepositBonus" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.DepositBonus']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>Transfer From</th>
	        <td><input name="TransferFrom" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.TransferFrom']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Deposit Channel</label></th>
	        <td><input name="DepositChannel" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.DepositChannel']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>Bank</th>
	        <td>
                    <select name="Bank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if ($data['content_param']['bank_list'][$i]['Label']==$_SESSION['transaction_AgentIndex']['param']['t.Bank']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select>
                </td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Reference Code</label></th>
	        <td><input name="ReferenceCode" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.ReferenceCode']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>Transfer (MYR)</th>
	        <td><input name="Amount" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.Amount']; ?>" /></td>
	      </tr>
	          <?php /*?><th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['transaction_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td><?php */?>
          <tr>
            <th>Bonus (MYR) (Starting From)</th>
            <td><input name="Bonus" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.Bonus']; ?>" /></td>
            <td>&nbsp;</td>
            <th>Commission (MYR) (Starting From)</th>
            <td><input name="Commission" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.Commission']; ?>" /></td>
          </tr>
	      <tr>
	      	<th scope="row"><label>Rejected Remark</label></th>
	        <td><input name="RejectedRemark" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.RejectedRemark']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Promotion</label></th>
	        <td>
                    <select name="Promotion" class="validate[] chosen_full">

                        <option value="">None</option>
                        <?php for ($i=0; $i<$data['content_param']['agentpromotion_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['agentpromotion_list'][$i]['Title']; ?>" <?php if ($data['content_param']['agentpromotion_list'][$i]['Title']==$_SESSION['transaction_AgentIndex']['param']['t.Promotion']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agentpromotion_list'][$i]['Title']; ?></option>
                        <?php } ?>
                    </select>
                </td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Bank Slip</label></th>
	        <td><input name="BankSlip" type="text" value="<?php echo $_SESSION['transaction_AgentIndex']['param']['t.BankSlip']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
                <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/index?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
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
  <div class="results_right">
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
    <a href='/agent/transaction/add?apc=apci'>
    <input type="button" class="button" value="Create Transaction">
    </a>
    <?php } ?>
<?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
      <a href='/agent/transaction/add?apc=apci'>
    <input type="button" class="button" value="Create Transaction">
    </a>
    <?php } ?>
    <!--<a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a>--><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>

 <table class="admin_table" border="0" cellpadding="0" cellspacing="0">
 <tr>
	<th class="text_right">In (RM)</th>
    <th class="text_right">Out (RM)</th>
    <th class="text_right">Bonus (RM)</th>
    <th class="text_right">Commission (RM)</th>
    <th class="text_right">Profit (RM)</th>
    <th class="text_right">Profit Sharing (%)</th>
    <th class="text_right">Profit Sharing (RM)</th>
 </tr>
<?php #if(isset($data['report'])){ ?>
 <tr class="color">
  	<td class="text_right"><?php echo ($data['report']['In']=='0.00')? '0.00':$data['report']['In']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Out']=='0.00')? '0.00':'-'.$data['report']['Out']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Bonus']=='0.00')? '0.00':'-'.$data['report']['Bonus']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Commission']=='0.00')? '0.00':'-'.$data['report']['Commission']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Profit']=='0.00')? '0.00':$data['report']['Profit']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Profitsharing']=='')? '0.00':$data['report']['Profitsharing']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Percentage']=='0.00')? '0.00':$data['report']['Percentage']; ?></td>

  </tr>
<?php /*}elseif(isset($data['content'])){ ?>
	<tr>
  	<td class="text_right"><?php echo ($data['content'][0]['Report']['In']=='')? '0.00':$data['content'][0]['Report']['In']; ?></td>
    <td class="text_right"><?php echo ($data['content'][0]['Report']['Out']=='')? '0.00':$data['content'][0]['Report']['Out']; ?></td>
    <td class="text_right"><?php echo ($data['content'][0]['Report']['Bonus']=='')? '0.00':$data['content'][0]['Report']['Bonus']; ?></td>
    <td class="text_right"><?php echo ($data['content'][0]['Report']['Commission']=='')? '0.00':$data['content'][0]['Report']['Commission']; ?></td>
    <td class="text_right"><?php echo ($data['content'][0]['Report']['Profit']=='')? '0.00':$data['content'][0]['Report']['Profit']; ?></td>
    <td class="text_right"><?php echo ($data['content'][0]['Report']['Profitsharing']=='')? '0.00':$data['content'][0]['Report']['Profitsharing']; ?></td>
    <td class="text_right"><?php echo ($data['content'][0]['Report']['Percentage']=='')? '0.00':$data['content'][0]['Report']['Percentage']; ?></td>
  </tr>
<?php }*/ ?>
</table>
<br />


<?php if ($data['content_param']['count']>0) { ?>

<table class="admin_table" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th>Date Posted</th>
    <th>Agent URL</th>
    <th>Member</th>
    <th class="center">Type</th>
    <th>Deposit Description</th>
    <th>Deposit Channel</th>
    <th>Reference Code</th>
    <!--<th>Details</th>-->
    <th style="text-align: right">Amount (MYR)</th>
    <th class="center">Bank Slip</th>
    <th style="text-align: right">Bonus (MYR)</th>
    <th style="text-align: right">Commission (MYR)</th>
    <th class="center">Status</th>
    <th class="center">Main Wallet (MYR)</th>
    <th class="center">Game Username</th>
    <th class="center">Remark</th>
    <th class="center">First Updated | Last Updated</th>
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
        <th class="center">&nbsp;</th>
        <th class="center">&nbsp;</th>
        <th class="center">&nbsp;</th>

    <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
        <th class="center">&nbsp;</th>
        <th class="center">&nbsp;</th>
        <th class="center">&nbsp;</th>
    <?php } ?>
  </tr>

  <?php for ($i=0; $i<$data['content']['count']; $i++) { ?>

  <tr>
    <td><a name="<?php echo $data['content'][$i]['ID']; ?>"></a><?php echo $data['content'][$i]['Date']; ?></td>
    <td><?php echo '<font color ="'.(($data['content'][$i]['AgentType']=='1') ? 'black' : 'blue').'">'.$data['content'][$i]['Agent']; ?></td>
     <td><b><?php echo $data['content'][$i]['MemberID']; ?></b> (<?php echo $data['content'][$i]['MemberUsername']; ?>)</td>
    <td class="center"><?php echo $data['content'][$i]['TypeID']; ?></td>
    <td><?php if ($data['content'][$i]['TypeID']=='Withdrawal') { ?>
        <?php echo $data['content'][$i]['Bank']; ?><br />
        <?php } ?>
        <?php if ($data['content'][$i]['TypeID']!='Transfer') { ?>
            <?php echo $data['content'][$i]['Description']; ?>
        <?php } ?>
    </td>
    <td> <?php if ($data['content'][$i]['TypeID']=='Deposit') { ?>
        <?php echo $data['content'][$i]['DepositChannel']; ?> - <?php echo $data['content'][$i]['Bank']; ?>
        <?php } ?>
    </td>
    <td><?php if ($data['content'][$i]['TypeID']=='Transfer') { ?>

            <?php echo $data['content'][$i]['TransferFrom']; ?> -> <?php echo $data['content'][$i]['TransferTo']; ?>
        <?php } else { ?>
            <?php if ($data['content'][$i]['ReferenceCode']!="") { ?>
            <div style="margin-top:5px;"><?php echo $data['content'][$i]['ReferenceCode']; ?></div>
            <?php } else { ?>
            <div style="margin-top:5px;">N/A</div>
            <?php } ?>
        <?php } ?>
            </td>
    <td style="white-space:nowrap; text-align: right">
    	<?php //echo $data['content'][$i]['TypeID']; ?>
    	<?php //echo $data['content'][$i]['Amount']; ?>
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
    <td class="center"><?php echo $data['content'][$i]['BankSlip']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Bonus']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Commission']; ?></td>
    <td class="center"><?php if($data['content'][$i]['Status'] == 'Rejected'){ ?><?php echo '<span class ="error">'.$data['content'][$i]['Status'].'</span>'; ?><?php }else{ echo $data['content'][$i]['Status']; } ?></td>
    <td class="center"><?php echo ($data['content'][$i]['MainWallet']=="")? '0.00' : $data['content'][$i]['MainWallet']; ?></td>
    <td class="center"><?php echo ($data['content'][$i]['GameUsername']!="")?$data['content'][$i]['GameUsername'] : 'Non Applicable'; ?><br />
        <a target="_blank" href="/agent/wallet/edit/<?php echo $data['content'][$i]['WalletID']; ?>">Edit Wallet</a></td>
    <td class="text_right"><?php echo $data['content'][$i]['RejectedRemark']; ?></td>
    <td class="center"><?php if (($data['content'][$i]['OperatorID']!="")&&($data['content'][$i]['OperatorID']!="0")) { ?>
        <div style="margin-top:5px; font-size:11px; font-style:italic; color: #777;">First Updated: <?php echo $data['content'][$i]['ModifiedDate']; ?> <?php echo $data['content'][$i]['ModifiedPerson']; ?><br />Last Updated: <?php echo $data['content'][$i]['UpdatedDate']; ?> <?php echo $data['content'][$i]['UpdatedPerson']; ?></div>
        <?php } ?></td>
      <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
    <td>
        <div class="onclick"><span class="<?php echo $data['content'][$i]['ID']; ?>"></span>Q</div>
    </td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/edit/<?php echo $data['content'][$i]['ID']; ?>?apc=apci'>Edit</a></div></td>
    <td>
        <div class="onview"><span class="<?php echo $data['content'][$i]['RawMemberID']; ?>"></span>V</div>
    </td>
   <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <td>
        <div class="onclick"><span class="<?php echo $data['content'][$i]['ID']; ?>"></span>Q</div>
    </td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/edit/<?php echo $data['content'][$i]['ID']; ?>?apc=apci'>Edit</a></div></td>
    <td>
        <div class="onview"><span class="<?php echo $data['content'][$i]['RawMemberID']; ?>"></span>V</div>
    </td>

   <?php } ?>

  </tr>

  <?php } ?>
</table>
<?php } else{//if($data['membertotal'] =='') { ?>
	<!--<table class="admin_table" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<th class="center">In</th>
    <th class="center">Out</th>
    <th class="center">Profit</th>
 </tr>
  <tr>
  	<td>0.00</td>
    <td>0.00</td>
    <td>0.00</td>
  </tr>
 </table>-->
<p>No Transaction records.</p>
<?php } ?>

<div id="contactdiv">

</div>

<div id="historydiv">
    <div class="cancel">Close</div>
    <div id="admin_table">

</div>
</div>
