<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.css" media="screen" />
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/core/core.slug.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.maskedinput.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".chosen").chosen();
	$(".chosen_full").chosen({ width: '100%' });
    $(".chosen_simple").chosen({
       disable_search:true 
    });
	$(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
	$("#edit_form").validationEngine();
	
	$(".friendly_url").slug({ 
        slug:'FriendlyURL',
        hide: false       
    });
    
    $(".mask_date").mask("?99-99-9999",{placeholder:" "});
    
    

    var error = 0;     
    $("input").click(function() {

             error++;

    });

    $("input").keydown(function() {

             error++;

    });

    $("input").keyup(function() {

             error++;

    });


    $("#admin-language").change(function(){


        //console.log(error);
        if(error > 0)
        {

            alert('Please update the current changes first before you continue.');
            //return;

        }
        else
        { 
            var lang =  $("#admin-language").val(); 

            $.ajax({
              type: "GET",
              dataType: "json",
              //contentType: "application/x-www-form-urlencoded;charset=utf-8",
              data: {contentID: "<?php echo $this->id; ?>", lang: lang},
              url: "<?php echo $data['config']['SITE_URL']; ?>/admin/moduletranslation/ajaxtranslateaction/<?php echo $this->controller; ?>", 
              success: function(data) {
                  console.log(data);
                    //$("input[name='Label']").val(data[0].Label);
                      $("input[name='Source']").val(data[0].Source);
                      $("input[name='Title']").val(data[0].Title);
                      $("textarea[name='Description']").val(data[0].Description);
                      CKEDITOR.instances.Content.setData(data[0].Content); 
                      //$("textarea[id='Content']").val(data.Content);
                    



              },
              error: function(xhr, status, error) {
                alert(xhr.responseText);
              }         
            });
        }
      });     
});
</script>