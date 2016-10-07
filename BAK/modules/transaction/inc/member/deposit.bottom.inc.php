<?php if ($_SESSION['superid']=='1') { ?>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['SITE_DIR']; ?>/lib/jquery-safeform-master/jquery.safeform.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/jquery/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo $data['config']['THEME_DIR']; ?>js/foundation/foundation.reveal.js"></script>
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
        controlType: 'select',
        showSecond: true
    });

	$("#add_form").validationEngine();
        //$("#transfer_add_form").validationEngine();

	$(".mask_date").mask("?99-99-9999 99:99:99",{placeholder:" "});

    $('#announcement_popup').foundation('reveal', 'open');

    <?php if($data['content_param']['bank_info']['count'] > 0){ ?>
        <?php for ($i = 0; $i < $data['content_param']['bank_info']['count']; $i++) { ?>
            $('input[type="radio"]').click(function() {
            if($('#<?php echo str_replace(' ', '', $data['content_param']['bank_info'][$i]['Name']); ?>').is(':checked')) {
                        // $("#CIMB").show();
                        $(".<?php echo str_replace(' ', '', $data['content_param']['bank_info'][$i]['Name']); ?>").show();
                }else{
                        // $("#CIMB").hide();
                        $(".<?php echo str_replace(' ', '', $data['content_param']['bank_info'][$i]['Name']); ?>").hide();
                }
            });
        <?php } ?>
    <?php } ?>

         /*$('input[type="radio"]').click(function() {
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
            });*/


    /*$('input[type="radio"]').click(function() {
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
    });*/

    /*$("form").submit(function() {
    $(this).submit(function() {
        return false;
    });
        return true;
    });*/


    /*$("#Submit").click(function() {
        $("#Submit").hide();
        $("#Cancel").hide();
    });*/




    /*var form_control = $("#add_form").validationEngine('validate');

    if(form_control === true)
    {



        });
    }*/

    /*$("#Submit").click(function() {
            $("#Submit").hide();
            $("#Cancel").hide();*/

    /*$(function(){
    $('#Submit').click(function(e){

        if(!$("#add_form").validationEngine('validate')){

            return false;
        }
        else
        {

            $('#depositformcontainer').html('Processing.....');

        }


    })
});*/

            $.ajax({
              type: "GET",
              dataType: "json",
              //contentType: "application/x-www-form-urlencoded;charset=utf-8",
              data: {contentID: "<?php echo $this->id; ?>", lang: <?php echo $_SESSION['language']; ?>},
              url: "<?php echo $data['config']['SITE_URL']; ?>/admin/moduletranslation/ajaxtranslateaction/bankin_slip",
              success: function(data) {
                   console.log(data);
                   //alert('hi');
                    /*$("#BankSlip > option").each(function(){
                        this.text = data.Label;
                        this.value = data.Label;
                    });*/

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

});
</script>


<?php } else { ?>

<?php } ?>
