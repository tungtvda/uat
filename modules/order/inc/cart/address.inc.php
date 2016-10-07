<script type="text/javascript" src="<?php echo $data['config']['SITE_URL']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_URL']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen({ width: 'auto' });
	$(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       width: 'auto',
       disable_search:true 
    });
	$(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
	
	$("#search_trigger").click(function() {
        if ($('#search_content').is(":visible")) {
            $("#search_content").hide('fast');
            $("#search_box").addClass('search_initial')            
        }
        else
        {
            $("#search_content").show('fast');
            $("#search_box").removeClass('search_initial')
        }
    });
    //var a ='1';
    //var b = "/cart/order/shippingtext/"+a;
    //alert(a);
   var fixbillingIDvalue = $("#billing").val();
   var fixdeliveryIDvalue = $("#delivery").val();
   var fixbillingIDvalue = "/cart/order/shippingtext/"+fixbillingIDvalue;
   var fixdeliveryIDvalue = "/cart/order/shippingtext/"+fixdeliveryIDvalue;
   //alert(paramdefault);
   $.ajax({url:fixbillingIDvalue,success:function(result){
			$("#billingaddr").html(result);
			
		}});
		
	$.ajax({url:fixdeliveryIDvalue,success:function(result){
			
			$("#shippingaddr").html(result);
		}});	
//alert('This is shipping '+ defaultID);

$("#billing").change(function() {
    var dynamicIDvalue = $(this).val();
    //alert('This is shipping '+ dynamicID);
    var dynamicIDvalue = "/cart/order/shippingtext/"+dynamicIDvalue;
    
    $.ajax({url:dynamicIDvalue,success:function(result){
			$("#billingaddr").html(result);
			
		}});
});

$("#delivery").change(function() {
    var dynamicIDvalue = $(this).val();
    //alert('This is shipping '+ dynamicID);
    var dynamicIDvalue = "/cart/order/shippingtext/"+dynamicIDvalue;
    
    $.ajax({url:dynamicIDvalue,success:function(result){
		
			$("#shippingaddr").html(result);
		}});
});


});
</script>