<script type="text/javascript">
function submit_address(){
    // if (document.getElementById('AcceptTerms').checked != true) {
        // alert('Please accept the terms and conditions to continue.');
    // } else {
        document.getElementById("update_shipping").submit();
    //}
}
</script>
<?php if (isset($_SESSION['merchantcart']['item'])) { ?>
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
<div style="margin-top: 18px;float: right;margin-bottom: 15px;margin-right: 10px;"><strong style="margin-left: 5px;">Total Products:&nbsp;<?php echo $_SESSION['merchantcart'][$data['merchantID']]['total']; ?></strong><br /><!-- <strong>+</strong>Total Shipping:&nbsp;RM<?php //echo $data['shipping_cost']; ?><br /><hr /><strong>Subtotal:&nbsp;<?php //$subtotal = $_SESSION['merchantcart'][$data['merchantID']]['total'] + $data['shipping_cost']; ?>RM<?php //echo $subtotal;?></strong> --></div>
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
<!-- <div>
	<div style="border: 1px solid #E4E3E2;float: left;padding:8px 5px 8px 8px;margin: 15px 5px 0 5px;max-width: 369px;min-width: 450px;" id="target">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
	<div style="border: 1px solid #E4E3E2;float: right;padding:8px 8px 8px 5px;margin: 15px 5px 0 5px;max-width: 369px;min-width: 450px;">
	    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
</div> -->

<div style="padding-top: 20px;margin-bottom: 100px;" class="clear">
	<div>
		<h4>Choose your delivery method</h4>
	<?php if($_SESSION['merchantcart'][$data['merchantID']]['carrier_options']['count']>0 && isset($_SESSION['merchantcart'][$data['merchantID']]['carrier_options']['count'])){ ?>
		<table class="member_table">
			<tr>
				<th>Carrier</th>
				<th>Carrier type</th>
				<th>Information</th>
				<th>Price</th>
			</tr>
			<form name="shipping_form" id="update_shipping" action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/confirm/<?php echo $data['merchantID']; ?>" method="post">
				<input type="hidden" name="merchantID" value="<?php echo $data['merchantID']; ?>">
		<?php for ($i=0; $i<$_SESSION['merchantcart'][$data['merchantID']]['carrier_options']['count']; $i++) { ?>		
					<tr>
						
					<td>
					  
					  <input type="hidden" name="carriercost" value="<?php echo $_SESSION['merchantcart'][$data['merchantID']]['carrier_options'][$i]['Cost']; ?>">
                      <input type="radio" name="carrier" value="<?php echo $_SESSION['merchantcart'][$data['merchantID']]['carrier_options'][$i]['CarrierID']; ?>">
                      
                      
                    </td>  
               			
					
				<td><?php echo $_SESSION['merchantcart'][$data['merchantID']]['carrier_options'][$i]['CarrierName']; ?></td>	
				<td>Weight Carrier price</td>
				<td>RM <?php echo $_SESSION['merchantcart'][$data['merchantID']]['carrier_options'][$i]['Cost']; ?></td>
				</tr>
			
			<?php } ?>	
			</form>
			</table>
	<?php }else{ ?>
		<table class="member_table">
			<tr>
				<th>Carrier</th>
				<th>Carrier type</th>
				<th>Information</th>
				<th>Price</th>
			</tr>
			<tr>
				
				<td style="color: #CC0000;" colspan="3"><strong><?php echo $_SESSION['merchantcart'][$data['merchantID']]['carrier_options']; ?> !</strong></td>
					  
			</tr>
		</table>		
	<?php } ?>
		
		<div style="float: right;margin-top: 35px;">
  			<a href="<?php echo $data['config']['SITE_URL']; ?>/cart/order/shipping"><input type="button" value="Previous" class="button" /></a>
    		<input type="button" onclick="submit_address();return false;" value="Next" class="button">
  	</div> 
	</div>
	
</div>

