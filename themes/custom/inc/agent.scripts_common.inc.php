<link href="<?php echo $data['config']['THEME_DIR']; ?>img/favicon.ico" rel="icon" type="image/x-icon" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/fonts/source_sans_pro.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $data['config']['THEME_DIR']; ?>css/reseller.global.css?time=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $data['config']['THEME_DIR']; ?>css/jquery.treetable.css" />
<link rel="stylesheet" href="<?php echo $data['config']['THEME_DIR']; ?>css/jquery.treetable.theme.default.css" />

<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/custom/jqtreetable/jquery.treetable.js"></script>
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
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/custom/jquery.ui.autocomplete.html.js"></script>

<script type="text/javascript">
function call_confirm(){
   var answer = window.confirm ("Are you sure you want to delete?");
   if (answer)
   return true;
   else
   return false;
}
    
// initialise plugins
jQuery(function(){
    
    $("span.real-balance:contains('-')").css( "color", "#FF0033" );
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
        
/*var data = [
    {
        label: 'node1', id: 1,
        children: [
            { label: 'child1', id: 2 },
            { label: 'child2', id: 3 }
        ]
    },
    {
        label: 'node2', id: 4,
        children: [
            { label: 'child3', id: 5}
        ]
    }
];*/        
/*var data = [
    {
        
        
        label: '<?php echo $data['content'][0]["Name"]; ?>', id: 1,
        
        
        children: [
            { label: 'child1', id: 2, children: [
                    {label: 'Coelophysoids', id: 3},
                    {label: 'Ceratosaurians', id: 4},
                    {label: 'Spinosauroids', id: 5},
                    {label: 'Carnosaurians', id: 6},
                    {
                        label: 'Coelurosaurians',
                        id: 8,
                        children: [
                            {label: 'Tyrannosauroids', id: 7},
                            {label: 'Ornithomimosaurians', id: 8},
                            {label: 'Therizinosauroids', id: 9},
                            {label: 'Oviraptorosaurians', id: 10},
                            {label: 'Dromaeosaurids', id: 11},
                            {label: 'Troodontids', id: 12},
                            {label: 'Avialans', id: 13}
                        ]
                    }
                ] 
            }
        ]
    }
    
];*/

<?php 

    //CheckChildExist($data['content'][0]['Child']);         
?>


/*$('#tree1').tree({
    data: data,
    autoOpen: true,
    dragAndDrop: false,
    selectable: false
});*/

$("#treetable").treetable({expandable: true, initialState: "expanded"});
   
    

});





</script>

<!--<style>
ul.jqtree-tree li.jqtree_common {
    clear: both;
    list-style-type: none;
    margin-bottom: 0px;
}

</style>-->
<?php require('custom_include.inc.php'); ?>