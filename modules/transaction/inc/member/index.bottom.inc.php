<?php if ($_SESSION['superid']=='1') { ?>

<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    <?php for ($i = 0; $i < $data['content_param']['count']; $i++) { ?>
    <?php if($data['content'][$i]['TimeLeft']>0){ ?>
        (function(){
            var elapse<?php echo $data['content'][$i]['ID']; ?> = <?php echo $data['content'][$i]['TimeLeft']; ?>;//100
             //console.log(elapse<?php echo $data['content'][$i]['ID']; ?>);
            var looper = setInterval(function(){

                if(elapse<?php echo $data['content'][$i]['ID']; ?>>0)
                {
                    //console.log(elapse<?php echo $data['content'][$i]['ID']; ?>);
                    elapse<?php echo $data['content'][$i]['ID']; ?>--;
                }

                var mins = elapse<?php echo $data['content'][$i]['ID']; ?> / 60;
                mins = Math.floor(mins);

                var sec = elapse<?php echo $data['content'][$i]['ID']; ?> % 60;
                sec =("0" + sec).slice(-2);

                $("#elapse<?php echo $data['content'][$i]['ID']; ?>").html("<span class='small-label hide-for-large-up'><?php echo Helper::translate("Time Elapse", "member-history-time-elapse"); ?>:</span>"+mins+':'+sec);

                if (elapse<?php echo $data['content'][$i]['ID']; ?>===0)
                {
                    clearInterval(looper);
                    //alert(elapse<?php echo $data['content'][$i]['ID']; ?>);
                }

            }, 1000);
        })();

    <?php } else { ?>

        $("#elapse<?php echo $data['content'][$i]['ID']; ?>").html("<span class='small-label hide-for-large-up'><?php echo Helper::translate("Time Elapse", "member-history-time-elapse"); ?>:</span>0:00");

    <?php } ?>
    <?php } ?>

	$(".datepicker").datetimepicker({
		dateFormat: 'dd-mm-yy',
		timeFormat: 'HH:mm:ss',
		showSecond: true
	});

	$(".defaultdatepicker").datetimepicker({
	 dateFormat: 'dd-mm-yy',
	 timeFormat: 'HH:mm:ss',
	 hour: 23,
	 minute: 59,
	 second: 59
	 });

	 $(".last-week").click(function(){
		$(".datepicker").val('<?php echo date('d-m-Y',strtotime('Monday last week')); ?> 00:00:00');
		$(".defaultdatepicker").val('<?php echo date('d-m-Y',strtotime('Sunday last week')); ?> 23:59:59');
	});

	$(".this-week").click(function(){
		$(".datepicker").val('<?php echo date('d-m-Y',strtotime('Monday this week')); ?> 00:00:00');
		$(".defaultdatepicker").val('<?php echo date('d-m-Y',strtotime('Sunday this week')); ?> 23:59:59');
	});

	$(".chosen").chosen({ width: 'auto' });
	$(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       width: 'auto',
       disable_search:true
    });


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
</script>

<?php } else { ?>

<?php } ?>