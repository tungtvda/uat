<?php if ($_SESSION['superid']=='1') { ?>
<!-- <script src="<?php echo $data['config']['SITE_DIR']; ?>js/foundation/vendor/jquery.js"></script> -->
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-1.7.1.min.js"></script>
<!-- Validation Engine -->
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.validationEngine-en.js" charset="utf-8"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.validationEngine.js" charset="utf-8"></script>
<!-- jQuery UI -->
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-ui.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.core.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.widget.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.datepicker.js"></script>
<script src="<?php echo $data['config']['SITE_DIR']; ?>/lib/timepicker/jquery-ui-timepicker-addon.js"></script>
<!-- Foundation -->
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.equalizer.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.offcanvas.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.alert.js"></script>
<script>
// Initialize Foundation
$(document).foundation();

$(document).ready(function() {
});    

    


function call_confirm()
{
   var answer = window.confirm ("Are you sure you want to delete?");
   if (answer)
   return true;
   else
   return false;
}
</script>
<!-- Embedded CSS and Javascript START -->
<?php require('custom_bottom_include.inc.php'); ?>
<!-- Embedded CSS and Javascript END -->


<?php } else { ?>


<!-- <script src="<?php echo $data['config']['SITE_DIR']; ?>js/foundation/vendor/jquery.js"></script> -->

<!-- Validation Engine -->
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.validationEngine-en.js" charset="utf-8"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.validationEngine.js" charset="utf-8"></script>
<!-- jQuery UI -->
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-ui.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.core.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.widget.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.ui.datepicker.js"></script>
<script src="<?php echo $data['config']['SITE_DIR']; ?>/lib/timepicker/jquery-ui-timepicker-addon.js"></script>
<!-- Foundation -->
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.equalizer.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.offcanvas.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.alert.js"></script>
<script src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.reveal.js"></script>
<script>
// Initialize Foundation
//$(document).foundation(); 
/*jQuery(document).ready(function(){
     jQuery(document).foundation();


    
    $('#announcement_popup').foundation('reveal', 'open');
    //$('#announcement_deposit_popup').foundation('reveal', 'open');
});*/

function call_confirm()
{
   var answer = window.confirm ("Are you sure you want to delete?");
   if (answer)
   return true;
   else
   return false;
}
</script>
<!-- Embedded CSS and Javascript START -->
<?php require('custom_bottom_include.inc.php'); ?>
<!-- Embedded CSS and Javascript END -->

<?php } ?>