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
});
</script>
<style>
body{
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
    background-color: #EFEFEF;
    border-radius: 6px;
    margin-bottom: 15px;
    padding: 11px 16px;
}
#search_trigger_box {
    display: inline-block;
    font-size:11px;
}
</style>