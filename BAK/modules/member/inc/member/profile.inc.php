<?php if ($_SESSION['superid']=='1') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<style type="text/css">
#member_profile_wrapper {
}
#member_profile_wrapper #profile_form h2 {
	margin-bottom:1rem;
}

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
<style>
	label{
		color: #EFEFEF;
	}
</style>
<?php } ?>