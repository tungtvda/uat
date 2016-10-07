<?php if ($data['page']['transaction_orderdelete']['ok']==1) { ?>
<div class="notify">Transaction deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/orderindex/<?php echo $data['parent']['id']; ?>" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Type</label></th>
	        <td><select name="TypeID" class="chosen">
	            <option value="" selected="selected">All Types</option>
	            <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$_SESSION['transaction_AdminOrderIndex']['param']['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th>Amount</th>
	        <td><input name="Amount" type="text" value="<?php echo $_SESSION['transaction_AdminOrderIndex']['param']['Amount']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Name</label></th>
	        <td><input name="Name" type="text" value="<?php echo $_SESSION['transaction_AdminOrderIndex']['param']['Name']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Status</label></th>
	        <td><select name="Status" class="chosen_simple">
	            <option value="" selected="selected">All Statuses</option>
	            <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$_SESSION['transaction_AdminOrderIndex']['param']['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date Posted (From)</label></th>
	        <td><input name="DatePostedFrom" class="datepicker" type="text" value="<?php echo $_SESSION['transaction_AdminOrderIndex']['param']['DatePostedFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Payment Method</label></th>
	        <td><select name="PaymentMethod" class="chosen">
	            <option value="" selected="selected">All Payment Methods</option>
	            <?php for ($i=0; $i<$data['content_param']['paymentmethod_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['paymentmethod_list'][$i]['ID']; ?>" <?php if ($data['content_param']['paymentmethod_list'][$i]['ID']==$_SESSION['transaction_AdminOrderIndex']['param']['PaymentMethod']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['paymentmethod_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date Posted (To)</label></th>
	        <td><input name="DatePostedTo" class="datepicker" type="text" value="<?php echo $_SESSION['transaction_AdminOrderIndex']['param']['DatePostedTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
	          <?php /*?><th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['transaction_AdminOrderIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td><?php */?>
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/orderindex/<?php echo $data['parent']['id']; ?>?page=all">
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
  <div class="results_right"><a href='/admin/transaction/orderadd/<?php echo $data['parent']['id']; ?>'>
    <input type="button" class="button" value="Create Transaction">
    </a><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/export/AdminOrderIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Date Posted</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Payment Method</th>
    <th class="center">Status</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['DatePosted']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['TypeID']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['Amount']; ?></td>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['PaymentMethod']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Status']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/orderedit/<?php echo $data['parent']['id']; ?>,<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/orderdelete/<?php echo $data['parent']['id']; ?>,<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
