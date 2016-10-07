<?php if ($_SESSION['superid']=='1') { ?>
<style>
    .common_block {
	padding:0.8rem 1.6rem;
        <?php if(empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE){ ?>
        background:<?php echo $_SESSION['agent']['BackgroundColour']; ?>;
        <?php } else { ?>
	background-color: #691111;
        <?php } ?>
	height: inherit;
	margin-bottom: 0.67rem;
}
</style>
<?php } else { ?>
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
<?php } ?>