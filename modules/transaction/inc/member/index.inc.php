<?php if ($_SESSION['superid']=='1') { ?>

<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<style type="text/css">
 
<?php if(empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE){ ?>
.table_header {
    
	background-color: <?php echo $_SESSION['agent']['BackgroundColour']; ?>;
	border-top: 1px solid #202020;
	border-left: 1px solid #202020;
        border-right: 1px solid #202020;
}
<?php } ?>
#member_history_wrapper {
}
#member_history_wrapper select {
    color: #222;
}
.this-week, .last-week{
   cursor:pointer;
}
	/*th{
		color: #EFEFEF;
	}*/
body{
	color: #EFEFEF;
}
#main{
	<?php if(empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE){ ?>
        background: rgba(0, 0, 0, 0);
        <?php }else{ ?>
	background-color: #000000;
        <?php } ?>
}
#main h1{
	margin-top: 12px;
}
.admin_table {
    border-collapse: separate;
    border-spacing: 4px;
}
.admin_table th, .admin_table td {
    padding: 5px 9px;
    background:#202020;
}
.admin_table th {
    font-weight: bold;
}
#search_box {
    background-color: #202020;
    border-radius: 6px;
    margin-bottom: 15px;
    padding: 11px 16px;
}
#search_trigger_box {
    display: inline-block;
    font-size:11px;
}
</style>

<?php } else { ?>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
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
                
            
            $("#elapse<?php echo $data['content'][$i]['ID']; ?>").html(mins+':'+sec);
            
            if (elapse<?php echo $data['content'][$i]['ID']; ?>===0)
            {
                clearInterval(looper);
                
                //alert(elapse<?php echo $data['content'][$i]['ID']; ?>);
            }

        }, 1000);
        
            
            })();
        
    <?php }else{ ?> 
    
        $("#elapse<?php echo $data['content'][$i]['ID']; ?>").html("0:00");
        
    <?php } ?>
        
<?php  } ?>
	
        
        
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
<style>
	/*th{
		color: #EFEFEF;
	}*/
body{
	color: #EFEFEF;
}
#main{
	<?php if(empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE){ ?>
        background: rgba(0, 0, 0, 0);
        <?php }else{ ?>
	background-color: #000000;
        <?php } ?>
}
#main h1{
	margin-top: 12px;
}
.admin_table {
    border-collapse: separate;
    border-spacing: 4px;
}
.admin_table th, .admin_table td {
    padding: 5px 9px;
    background:#202020;
}
.admin_table th {
    font-weight: bold;
}
#search_box {
    background-color: #202020;
    border-radius: 6px;
    margin-bottom: 15px;
    padding: 11px 16px;
}
#search_trigger_box {
    display: inline-block;
    font-size:11px;
}
.this-week, .last-week{
    /*border-style: 1px solid none;*/
    /*width:25px;*/
    /*border-radius: 15px;*/
   cursor:pointer;
    /*background-color: #007CF9;*/
}
</style>
<?php } ?>