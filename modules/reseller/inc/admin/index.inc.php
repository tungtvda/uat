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

.this-week, .last-week{
    /*border-style: 1px solid none;*/
    /*width:25px;*/
    /*border-radius: 15px;*/
   cursor:pointer;
    /*background-color: #007CF9;*/
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
		showSecond: true 
	});
	
	$(".defaultdatepicker").datetimepicker({
	 dateFormat: 'dd-mm-yy',
	 timeFormat: 'HH:mm:ss',
	 hour: 23,
	 minute: 59,
	 second: 59	 
	 });
	
	$(".last-week").click(function(){
		$(".datepicker").val('<?php echo date('d-m-Y',strtotime('Monday last week')); ?> 00:00:00');
		$(".defaultdatepicker").val('<?php echo date('d-m-Y',strtotime('Sunday last week')); ?> 23:59:59');
	});
	
	$(".this-week").click(function(){
		$(".datepicker").val('<?php echo date('d-m-Y',strtotime('Monday this week')); ?> 00:00:00');
		$(".defaultdatepicker").val('<?php echo date('d-m-Y',strtotime('Sunday this week')); ?> 23:59:59');
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