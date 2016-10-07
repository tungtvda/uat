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
	 
	$(".last-week").click(function(){
		$(".datepicker").val('<?php echo date('d-m-Y',strtotime('Monday last week')); ?> 00:00:00');
		$(".defaultdatepicker").val('<?php echo date('d-m-Y',strtotime('Sunday last week')); ?> 23:59:59');
	});
	
	$(".this-week").click(function(){
		$(".datepicker").val('<?php echo date('d-m-Y',strtotime('Monday this week')); ?> 00:00:00');
		$(".defaultdatepicker").val('<?php echo date('d-m-Y',strtotime('Sunday this week')); ?> 23:59:59');
	});

    //$(".mask_date").mask("?99-99-9999 99:99:99",{placeholder:" "});

});
</script>
<style>
.this-week, .last-week{
    /*border-style: 1px solid none;*/
    /*width:25px;*/
    /*border-radius: 15px;*/
   cursor:pointer;
    /*background-color: #007CF9;*/
}
	/*th{
		color: #EFEFEF;
	}*/
/*body{
	color: #EFEFEF;
}
#main{
	background-color: #000000;
}
#main h1{
	margin-top: 12px;
}
.admin_table {
    border-collapse: separate;
    border-spacing: 4px;
}
.admin_table th, .admin_table td {
    padding: 5px 9px;
    background:#202020;
}
.admin_table th {
    font-weight: bold;
}
#search_box {
    background-color: #202020;
    border-radius: 6px;
    margin-bottom: 15px;
    padding: 11px 16px;
}
#search_trigger_box {
    display: inline-block;
    font-size:11px;
}*/
</style>