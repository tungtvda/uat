<?php //Debug::displayArray($data); exit; ?>
<?php if ($_SESSION['superid']=='1') { ?>
<div id="member_history_wrapper">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <?php if ($_GET['paramdeposit']==="successd") { ?>
            <div class="alert-box success radius"><?php echo Helper::translate("Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be credited to your account within 5 - 10 minutes.", "member-history-credited"); ?><br />
                <span style="color:#990000; text-transform: uppercase; font-weight: bold"><?php echo Helper::translate("For cash deposit, please visit our live chat to confirm your deposit.", "member-history-deposit"); ?></span>
            </div>
            <?php } else if ($_GET['param']==="successw") { ?>
            <div class="alert-box success radius"><?php echo Helper::translate("Thank you. Your transaction has been requested successfully and is under processing. The amount will be banked in to your designated bank account within 10 minutes.", "member-history-bankin"); ?></div>
            <?php } else if ($_GET['paramtransfer']==="successt") { ?>
            <div class="alert-box success radius"><?php echo Helper::translate("Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be transferred within 5 - 10 minutes.", "member-history-transfer"); ?>
            </div>
            <?php } else if ($_GET['paramdeposit']==="failure") { ?>
            <div class="alert-box alert radius"><?php echo Helper::translate("Transaction error occurred.", "member-history-error"); ?></div>
            <?php } else if ($_GET['paramtransfer']==="failure") { ?>
            <div class="alert-box alert radius"><?php echo Helper::translate("Transaction error occurred.", "member-history-error"); ?></div>
            <?php } else if ($_GET['param']==="failure") { ?>
            <div class="alert-box alert radius"><?php echo Helper::translate("Transaction error occurred.", "member-history-error"); ?></div>
            <?php } ?>
        </div>
        <div class="small-12 medium-12 large-12 columns">
            <div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
                <h2><?php echo Helper::translate("Search", "member-history-search"); ?></h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);"><?php echo Helper::translate("click to show/hide", "member-history-showhide"); ?></a>)</span>
                <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="disappear"<?php } ?>>
                    <p><?php echo Helper::translate("Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.", "member-history-search-message"); ?></p>
                    <form name="search_form" class="common_form" id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index" method="post">
                        <input name="Trigger" type="hidden" value="search_form" />
                        <div class="row">
                            <div class="small-12 medium-12 large-2 columns">
                                <label class="inline"><?php echo Helper::translate("Week", "member-history-week"); ?></label>
                            </div>
                            <div class="small-12 medium-8 end large-4 columns">
                                <label class="inline"><span class="this-week"><?php echo Helper::translate("This week", "member-history-thisweek"); ?></span> | <span class="last-week"><?php echo Helper::translate("Last Week", "member-history-lastweek"); ?></span></label>
                            </div>
                            <div class="hide-for-large-up" style="margin:5px 0;">&nbsp;</div>
                        </div>
                        <div class="row">
                            <div class="small-12 medium-12 large-2 columns">
                                <label for="DateFrom" class="inline"><?php echo Helper::translate("Date (From)", "member-history-datefrom"); ?></label>
                            </div>
                            <div class="small-12 medium-8 large-4 columns">
                                <input name="DateFrom" class="datepicker" type="text" value="<?php echo $_SESSION['transaction_MemberIndex']['param']['DateFrom']; ?>" placeholder="(dd-mm-yyyy hh:mm:ss)" />
                            </div>
                            <div class="small-12 medium-12 large-2 columns">
                                <label for="DateTo" class="inline"><?php echo Helper::translate("Date (To)", "member-history-dateto"); ?></label>
                            </div>
                            <div class="small-12 medium-8 large-4 end columns">
                                <input name="DateTo" class="defaultdatepicker" type="text" value="<?php echo $_SESSION['transaction_MemberIndex']['param']['DateTo']; ?>" placeholder="(dd-mm-yyyy hh:mm:ss)" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 medium-12 large-2 columns">
                                <label for="TypeID" class="inline"><?php echo Helper::translate("Type", "member-history-type"); ?></label>
                            </div>
                            <div class="small-12 medium-8 large-4 columns">
                                <select name="TypeID" class="chosen">
                                    <option value="" selected="selected"><?php echo Helper::translate("All Types", "member-history-alltypes"); ?></option>
                                    <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
                                    <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$_SESSION['transaction_MemberIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="small-12 medium-12 large-2 columns">
                                <label for="Status" class="inline"><?php echo Helper::translate("Status", "member-history-status"); ?></label>
                            </div>
                            <div class="small-12 medium-8 large-4 end columns">
                                <select name="Status" class="chosen_simple">
                                    <option value="" selected="selected"><?php echo Helper::translate("All Statuses", "member-history-allstatuses"); ?></option>
                                    <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
                                    <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$_SESSION['transaction_MemberIndex']['param']['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 small-text-right medium-8 large-12 columns">
                                <input type="hidden" id="SearchTrigger" name="SearchTrigger" value="1" />
                                <input type="submit" name="submit" value="<?php echo Helper::translate("Search", "member-history-search"); ?>" class="button" />
                                <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index?page=all">
                                <input type="button" value="<?php echo Helper::translate("Reset", "member-history-reset"); ?>" class="button" />
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="small-12 medium-12 large-12 columns">
            <h2><?php echo $data['content_param']['query_title']; ?></h2>
            <?php if ($data['content_param']['count']>0) { ?>
            <div><?php echo Helper::translate("Total Results: ", "member-history-totalresults"); ?><?php echo $data['content_param']['total_results']; ?></div>
            <?php } ?>
        </div>
        <div class="small-12 medium-12 large-12 columns">
            <?php echo $data['content_param']['paginate']; ?>
        </div>
        <div class="small-12 medium-12 large-12 columns">
            <div class="small-12 medium-12 large-12 columns">

                <?php if ($data['content_param']['count']>0) { ?>
                <div class="row table_header disappear show-for-large-up" data-equalizer>
                    <div class="small-12 medium-12 large-1 columns" data-equalizer-watch><?php echo Helper::translate("Date Posted", "member-history-dateposted"); ?></div>
                    <div class="small-12 small-text-center medium-12 large-1 columns" data-equalizer-watch><?php echo Helper::translate("Type", "member-history-type"); ?></div>
                    <div class="small-12 medium-12 large-3 columns" data-equalizer-watch><?php echo Helper::translate("Details", "member-history-details"); ?></div>
                    <div class="small-12 small-text-right medium-12 large-1 columns" data-equalizer-watch><?php echo Helper::translate("Amount (MYR)", "member-history-amount"); ?></div>
                    <div class="small-12 small-text-right medium-12 large-1 columns" data-equalizer-watch><?php echo Helper::translate("Bonus (MYR)", "member-history-bonus"); ?></div>
                    <div class="small-12 small-text-right medium-12 large-1 columns" data-equalizer-watch><?php echo Helper::translate("Commission (MYR)", "member-history-commission"); ?></div>
                    <div class="small-12 small-text-center medium-12 large-1 columns" data-equalizer-watch><?php echo Helper::translate("Status", "member-history-status"); ?></div>
                    <div class="small-12 small-text-center medium-12 large-2 columns" data-equalizer-watch><?php echo Helper::translate("Remark", "member-history-remark"); ?></div>
                    <div class="small-12 small-text-center medium-12 large-1 end columns" data-equalizer-watch><?php echo Helper::translate("Time Elapse", "member-history-time-elapse"); ?></div>
                </div>
                <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
                <div class="row table_row" data-equalizer>
                    <div class="small-12 medium-12 large-1 columns" data-equalizer-watch>
                        <span class="small-label hide-for-large-up"><?php echo Helper::translate("Date Posted", "member-history-dateposted"); ?>:</span><?php echo $data['content'][$i]['Date']; ?>
                    </div>
                    <div class="small-12 small-text-left medium-12 large-1 large-text-center columns" data-equalizer-watch>
                        <span class="small-label hide-for-large-up"><?php echo Helper::translate("Type", "member-history-type"); ?>:</span><?php echo $data['content'][$i]['TypeID']; ?>
                    </div>
                    <div class="small-12 medium-12 large-3 columns" data-equalizer-watch>
                        <span class="small-label small-label-long hide-for-large-up"><?php echo Helper::translate("Details", "member-history-details"); ?>:</span><?php echo $data['content'][$i]['Date']; ?>
                        <?php if ($data['content'][$i]['TypeID']=='Withdrawal') { ?>
                        <?php echo $data['content'][$i]['Bank']; ?><br />
                        <?php } ?>
                        <?php #if ($data['content'][$i]['TypeID']!='Transfer') { ?>
                            <?php echo $data['content'][$i]['Description']; ?>
                        <?php #} ?>
                        <?php if ($data['content'][$i]['TypeID']=='Deposit') { ?>
                        (<?php echo Helper::translate("Deposit Channel: ", "member-history-depositchannel"); ?><?php echo $data['content'][$i]['DepositChannel']; ?> - <?php echo $data['content'][$i]['Bank']; ?>)
                        <?php } ?>
                        <?php if ($data['content'][$i]['TypeID']=='Transfer') { ?>
                            <?php echo $data['content'][$i]['TransferFrom']; ?> -> <?php echo $data['content'][$i]['TransferTo']; ?>
                        <?php } else { ?>
                            <?php if ($data['content'][$i]['ReferenceCode']!="") { ?>
                            <div style="margin-top:5px;"><?php echo Helper::translate("Reference Code:", "member-history-referencecode"); ?><?php echo $data['content'][$i]['ReferenceCode']; ?></div>
                            <?php } else { ?>
                            <div style="margin-top:5px;"><?php echo Helper::translate("Reference Code:", "member-history-referencecode"); ?><?php echo Helper::translate("N/A", "member-history-notavailable"); ?></div>
                            <?php } ?>
                        <?php } ?>

                        <?php //if($data['content'][$i]['Status'] == 'Rejected'){ ?>
                                <!--<br />
                            <div class="error"><?php echo Helper::translate("Rejected Remark:", "member-history-rejectedremark"); ?><?php echo $data['content'][$i]['RejectedRemark']; ?></div>-->

                        <?php //} ?>
                    </div>
                    <div class="small-12 small-text-left medium-12 large-1 large-text-right columns" data-equalizer-watch>
                            <span class="small-label hide-for-large-up"><?php echo Helper::translate("Amount (MYR)", "member-history-amount"); ?>:</span><?php

                            if ($data['content'][$i]['TypeID']=='Deposit') {
                                 echo $data['content'][$i]['In'];
                            }
                            if ($data['content'][$i]['TypeID']=='Withdrawal') {
                                echo $data['content'][$i]['Out'];
                            }
                            if ($data['content'][$i]['TypeID']=='Transfer') {
                                echo $data['content'][$i]['Amount'];
                            } ?>
                    </div>
                    <div class="small-12 small-text-left medium-12 large-1 large-text-right columns" data-equalizer-watch><span class="small-label hide-for-large-up"><?php echo Helper::translate("Bonus (MYR)", "member-history-bonus"); ?>:</span><?php echo $data['content'][$i]['Bonus']; ?></div>
                    <div class="small-12 small-text-left medium-12 large-1 large-text-right columns" data-equalizer-watch><span class="small-label hide-for-large-up"><?php echo Helper::translate("Commission (MYR)", "member-history-commission"); ?>:</span><?php echo $data['content'][$i]['Commission']; ?></div>
                    <div class="small-12 small-text-left medium-12 large-1 large-text-center  columns" data-equalizer-watch><span class="small-label hide-for-large-up"><?php echo Helper::translate("Status", "member-history-status"); ?>:</span><?php if($data['content'][$i]['Status'] == 'Processing'){ ?><?php echo '<span class="yellow-text">Processing (Wait for 3 min)</span>'; ?><?php }else{ echo $data['content'][$i]['Status']; } ?></div>
                    <div class="small-12 small-text-left medium-12 large-2 large-text-center columns" data-equalizer-watch><span class="small-label small-label-long hide-for-large-up"><?php echo Helper::translate("Remark", "member-history-remark"); ?>:</span><?php echo $data['content'][$i]['RejectedRemark']; ?></div>
                    <div class="small-12 small-text-left medium-12 large-1 large-text-center end columns" style="color: #FFFF00;" id="elapse<?php echo $data['content'][$i]['ID']; ?>" data-equalizer-watch></div>
                </div>
                <div class="hide-for-large-up" style="margin:5px 0;">&nbsp;</div>
                <?php } ?>
                <?php } else { ?>
                <p><?php echo Helper::translate("No records.", "member-history-norecord"); ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php } else { ?>
<?php if ($_GET['paramdeposit']==="successd") { ?>
<div class="notify"><?php echo Helper::translate("Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be credited to your account within 5 - 10 minutes.", "member-history-credited"); ?><br />
    <span style="color:#990000; text-transform: uppercase;"><?php echo Helper::translate("For cash deposit, please visit our live chat to confirm your deposit.", "member-history-deposit"); ?></span>
</div>
<?php } elseif ($_GET['param']==="successw") { ?>
<div class="notify"><?php echo Helper::translate("Thank you. Your transaction has been requested successfully and is under processing. The amount will be banked in to your designated bank account within 10 minutes.", "member-history-bankin"); ?></div>
<?php } elseif ($_GET['paramtransfer']==="successt") { ?>
<div class="notify"><?php echo Helper::translate("Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be transferred within 5 - 10 minutes.", "member-history-transfer"); ?>
</div>
<?php } elseif ($_GET['paramdeposit']==="failure") { ?>
<div class="error"><?php echo Helper::translate("Transaction error occurred.", "member-history-error"); ?></div>
<?php } elseif ($_GET['paramtransfer']==="failure") { ?>
<div class="error"><?php echo Helper::translate("Transaction error occurred.", "member-history-error"); ?></div>
<?php } elseif ($_GET['param']==="failure") { ?>
<div class="error"><?php echo Helper::translate("Transaction error occurred.", "member-history-error"); ?></div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2><?php echo Helper::translate("Search", "member-history-search"); ?></h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);"><?php echo Helper::translate("click to show/hide", "member-history-showhide"); ?></a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p><?php echo Helper::translate("Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.", "member-history-search-message"); ?></p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <!--<th scope="row"><label>Reseller</label></th>
	        <td><input name="Reseller" type="text" value="<?php echo $_SESSION['reseller_AdminIndex']['param']['Reseller']; ?>" size="" /></td>-->
	        <th scope="row"><label><?php echo Helper::translate("Week", "member-history-week"); ?></label></th>
	        <td><span class="this-week"><?php echo Helper::translate("This week", "member-history-thisweek"); ?></span> | <span class="last-week"><?php echo Helper::translate("Last Week", "member-history-lastweek"); ?></span></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label><?php echo Helper::translate("Date (From)", "member-history-datefrom"); ?></label></th>
	        <td><input name="DateFrom" class="datepicker" type="text" value="<?php echo $_SESSION['transaction_MemberIndex']['param']['DateFrom']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label><?php echo Helper::translate("Type", "member-history-type"); ?></label></th>
            <td><select name="TypeID" class="chosen">
                <option value="" selected="selected"><?php echo Helper::translate("All Types", "member-history-alltypes"); ?></option>
                <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$_SESSION['transaction_MemberIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select></td>
  	      </tr>
	      <tr>
	      	<th scope="row"><label><?php echo Helper::translate("Date (To)", "member-history-dateto"); ?></label></th>
	        <td><input name="DateTo" class="defaultdatepicker" type="text" value="<?php echo $_SESSION['transaction_MemberIndex']['param']['DateTo']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
            <th scope="row"><label><?php echo Helper::translate("Status", "member-history-status"); ?></label></th>
            <td><select name="Status" class="chosen_simple">
                <option value="" selected="selected"><?php echo Helper::translate("All Statuses", "member-history-allstatuses"); ?></option>
                <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$_SESSION['transaction_MemberIndex']['param']['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
                <?php } ?>
              </select></td>
	      </tr>
	    <tr>
	        <!--<th scope="row"><label>Rejected Remark</label></th>
	        <td><input name="RejectedRemark" class="validate[]" type="text" value="<?php echo $_SESSION['transaction_MemberIndex']['param']['RejectedRemark']; ?>" size="10" /></td>-->
	        <td>&nbsp;</td>
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
	        <td class="text_right">
                    <input type="hidden" id="SearchTrigger" name="SearchTrigger" value="1" />
                    <input type="submit" name="submit" value="<?php echo Helper::translate("Search", "member-history-search"); ?>" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index?page=all">
	          <input type="button" value="<?php echo Helper::translate("Reset", "member-history-reset"); ?>" class="button" />
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
    <div><?php echo Helper::translate("Total Results: ", "member-history-totalresults"); ?><?php echo $data['content_param']['total_results']; ?></div>
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
    <th><?php echo Helper::translate("Date Posted", "member-history-dateposted"); ?></th>
    <th class="center"><?php echo Helper::translate("Type", "member-history-type"); ?></th>
    <th><?php echo Helper::translate("Details", "member-history-details"); ?></th>
    <th style="text-align: right"><?php echo Helper::translate("Amount (MYR)", "member-history-amount"); ?></th>
    <th style="text-align: right"><?php echo Helper::translate("Bonus (MYR)", "member-history-bonus"); ?></th>
    <th style="text-align: right"><?php echo Helper::translate("Commission (MYR)", "member-history-commission"); ?></th>
    <th class="center"><?php echo Helper::translate("Status", "member-history-status"); ?></th>
    <th class="center"><?php echo Helper::translate("Remark", "member-history-remark"); ?></th>
    <th class="center"><?php echo Helper::translate("Time Elapse", "member-history-time-elapse"); ?></th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['Date']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['TypeID']; ?></td>
    <td>
        <?php if ($data['content'][$i]['TypeID']=='Withdrawal') { ?>
        <?php echo $data['content'][$i]['Bank']; ?><br />
        <?php } ?>
        <?php #if ($data['content'][$i]['TypeID']!='Transfer') { ?>
            <?php echo $data['content'][$i]['Description']; ?>
        <?php #} ?>
        <?php if ($data['content'][$i]['TypeID']=='Deposit') { ?>
        (<?php echo Helper::translate("Deposit Channel: ", "member-history-depositchannel"); ?><?php echo $data['content'][$i]['DepositChannel']; ?> - <?php echo $data['content'][$i]['Bank']; ?>)
        <?php } ?>
        <?php if ($data['content'][$i]['TypeID']=='Transfer') { ?>
            <?php echo $data['content'][$i]['TransferFrom']; ?> -> <?php echo $data['content'][$i]['TransferTo']; ?>
        <?php } else { ?>
            <?php if ($data['content'][$i]['ReferenceCode']!="") { ?>
            <div style="margin-top:5px;"><?php echo Helper::translate("Reference Code:", "member-history-referencecode"); ?><?php echo $data['content'][$i]['ReferenceCode']; ?></div>
            <?php } else { ?>
            <div style="margin-top:5px;"><?php echo Helper::translate("Reference Code:", "member-history-referencecode"); ?><?php echo Helper::translate("N/A", "member-history-notavailable"); ?></div>
            <?php } ?>
        <?php } ?>

        <?php //if($data['content'][$i]['Status'] == 'Rejected'){ ?>
                <!--<br />
        	<div class="error"><?php echo Helper::translate("Rejected Remark:", "member-history-rejectedremark"); ?><?php echo $data['content'][$i]['RejectedRemark']; ?></div>-->

        <?php //} ?></td>
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
    <td class="text_right"><?php echo $data['content'][$i]['Bonus']; ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Commission']; ?></td>
    <td class="center"><?php if($data['content'][$i]['Status'] == 'Processing'){ ?><?php echo '<span class="yellow-text">Processing (Wait for 3 min)</span>'; ?><?php }else{ echo $data['content'][$i]['Status']; } ?></td>
    <td class="center"><?php echo $data['content'][$i]['RejectedRemark']; ?></td>
    <td class="center" style="color: #FFFF00;" id="elapse<?php echo $data['content'][$i]['ID']; ?>"></td>
    
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p><?php echo Helper::translate("No records.", "member-history-norecord"); ?></p>
<?php } ?>





<?php } ?>


