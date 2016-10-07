<script type="text/javascript">
$(document).ready(function() {
     setTimeout(function () {
        $('#profileupgradeprocess_form_standard').submit();
    }, 100); 

});
</script>
<form name="profileupgradeprocess_form" id="profileupgradeprocess_form_standard" action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/confirm" method="post">
    <input type="hidden" name="OrderType" id="OrderType" value="Standard Membership" />
    <input type="hidden" name="OrderItem" id="OrderItem" value="Standard Membership Upgrade - One Year" />
    <input type="hidden" name="OrderDesc" id="OrderDesc" value="Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['STANDARD_MEMBER_FEE']); ?>) (Period: <?php echo date('d-m-Y'); ?> to <?php echo date('d-m-Y',strtotime('+1 year')); ?>)" />
    <input type="hidden" name="OrderAmount" id="OrderAmount" value="<?php echo $data['config']['STANDARD_MEMBER_FEE']; ?>" />
    <input type="hidden" name="OrderKey" id="OrderKey" value="aseanfnb" />
    <input type="hidden" name="OrderDelivery" id="OrderDelivery" value="standard-membership-upgrade" />
    <input type="hidden" name="OrderTrigger" id="OrderTrigger" value="1" />
    <input type="hidden" name="RedirectURL" id="RedirectURL" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
</form>
<p>Please wait while we process your request...</p>