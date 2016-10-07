<script type="text/javascript">
function submit_address(){
    // if (document.getElementById('AcceptTerms').checked != true) {
        // alert('Please accept the terms and conditions to continue.');
    // } else {
        document.getElementById("update_shipping").submit();
    //}
}
</script>
<?php if(!empty($_SESSION['merchantcart']['item'])) { ?>
    <h2>SHOPPING CART SUMMARY</h2>
    
<table class="member_table" id="member_table">
  <tr>
    <!-- <th class="center">Type</th> -->
    <th class="center">Name</th>
    <th class="center">Description</th>
    <th class="center">Ref</th>
    <th class="center">Quantity</th>
    <th class="center">Price</th>
    <th class="center">Brand</th>
    <th class="center">Total</th>
  </tr>
  <?php //Debug::displayArray($_SESSION['cart']['item'][0]['product'][0]['ShortDesc']); ?>
  <?php for ($i=0; $i<$_SESSION['merchantcart'][$data['merchantID']]['count']; $i++) { ?>
  	<?php //if(!is_null($_SESSION['cart']['item'][$i])) { ?>
  <tr>
     <!-- <td class="center"><?php //echo $_SESSION['cart']['item'][$i]['product'][$i]['TypeID']; ?></td> -->
     <td class="center"><a href="<?php echo $data['config']['SITE_URL']; ?>/main/product/view/<?php echo $_SESSION['merchantcart']['item'][$data['merchantID']][$i]['ID']; ?>"><img src="<?php echo $data['config']['SITE_URL'].$_SESSION['merchantcart']['item'][$data['merchantID']][$i]['ProductImage'][0]['ImageURLThumb']; ?>" /></a></td>
     <td class="center"><?php echo $_SESSION['merchantcart']['item'][$data['merchantID']][$i]['ShortDesc']; ?></td>
     <td class="center"><?php echo $_SESSION['merchantcart']['item'][$data['merchantID']][$i]['SKU']; ?></td>
     <td class="center"><form name="add_form" id="add_form" action="<?php echo $data['config']['SITE_URL'].'/cart/order/updatequantity'; ?>" method="post">
     <input type="text" name="updatequantity" class="validate[required]" value="<?php echo $_SESSION['merchantcart']['item'][$data['merchantID']][$i]['Quantity']; ?>" size="1" />
     <input type="hidden" name="quantityID" value="<?php echo $_SESSION['merchantcart']['item'][$data['merchantID']][$i]['ID']; ?>">
     <input type="hidden" name="counter" value="<?php echo $i; ?>">
     <input type="hidden" name="merchantID" value="<?php echo $value[$i]['MerchantID']; ?>">
     <input type="submit" name="update" value="Update Quantity" class="button" /><input type="submit" name="delete" value="Delete" class="button" /></form></td>
     <td class="center"><?php echo $_SESSION['merchantcart']['item'][$data['merchantID']][$i]['Price']; ?></td>
     <td class="center"><?php echo $_SESSION['merchantcart']['item'][$data['merchantID']][$i]['Brand']; ?></td>
     <td class="center"><?php echo $_SESSION['merchantcart']['item'][$data['merchantID']][$i]['subtotal']; ?>.00</td>
  </tr>
  <?php //}//elseif(!isset($_SESSION['cart']['item'][$i])){ continue; }?>
  <?php } ?>
</table>
<div style="margin-top: 18px;float: right;margin-bottom: 15px;margin-right: 10px;"><strong>Total Products:&nbsp;<?php echo $_SESSION['merchantcart'][$data['merchantID']]['total']; ?></strong></div>
<?php //if($_SESSION['voucher']=='1'){ $_SESSION['usedvoucher'] = '1'; }?>
<?php //if($_SESSION['voucher']=='1'){ ?>
<!-- <div class="notify">Voucher is valid and is applied to item(s) price</div> -->
<!-- <div>Current total price: &nbsp;<?php //echo $_SESSION['cart']['total']; ?></div> -->
<?php 
// unset($_SESSION['voucher']);
      
// }elseif($_SESSION['voucher']=='0'){ ?>
<!-- <div class="error">Voucher is invalid. Please type in another voucher code</div> -->
<?php 
// unset($_SESSION['voucher']);
//} ?>
<?php //if(isset($_SESSION['usedcode'])){  ?>
<!-- <div class="error">You already used your voucher. Please type in another voucher code</div>	 -->
<?php //} ?>
	
<?php //if($_SESSION['voucher']!='1'){ ?>

<?php //} ?>

<?php } else { ?>
<p>No records.</p>
<?php } ?>
<div style="clear: both;">
 <div style="float: left;">
  <form name="billing_form" id="update_shipping" action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/updateaddress/<?php echo $data['merchantID']; ?>" method="post">
		<label>Choose a delivery address:&nbsp;</label>
			<select name="billing" class="chosen_simple" id="billing">
		          <?php for ($i=0; $i<$data['result']['count']; $i++) { ?>
		          	
		          <option value="<?php echo $data['result'][$i]['ID']; ?>"><?php echo $data['result'][$i]['Title']; ?></option>
		          
		          <?php } ?>
		    </select>
	    <!-- <input type="submit" value="Update" class="button"> -->
   <!-- </form> -->
  </div> 
  <div style="float: right;margin-right: 170px;">
   <!-- <form name="delivery_form" id="update_delivery" action="<?php //echo $data['config']['SITE_URL']; ?>/cart/order/updateaddress/<?php //echo $data['merchantID']; ?>" method="post"> -->
		<label>Choose a delivery address:&nbsp;</label>
			<select name="delivery" class="chosen_simple" id="delivery">
		          <?php for ($i=0; $i<$data['result']['count']; $i++) { ?>
		          	
		          <option value="<?php echo $data['result'][$i]['ID']; ?>"><?php echo $data['result'][$i]['Title']; ?></option>
		          
		          <?php } ?>
		    </select>
	    <!-- <input type="submit" value="Update" class="button"> -->
   </form> 
  </div>      
</div>
    
    	<div style="border: 1px solid #E4E3E2;float: left;padding:8px 5px 8px 8px;margin: 27px 5px 0 5px;max-width: 369px;min-width: 450px;" >
			<h3>Billing Address : </h3>
		    <div id="billingaddr">	
			</div>
	    </div>

	 
		<div style="border: 1px solid #E4E3E2;float: right;padding:8px 5px 8px 8px;margin: 27px 5px 0 5px;max-width: 369px;min-width: 450px;" >
			<h3>Delivery address : </h3>
		    <div id="shippingaddr">
		    </div>
	    </div>
		
	    
	
	

	

<div style="height:350px;">
<div style="padding-top: 20px;margin-bottom: 25px;" class="clear">
	<h3>Terms of service</h3>
	<input type="checkbox" name="service" value="agree">&nbsp;I agree to the terms of service and will adhere to them unconditionally. (read)
	</div>
	<div style="float: right;">
			<div style="float: left;margin-right: 6px;">
				<a href="<?php echo $data['config']['SITE_URL']; ?>/cart/order/index"><input type="button" value="Previous" class="button" /></a>
			</div>
  			<div style="float: right;">
  				<!-- <input onclick="check_terms();" type="button" class="button" value="Pay Now"> -->
    		    <!-- <a href="<?php echo $data['config']['SITE_URL']; ?>/cart/order/shipping"> --><input type="button" onclick="submit_address();return false;" value="Next" class="button"><!-- </a> -->
  			</div>   
  	</div> 
</div>	
	

