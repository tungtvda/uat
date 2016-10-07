<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen();
    $(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       disable_search:true 
    });
	$("#edit_form").validationEngine({
		'custom_error_messages': {
			'#PasswordConfirm' : {
				'equals': {
					'message': "* Passwords do not match"
				}
			}
		}	
	});
	
	$('#NewPassword').change(function() 
    {        
        if ($('#NewPassword').is(':checked'))
        {
            $('#NewPasswordBox').show('medium');
        }
        else 
        {
            $('#NewPasswordBox').hide('medium');
        }
    });
});
</script>