<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.maskedinput.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="<?php $data['config']['SITE_DIR']; ?>/lib/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="<?php $data['config']['SITE_DIR']; ?>/lib/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen();
    $(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       disable_search:true 
    });
    
    $(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
    
    $(".cpicker").ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).val('#'+hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            var hexcode = this.value.replace("#","");
            
            if (hexcode.length==3) {
                var hexcode = hexcode.split("");
                hexcode = hexcode[0]+hexcode[0]+hexcode[1]+hexcode[1]+hexcode[2]+hexcode[2];
            }
            
            $(this).ColorPickerSetColor(hexcode);
        }
    })
    .bind('keyup', function(){
        $(this).ColorPickerSetColor(this.value);
    });    
        
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