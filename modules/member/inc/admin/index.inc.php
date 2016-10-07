<style type="text/css">
.member_title {
    font-weight:bold;
    font-size:14px;
    margin-bottom:5px;
    display:inline-block;
}
.member_dob {
    color:#909090;
}
.member_inner_header {
    width:82px;
    display:inline-block;
    font-weight:bold;
    margin-bottom:2px;
}
</style>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen({ width: 'auto' });
    $(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       width: 'auto',
       disable_search:true 
    });
	$(".datepicker").datetimepicker({
		dateFormat: 'dd-mm-yy',
		timeFormat: 'HH:mm:ss',
		controlType: 'select',
		showSecond: true
	});

	$(".defaultdatepicker").datetimepicker({
	 dateFormat: 'dd-mm-yy',
	 timeFormat: 'HH:mm:ss',
	 controlType: 'select',
	 hour: 23,
	 minute: 59,
	 second: 59
	 });
	
	$("#search_trigger").click(function() {
        if ($('#search_content').is(":visible")) {
            $("#search_content").hide('fast');
            $("#search_box").addClass('search_initial');    
        }
        else
        {
            $("#search_content").show('fast');
            $("#search_box").removeClass('search_initial');
        }
    });
});
</script>