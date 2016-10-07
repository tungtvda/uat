<?php if ($data['page']['agentcredit_delete']['ok']==1) { ?>
<div class="notify">Transaction deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentcredit/index" method="post">
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
	            <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$_SESSION['agentcredit_AdminIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th>Description</th>
            <td><input name="Description" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['Description']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Agent</label></th>	                        
                  <td>
                    <select name="AgentID" class="chosen_full">
                    <option value="">--Select All--</option> 
                    <?php for ($g=0; $g<$data['content_param']['agent_list1']['count']; $g++) { ?>
                    <option value="<?php echo $data['content_param']['agent_list1'][$g]['ID']; ?>" <?php if($data['content_param']['agent_list1'][$g]['ID']==$_SESSION['agentcredit_AdminIndex']['param']['AgentID']){ ?>selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list1'][$g]['Name']; ?> - <?php echo $data['content_param']['agent_list1'][$g]['ID']; ?></option>
	            <?php Helper::agentOptionList($data['content_param']['agent_list1'][$g]['Child'], $_SESSION['agentcredit_AdminIndex']['param']['AgentID']); ?>
                    <?php } ?>
                    <?php for ($i=0; $i<$data['content_param']['agent_list2']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['agent_list2'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list2'][$i]['ID']==$_SESSION['agentcredit_AdminIndex']['param']['AgentID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list2'][$i]['Name']; ?></option>
	            <?php } ?>
                    </select>
                </td>
                  
	        <td>&nbsp;</td>
	        <th scope="row"><label>Status</label></th>
	        <td><select name="Status" class="chosen_simple">
	            <option value="" selected="selected">All Statuses</option>
	            <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$_SESSION['agentcredit_AdminIndex']['param']['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['Name']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>In (MYR)</th>
	        <td><input name="Debit" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['Debit']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date (From)</label></th>
	        <td><input name="DateFrom" class="datepicker" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['DateFrom']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <th>Out (MYR)</th>
	        <td><input name="Credit" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['Credit']; ?>" /></td>
	      </tr>
	      <tr>
	      	<th scope="row"><label>Date (To)</label></th>
	        <td><input name="DateTo" class="defaultdatepicker" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['DateTo']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
	        <th>Transfer To</th>
	        <td><input name="TransferTo" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['TransferTo']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Deposit Bonus</label></th>
	        <td><input name="DepositBonus" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['DepositBonus']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>Transfer From</th>
	        <td><input name="TransferFrom" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['TransferFrom']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Deposit Channel</label></th>
	        <td><input name="DepositChannel" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['DepositChannel']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>Bank</th>
	        <td>
                    <select name="Bank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if ($data['content_param']['bank_list'][$i]['Label']==$_SESSION['agentcredit_AdminIndex']['param']['Bank']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select>
                    </td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Reference Code</label></th>
	        <td><input name="ReferenceCode" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['ReferenceCode']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th>Transfer (MYR)</th>
	        <td><input name="Amount" type="text" value="<?php echo $_SESSION['agentcredit_AdminIndex']['param']['Amount']; ?>" /></td>
	      </tr>
	          <?php /*?><th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['resellercredit_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td><?php */?>
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
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentcredit/index?page=all">
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
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <a href='/admin/agentcredit/add/'>
    <input type="button" class="button" value="Create Credit Transaction">
    </a>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']!='2') { ?>
    <a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/agentcredit/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a>
    <?php } ?>
    <?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php /*if ($data['content_param']['count']>0) {*/ ?>
<table class="admin_table" border="0" cellpadding="0" cellspacing="0">
 <tr>
	<th class="text_right">Deposit (RM)</th>
    <th class="text_right">Credit (RM)</th>
    <th class="text_right">Credit Balance (RM)</th>
 </tr>
 <?php //for ($s=0; $s <$data['summary']['count']; $s++) { ?>
 <tr class="color"> 
  	<td class="text_right"><?php echo ($data['summary']['TotalIn']=='0.00')? '0.00':$data['summary']['TotalIn']; ?></td>
    <td class="text_right"><?php echo ($data['summary']['TotalOut']=='0.00')? '0.00':'-'.$data['summary']['TotalOut']; ?></td>
    <td class="text_right"><?php echo ($data['summary']['Balance']=='0.00')? '0.00':$data['summary']['Balance']; ?></td>  
  </tr>
 <?php //} ?> 
</table>
<?php /*}else{ ?>
	
<!--<p>No result(s)</p>-->
<?php }*/ ?>
	
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Date Posted</th>
    <th>Agent</th>
    <th class="center">Type</th>
    <th>Description</th>
    <th style="text-align: right">Amount (MYR)</th>
    <th class="center">Status</th>
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <th>&nbsp;</th>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <th>&nbsp;</th>
    <?php } ?>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['Date']; ?></td>
    <td><?php echo $data['content'][$i]['AgentID']['Name']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['TypeID']; ?></td>
    <td>
        <?php echo $data['content'][$i]['Description']; ?>
        <!--<?php if ($data['content'][$i]['TypeID']=='Deposit') { ?>
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
            <div style="margin-top:5px;">Reference Code: N/A
            <?php } ?>
        <?php } ?>

        <?php if (($data['content'][$i]['StaffID']!="")&&($data['content'][$i]['StaffID']!="0")) { ?>
            <div style="margin-top:5px; font-size:11px; font-style:italic; color: #777;">Updated by <?php echo $data['content'][$i]['StaffID']; ?> | <?php echo $data['content'][$i]['ModifiedDate']; ?>
        <?php } ?>

        </div>--></td>
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
    <td style="white-space:nowrap; text-align: right"><?php echo $data['content'][$i]['Status']; ?>
    <?php if($data['content'][$i]['RejectedRemark']=='Rejected'){ ?>	
    	<div class="error"><?php echo $data['content'][$i]['RejectedRemark']; ?></div>
    <?php } ?>	
    </td>
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/agentcredit/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/agentcredit/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
    <?php } ?>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
