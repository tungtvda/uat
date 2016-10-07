<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen();
	$(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       disable_search:true
    });

    $(".datepicker").datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss',
        showSecond: true
    });

	$("#add_form").validationEngine();

	$(".mask_date").mask("?99-99-9999 99:99:99",{placeholder:" "});

    $('input[type="radio"]').click(function() {
    if($('#cimb').is(':checked')) {
   		// $("#CIMB").show();
   		$("#CIMBDetails").show();
   	}else{
   		// $("#CIMB").hide();
   		$("#CIMBDetails").hide();
   	}
    });
    $('input[type="radio"]').click(function() {
    if($('#publicbank').is(':checked')) {
   		// $("#PublicBank").show();
   		$("#PublicBankDetails").show();
   	}else{
   		// $("#PublicBank").hide();
   		$("#PublicBankDetails").hide();
   	}
    });
    $('input[type="radio"]').click(function() {
    if($('#hongleong').is(':checked')) {
   		// $("#HongLeong").show();
   		$("#HongLeongDetails").show();
   	}else{
   		// $("#HongLeong").hide();
   		$("#HongLeongDetails").hide();
   	}
    });
    $('input[type="radio"]').click(function() {
    if($('#rhbbank').is(':checked')) {
   		// $("#RHBBank").show();
   		$("#RHBBankDetails").show();
   	}else{
   		// $("#RHBBank").hide();
   		$("#RHBBankDetails").hide();
   	}
    });
    $('input[type="radio"]').click(function() {
    if($('#maybank').is(':checked')) {
   		// $("#MayBank").show();
   		$("#MayBankDetails").show();
   	}else{
   		//$("#MayBank").hide();
   		$("#MayBankDetails").hide();
   	}
    });
    
    
    $('input[type="radio"]').click(function() {
    if($('#bank1').is(':checked')) {
   		// $("#Bank1").show();
   		$("#Bank1Details").show();
   	}else{
   		//$("#Bank1").hide();
   		$("#Bank1Details").hide();
   	}
    });
    
    
    $('input[type="radio"]').click(function() {
    if($('#bank2').is(':checked')) {
   		// $("#Bank2").show();
   		$("#Bank2Details").show();
   	}else{
   		//$("#Bank2").hide();
   		$("#Bank2Details").hide();
   	}
    });
    
    
    $('input[type="radio"]').click(function() {
    if($('#bank3').is(':checked')) {
   		
   		$("#Bank3Details").show();
   	}else{
   		
   		$("#Bank3Details").hide();
   	}
    });
    
    


});
</script>
<style>
#CIMB{
	width:146px;
	height:45px;
    margin: 0 5px 5px 0;
    float: right;
    /*background-image: url('<?php //echo $data['config']['THEME_DIR']; ?>img/cimb.jpg');*/
    background-repeat: no-repeat;
}
#RHBBank{
	width:146px;
	height:45px;
    margin: 0 5px 5px 0;
    float: right;
    /*background-image: url('<?php //echo $data['config']['THEME_DIR']; ?>img/rhb.jpg');*/
    background-repeat: no-repeat;
}
#MayBank{
	width:146px;
	height:45px;
    margin: 0 5px 5px 0;
    float: right;
    /*background-image: url('<?php //echo $data['config']['THEME_DIR']; ?>img/maybank.jpg');*/
    background-repeat: no-repeat;
}
#HongLeong{
	width:146px;
	height:45px;
    margin: 0 5px 5px 0;
    float: right;
    /*background-image: url('<?php //echo $data['config']['THEME_DIR']; ?>img/hlb.jpg');*/
    background-repeat: no-repeat;
}
#PublicBank{
	width:146px;
	height:45px;
    margin: 0 5px 5px 0;
    float: right;
    /*background-image: url('<?php //echo $data['config']['THEME_DIR']; ?>img/public_bank.jpg');*/
    background-repeat: no-repeat;
}

#Bank1{
	width:146px;
	height:45px;
	margin: 0 5px 5px 0;
	/*background-image: url('<?php //echo $data['config']['THEME_DIR']; ?>img/public_bank.jpg');*/
    float: right;    
    background-repeat: no-repeat;
}

#Bank2{
	width:146px;
	height:45px;
    margin: 0 5px 5px 0;
    /*background-image: url('<?php //echo $data['config']['THEME_DIR']; ?>img/public_bank.jpg');*/
    float: right;   
    background-repeat: no-repeat;
}

#Bank3{
	width:146px;
	height:45px;
    margin: 0 5px 5px 0;
    /*background-image: url('<?php //echo $data['config']['THEME_DIR']; ?>img/public_bank.jpg');*/
    float: right;
    background-repeat: no-repeat;
}

th, td{
	color: #EFEFEF;
}
label{
		color: #EFEFEF;
}
input[type="radio"]{
	margin: 15px 3px 0 0;
}
</style>
