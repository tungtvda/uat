<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/affiliatedreporting/<?php echo $data['param']; ?>" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
              <tr>
               <th scope="row"><label>Week</label></th>
	        <td><span class="this-week">This week</span> | <span class="last-week">Last Week</span></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date (From)</label></th>
	        <td><input name="DateFrom" class="validate[custom[dmyDateTime]] datepicker" type="text" value="<?php echo $_SESSION['AgentAffiliatedReporting']['DateFrom']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	        <td>&nbsp;</td>
                <th scope="row"><label>Date (To)</label></th>
	        <td><input name="DateTo" class="validate[custom[dmyDateTime]] defaultdatepicker" type="text" value="<?php echo $_SESSION['AgentAffiliatedReporting']['DateTo']; ?>" size="20" />
	          (dd-mm-yyyy hh:mm:ss)</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/affiliatedreporting?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
	      </tr>
	    </table>
	  </form>
  </div>
</div>



<?php if($data['parentID']!='0'){ ?>
<a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/agent/transaction/affiliatedreporting/<?php echo $data['parentID']; ?>">
    &laquo;Back To Parent
</a>
<br>&nbsp;
<?php }elseif($data['parentID']=='0'){ ?>
<a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/agent/transaction/affiliatedreporting">
    &laquo;Back To Parent
</a>
<br>&nbsp;
<?php } ?>
<?php //if ($data['content_param']['count']>'0') { ?>
 <table class="admin_table" border="0" cellpadding="0" cellspacing="0" style = "width:auto;">
 <tr class="noBorder">
    <th class="center"></th>
    <th class="text_right"></th>
    <th class="text_right"></th>
    <th class="text_right"></th>
    <th class="text_right"></th>
    <th class="text_right"></th>
    <th class="text_right"></th>
    <th class="text_right"></th>
    <th class="text_right">Downline</th>
    <th class="text_right"></th>
    <th class="text_right"></th>
    <th class="text_right">Yourself (<?php echo $data['profitSharing']; ?>%)</th>
    <th class="text_right"></th>
    <th class="text_right"></th>
    <th class="text_right">Upline (<?php echo $data['profitSharingDiff']; ?>%)</th>
    <th class="text_right"></th>
 </tr>
 <tr>
    <th class="center">Agent Username</th>
    <th class="text_right leftBorder">Deposit (RM)</th>
    <th class="text_right">Withdrawal (RM)</th>
    <th class="text_right">Total Win/Lose (RM)</th>
    <th class="text_right">Bonus + Commission (RM)</th>
    <th class="text_right">Profit/Loss (RM)</th>
    <th class="text_right rightBorder">PT (%)</th>
    <th class="text_right">Win/Lose (RM)</th>
    <th class="text_right">Promotion (RM)</th>
    <th class="text_right rightBorder">Total (RM)</th>
    <th class="text_right">Win/Lose (RM)</th>
    <th class="text_right">Promotion (RM)</th>
    <th class="text_right rightBorder">Total (RM)</th>
    <th class="text_right">Win/Lose (RM)</th>
    <th class="text_right">Promotion (RM)</th>
    <th class="text_right rightBorder">Total (RM)</th>
 </tr>
 <tr class="color">
     <td class="center" id="agentName"><?php echo $data['currentAgent'][0]['Username']; ?></td>
    <td class="text_right leftBorder"><?php echo ($data['currentAgent'][0]['First']['In']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['First']['In']); ?></td>
    <td class="text_right"><?php echo ($data['currentAgent'][0]['First']['Out']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['First']['Out']); ?></td>
    <td class="text_right"><?php echo ($data['currentAgent'][0]['First']['winLose']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['First']['winLose']); ?></td>
    <td class="text_right color"><?php echo ($data['currentAgent'][0]['First']['Bonus']=='')? '0.00':'-'.Helper::displayCurrency($data['currentAgent'][0]['First']['Bonus']); ?></td>
    <td class="text_right"><?php echo ($data['currentAgent'][0]['First']['Profit']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['First']['Profit']); ?></td>
    <td class="text_right rightBorder"><?php echo ($data['currentAgent'][0]['First']['Profitsharing']=='')? '0.00':$data['currentAgent'][0]['First']['Profitsharing']; ?></td>
    <td class="text_right"><?php echo ($data['currentAgent'][0]['Sec']['In']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['Sec']['In']); ?></td>
    <td class="text_right color"><?php echo ($data['currentAgent'][0]['Sec']['Bonus']=='')? '0.00':'-'.Helper::displayCurrency($data['currentAgent'][0]['Sec']['Bonus']); ?></td>
    <td class="text_right rightBorder"><?php echo ($data['currentAgent'][0]['Sec']['Profit']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['Sec']['Profit']); ?></td>
    <td class="text_right"><?php echo ($data['currentAgent'][0]['Third']['In']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['Third']['In']); ?></td>
    <td class="text_right color"><?php echo ($data['currentAgent'][0]['Third']['Bonus']=='')? '0.00':'-'.Helper::displayCurrency($data['currentAgent'][0]['Third']['Bonus']); ?></td>
    <td class="text_right rightBorder"><?php echo ($data['currentAgent'][0]['Third']['Profit']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['Third']['Profit']); ?></td>
    <td class="text_right"><?php echo ($data['currentAgent'][0]['Fourth']['In']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['Fourth']['In']); ?></td>
    <td class="text_right color"><?php echo ($data['currentAgent'][0]['Fourth']['Bonus']=='')? '0.00':'-'.Helper::displayCurrency($data['currentAgent'][0]['Fourth']['Bonus']); ?></td>
    <td class="text_right rightBorder"><?php echo ($data['currentAgent'][0]['Fourth']['Profit']=='')? '0.00':Helper::displayCurrency($data['currentAgent'][0]['Fourth']['Profit']); ?></td>
 </tr>
<?php for ($i = 0; $i < $data['content']['count']; $i++) { ?>
 <tr class="color">
      <td class="center"><a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/agent/transaction/affiliatedreporting/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Username']; ?></a></td>
    <td class="text_right leftBorder"><?php echo ($data['content'][$i]['First']['In']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['First']['In']); ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['First']['Out']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['First']['Out']); ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['First']['winLose']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['First']['winLose']); ?></td>
    <td class="text_right color"><?php echo ($data['content'][$i]['First']['Bonus']=='')? '0.00':'-'.Helper::displayCurrency($data['content'][$i]['First']['Bonus']); ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['First']['Profit']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['First']['Profit']); ?></td>
    <td class="text_right rightBorder"><?php echo ($data['content'][$i]['First']['Profitsharing']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['First']['Profitsharing']); ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Sec']['In']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['Sec']['In']); ?></td>
    <td class="text_right color"><?php echo ($data['content'][$i]['Sec']['Bonus']=='')? '0.00':'-'.Helper::displayCurrency($data['content'][$i]['Sec']['Bonus']); ?></td>
    <td class="text_right rightBorder"><?php echo ($data['content'][$i]['Sec']['Profit']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['Sec']['Profit']); ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Third']['In']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['Third']['In']); ?></td>
    <td class="text_right color"><?php echo ($data['content'][$i]['Third']['Bonus']=='')? '0.00':'-'.Helper::displayCurrency($data['content'][$i]['Third']['Bonus']); ?></td>
    <td class="text_right rightBorder"><?php echo ($data['content'][$i]['Third']['Profit']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['Third']['Profit']); ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Fourth']['In']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['Fourth']['In']); ?></td>
    <td class="text_right color"><?php echo ($data['content'][$i]['Fourth']['Bonus']=='')? '0.00':'-'.Helper::displayCurrency($data['content'][$i]['Fourth']['Bonus']); ?></td>
    <td class="text_right rightBorder"><?php echo ($data['content'][$i]['Fourth']['Profit']=='')? '0.00':Helper::displayCurrency($data['content'][$i]['Fourth']['Profit']); ?></td>
  </tr>
<?php } ?>
  <tr class="bold-color color">
      <td class="center">TOTAL</td>
      <td class="text_right leftBorder"><?php echo Helper::displayCurrency($data['total']['Total']['In']); ?></td>
      <td class="text_right"><?php echo Helper::displayCurrency($data['total']['Total']['Out']); ?></td>
      <td class="text_right"><?php echo Helper::displayCurrency($data['total']['Total']['winLose']); ?></td>
      <td class="text_right color"><?php echo ($data['total']['Total']['Bonus']=='')? '0.00':'-'.Helper::displayCurrency($data['total']['Total']['Bonus']); ?></td>
      <td class="text_right"><?php echo Helper::displayCurrency($data['total']['Total']['Profit']); ?></td>
      <td class="text_right rightBorder"></td>
      <td class="text_right"><?php echo Helper::displayCurrency($data['total']['Total']['SecIn']); ?></td>
      <td class="text_right color"><?php echo ($data['total']['Total']['SecBonus']=='')? '0.00': '-'.Helper::displayCurrency($data['total']['Total']['SecBonus']); ?></td>
      <td class="text_right rightBorder"><?php echo Helper::displayCurrency($data['total']['Total']['SecProfit']); ?></td>
      <td class="text_right"><?php echo Helper::displayCurrency($data['total']['Total']['ThirdIn']); ?></td>
      <td class="text_right color"><?php echo ($data['total']['Total']['ThirdBonus']=='')? '0.00': '-'.Helper::displayCurrency($data['total']['Total']['ThirdBonus']); ?></td>
      <td class="text_right rightBorder"><?php echo Helper::displayCurrency($data['total']['Total']['ThirdProfit']); ?></td>
      <td class="text_right"><?php echo Helper::displayCurrency($data['total']['Total']['FourthIn']); ?></td>
      <td class="text_right color"><?php echo ($data['total']['Total']['FourthBonus']=='')? '0.00': '-'.Helper::displayCurrency($data['total']['Total']['FourthBonus']); ?></td>
      <td class="text_right rightBorder"><?php echo Helper::displayCurrency($data['total']['Total']['FourthProfit']); ?></td>
  </tr>
</table>
<?php //} else { ?>
    <!--<p>No records.</p>-->
<?php //} ?>
