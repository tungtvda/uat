<script type="text/javascript">
$(document).ready(function(){
	$("#password_form").validationEngine({
		'custom_error_messages': {
			'#PasswordConfirm' : {
				'equals': {
					'message': "* New passwords do not match"
				}
			}
		}	
	});
});
</script>