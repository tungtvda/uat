<link href="<?php echo $data['config']['THEME_DIR']; ?>img/favicon.ico" rel="icon" type="image/x-icon" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/fonts/source_sans_pro.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/global.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-1.7.1.min.js"></script>
<!-- Nav Menu -->
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/superfish/css/superfish.css" media="screen">
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

<script type="text/javascript">
// initialise plugins
jQuery(function(){
	jQuery('ul.sf-menu').superfish();
    $("#poker").mouseover(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_10.jpg");

	});
	$("#poker").mouseout(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/online-casino-10.jpg");

	});

	$("#roulette").mouseover(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_11.jpg");

	});
	$("#roulette").mouseout(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/online-casino-11.jpg");

	});

	$("#blackjack").mouseover(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_12.jpg");

	});
	$("#blackjack").mouseout(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/online-casino-12.jpg");

	});

	$("#soccer").mouseover(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_13.jpg");

	});
	$("#soccer").mouseout(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/online-casino-13.jpg");

	});

	$("#horseracing").mouseover(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_14.jpg");

	});
	$("#horseracing").mouseout(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/online-casino-14.jpg");

	});


	$("#border-color div").mouseover(function(){
		$(this).addClass("border-color-change");

	});
	$("#border-color div").mouseout(function(){
		$(this).removeClass("border-color-change");

	});
	$("#border-color .bg-border-red").mouseover(function(){
		$(this).addClass("border-color-change");
		//$(this).find("caption").addClass("showcaption");
	});
	$("#border-color .bg-border-red").mouseout(function(){
		$(this).removeClass("border-color-change");
		//$(this).find("caption").addClass("hidecaption");

	});
	$("#border-color .s-border-red").mouseover(function(){
		$(this).addClass("border-color-change");

	});
	$("#border-color .s-border-red").mouseout(function(){
		$(this).removeClass("border-color-change");

	});
	$("#deposit").mouseover(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/gambling_19.jpg");

	});
	$("#deposit").mouseout(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_19.jpg");

	});
	$("#withdraw").mouseover(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/gambling_27.jpg");
	});
	$("#withdraw").mouseout(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_27.jpg");
	});
	$("#transfer").mouseover(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/gambling_23.jpg");

	});
	$("#transfer").mouseout(function(){
		$(this).attr("src","<?php echo $data['config']['THEME_DIR']; ?>img/casino-online_23.jpg");

	});
	// $(".border-color-change").mouseout(function(){
	// $(".border-color-change").css("border-color","red");
	// });
        $("#language").on('change', function() {
            
                var lngcode = $("#language option:selected").val();
                //alert('This is language code '+ lngcode);
                
                
                var lngcode = "/main/translation/changelanguage/"+lngcode;

                $.ajax({url:lngcode,success:function(result){
                                    //$("#branch-container").html(result);
                                    //$("#BranchID").chosen();
                                    window.location = result;
                }});
                
                //window.location = "<?php //echo $data['config']['SITE_URL']; ?>/<?php //echo $_SERVER['PHP_SELF']; ?>";
            
            });

});
            
            
            
            
</script>
<style>
.border-red{
	width: 171px;height: 189px;border: 3px solid #990000;margin-left: 17px;float: left;
}
.bg-border-red{
	width: 638px;height: 189px;border: 3px solid #990000;margin:15px 0 0 15px;float: left;
}
.s-border-red{
	width: 276px;height: 82px;border: 3px solid #990000;margin:15px 19px 0 3px;float: right;
}
.m-border-red{
   width: 276px;height: 85px;border: 3px solid #990000;margin:15px 19px 0 3px;float: right;
}
.border-color-change{


	border-color: #EFEFEF;

}
h3 {
    color: #f00;
}
#home-input input[type="text"]{
	font-size:16px;
	background-color: #EFEFEF;
	width:99px;
	height:25px;
	margin-right: 5px;
	/*background-color: #EE0101;
	border: 3px solid #EFEFEF;*/
}

#home-input input[type="password"]{
	font-size:16px;
	background-color: #EFEFEF;
	width:99px;
	height:25px;
	margin-right: 5px;
	/*background-color: #EE0101;
	border: 3px solid #EFEFEF;*/
}

#home-input input[type="submit"]{
	font-size:16px;
	color: #EFEFEF;
	width:89px;
	height:35px;
	background-color: #EE0101;
	border: 3px solid #EFEFEF;
	margin-right: 5px;
	cursor: pointer;
}
#home-input a.join{
	padding: 4px 12px;
	font-size:16px;
	color: #EFEFEF;
	width:89px;
	height:35px;
	background-color: #670004;
	border: 3px solid #EFEFEF;
}
#home-input #member_in_box a {
    background-color: #202020;
    border-radius: 4px;
    padding: 5px 10px;
}
/*.caption{
	display: none;
}
.showcaption{
	font-size: 16px;
	top: 135px;
	text-align: center;
	letter-spacing: 2px;

	font-weight:bold;
	padding-top:15px;
	background-color:#000000;
	width:171px;
	height: 38px;
    opacity:0.7;
    filter:alpha(opacity=70);
}
.showcaption span{
	color: -webkit-linear-gradient(#faf209, #fb7c0b);
	color: -o-linear-gradient(#faf209, #fb7c0b);
	color: -moz-linear-gradient(#faf209, #fb7c0b);
	color: linear-gradient(#faf209, #fb7c0b);
}*/

/*.transbox
  {
  width:171px;
  height:27px;
  margin:2px 0 30px 0;
  padding-top:5px;
  }
.transbox span:hover
  {
  margin:30px 40px;

  color:#efefef;
  background-color:#000000;
  opacity:0.7;
  filter:alpha(opacity=70);
  }
.transbox span
  {
  margin:30px 40px;
  opacity:0;
  filter:alpha(opacity=0);
  } */
/*button[type="button"].join{
	float:right;
	font-size:16px;
	color: #EFEFEF;
	width:89px;
	height:35px;
	background-color: #670004;
	border: 3px solid #EFEFEF;
}*/
/*ul
{
list-style-type:none;
margin:0;
padding:0;
overflow:hidden;
}
li
{
float:left;
}
a:link,a:visited
{
display:block;
font-weight:bold;
color:#FFFFFF;
text-align:center;
text-decoration:none;
text-transform:uppercase;
}*/
.sf-menu, .sf-menu *{

	margin: 0 0 0 0;
}

.sf-menu li{
	background-color: #000000;
	padding: 0 0 0 0;
	border-radius: 0;
}

.sf-menu a:hover{
	background-color: #000000;

}

<?php if(empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE){ ?>
    
    
    body{
       background-color: <?php echo $_SESSION['agent']['BackgroundColour']; ?>;
       
       color: <?php echo $_SESSION['agent']['FontColour']; ?> !important; 
    }
    
    .button{
       color: <?php echo $_SESSION['agent']['FontColour']; ?> !important; 
    }
    
    h1, h2, h3, h4, h5, h6, span, a, .common_block h1{
       color: <?php echo $_SESSION['agent']['FontColour']; ?> !important; 
    }

<?php } ?>

</style>
<?php require('custom_include.inc.php'); ?>