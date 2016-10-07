<script type="text/javascript">
function check_terms() {
    if (document.getElementById('AcceptTerms').clicked == true) {
        alert('Please accept the terms and conditions to continue.');
    } else {
        document.getElementById("confirm_form").submit();
    }
}
</script>
<?php if($data['content']['Name']!=""){ ?>
    <!--<form action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/request" method="post" id="confirm_form">-->
    <table style="margin-bottom:15px;" class="member_table" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th>Payee Name</th>
        <th class="text_right">Account No</th>
        <th>Bank Name</th>
        <th class="text_right">Total Amount (RM)</th>
        <!--<th class="text_right">Year</th>-->
      <tr>
        <td>
        	<?php echo $_SESSION['manualcheque']['Name']; ?>
        </td>
        <td  class="text_right">
        	<?php echo $_SESSION['manualcheque']['AccountNo']; ?>
        </td>
        <td>
        	<?php echo $_SESSION['manualcheque']['Bank']; ?>
        </td>
        <td  class="text_right">
        	<?php if(!isset($_SESSION['DealerMerchant'])){ ?>
        	<?php echo $_SESSION['cart']['SelectedAmount']; ?>
        	<?php }else{ ?>
        	<?php echo $_SESSION['DealerMerchant']['SelectedAmount']; ?>	
        	<?php } ?>	
        </td>
        
      </tr>
    </table>
    
    <p style="color:#777; font-style: italic; font-size:11px; text-align: right; margin-top: -7px; padding-left: 10px;">(Note: All purchases are non-refundable)</p>
    <form action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/paymentcheque/<?php echo $_SESSION['manualcheque']['ID']; ?>" method="post" id="add_form" name="add_form">
    <div class="common_block">
    		<label><span class="terms_box"><input class="validate[required] checkbox" type="checkbox" id="agree" name="agree"/></span>By submitting this order, I agree that the order information above is correct, and I accept the <a href="<?php echo $data['config']['SITE_URL']; ?>/main/page/terms-and-conditions" target="_blank">terms of use</a> of the website.</label>
    </div>
    
    <a href="<?php echo $data['config']['SITE_URL']; ?>/cart/order/confirm/<?php echo $data['param']; ?>"><input style="float:left;" type="button" class="button" value="Back"></a>
    <input style="float:right;"  type="submit" class="button" value="Pay Now">
    </form>
    <?php }else{ ?>
    <p>No records</p>	
    <?php } ?>
    <!-- Payment Data -->
    <!--<input type="hidden" name="RequestTrigger" id="RequestTrigger" value="1" /> 
</form>-->