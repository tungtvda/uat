<script type="text/javascript">
function check_terms() {
    if (document.getElementById('AcceptTerms').checked != true) {
        alert('Please accept the terms and conditions to continue.');
    } else {
        document.getElementById("confirm_form").submit();
    }
}
</script>
    <form action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/paymentcheck" method="post" id="confirm_form">
    <table style="margin-bottom:15px;" class="member_table" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th>Item</th>
        <th class="text_right">Total / Year</th>
        <!--<th class="text_right">Year</th>-->
      <tr>
        <td><strong>
        	<?php if(!isset($_SESSION['DealerMerchant'])){ ?>
        	<?php echo $_SESSION['cart']['OrderItem']; ?></strong><br />
            <?php echo $_SESSION['cart']['OrderDesc']; ?><br />
            <?php echo $_SESSION['cart']['OrderDesc2']; ?>
            <?php }else{ ?>
            <?php echo $_SESSION['DealerMerchant']['OrderItem']; ?></strong><br />
            <?php echo $_SESSION['DealerMerchant']['OrderDesc']; ?><br />
            <?php echo $_SESSION['DealerMerchant']['OrderDesc2']; ?>
            <?php } ?>	
        </td>
        <!--<td class="text_right">RM<?php echo Helper::displayCurrency($_SESSION['cart']['OrderAmount']); ?></td>-->
        <td>
        	<?php if(!isset($_SESSION['DealerMerchant'])){ ?>
	        <input type="radio" name="year" value="1" <?php if($_SESSION['YearSelected']=='1'){ ?>checked="checked" <?php }elseif(empty($_SESSION['YearSelected'])){ ?>checked="checked" <?php } ?>> RM<?php echo Helper::displayCurrency($_SESSION['cart']['OrderAmount']); ?> / 1 year <br />
	        <input type="radio" name="year" value="2" <?php if($_SESSION['YearSelected']=='2'){ ?>checked="checked" <?php } ?>> RM<?php echo Helper::displayCurrency($_SESSION['cart']['OrderAmount2']); ?> / 2 years
	        <?php }else{ ?>
	        <input type="radio" name="year" value="1" <?php if($_SESSION['YearSelected']=='1'){ ?>checked="checked" <?php } ?>> RM<?php echo Helper::displayCurrency($_SESSION['DealerMerchant']['OrderAmount']); ?> / 1 year <br />
	        <input type="radio" name="year" value="2" <?php if($_SESSION['YearSelected']=='1'){ ?>checked="checked" <?php } ?>> RM<?php echo Helper::displayCurrency($_SESSION['DealerMerchant']['OrderAmount2']); ?> / 2 years
	        <?php } ?>	 
        </td>
      </tr>
    </table>
    <p style="color:#777; font-style: italic; font-size:11px; text-align: right; margin-top: -7px; padding-left: 10px;">(Note: All purchases are non-refundable)</p>
    <div class="common_block"><label><span class="terms_box"><input type="checkbox" name="AcceptTerms" id="AcceptTerms" value="1" /></span>By submitting this order, I agree that the order information above is correct, and I accept the <a href="<?php echo $data['config']['SITE_URL']; ?>/main/page/terms-and-conditions" target="_blank">terms of use</a> of the website.</label></div>
    
    
    <div style="float:left;">Online Payment &nbsp;&nbsp;</div>
    <input style="float:left;" name="payment" type="radio" class="button" value="Online" <?php if($_SESSION['PaymentType']=='Online'){ ?>checked="checked" <?php }elseif(empty($_SESSION['PaymentType'])){ ?>checked="checked" <?php } ?>>
    <div class="clear"></div>
    <br />
    <div style="float:left;">Manual Bank-In &nbsp;&nbsp;</div>
    <input style="float:left;" name="payment" type="radio" class="button" value="BankIn" <?php if($_SESSION['PaymentType']=='BankIn'){ ?>checked="checked" <?php } ?>>
    <div class="clear"></div>
    <br />
    <div style="float:left;">Manual Cheque &nbsp;&nbsp;</div>
    <input style="float:left;" name="payment" type="radio" class="button" value="Cheque" <?php if($_SESSION['PaymentType']=='Cheque'){ ?>checked="checked" <?php } ?>>
    <div class="clear"></div>
    <br />
    <?php if($data['back_link']=="merchant"){ ?>
    <a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/dashboard">
    <input style="float:left;" type="button" class="button" value="Back">
    </a>
    <?php }else{ ?>
    <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/merchant/index">
    <input style="float:left;" type="button" class="button" value="Back">
    </a>	
    <?php } ?>	
    <input style="float:right;" onclick="check_terms();" type="button" class="button" value="Pay Now">
    <!-- Payment Data -->
    <input type="hidden" name="RequestTrigger" id="RequestTrigger" value="1" /> 
</form>

