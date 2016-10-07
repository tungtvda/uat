<?php 
function familyTree($array, $parentID)
	{
            //global $data;
           
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                             
                             if ($array[$index]['ID']==$parentID) { 
                                $selected= 'selected="selected"'; 

                             }                     
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].'</option>';    
                       
                            echo $data;
                            unset($selected);
                            
                           familyTree($array[$index]['Child'], $parentID);
                      }
                     
                  
                }
                
        }
                               
?>
<?php if ($data['page']['announcementticker_add']['error']['count']>0) { ?>
    <div class="error">Announcement Ticker create failed.</div>
<?php } else { ?>
    <?php if ($data['page']['announcementticker_add']['ok']==1) { ?>
    <div class="notify">Announcement Ticker created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['announcementticker_edit']['error']['count']>0) { ?>
    <div class="error">Announcement Ticker edit failed.</div>
<?php } else { ?>
    <?php if ($data['page']['announcementticker_edit']['ok']==1) { ?>
    <div class="notify">Announcement Ticker edited successfully.</div>
    <?php } ?>
<?php } ?>
<form action="<?php echo $data['config']['SITE_DIR']; ?>/agent/announcementticker/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post" enctype="multipart/form-data" name="edit_form" class="admin_table_nocell"  id="edit_form">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Agent<span class="label_required">*</span></label></th>
      <td><select name="AgentID" class="validate[] chosen">
                        <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($data['content'][0]['AgentID']==$data['agent'][0]['ID']){ ?> selected="selected" <?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?></option>    
                        <?php familyTree($data['agent'][0]['Child'], $data['content'][0]['AgentID']); ?>
                  </select>
          </td>
    </tr>
    <tr>
      <th scope="row"><label>Content<span class="label_required">*</span></label></th>
      <td><textarea name="Content" class="validate[required]" type="text" rows="5" cols="60"><?php echo $data['content'][0]['Content']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" type="text" class="validate[required,custom[integer]]" value="<?php echo $data['content'][0]['Position']; ?>" size="3" /></td>
    </tr>
   <tr>
      <th scope="row"><label>Enabled<span class="label_required">*</span></label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/announcementticker/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
