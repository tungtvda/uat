<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.maskedinput.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    var memberName = $("#search_bar").val();
    var prmLink = "/main/search/productdefault";

    $.ajax({type: "POST",data: {name: memberName},url:prmLink,success:function(result){
                        //alert(result);
                        $("#ajaxMemberID").val(result);
                        //$("#BranchID").chosen();
    }});


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

    $("#search_form").validationEngine();



	$(".mask_date").mask("?99-99-9999 99:99:99",{placeholder:" "});


        $(function(){
          $('select.styled').customSelect();
      });

    $("div.onclick").click(function() {

        var ID = $(this).find("span").attr("class");

        var ID = "/admin/transaction/quickedit/"+ID;

        $.ajax({
                method: "GET",
                url: ID,
                dataType: "html",
                data: {pagination: "<?php echo $_GET['page']; ?>"},
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

        var MemberID = "/admin/transaction/history/"+MemberID;

    $.ajax({url:MemberID,success:function(result){
	    $("#admin_table").html(result);

 	}});

        $("#historydiv").css("display", "block");
    });
    $(".cancel").click(function() {
        $("#historydiv").hide();
    });
    
    $("tr.color td:contains('-')").css( "color", "#FF0033" );
    $("td.color td:contains('-')").css( "color", "#FF0033" );
    
    //$("td").each(function(){
        
    //$("td:not(:contains('-'))").css( "color", "#2AFF31" );
    $("td:contains('TOTAL')").css( "color", "#000" ); 
    $("#agentName").css( "color", "#000" ); 
        
    //});
    


/*var status = $( "#Status option:selected" ).text();

    if(status === "Rejected")
    {
        $("#RejectedRemark").hide();
    }*/



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

td.leftBorder, th.leftBorder{
    border-left: 3px solid #C3C0C0;
}
td.rightBorder, th.rightBorder {
    border-right: 3px solid #C3C0C0;
}
.bold-color{
    font-weight: bold;
}

</style>