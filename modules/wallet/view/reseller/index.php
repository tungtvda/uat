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
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Date (From)</label></th>
	        <td><input name="DateFrom" class="datepicker" type="text" value="<?php echo $_SESSION['transaction_MemberIndex']['param']['DateFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label>Type</label></th>
            <td><select name="TypeID" class="chosen">
                <option value="" selected="selected">All Types</option>
                <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$_SESSION['transaction_MemberIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select></td>
  	      </tr>
	      <tr>
	      	<th scope="row"><label>Date (To)</label></th>
	        <td><input name="DateTo" class="datepicker" type="text" value="<?php echo $_SESSION['transaction_MemberIndex']['param']['DateTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label>Status</label></th>
            <td><select name="Status" class="chosen_simple">
                <option value="" selected="selected">All Statuses</option>
                <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$_SESSION['transaction_MemberIndex']['param']['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select></td>
	      </tr>
	    <tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index?page=all">
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
    <th class="center">Total(MYR)</th>
  </tr>
  <?php for ($i=0; $i<$data['content']['count']; $i++) { ?>
  	<?php for ($j=0; $j<$data['content'][$i]['count']; $j++) { ?>
  <tr>
    <td><?php echo $data['content'][$i][$j]['MemberID']; ?></td>
    <td class="center"><?php echo $data['content'][$i][$j]['ProductID']; ?></td>
    <td class="center"><?php echo $data['content'][$i][$j]['Total']; ?></td>
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
  </tr>
  <?php } ?>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
