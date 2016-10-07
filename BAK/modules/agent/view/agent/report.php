<?php 
function familyTree($array)
	{
           
           
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                             if ($array[$index]['ID']==$_SESSION['agent_AgentReport']['Agent']) { 
                                $selected= 'selected="selected"'; 

                             }                     
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].'</option>';    
                       
                            echo $data;
                            unset($selected);
                            
                           familyTree($array[$index]['Child']);
                      }
                     
                  
                }
                
        }
                               
?>
<?php //Debug::displayArray($this); ?>
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
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/report" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0" style="width:100%">
	      <tr>
	        <th scope="row"><label>Years</label></th>
            <td><select name="Year" class="chosen_simple">

                <?php for ($i=0; $i<$data['filters']['years']['count']; $i++) { ?>
                <option value="<?php echo $data['filters']['years'][$i]; ?>" <?php if ($data['filters']['years'][$i]==$_SESSION['agent_AgentReport']['Year']) { ?> selected ="selected" <?php } ?>><?php echo $data['filters']['years'][$i]; ?></option>
                <?php } ?>
              </select></td>
              <td>&nbsp;</td>
            <th scope="row"><label>Months</label></th>
            <td><select name="Month" class="chosen_simple">
                <option value="0">All months</option>
                <?php for ($i=1; $i<=$data['filters']['months']['count']; $i++) { ?>
                <option value="<?php echo $data['filters']['months'][$i]; ?>" <?php if ($data['filters']['months'][$i]==$_SESSION['agent_AgentReport']['Month']) { ?> selected ="selected" <?php } ?>><?php echo $data['filters']['months'][$i]; ?></option>
                <?php } ?>
              </select></td>
  	      </tr>
	    <tr>
	        <th scope="row"><label>Agent</label></th>
	      	<td><select name="Agent" class="chosen_full">
	            <option value="">--Select All--</option>
                    <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($data['agent'][0]['ID']==$_SESSION['agent_AgentReport']['Agent']){ ?>selected="selected"<?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?></option>
	            <?php familyTree($data['agent'][0]['Child']); ?>
	          </select></td>
	        <td>&nbsp</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/report?page=all">
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
<?php if($data['content']['count'] != ''){ ?>
<?php if($data['content']['count']>0){ ?>
	 <table class="admin_table" border="0" cellpadding="0" cellspacing="0">
 <tr>
 	<th class="text_left" style="padding-left: <?php echo $data['content']['Padding']; ?>px;">Agent</th>
	<th class="text_right">In (RM)</th>
    <th class="text_right">Out (RM)</th>
    <th class="text_right">Bonus (RM)</th>
    <th class="text_right">Commission (RM)</th>
    <th class="text_right">Profit (RM)</th>
<!--    <th class="text_right">Profit Sharing (Sum)</th>
    <th class="text_right">Profit Sharing (RM)</th>-->
 </tr>
	<?php for ($i=0; $i <$data['content']['count'] ; $i++) { ?>




 <tr class="color">
  	<td class="text_left" style="padding-left: <?php echo $data['content'][$i]['Padding']; ?>px;"><?php echo $data['content'][$i]['Agent']; ?></td>
  	<td class="text_right"><?php echo ($data['content'][$i]['In']=='0.00')? '0.00':$data['content'][$i]['In']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Out']=='0.00')? '0.00':'-'.$data['content'][$i]['Out']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Bonus']=='0.00')? '0.00':'-'.$data['content'][$i]['Bonus']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Commission']=='0.00')? '0.00':'-'.$data['content'][$i]['Commission']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Profit']=='0.00')? '0.00':$data['content'][$i]['Profit']; ?></td>
<!--    <td class="text_right"><?php echo ($data['content'][$i]['Profitsharing']=='')? '0.00':$data['content'][$i]['Profitsharing']; ?></td>
    <td class="text_right"><?php echo ($data['content'][$i]['Percentage']=='')? '0.00':$data['content'][$i]['Percentage']; ?></td>-->
  </tr>


<?php } ?>
</table>
<?php } ?>

<?php } ?>

<?php if($data['months']['count'] != ''){ ?>
<?php if($data['months']['count']>0){ ?>
	
	


<?php for ($m=1; $m <= 12 ; $m++) { ?>
	<div>Month: <strong><?php echo $data['months'][$m]['Month']; ?></strong></div> 
	<div>Year: <strong><?php echo $data['months']['year']; ?></strong></div>	
			 <table class="admin_table" border="0" cellpadding="0" cellspacing="0">
 <tr>
 	
 	<th class="text_left" style="padding-left:<?php echo $data['months']['padding']; ?>px;">Agent</th>
	<th class="text_right">In (RM)</th>
    <th class="text_right">Out (RM)</th>
    <th class="text_right">Bonus (RM)</th>
    <th class="text_right">Commission (RM)</th>
    <th class="text_right">Profit (RM)</th>
<!--    <th class="text_right">Profit Sharing (Sum)</th>
    <th class="text_right">Profit Sharing (RM)</th>-->
 </tr>
 <?php for ($i=0; $i <$data['months']['count'] ; $i++) { ?>
 <tr class="color">
  	

  	<td class="text_left" style="padding-left:<?php echo $data['months'][$m][$i]['Padding']; ?>px;"><?php echo $data['months'][$m][$i]['Agent']; ?></td>
  	<td class="text_right"><?php echo ($data['months'][$m][$i]['In']=='0.00')? '0.00':$data['months'][$m][$i]['In']; ?></td>
    <td class="text_right"><?php echo ($data['months'][$m][$i]['Out']=='0.00')? '0.00':'-'.$data['months'][$m][$i]['Out']; ?></td>
    <td class="text_right"><?php echo ($data['months'][$m][$i]['Bonus']=='0.00')? '0.00':'-'.$data['months'][$m][$i]['Bonus']; ?></td>
    <td class="text_right"><?php echo ($data['months'][$m][$i]['Commission']=='0.00')? '0.00':'-'.$data['months'][$m][$i]['Commission']; ?></td>
    <td class="text_right"><?php echo ($data['months'][$m][$i]['Profit']=='0.00')? '0.00':$data['months'][$m][$i]['Profit']; ?></td>
<!--    <td class="text_right"><?php echo ($data['months'][$m][$i]['Profitsharing']=='')? '0.00':$data['months'][$m][$i]['Profitsharing']; ?></td>
    <td class="text_right"><?php echo ($data['months'][$m][$i]['Percentage']=='')? '0.00':$data['months'][$m][$i]['Percentage']; ?></td>-->
  </tr>
<?php } ?>
</table>
<br />

<?php } ?>

<?php } ?>
<?php } ?>


<?php if($data['agentmonths']['count']>0){ ?>
<div>Month: <strong><?php echo $data['agentmonths']['month']; ?></strong></div> 
	<div>Year: <strong><?php echo $data['agentmonths']['year']; ?></strong></div>	
			 <table class="admin_table" border="0" cellpadding="0" cellspacing="0">
 <tr>
 	
 	<th class="text_left">Agent</th>
	<th class="text_right">In (RM)</th>
    <th class="text_right">Out (RM)</th>
    <th class="text_right">Bonus (RM)</th>
    <th class="text_right">Commission (RM)</th>
    <th class="text_right">Profit (RM)</th>
<!--    <th class="text_right">Profit Sharing (Sum)</th>
    <th class="text_right">Profit Sharing (RM)</th>-->
 </tr>
 <?php //for ($i=0; $i <$data['resellermonths']['count'] ; $i++) { ?>
 <tr class="color">
  	

  	<td class="text_left"><?php echo $data['agentmonths']['Agent']; ?></td>
  	<td class="text_right"><?php echo ($data['agentmonths']['In']=='0.00')? '0.00':$data['agentmonths']['In']; ?></td>
    <td class="text_right"><?php echo ($data['agentmonths']['Out']=='0.00')? '0.00':'-'.$data['agentmonths']['Out']; ?></td>
    <td class="text_right"><?php echo ($data['agentmonths']['Bonus']=='0.00')? '0.00':'-'.$data['agentmonths']['Bonus']; ?></td>
    <td class="text_right"><?php echo ($data['agentmonths']['Commission']=='0.00')? '0.00':'-'.$data['agentmonths']['Commission']; ?></td>
    <td class="text_right"><?php echo ($data['agentmonths']['Profit']=='0.00')? '0.00':$data['agentmonths']['Profit']; ?></td>
<!--    <td class="text_right"><?php echo ($data['agentmonths']['Profitsharing']=='')? '0.00':$data['agentmonths']['Profitsharing']; ?></td>
    <td class="text_right"><?php echo ($data['agentmonths']['Percentage']=='')? '0.00':$data['agentmonths']['Percentage']; ?></td>-->
  </tr>
<?php //} ?>
 
 
<?php } ?>

</table>

<?php if($data['agentallmonths']['count']>0){ ?>
	<?php for ($i=1; $i <=12 ; $i++) { ?>
<div>Month: <strong><?php echo $data['agentallmonths'][$i]['month']; ?></strong></div> 
	<div>Year: <strong><?php echo $data['agentallmonths']['year']; ?></strong></div>
	<?php //} ?>	
			 <table class="admin_table" border="0" cellpadding="0" cellspacing="0">
 <tr>
 	
 	<th class="text_left">Agent</th>
	<th class="text_right">In (RM)</th>
    <th class="text_right">Out (RM)</th>
    <th class="text_right">Bonus (RM)</th>
    <th class="text_right">Commission (RM)</th>
    <th class="text_right">Profit (RM)</th>
<!--    <th class="text_right">Profit Sharing (Sum)</th>
    <th class="text_right">Profit Sharing (RM)</th>-->
 </tr>
 <?php //for ($i=1; $i <=12 ; $i++) { ?>
 <tr class="color">
  	

  	<td class="text_left"><?php echo $data['agentallmonths'][$i]['Agent']; ?></td>
  	<td class="text_right"><?php echo ($data['agentallmonths'][$i]['In']=='0.00')? '0.00':$data['agentallmonths'][$i]['In']; ?></td>
    <td class="text_right"><?php echo ($data['agentallmonths'][$i]['Out']=='0.00')? '0.00':'-'.$data['agentallmonths'][$i]['Out']; ?></td>
    <td class="text_right"><?php echo ($data['agentallmonths'][$i]['Bonus']=='0.00')? '0.00':'-'.$data['agentallmonths'][$i]['Bonus']; ?></td>
    <td class="text_right"><?php echo ($data['agentallmonths'][$i]['Commission']=='0.00')? '0.00':'-'.$data['agentallmonths'][$i]['Commission']; ?></td>
    <td class="text_right"><?php echo ($data['agentallmonths'][$i]['Profit']=='0.00')? '0.00':$data['agentallmonths'][$i]['Profit']; ?></td>
<!--    <td class="text_right"><?php echo ($data['agentallmonths'][$i]['Profitsharing']=='')? '0.00':$data['agentallmonths'][$i]['Profitsharing']; ?></td>
    <td class="text_right"><?php echo ($data['agentallmonths'][$i]['Percentage']=='')? '0.00':$data['agentallmonths'][$i]['Percentage']; ?></td>-->
  </tr>
  </table>
  <br />
<?php } ?>
 
 
<?php } ?>





