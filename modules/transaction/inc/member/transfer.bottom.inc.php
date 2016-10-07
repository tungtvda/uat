<?php if ($_SESSION['superid']=='1') { ?>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.reveal.js"></script>
<script type="text/javascript">
$(document).ready(function(){
 $("#TransferFrom").change(function(){
	if($('#TransferFrom option:selected').val()=="30"){
		$('.mainwallet').hide();
		$('.nonmainwallet').show();
		$('.mainwallet').prop('disabled', 'disabled');
		$('.nonmainwallet').prop('disabled', '');
	}
	else { //if($('#TransferFrom option:selected').text()!="Main Wallet"){
		$('.mainwallet').show();
		$('.nonmainwallet').hide();
		$('.nonmainwallet').prop('disabled', 'disabled');
		$('.mainwallet').prop('disabled', '');
	}
	 });





	$(".chosen").chosen();
	$(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       disable_search:true
    });
	$(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
	$("#add_form").validationEngine();

    $(".mask_date").mask("?99-99-9999",{placeholder:" "});

    $('#announcement_popup').foundation('reveal', 'open');

    /*$("#Submit").click(function() {
        $("#Submit").hide();
        $("#Cancel").hide();
    });*/

});
</script>


<?php } else { ?>

<?php } ?>
