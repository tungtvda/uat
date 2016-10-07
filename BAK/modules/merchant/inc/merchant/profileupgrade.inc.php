<script type="text/javascript" src="/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen();
    $(".chosen_simple").chosen({
       disable_search:true 
    });
	$(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
    $("#profile_form").validationEngine();
});
</script>