<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
    $("#search_bar").autocomplete({

        source: "/main/search/productagentgroupsearch",
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
    
    
    /*var memberName = $("#search_bar").val();
    var prmLink = "/main/search/productagentgroupdefault";
    

    $.ajax({type: "POST",data: {name: memberName},url:prmLink,success:function(result){
                        
                        
                        $("#ajaxMemberID").val(result);
                        
    }});*/





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

    $("#search_form").validationEngine();

	$(".datepicker").datetimepicker({
		dateFormat: 'dd-mm-yy',
		timeFormat: 'HH:mm:ss',
		controlType: 'select',
		showSecond: true
	});

	$(".defaultdatepicker").datetimepicker({
	 dateFormat: 'dd-mm-yy',
	 timeFormat: 'HH:mm:ss',
	 controlType: 'select',
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
        
        $("div.onclick").click(function() {
        
            var ID = $(this).find("span").attr("class");

            var ID = "/agent/transaction/quickedit/"+ID;

            $.ajax({
                    method: "GET",
                    url: ID,
                    dataType: "html",             
                    data: {pagination: "<?php echo $_GET['page']; ?>", page: "group"},
                        success:function(result){
                            $("#contactdiv").html(result);
                            $(".chosen_simple").chosen({
                                width: 'auto',
                                disable_search:true
                             });

                        }
                    }
                );

            $("#contactdiv").css("display", "block");
        });
    
    
        $("div.onview").click(function() {

            var MemberID = $(this).find("span").attr("class");

            var MemberID = "/agent/transaction/history/"+MemberID;

            $.ajax({url:MemberID,success:function(result){
                $("#admin_table").html(result);

            }});

            $("#historydiv").css("display", "block");
        });
        $(".cancel").click(function() {
            $("#historydiv").hide();
        });
        
        $("tr.color td:contains('-')").css( "color", "#FF0033" );

});
</script>
<style>
.onclick, .onview{
padding:5px;
color:green;
cursor:pointer;
/*padding:5px 5px 5px 15px;*/
color:white;
background-color:#123456;
box-shadow:1px 1px 5px grey;
border-radius:3px;
text-align: center;
}

.popup_form{
border-radius:2px;
padding:20px 30px;
box-shadow:0 0 15px;
font-size:14px;
font-weight:bold;
width:350px;
margin:20px 250px 0 35px;
float:left;
}
.input{
width:70%;
height:25px;
margin-top:5px;
border:1px solid #999;
border-radius:3px;
padding:5px;
}

textarea{
width:100%;
height:80px;
margin-top:5px;
border-radius:3px;
padding:5px;
resize:none;
}
#contactdiv{

/*position: absolute;*/
/*margin: 0 auto;*/
left: 50%;
height: 100%;
width: 100%;
z-index:9999;
display: none;
}


#contact{
width:350px;
margin:0px;
background-color:white;
position: fixed;
border: 5px solid rgb(90, 158, 181);
left: 50%;
top: 50%;
margin-left:-210px;
margin-top:-255px;

}

#historydiv{
background-color: #C5C5C5;
padding-left: 10px;
padding-right: 10px;
padding-bottom: 10px;
padding-top: 0;
position: fixed;
left:0;
top:0;
right: 0;
display:none;
border: 5px solid rgb(90, 158, 181);
}

#admin_table{
    //width: 100%;
    background-color: white;
    overflow: scroll;
    height: 500px;
}
.admin_table{
    //width: 100%;
    margin-top: 0;
}

.cancel
{
    text-align: right;
    cursor: pointer;
}
/*.chosen-container .chosen-results {
   max-height:50px !important;
}*/

	.this-week, .last-week{
    /*border-style: 1px solid none;*/
    /*width:25px;*/
    /*border-radius: 15px;*/
   cursor:pointer;
    /*background-color: #007CF9;*/
}

.chzn-container .chzn-results {
height: 150px;}


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


</style>
<!--<style>
.onclick, .onview{
padding:5px;
color:green;
cursor:pointer;
/*padding:5px 5px 5px 15px;*/
/*min-width:70px;*/
color:white;
background-color:#123456;
box-shadow:1px 1px 5px grey;
border-radius:3px;
text-align: center;
}

.popup_form{
border-radius:2px;
padding:20px 30px;
box-shadow:0 0 15px;
font-size:14px;
font-weight:bold;
width:350px;
margin:20px 250px 0 35px;
float:left;
}
.input{
width:70%;
height:25px;
margin-top:5px;
border:1px solid #999;
border-radius:3px;
padding:5px;
}

textarea{
width:100%;
height:80px;
margin-top:5px;
border-radius:3px;
padding:5px;
resize:none;
}
#contactdiv{

/*position: absolute;*/
/*margin: 0 auto;*/
left: 50%;
height: 100%;
width: 100%;
z-index:9999;
display: none;
}


#contact{
width:350px;
margin:0px;
background-color:white;
position: fixed;
border: 5px solid rgb(90, 158, 181);
left: 50%;
top: 50%;
margin-left:-210px;
margin-top:-255px;

}

#historydiv{    
background-color: #C5C5C5; 
padding-left: 10px;
padding-right: 10px;
padding-bottom: 10px;
padding-top: 0;
position: fixed;
left:0;
top:0;
right: 0;
display:none;
border: 5px solid rgb(90, 158, 181);
}

.cancel
{
    text-align: right;
    cursor: pointer;
}     
    
.this-week, .last-week{
    /*border-style: 1px solid none;*/
    /*width:25px;*/
    /*border-radius: 15px;*/
   cursor:pointer;
    /*background-color: #007CF9;*/
}
	/*th{
		color: #EFEFEF;
	}*/
body{
	color: #EFEFEF;
}
#main{
	background-color: #000000;
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
    background-color: #EFEFEF;
    border-radius: 6px;
    margin-bottom: 15px;
    padding: 11px 16px;
}
#search_trigger_box {
    display: inline-block;
    font-size:11px;
}
</style>-->