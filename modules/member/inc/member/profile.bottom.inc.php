<?php if ($_SESSION['superid']=='1') { ?>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.maskedinput.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen();
    $(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       disable_search:true 
    });
    $(".chosen_simple_full").chosen({
       disable_search:true,
       width: '100%' 
    });
	$(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
    $("#profile_form").validationEngine();
    
    $("#DOB").mask("?99-99-9999",{placeholder:" "});
    $("#NRIC").mask("?999999-99-9999",{placeholder:" "});
    
    $('#Nationality').change(function() 
    {   
        var value = $(this).val();
        
        if (value=='151')
        {
            $('#nric_box').show('medium');
            $('#passport_box').hide();
        }
        else 
        {
            $('#nric_box').hide();
            $('#passport_box').show('medium');
        }
    });
});
</script>

<?php } else { ?>




<?php } ?>