<link rel="stylesheet" media="screen" type="text/css" href="<?php $data['config']['SITE_URL']; ?>/lib/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="<?php $data['config']['SITE_URL']; ?>/lib/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#add_form").validationEngine();
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
});
</script>