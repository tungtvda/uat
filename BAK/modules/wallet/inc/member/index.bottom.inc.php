<?php if ($_SESSION['superid']=='1') { ?>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".chosen").chosen({ width: 'auto' });
    $(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       width: 'auto',
       disable_search:true
    });
    $(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });

    $("#search_trigger").click(function() {
        if ($('#search_content').is(":visible")) {
            $("#search_content").hide('fast');
            $("#search_box").addClass('search_initial')
        }
        else
        {
            $("#search_content").show('fast');
            $("#search_box").removeClass('search_initial')
        }
    });
});

function openWin(url)
{
    var PlayLinkWindow = window.open(url,"","width=1300,height=700");
}
</script>
<?php } else { ?>

<?php } ?>
