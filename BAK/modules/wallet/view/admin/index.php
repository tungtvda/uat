<?php if ($data['page']['wallet_delete']['ok']==1) { ?>
<div class="notify">Wallet deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Member</label></th>
	        <td><select name="MemberID" class="chosen">
	            <option value="" selected="selected">All Members</option>
	            <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>" <?php if ($data['content_param']['member_list'][$i]['ID']==$_SESSION['wallet_AdminIndex']['param']['MemberID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['member_list'][$i]['Name']; ?> | <?php echo $data['content_param']['member_list'][$i]['Username']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <td>Total</label></td>
	        <td><input name="Total" type="text" id="Label" value="<?php echo $_SESSION['wallet_AdminIndex']['param']['Total']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Product</label></th>
	        <td><select name="ProductID" class="chosen">
	            <option value="" selected="selected">All Products</option>
	            <?php for ($i=0; $i<$data['content_param']['product_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['product_list'][$i]['ID']; ?>" <?php if ($data['content_param']['product_list'][$i]['ID']==$_SESSION['wallet_AdminIndex']['param']['ProductID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['product_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
                <th scope="row"><label>Agent</label></th>
<!--	        <td><select name="AgentID" class="chosen">
	            <option value="" selected="selected">All Agents</option>
	            <?php for ($i=0; $i<$data['content_param']['agent_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['agent_list'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list'][$i]['ID']==$_SESSION['wallet_AdminIndex']['param']['AgentID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list'][$i]['Name']; ?> | <?php echo $data['content_param']['agent_list'][$i]['Username']; ?></option>
	            <?php } ?>
	          </select></td>-->
                  <td>
                    <select name="AgentID" class="chosen_full">
                    <option value="">--Select All--</option> 
                    <?php for ($g=0; $g<$data['content_param']['agent_list1']['count']; $g++) { ?>
                    <option value="<?php echo $data['content_param']['agent_list1'][$g]['ID']; ?>" <?php if($data['content_param']['agent_list1'][$g]['ID']==$_SESSION['wallet_AdminIndex']['param']['AgentID']){ ?>selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list1'][$g]['Name']; ?> - <?php echo $data['content_param']['agent_list1'][$g]['ID']; ?></option>
	            <?php Helper::agentOptionList($data['content_param']['agent_list1'][$g]['Child'], $_SESSION['wallet_AdminIndex']['param']['AgentID']); ?>
                    <?php } ?>
                    <?php for ($i=0; $i<$data['content_param']['agent_list2']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['agent_list2'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list2'][$i]['ID']==$_SESSION['wallet_AdminIndex']['param']['AgentID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list2'][$i]['Name']; ?></option>
	            <?php } ?>
                    </select>
                </td>
	      </tr>
	      <tr>
	        <th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['wallet_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/index?page=all">
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
    <a href='/admin/wallet/add/'>
    <input type="button" class="button" value="Create Wallet">
    </a>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']!='2') { ?>
    <a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a>
    <?php } ?>
    <?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Member</th>
    <th>Product</th>
    <th>Pin Number</th>
    <th>Agent</th>
    <th>Username</th>
    <th>Password</th>
    <th class="text_right">Total (MYR)</th>
    <th class="center">Enabled</th>
    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <th class="center">Edit</th>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <!--<th align="center">Delete</th>-->
    <?php } ?>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    
    <td><b><?php echo $data['content'][$i]['MemberID']; ?></b><br>(<?php echo $data['content'][$i]['MemberUsername']; ?>)</td>
    <td><?php echo $data['content'][$i]['ProductID']; ?></td>
    <td><?php  if($data['content'][$i]['PIN']==""){ echo "Not Available";}else{ echo $data['content'][$i]['PIN']; } ?></td>
    <td><?php echo $data['content'][$i]['AgentID']; ?></td>
    <td><?php  if($data['content'][$i]['Username']==""){ echo "Processing";}else{ echo $data['content'][$i]['Username']; } ?></td>
    <td><?php  if($data['content'][$i]['Password']==""){ echo "Processing"; }else{ echo $data['content'][$i]['Password'];} ?></td>
    <td class="text_right"><?php echo $data['content'][$i]['Total']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>

    <?php if ($_SESSION['admin']['Profile']!='3') { ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php } ?>
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
    <!--<td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>-->
    <?php } ?>
    <!-- <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td> -->
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
