<?php if ($data['page']['order_delete']['ok']==1) { ?>
<div class="notify">Order deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/order/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Merchant</label></th>
	        <td><select name="MerchantID" class="chosen">
	            <option value="" selected="selected">All Merchants</option>
	            <?php for ($i=0; $i<$data['content_param']['merchant_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['merchant_list'][$i]['ID']; ?>" <?php if ($data['content_param']['merchant_list'][$i]['ID']==$_SESSION['order_AdminIndex']['param']['MerchantID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['merchant_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	          <td>&nbsp;</td>
	          <th scope="row"><label>Delivery Method</label></th>
	        <td><select name="DeliveryMethod" class="chosen">
	            <option value="" selected="selected">All Delivery Methods</option>
	            <?php for ($i=0; $i<$data['content_param']['deliverymethod_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['deliverymethod_list'][$i]['ID']; ?>" <?php if ($data['content_param']['deliverymethod_list'][$i]['ID']==$_SESSION['order_AdminIndex']['param']['DeliveryMethod']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['deliverymethod_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row">Item</th>
            <td><input name="Item" type="text" value="<?php echo $_SESSION['order_AdminIndex']['param']['Item']; ?>" /></td>
	        <td>&nbsp;</td>
            <th>Dealer Total</th>
            <td><input name="DealerTotal" type="text" value="<?php echo $_SESSION['order_AdminIndex']['param']['DealerTotal']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Status</label></th>
	        <td><select name="Status" class="chosen_simple">
	            <option value="" selected="selected">All Order Statuses</option>
	            <?php for ($i=0; $i<$data['content_param']['orderstatus_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['orderstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['orderstatus_list'][$i]['ID']==$_SESSION['order_AdminIndex']['param']['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['orderstatus_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
            <th>Dealer Discount</th>
            <td><input name="DealerDiscount" type="text" value="<?php echo $_SESSION['order_AdminIndex']['param']['DealerDiscount']; ?>" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Payment Method</label></th>
	        <td><select name="PaymentMethod" class="chosen">
	            <option value="" selected="selected">All Payment Methods</option>
	            <?php for ($i=0; $i<$data['content_param']['paymentmethod_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['paymentmethod_list'][$i]['ID']; ?>" <?php if ($data['content_param']['paymentmethod_list'][$i]['ID']==$_SESSION['order_AdminIndex']['param']['PaymentMethod']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['paymentmethod_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Order Date (From)</label></th>
	        <td><input name="OrderDateFrom" class="datepicker" type="text" value="<?php echo $_SESSION['order_AdminIndex']['param']['OrderDateFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	      </tr>
	      <tr>
	        
	        
	        <th scope="row"><label>Order Date (To)</label></th>
	        <td><input name="OrderDateTo" class="datepicker" type="text" value="<?php echo $_SESSION['order_AdminIndex']['param']['OrderDateTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	      </tr>
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
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/order/index?page=all">
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
  <div class="results_right"><a href='/admin/order/add/'><input type="button" class="button" value="Create Order"></a><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/order/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Item</th>
    <th>Total</th>
    <th>DealerTotal</th>
    <th>DealerDiscount</th>
    <th>Order Date</th>
    <th>Delivery Method</th>
    <th>Payment Method</th>
    <th class="center">Status</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="white-space:nowrap"><?php echo $data['content'][$i]['ID']; ?></td>
    <td><?php echo $data['content'][$i]['MerchantName']; ?></td>
    <td><?php echo $data['content'][$i]['Item']; ?></td>
    <td><?php echo $data['content'][$i]['Total']; ?></td>
    <td><?php echo $data['content'][$i]['DealerTotal']; ?></td>
    <td><?php echo $data['content'][$i]['DealerDiscount']; ?></td>
    <td><?php echo $data['content'][$i]['OrderDate']; ?></td>
    <td><?php echo $data['content'][$i]['DeliveryMethod']; ?></td>
    <td><?php echo $data['content'][$i]['PaymentMethod']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Status']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/order/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/admin/order/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
