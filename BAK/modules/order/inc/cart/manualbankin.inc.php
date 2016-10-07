<script type="text/javascript" src="<?php echo $data['config']['SITE_URL']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_URL']; ?>/lib/chosen/chosen.css" media="screen" />
<style>
#cart_wrapper {
    margin-bottom:25px;
}
td.cart_image {
    width: 66px;
    padding: 7px 3px 7px 7px;
}
.cart_image img {
    width: 66px;
    height: 66px;
    display: block;
    padding:3px;
    border: 1px dashed #e0e0e0;
    background-color: #fff;
}
td.cart_details {
    border-left: 0px;
}
.cart_title {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 3px;
}
.cart_description {
    color: #909090;
    font-size:11px;
    line-height:16px;
}
.cart_quantity {
    border: 0;
    background-color: transparent;
    float: right;
}
.cart_remove {
    border: 0 none;
    float: right;
    margin-left: 10px;
    padding: 0;
}
#cart_total_product {
    font-size: 12px;
    margin-top: 11px;
    text-align: right;
}
#order_summary {
    border-right: 1px solid #ddd;
    border-top: 1px solid #ddd;
}
#order_summary tr {
    background: none;
}
#order_summary td.cart_summary_label {
    font-weight: bold;
    padding: 7px 10px;
}
#order_summary td.cart_summary_value {
    text-align: right;
    border-left: 0;
}
#order_summary tr.cart_total {
    background-color: rgba(204, 204, 204, 0.25);
}
#order_summary tr.cart_total td.cart_summary_value {
    font-weight: bold;
    font-size: 24px;
    padding: 10px 15px;
}
#order_summary tr.cart_total td {
    border-top: 1px solid #ddd;
}

</style>
<script type="text/javascript">
$(document).ready(function(){
$("#add_form").validationEngine();

});

function confirm()
{
   var answer = window.confirm('Are you sure to proceed with Bank-in Payment?');
   if (answer)
   return true;
   else
   return false;
}

</script>