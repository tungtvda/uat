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
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/report" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0" style="width:100%">
	      <tr>
	        <th scope="row"><label>Years</label></th>
            <td><select name="Year" class="chosen_simple">

                <?php for ($i=0; $i<$data['filters']['years']['count']; $i++) { ?>
                <option value="<?php echo $data['filters']['years'][$i]; ?>" <?php if ($data['filters']['years'][$i]==$_SESSION['reseller_ResellerReport']['Year']) { ?> selected ="selected" <?php } ?>><?php echo $data['filters']['years'][$i]; ?></option>
                <?php } ?>
              </select></td>
              <td>&nbsp;</td>
            <th scope="row"><label>Months</label></th>
            <td><select name="Month" class="chosen_simple">

                <?php for ($i=1; $i<=$data['filters']['months']['count']; $i++) { ?>
                <option value="<?php echo $data['filters']['months'][$i]; ?>" <?php if ($data['filters']['months'][$i]==$_SESSION['reseller_ResellerReport']['Month']) { ?> selected ="selected" <?php } ?>><?php echo $data['filters']['months'][$i]; ?></option>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/reseller/report?page=all">
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

    <?php if ($data['content']!='') { ?>
    <!--<div>Total Results: <?php //echo $data['content_param']['total_results']; ?></div>-->

  </div>
  <div class="results_right"><!--<a href='/admin/transaction/add/'>
    <input type="button" class="button" value="Create Transaction">
    </a>-->
    <?php //echo $data['content_param']['paginate']; ?></div>
    <?php } ?>
  <div class="clear"></div>
</div>
<?php if($data['content']['count']>0){ ?>
	 <table class="admin_table" border="0" cellpadding="0" cellspacing="0">
 <tr>
 	<th class="text_left">Reseller</th>
	<th class="text_right">In (RM)</th>
    <th class="text_right">Out (RM)</th>
    <th class="text_right">Bonus (RM)</th>
    <th class="text_right">Commission (RM)</th>
    <th class="text_right">Profit (RM)</th>
    <th class="text_right">Profit Sharing (%)</th>
    <th class="text_right">Profit Sharing (RM)</th>
 </tr>
	<?php for ($i=0; $i <$data['content']['count'] ; $i++) { ?>




  <tr>
  	<td class="text_left"><?php echo $data['content'][$i]['Report']['Reseller'][0]['Name']; ?></td>
  	<td class="text_right"><?php echo ($data['content'][$i]['Report']['In']=='')? '0.00':$data['content'][$i]['Report']['In']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Report']['Out']=='')? '0.00':$data['content'][$i]['Report']['Out']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Report']['Bonus']=='')? '0.00':$data['content'][$i]['Report']['Bonus']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Report']['Commission']=='')? '0.00':$data['content'][$i]['Report']['Commission']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Report']['Profit']=='')? '0.00':$data['content'][$i]['Report']['Profit']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Report']['Profitsharing']=='')? '0.00':$data['content'][$i]['Report']['Profitsharing']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Report']['Percentage']=='')? '0.00':$data['content'][$i]['Report']['Percentage']; ?></td>
  </tr>


<?php } ?>
</table>
<?php }else{ ?>

<p>No Report.</p>

<?php } ?>

