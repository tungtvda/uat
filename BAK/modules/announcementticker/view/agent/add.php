<?php 
function familyTree($array)
	{
           
           
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                                                 
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].'</option>';    
                       
                            echo $data;
                            
                            
                           familyTree($array[$index]['Child']);
                      }
                     
                  
                }
                
        }
                               
?>
<form action="<?php echo $data['config']['SITE_DIR']; ?>/agent/announcementticker/addprocess" method="post" enctype="multipart/form-data" name="add_form" class="admin_table_nocell"  id="add_form">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Agent<span class="label_required">*</span></label></th>
      <td><select name="AgentID" class="chosen">
              <option value="<?php echo $data['agent'][0]['ID']; ?>"><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?></option>  
            <?php familyTree($data['agent'][0]['Child']); ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Content<span class="label_required">*</span></label></th>
      <td><textarea name="Content" class="validate[required]" type="text" rows="5" cols="60"></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" class="validate[required,custom[integer]]" type="text" value="" size="3" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled<span class="label_required">*</span></label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/announcementticker/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
