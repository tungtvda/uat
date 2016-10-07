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
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/reseller/resellercredit/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0" style="width:100%">
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
	        <th scope="row"><label>Date (From)</label></th>
	        <td><input name="DateFrom" class="datepicker" type="text" value="<?php echo $_SESSION['resellercredit_ResellerIndex']['param']['DateFrom']; ?>" size="20" />
	          (yyyy-mm-dd hh:mm:ss)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label>Type</label></th>
            <td><select name="TypeID" class="chosen">
                <option value="" selected="selected">All Types</option>
                <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$_SESSION['resellercredit_ResellerIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select>
            </td>
            
  	      </tr>
	      <tr>
	      	<th scope="row"><label>Date (To)</label></th>
	        <td><input name="DateTo" class="defaultdatepicker" type="text" value="<?php echo $_SESSION['resellercredit_ResellerIndex']['param']['DateTo']; ?>" size="20" />
	          (yyyy-mm-dd hh:mm:ss)</td>
	        <td>&nbsp;</td>	
            <th scope="row"><label>Status</label></th>
            <td><select name="Status" class="chosen_simple">
                <option value="" selected="selected">All Statuses</option>
                <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$_SESSION['resellercredit_ResellerIndex']['param']['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select></td>
	      </tr>
	      <tr>
	      	<th>Description</th>
            <td><input name="Description" type="text" value="<?php echo $_SESSION['resellercredit_ResellerIndex']['param']['Description']; ?>" /></td>
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
	    <!--<tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>-->
	      <tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/resellercredit/index?page=all">
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

 <table class="admin_table" border="0" cellpadding="0" cellspacing="0">
 <tr>	
	<th class="text_right">Deposit (RM)</th>
    <th class="text_right">Credit (RM)</th>
    <th class="text_right">Balance (RM)</th>
 </tr>
  <tr>
  	<td class="text_right"><?php echo $data['report']['TotalIn']; ?></td>
    <td class="text_right"><?php echo $data['report']['TotalOut']; ?></td>
    <td class="text_right"><?php echo $data['report']['Balance']; ?></td>  
  </tr> 
</table>
<?php if ($data['content_param']['count']>0) { ?>
	
<table class="admin_table" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th>Date Posted</th>
    <!--<th>Member</th>-->
    <th class="center">Type</th>
    <th class="center">Description</th>
    <!--<th>Details</th>-->
    <th style="text-align: right">Amount (MYR)</th>
    <th class="center">Status</th>
   
  </tr>
 
  <?php for ($i=0; $i<$data['content']['count']; $i++) { ?>
  	
  <tr>
    <td><?php echo $data['content'][$i]['Date']; ?></td>
     <!--<td><?php echo $data['content'][$i]['MemberID']; ?></td>-->
    <td class="center"><?php echo $data['content'][$i]['TypeID']; ?></td>
    <td>
        <?php echo $data['content'][$i]['Description']; ?>
    </td>    
     <!--<td class="center"><?php echo $data['content'][$i]['Out']; ?></td>
     <td class="center"><?php echo $data['content'][$i]['In']; ?></td>-->
    <!--<td>
    	
        <?php if ($data['content'][$i]['TypeID']=='Withdrawal') { ?>
        <?php echo $data['content'][$i]['Bank']; ?><br />
        <?php } ?>
        <?php if ($data['content'][$i]['TypeID']!='Transfer') { ?>
            <?php echo $data['content'][$i]['Description']; ?>
        <?php } ?>
        <?php if ($data['content'][$i]['TypeID']=='Deposit') { ?>
        (Deposit Channel: <?php echo $data['content'][$i]['DepositChannel']; ?> - <?php echo $data['content'][$i]['Bank']; ?>)
        <?php } ?>
        <?php if ($data['content'][$i]['TypeID']=='Transfer') { ?>
        	 
            <?php echo $data['content'][$i]['TransferFrom']; ?> -> <?php echo $data['content'][$i]['TransferTo']; ?>
        <?php } else { ?>
            <?php if ($data['content'][$i]['ReferenceCode']!="") { ?>
            <div style="margin-top:5px;">Reference Code: <?php echo $data['content'][$i]['ReferenceCode']; ?>
            <?php } else { ?>
            <div style="margin-top:5px;">Reference Code: N/A
            <?php } ?>
        <?php } ?>
        </div></td>-->
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
    
    <td style="white-space:nowrap; text-align: right"><?php echo $data['content'][$i]['Status']; ?>
    	<?php if($data['content'][$i]['Status'] == "Rejected"){ ?>
    	<div class="error">Rejected Remark :<?php echo $data['content'][$i]['RejectedRemark']; ?></div>
    	<?php } ?>
    </td>
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
