<style type="text/css">
.tax_cover {
    padding:7px !important;
}
.tax_cover img {
    display:block;
    border:1px dashed #e0e0e0;
    padding:3px;
    width:100px;
    height:100px;
    background-color:#fff;
}
.tax_title {
    font-weight:bold;
    font-size:14px;
    margin-bottom:1px;
}
.tax_date {
    color:#909090;
    margin-bottom:10px;
}
.tax_author {
    text-transform:uppercase;
}
.tax_desc {
    margin-bottom:10px;
}
.tax_update {
    color:#909090;
    font-size:11px;
    font-style:italic;
}
</style>
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
});
</script>