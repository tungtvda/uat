<div>
	<label>Choose a carrier:&nbsp;</label>        
</div>
<!-- <div>
	<div style="border: 1px solid #E4E3E2;float: left;padding:8px 5px 8px 8px;margin: 15px 5px 0 5px;max-width: 369px;min-width: 450px;" id="target">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
	<div style="border: 1px solid #E4E3E2;float: right;padding:8px 8px 8px 5px;margin: 15px 5px 0 5px;max-width: 369px;min-width: 450px;">
	    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
</div> -->

<div style="padding-top: 20px;" class="clear">
	<div>
		<h4>Choose your delivery method</h4>
		<table class="member_table">
			<tr>
				<th>Carrier</th>
				<th>Information</th>
				<th>Price</th>
			</tr>
			<tr>
				<td><?php for ($i=0; $i<$data['result']['count']; $i++) { ?>
          <input id="id_carrier20" type="radio" <?php if($i==0)echo 'checked="checked"'; ?> value="<?php echo $data['result'][$i]['ID']; ?>" name="id_carrier"><label for="id_carrier20"><?php echo $data['result'][$i]['Label']; ?></label>
          <?php } ?>
					
					</td>
				<td>3 - 5 Working Days (Peninsular) / 5 - 7 Working Days (Sabah & Sarawak)</td>
				<td>Free</td>
			</tr>
			
		</table>
		<div style="float: right;">
  			<a href="<?php echo $data['config']['SITE_URL']; ?>/cart/order/shipping"><input type="button" value="Previous" class="button" /></a>
    		<a href="<?php echo $data['config']['SITE_URL']; ?>/cart/order/confirm"><input type="submit" name="submit" value="Next" class="button" /></a>
  	</div> 
	</div>
	
</div>
