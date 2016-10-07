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
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].' | '. $array[$index]['Company'].'</option>';    
                       
                            echo $data;
                            unset($selected);
                            
                           familyTree($array[$index]['Child'], $parentID);
                      }
                     
                  
                }
                
        }
                               
?>
<?php if ($data['page']['agentpromotion_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['agentpromotion_add']['ok']==1) { ?>
    <div class="notify">Agent Promotion created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['agentpromotion_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['agentpromotion_edit']['ok']==1) { ?>
    <div class="notify">Agent Promotion edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" enctype="multipart/form-data" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentpromotion/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Agent<span class="label_required">*</span></label></th>
      <td><select name="AgentID" class="validate[] chosen">
                        <option value="<?php echo $data['agent'][0]['ID']; ?>"<?php if($data['content'][0]['AgentID']==$data['agent'][0]['ID']){ ?> selected="selected"<?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?> | <?php echo $data['agent'][0]['Company']; ?></option><?php familyTree($data['agent'][0]['Child'], $data['content'][0]['AgentID']); ?>
          </select>
          </td>
    </tr>
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Title']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Position']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>First</label></th>
      <td><select name="First">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['Value']; ?>" <?php if ($data['content'][0]['First']==$data['content_param']['enabled_list'][$i]['Value']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled">
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
        <input type="hidden" id="EditFormPost" name="EditFormPost" value="1" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentpromotion/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
