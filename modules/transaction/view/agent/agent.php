<?php
        function familyTree($array)
	{
           
           
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                             if ($array[$index]['ID']==$_GET['id']) { 
                                $selected= 'selected="selected"'; 

                             }                     
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="/agent/transaction/agent/'. $array[$index]['ID'].'?page=all" '.$selected.'>'.$array[$index]['Name'].' ('. $array[$index]['Company'].')</option>';    
                       
                            echo $data;
                            unset($selected);
                            
                           familyTree($array[$index]['Child']);
                      }
                     
                  
                }
                
        }
?>

<?php if ($_GET['param']==="successd") { ?>
<div class="notify">Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be credited to your account within 5 - 10 minutes.</div>
<?php } elseif ($_GET['param']==="successw") { ?>
<div class="notify">Thank you. Your transaction has been requested successfully and is under processing. The amount will be banked in to your designated bank account within 10 minutes.</div>
<?php } elseif ($_GET['param']==="successt") { ?>
<div class="notify">Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be transferred within 5 - 10 minutes.</div>
<?php } elseif ($_GET['param']==="failure") { ?>
<div class="error">Transaction error occurred.</div>
<?php } ?>
<script type="text/javascript" >
$( document ).ready(function() {
    $('#Reseller_ID').change( function() {
        if ($(this).val()!="")
        {
            window.open( $(this).val() ,"_self");
        }
    });
});
</script>
<div style="margin-bottom:15px;">
    <form name="reseller_form" class="admin_table_nocell" id="reseller_form">
        Agent:
        <select name="Reseller_ID" class="chosen_full" id="Reseller_ID">
            <option value="">--Select Agent--</option>
            <?php /*for ($i=0; $i<$data['content_param']['agent_list']['count']; $i++) { ?>
            <option value="/agent/transaction/agent/<?php echo $data['content_param']['agent_list'][$i]['ID']; ?>?page=all" <?php if ($data['content_param']['agent_list'][$i]['ID']==$_GET['id']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list'][$i]['Name']; ?> (<?php echo $data['content_param']['agent_list'][$i]['Company']; ?>)</option>
            <?php }*/ ?>
            <option value="/agent/transaction/agent/<?php echo $data['agent'][0]['ID']; ?>?page=all" <?php if($data['agent'][0]['ID']==$_GET['id']){ ?>selected="selected"<?php } ?>><?php echo $data['agent'][0]['Name'].' ('.$data['agent'][0]['Company']; ?>)</option>            
            <?php familyTree($data['agent'][0]['Child']); ?>
        </select>
    </form>
</div>



<?php if ($_GET['id']!="") { ?>

<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/agent/<?php echo $data['ID']; ?>" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0" style="width:100%">
	      <tr>
	        <!--<th scope="row"><label>Reseller</label></th>
	        <td><input name="Reseller" type="text" value="<?php echo $_SESSION['agent_AgentIndex']['param']['Agent']; ?>" size="" /></td>-->
	        <th scope="row"><label>Week</label></th>
	        <td><span class="this-week">This week</span> | <span class="last-week">Last Week</span></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date (From)</label></th>
	        <td><input name="DateFrom" class="datepicker" type="text" value="<?php echo $_SESSION['transaction_AgentAgent']['param']['t.DateFrom']; ?>" size="20" />
	          (yyyy-mm-dd hh:mm:ss)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label>Type</label></th>
            <td><select name="TypeID" class="chosen">
                <option value="" selected="selected">All Types</option>
                <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$_SESSION['transaction_AgentAgent']['param']['t.TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select>
            </td>

  	      </tr>
	      <tr>
	      	<th scope="row"><label>Date (To)</label></th>
	        <td><input name="DateTo" class="defaultdatepicker" type="text" value="<?php echo $_SESSION['transaction_AgentAgent']['param']['t.DateTo']; ?>" size="20" />
	          (yyyy-mm-dd hh:mm:ss)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label>Status</label></th>
            <td><select name="Status" class="chosen_simple">
                <option value="" selected="selected">All Statuses</option>
                <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$_SESSION['transaction_AgentAgent']['param']['t.Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select></td>
	      </tr>
	      <tr>
	      	<th scope="row"><label>Member</label></th>
            <td><select name="MemberID" class="chosen">
                <option value="" selected="selected">All Member</option>
                <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>" <?php if ($data['content_param']['member_list'][$i]['ID']==$_SESSION['transaction_AgentAgent']['param']['t.MemberID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['member_list'][$i]['Name']; ?> | <?php echo $data['content_param']['member_list'][$i]['Username']; ?> | <?php echo $data['content_param']['member_list'][$i]['AgentURL']; ?></option>
                <?php } ?>
              </select>
            </td>
            <td>&nbsp;</td>
                <th scope="row"><label>Promotion</label></th>
	        <td><select name="Promotion" class="chosen">
                <option value="">--Select All--</option>
                <?php for ($i=0; $i<$data['content_param']['agentpromotion_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['agentpromotion_list'][$i]['Title']; ?>" <?php if ($data['content_param']['agentpromotion_list'][$i]['Title']==$_SESSION['transaction_AgentAgent']['param']['t.Promotion']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agentpromotion_list'][$i]['Title']; ?></option>
                <?php } ?>
              </select>
            </td>
	      </tr>
	    <tr>
	        <th scope="row"><label>Bank Slip</label></th>
	        <td>
                    <input name="BankSlip" class="" type="text" value="<?php echo $_SESSION['transaction_AgentAgent']['param']['t.BankSlip']; ?>" size="20" />
                </td>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/agent/<?php echo $data['ID']; ?>?page=all">
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
    </a>--><?php echo $data['content_param']['paginate']; ?>
    
    </div>
  <div class="clear"></div>
</div>

 <table class="admin_table" border="0" cellpadding="0" cellspacing="0" style = "width:auto;">
 <tr>
	<th class="text_right">In (RM)</th>
    <th class="text_right">Out (RM)</th>
    <th class="text_right">Bonus (RM)</th>
    <th class="text_right">Commission (RM)</th>
    <th class="text_right">Profit (RM)</th>
<!--    <th class="text_right">Profit Sharing (Sum)</th>
    <th class="text_right">Profit Sharing (RM)</th>-->
 </tr>
 <tr class="color">
    <td class="text_right"><?php echo ($data['report']['In']=='0.00')? '0.00':$data['report']['In']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Out']=='0.00')? '0.00':'-'.$data['report']['Out']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Bonus']=='0.00')? '0.00':'-'.$data['report']['Bonus']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Commission']=='0.00')? '0.00':'-'.$data['report']['Commission']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Profit']=='0.00')? '0.00':$data['report']['Profit']; ?></td>
<!--    <td class="text_right"><?php echo ($data['report']['Profitsharing']=='')? '0.00':$data['report']['Profitsharing']; ?></td>
    <td class="text_right"><?php echo ($data['report']['Percentage']=='')? '0.00':$data['report']['Percentage']; ?></td>-->
  </tr>

</table>
<br />
<?php if ($data['content_param']['count']>0) { ?>

<table class="admin_table" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th>Agent</th>
    <th>Date</th>
    <th width="12%">Member</th>
    <th>Username</th>
    <th class="center">Type</th>
    <!--<th>Details</th>-->
    <th>Deposit Description</th>
    <th>Deposit Channel</th>
    <th>Reference Code</th>
    <th style="text-align: right">Amount (MYR)</th>
    <th style="text-align: right">Promotions</th>
    <th class="text_right">Bank Slip</th>
    <th style="text-align: right">Bonus (MYR)</th>
    <th style="text-align: right">Commission (MYR)</th>
    <th class="center">Status</th>
    <th class="text_right">Main Wallet (MYR)</th>
    <th class="center">Game Username</th>
<!--<th class="center">First Updated</th>
    <th class="center">Last Updated</th>-->
    <th class="center">Remark</th>
  </tr>

  <?php for ($i=0; $i<$data['content']['count']; $i++) { ?>

  <tr>
    <td><?php echo $data['content'][$i]['Agent']; ?>
    </td>
    <td><?php echo $data['content'][$i]['Date']; ?>
      </td>
     <td><?php echo $data['content'][$i]['MemberID']; ?></td>
     <td><?php echo $data['content'][$i]['MemberUsername']; ?></td>
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
    <!--<td>-->

        <?php /*if ($data['content'][$i]['TypeID']=='Withdrawal') { ?>
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
            <div style="margin-top:5px;">Reference Code: N/A</div>
            <?php } ?>
        <?php }*/ ?>
        <?php //if($data['content'][$i]['Status'] == 'Rejected'){ ?>
                <!--<br />
        	<div class="error">Rejected Remark: <?php echo $data['content'][$i]['RejectedRemark']; ?></div>-->

        <?php //} ?>
    <!--</div></td>-->
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
    <td class="text_right"><?php echo $data['content'][$i]['Promotion']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['BankSlip']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Bonus']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Commission']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Status']; ?></td>     
    <td class="center"><?php echo ($data['content'][$i]['MainWallet']=="")? '0.00' : $data['content'][$i]['MainWallet']; ?></td>    
    <td class="center"><?php echo ($data['content'][$i]['GameUsername']!="")?$data['content'][$i]['GameUsername'] : 'Non Applicable'; ?></td>
    <!--<td class="center"><?php if (($data['content'][$i]['StaffID']!="")&&($data['content'][$i]['StaffID']!="0")) { ?>
        <div style="margin-top:5px; font-size:11px; font-style:italic; color: #777;">First Updated: <?php echo $data['content'][$i]['ModifiedDate']; ?> <?php echo $data['content'][$i]['StaffID'][0]['Email']; ?></div><?php } ?></td>-->
    
    <!--<td class="center"><?php if (($data['content'][$i]['StaffID']!="")&&($data['content'][$i]['StaffID']!="0")) { ?><div style="margin-top:5px; font-size:11px; font-style:italic; color: #777;">Last Updated: <?php echo $data['content'][$i]['UpdatedDate']; ?> <?php echo $data['content'][$i]['StaffIDUpdated'][0]['Email']; ?></div><?php } ?>
        </td>-->
    <td class="center"><?php echo $data['content'][$i]['RejectedRemark']; ?></td>        
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
<?php } ?>