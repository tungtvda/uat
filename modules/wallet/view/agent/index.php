<?php
function familyTree($array)
{


        if(is_array($array)===TRUE)
        {


              for ($index = 0; $index < $array['count']; $index++) {

                     if ($array[$index]['ID']==$_SESSION['wallet_AgentIndex']['param']['AgentID']) {
                        $selected= 'selected="selected"';

                     }

                    $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].' | '. $array[$index]['Company'].'</option>';

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
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/wallet/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Member</label></th>
	        <td colspan="4"><select name="MemberID" class="chosen_full">
	            <option value="" selected="selected">All Members</option>
	            <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>" <?php if ($data['content_param']['member_list'][$i]['ID']==$_SESSION['wallet_AgentIndex']['param']['MemberID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['member_list'][$i]['Name']; ?> | <?php echo $data['content_param']['member_list'][$i]['Username']; ?> | <?php echo $data['content_param']['member_list'][$i]['AgentURL']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
          <tr>
            <th scope="row"><label>Agent</label></th>
            <td colspan="4">
                    <select name="AgentID" class="chosen_full">
                    <option value="">--Select All--</option>
                    <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($_SESSION['wallet_AgentIndex']['param']['AgentID']==$data['agent'][0]['ID']){ ?>selected="selected"<?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?> | <?php echo $data['agent'][0]['Company']; ?></option>
                <?php familyTree($data['agent'][0]['Child']); ?>
                    </select>
            </td>
          </tr>
	      <tr>
	        <th scope="row"><label>Product</label></th>
	        <td><select name="ProductID" class="chosen">
	            <option value="" selected="selected">All Products</option>
	            <?php for ($i=0; $i<$data['content_param']['product_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['product_list'][$i]['ID']; ?>" <?php if ($data['content_param']['product_list'][$i]['ID']==$_SESSION['wallet_AgentIndex']['param']['ProductID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['product_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
            <td>Total</label></td>
            <td><input name="Total" type="text" id="Label" value="<?php echo $_SESSION['wallet_AgentIndex']['param']['Total']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['wallet_AgentIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/wallet/index?page=all">
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
    <a href='/agent/wallet/add/'>
    <input type="button" class="button" value="Create Wallet">
    </a>
    <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <a href='/agent/wallet/add/'>
    <input type="button" class="button" value="Create Wallet">
    </a>
    <?php } ?>
    <!--<a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a>--><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th>Member</th>
    <th class="center">Product</th>
    <th class="center">Agent</th>
    <th class="center">Username</th>
    <th class="center">PIN Number</th>
    <th class="center">Password</th>
    <th class="center">Total(MYR)</th>
    <th class="center">Enabled</th>
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
    <th class="center">&nbsp;</th>
    <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <th class="center">&nbsp;</th>

    <?php } ?>
  </tr>
  <?php for ($i=0; $i<$data['content']['count']; $i++) { ?>
  <tr>
    <td><b><?php echo $data['content'][$i]['MemberID']; ?></b> (<?php echo $data['content'][$i]['MemberUsername']; ?>)</td>
    <td class="center"><?php echo $data['content'][$i]['ProductID']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['AgentID']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Username']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['PIN']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Password']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Total']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/wallet/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/wallet/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>

    <?php } ?>
  </tr>
  <?php } ?>

</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
