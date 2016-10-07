<style type="text/css">
.ui-sortable-space {
	background: #FFE7A3 !important;
	height:250px !important;
}
</style>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/ckeditor/ckeditor.js"></script>
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
	
	// Sortable
	$("tbody.sortable").sortable({
        axis: 'y',
        items: 'tr',
        cursor: "move",
        placeholder: "ui-sortable-space",
        update: function() {
            saveOrder('admin_table','tbody.sortable tr');
        }
    }).disableSelection();
        
    function saveOrder(id,item)
    {
        var items = jQuery('#'+id)
            .find(item)
            .toArray()
            .map(function(el) {
                return $(el)
                    .attr('data-id');
            });
        var request = $.ajax('<?php echo $config['SITE_DIR']; ?>/admin/productimage/sort', {
            type: 'POST',
            data: 'param=' + items.toString()
        });
        
        request.done(function() {
            updatePositionDisplay(items);
        });   
    }
    
    function updatePositionDisplay(items)
    {   
        for (var i=0, len=items.length; i<len; i++)
        {
            var request = $.ajax('<?php echo $config['SITE_DIR']; ?>/admin/productimage/position', {
                type: 'POST',
                data: 'param=' + items[i]
            });
            
            request.done(function(data) 
            {
                var data = data.split(',');                
                $("span#sortable_position_"+data[0]).text(data[1]).effect("highlight", {color: "#6BA6FF"}, 1000);
            });   
        }
    }
});
</script>