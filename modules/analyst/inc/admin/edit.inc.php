<script type="text/javascript">
$(document).ready(function(){
	$("#edit_form").validationEngine();
        
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
    
    $('#NewPassword').change(function() 
    {        
        if ($('#NewPassword').is(':checked'))
        {
            $('#NewPasswordBox').show('medium');
        }
        else 
        {
            $('#NewPasswordBox').hide('medium');
        }
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
                      $("input[name='Label']").val(data[0].Label);  
                      /*$("input[name='Source']").val(data[0].Source);
                      $("input[name='Title']").val(data[0].Title);
                      $("textarea[name='Description']").val(data[0].Description);
                      CKEDITOR.instances.Content.setData(data[0].Content);*/ 
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