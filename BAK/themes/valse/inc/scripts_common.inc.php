<link href="<?php echo $data['config']['THEME_DIR']; ?>img/favicon.ico" rel="icon" type="image/x-icon" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/fonts/source_sans_pro.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/global.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-1.7.1.min.js"></script>
<!-- Nav Menu -->
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_URL']; ?>/lib/superfish/css/superfish.css" media="screen">
<script type="text/javascript" src="<?php echo $data['config']['SITE_URL']; ?>/lib/superfish/js/hoverIntent.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_URL']; ?>/lib/superfish/js/superfish.js"></script>
<!-- Validation Engine -->
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo $data['config']['THEME_DIR']; ?>css/jquery/validationEngine.jquery.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo $data['config']['THEME_DIR']; ?>css/jquery/jquery.ui.all.css">
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-ui.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.core.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.widget.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.datepicker.js"></script>
<script src="<?php echo $data['config']['SITE_URL']; ?>/lib/timepicker/jquery-ui-timepicker-addon.js"></script>
<link href="<?php echo $data['config']['SITE_URL']; ?>/lib/timepicker/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function call_confirm(){
   var answer = window.confirm ("Are you sure you want to delete?");
   if (answer)
   return true;
   else
   return false;
}
/*function confirm()
{
   var answer = window.confirm("Are you sure to proceed with Bank-in Payment?");
   if (answer)
   return true;
   else
   return false;
}*/

// initialise plugins
jQuery(function(){
	jQuery('ul.sf-menu').superfish();
});
</script>
<?php require('custom_include.inc.php'); ?>
