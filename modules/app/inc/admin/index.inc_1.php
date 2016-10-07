<style type="text/css">
.app_cover {
	padding:7px !important;
}
.app_cover img {
	display:block;
	border:1px dashed #e0e0e0;
	padding:3px;
	width:100px;
	height:100px;
	background-color:#fff;
}
.app_title {
	font-weight:bold;
	font-size:14px;
	margin-bottom:1px;
}
.app_ip {
    color: #555;
    font-size: 11px;
    font-style:italic;
    margin-bottom:7px;
}
.app_date {
	color:#909090;
	margin-bottom:10px;
	font-size:11px;
}
.app_source {
	text-transform:uppercase;
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