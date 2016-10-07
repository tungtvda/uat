<?php if ($_SESSION['superid']=='1') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<style>
/*#table_wrapper {
    overflow-x: auto;
}
table {
    width: 100%;
}
table tbody tr th, table tbody tr td {
    width: 20%;
}*/
#table_wrapper {
    padding:0 0.9375rem;
}
hr {
    margin: 0.5rem 0;
    border-color: #000;
}
h6 {
    font-weight: bold;
}

table tbody tr th, table tbody tr td {
	vertical-align: top;
	font-size: 0.8rem;
	line-height: 1.5;
	color: #efefef;
	padding: 5px 9px;
        <?php if(empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE){ ?>
        background:<?php echo $_SESSION['agent']['BackgroundColour']; ?>;
        <?php } else { ?>
        background:#202020;
        <?php } ?>
}
</style>


<?php } else { ?>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
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
<style>
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
    width: 800px;
    
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

<?php } ?>