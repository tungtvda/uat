<script type="text/javascript">
$(document).ready(function() {
     setTimeout(function () {
        $('#request_form').submit();
    }, 100); 

});
</script>
<form action="https://valse.com.my/paysuite/confirm.php" method="post" id="request_form">
    <!-- Payment Data -->
    <?php if(!isset($_SESSION['DealerMerchant'])){ ?>
    <input name="name" type="hidden" id="name" value="<?php echo $_SESSION['merchant']['Name']; ?>" /> 
    <?php /* ?><input name="no" type="hidden" id="no" value="<?=$data['client']['ContactMobile'];?>" /> <?php */ ?>
    <input name="email" type="hidden" id="email" value="<?php echo $_SESSION['merchant']['Email']; ?>" />
    <input name="oamt" type="hidden" id="oamt" value="<?php echo $_SESSION['cart']['OrderAmount']; ?>" /> 
    <input name="oid" type="hidden" id="oid" value="<?php echo $_SESSION['cart']['OrderNo']; ?>" />
    <input name="year" type="hidden" id="year" value="<?php echo $_SESSION['cart']['year']; ?>" />  
    <input name="oi" type="hidden" id="oi" value="<?php echo $_SESSION['cart']['OrderItem']; ?> | <?php echo $_SESSION['cart']['OrderDesc']; ?>" /> 
    <input name="orderkey" type="hidden" id="orderkey" value="<?php echo $_SESSION['cart']['OrderKey']; ?>" /> 
    <input name="sc" type="hidden" id="sc" value="Malaysia" /> 
    <input name="pk" type="hidden" value="64df268e0f43ebc9be303f9b1a4ecd7e7a968594" />
    <?php }else{ ?>
    <input name="name" type="hidden" id="name" value="<?php echo $_SESSION['DealerMerchant']['Name']; ?>" /> 
    <?php /* ?><input name="no" type="hidden" id="no" value="<?=$data['client']['ContactMobile'];?>" /> <?php */ ?>
    <input name="email" type="hidden" id="email" value="<?php echo $_SESSION['DealerMerchant']['Email']; ?>" />
    <input name="oamt" type="hidden" id="oamt" value="<?php echo $_SESSION['DealerMerchant']['OrderAmount']; ?>" /> 
    <input name="oid" type="hidden" id="oid" value="<?php echo $_SESSION['DealerMerchant']['OrderNo']; ?>" />
    <input name="year" type="hidden" id="year" value="<?php echo $_SESSION['DealerMerchant']['year']; ?>" />  
    <input name="oi" type="hidden" id="oi" value="<?php echo $_SESSION['DealerMerchant']['OrderItem']; ?> | <?php echo $_SESSION['DealerMerchant']['OrderDesc']; ?>" /> 
    <input name="orderkey" type="hidden" id="orderkey" value="<?php echo $_SESSION['DealerMerchant']['OrderKey']; ?>" /> 
    <input name="sc" type="hidden" id="sc" value="Malaysia" /> 
    <input name="pk" type="hidden" value="64df268e0f43ebc9be303f9b1a4ecd7e7a968594" />	
    	
    	
    <?php } ?>
</form>
<p>Please wait while we process your payment...</p>