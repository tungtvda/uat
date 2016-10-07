<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.maskedinput.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen();
	$(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       disable_search:true 
    });
	$(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
    $("#add_form").validationEngine({
        'custom_error_messages': {
            '#PasswordConfirm' : {
                'equals': {
                    'message': "* Passwords do not match"
                }
            }
        }   
    });
    
    $(".mask_date").mask("?99-99-9999",{placeholder:" "});
    $(".mask_nric").mask("?999999-99-9999",{placeholder:" "});
    
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