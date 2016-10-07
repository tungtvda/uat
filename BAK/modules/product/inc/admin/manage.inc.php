<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen({ width: 'auto' });
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

    // Get the checkboxes values based on the parent div id
    $("#buttonUpdatePermission").click(function() {
        //getValueUsingParentTag();
        
        var post_data = $("#manage_form").serialize();
        
        //$.post("/admin/permission/bulkupdate/", $("#manage_form").serialize(), function(data){
        $.post( 
            "/admin/permission/bulkupdate/", 
            post_data, 
            function(data)
            {
                $( ".test_result" ).html(data);
                
                $("#dialog").dialog({
                    modal: true,
                    resizable: false,
                    draggable: false,
                    buttons: {
                        Ok: function() {
                            $(this).dialog("close");
                        }
                    }
                });
            }
        );
    });
    
    // Select All Checkboxes Based on Type
    $("#permission1").change(function() {
        if(this.checked) {
            $('.view').attr('checked','checked');
        }else{
            $('.view').removeAttr('checked');
        }
    });
    
    $("#permission2").change(function() {
        if(this.checked) {
            $('.add').attr('checked','checked');
        }else{
            $('.add').removeAttr('checked');
        }
    });
    
    $("#permission3").change(function() {
        if(this.checked) {
            $('.edit').attr('checked','checked');
        }else{
            $('.edit').removeAttr('checked');
        }
    });
    
    $("#permission4").change(function() {
        if(this.checked) {
            $('.delete').attr('checked','checked');
        }else{
            $('.delete').removeAttr('checked');
        }
    });
});
</script>