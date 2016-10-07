<link href="<?php echo $data['config']['THEME_DIR']; ?>img/favicon.ico" rel="icon" type="image/x-icon" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/fonts/source_sans_pro.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/admin.global.css?<?php echo date('YmdHis'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-1.7.1.min.js" charset="utf-8"></script>
<!-- Nav Menu -->
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/superfish/css/admin.superfish.css" media="screen">
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/superfish/js/hoverIntent.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/superfish/js/superfish.js"></script>
<!-- Validation Engine -->
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo $data['config']['THEME_DIR']; ?>css/jquery/validationEngine.jquery.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo $data['config']['THEME_DIR']; ?>css/jquery/jquery.ui.all.css">
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-ui.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.core.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.widget.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.datepicker.js"></script>
<script src="<?php echo $data['config']['SITE_DIR']; ?>/lib/timepicker/jquery-ui-timepicker-addon.js"></script>
<link href="<?php echo $data['config']['SITE_DIR']; ?>/lib/timepicker/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/custom/jquery.ui.autocomplete.html.js"></script>
<script type="text/javascript">
$(function() {                                   
            
    $("#search_bar").autocomplete({

        source: "/main/search/productsearch",
        minLength: 1,
        select: function(event, ui) {
            var url = ui.item.id;
            
               //alert(url);     
               $("#ajaxMemberID").val(url);
            
            //if(url != '#') {
                
                //location.href = url;
            //}

        },

        html: true,
      // optional (jquery.ui.autocomplete.html.js required)

      // optional (if other layers overlap autocomplete list)
        open: function(event, ui) {
            $(".ui-autocomplete").css("z-index", 1000);
        }
    });

}); 
 
function call_confirm(){
   var answer = window.confirm ("Are you sure you want to delete?");
   if (answer)
   return true;
   else
   return false;
}
// initialise plugins
jQuery(function(){
	jQuery('ul.sf-menu').superfish();
});


</script>
<?php require('admin.custom_include.inc.php'); ?>
<style>
    /* AUTO COMPLETE CSS
----------------------------------------------------------------------------------------------------*/

/* highlight results */
.ui-autocomplete span.hl_results {
    font-weight: bold !important;
    /*color: #202020 !important;*/
}

/* loading - the AJAX indicator */
.ui-autocomplete-loading {
    background: white url('//code.jquery.com/ui/1.10.4/themes/smoothness/images/indicator.gif') right center no-repeat;
}

/* scroll results */
.ui-autocomplete {
    max-height: 250px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
    /* add padding for vertical scrollbar */
    padding-right: 5px;
}

.ui-autocomplete li {
    font-size: 12px !important;
}

.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus {
	background: #404040 !important;
	color: #fff !important;
	border: 1px solid #404040 !important;
	border-radius: 2px !important;
}
/* IE 6 doesn't support max-height
* we use height instead, but this forces the menu to always be this tall
*/
* html .ui-autocomplete {
    height: 250px;
}
    
	.last-week, .this-week{
	color: #0066CC;
	cursor: pointer; 
	  
    }
</style>
