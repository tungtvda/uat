<script>
    $(".popup_form").validationEngine();
    var selected = $("#Status option:selected").text();
    
    if(selected === "Rejected")
    {
        $("#rejectedremarkdiv").hide();

        $("#rejectmessagediv").show(); 
    }
    if(selected !== "Rejected")
    {
        $("#rejectmessagediv").hide();
    }    
    
    
    $("#contact #cancel").click(function() {
        
        $(this).parent().parent().hide();
        
    });
    
    $('#Status').on('change', function() {
        
        var status = $("#Status option:selected").text(); 
        var statusText = $("#Status option:selected").val();
        
        if(status === "Rejected")
        {                
           $("#rejectedremarkdiv").hide();

           $("#rejectmessagediv").show();        
        }
        if(status !== "Rejected")
        {
           $("#rejectedremarkdiv").show();

           $("#rejectmessagediv").hide(); 
        }
        
        if(statusText === 6)
        {
           $("#rejectedremarkdiv").show();

           $("#rejectmessagediv").hide(); 
        } 
    });
    
    $(".chosen_simple_custom").chosen({
       width: '80%',
       disable_search:true
    });
    //('.chosen_simple_custom').css("max-height","127px");
</script>
<form class="popup_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/quickeditprocess/<?php echo $data['ID']; ?>" id="contact" method="post">
<h3>Quick Edit</h3>
<hr/><br/>
<label>Member: <?php echo $data['content'][0]['MemberName']; ?></label>
<br/><br/>
<label>Bonus (MYR): </label>
<br/>
<input class="input validate[custom[number]]" type="text" name="Bonus" id="Bonus" placeholder="(e.g 40.00)" value="<?php echo ($data['content'][0]['Bonus']!='')? $data['content'][0]['Bonus']: ''; ?>" /><br/>
<br/>
<label>Commission (MYR): </label>
<br/>
<input class="input validate[custom[number]]" type="text" name="Commission" id="Commission" placeholder="(e.g 40.00)" value="<?php echo ($data['content'][0]['Commission']!='')? $data['content'][0]['Commission']: ''; ?>" /><br/>
<br/>
<label>Status: </label>
<br/>
<select name="Status" id="Status" class="chosen_simple">
	            <option value="" selected="selected">All Statuses</option>
	            <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
                    <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if($data['content'][0]['Status']==$data['content_param']['transactionstatus_list'][$i]['Label']){ ?>selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
	            <?php } ?>
</select>
<br/>
<br/>
<div id="rejectedremarkdiv">

<label>Remark: </label>
<br/>
<textarea id="RejectedRemark" name="RejectedRemarkManual" placeholder="Remark"><?php echo $data['content'][0]['RejectedRemark']; ?></textarea>
<br/>
</div>
<div id="rejectmessagediv">
  
<label>Reject Message: </label>
<br/>
<select name="RejectedRemarkSelect" class="chosen_simple_custom">
	            <option value="" selected="selected">All Reject Message</option>
	            <?php for ($i=0; $i<$data['content_param']['reject_message']['count']; $i++) { ?>
                    <option value="<?php echo $data['content_param']['reject_message'][$i]['Label']; ?>" <?php if($data['content'][0]['RejectedRemark']==$data['content_param']['reject_message'][$i]['Label']){ ?>selected="selected"<?php } ?>><?php echo $data['content_param']['reject_message'][$i]['Label']; ?></option>
	            <?php } ?>
</select>
</div>
<br/>
<input type="submit" name="submit" value="Update" class="button" />
<input type="button" class="button" id="cancel" value="Cancel"/>
<br/>
</form>