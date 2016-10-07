<script type="text/javascript" src="<?php echo $data['config']['SITE_URL']; ?>/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_URL']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_URL']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen();
	$(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       disable_search:true 
    });
    
    $("#edit_form").validationEngine();
    
    $(".datepicker").datetimepicker({ 
		dateFormat: 'dd-mm-yy',
		timeFormat: 'HH:mm:ss',
		showSecond: true 
	});
	
	$(".mask_date").mask("?99-99-9999 99:99:99",{placeholder:" "});
    
	
});
</script>