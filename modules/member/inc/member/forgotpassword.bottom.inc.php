<?php if ($_SESSION['superid']=='1') { ?>
<script type="text/javascript">
$(document).ready(function(){
    $("#forgotpassword_form").validationEngine();
});
</script>
<?php } else { ?>

<?php } ?>
