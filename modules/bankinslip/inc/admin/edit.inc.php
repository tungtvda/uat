<script type="text/javascript">
$(document).ready(function(){
	$("#edit_form").validationEngine();
        
        $("#info").hide();
                  
        var label = '';

        var lang = 'en';
        
        $.ajax({
              type: "GET",
              dataType: "json",
              //contentType: "application/x-www-form-urlencoded;charset=utf-8",
              data: {contentID: "<?php echo $this->id; ?>", lang: lang},
              url: "<?php echo $data['config']['SITE_URL']; ?>/admin/moduletranslation/ajaxtranslateaction/<?php echo $this->controller; ?>", 
              success: function(data) {
                
                        label = data[0].Label; 
                    
                        $("input[name='Label']").val(data[0].Label);
                        $("#hiddenLang").val(lang);

              },
              error: function(xhr, status, error) {
                alert(xhr.responseText);
              }         
            });
        
        $("#admin-language").change(function(){

            lang = $("#admin-language").val(); 
            $("#hiddenLang").val(lang);
            
            $.ajax({
              type: "GET",
              dataType: "json",
              //contentType: "application/x-www-form-urlencoded;charset=utf-8",
              data: {contentID: "<?php echo $this->id; ?>", lang: lang},
              url: "<?php echo $data['config']['SITE_URL']; ?>/admin/moduletranslation/ajaxtranslateaction/<?php echo $this->controller; ?>", 
              success: function(data) {
                        console.log(data[0])    
                        label = data[0].Label; 
 
                        $("input[name='Label']").val(data[0].Label);
 


              },
              error: function(xhr, status, error) {
                alert(xhr.responseText);
              }         
            });
        
      });
      
        
        
         $("input[name='Label']").click(function() {
           

            currentValue = $(this).val();           
            if(currentValue != label) 
            {
                $("#admin-language").attr('disabled', true);
                $("#info").show(1000);
            } 
            
            if(currentValue == label)
            {

                $("#admin-language").attr('disabled', false);
                $("#info").hide(1000);
            }  

        });

        $("input[name='Label']").keyup(function() {
            

            currentValue = $(this).val();
            if(currentValue != label) 
            {
                $("#admin-language").attr('disabled', true);
                $("#info").show(1000);
            }
            
            if(currentValue == label)
            {

                $("#admin-language").attr('disabled', false);
                $("#info").hide(1000);
            }   

        });
        
        $("input[name='Label']").keydown(function() {
           
           
            currentValue = $(this).val();
            if(currentValue != label) 
            {
                $("#admin-language").attr('disabled', true);
                
                $("#info").show(1000);
            } 
            
            if(currentValue == label)
            {

                $("#admin-language").attr('disabled', false);
                $("#info").hide(1000);
            }

        });
        
     
        
});
</script>