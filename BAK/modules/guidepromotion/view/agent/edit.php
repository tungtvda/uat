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
<?php if ($data['page']['guidepromotion_add']['error']['count']>0) { ?>
    <?php if ($data['page']['guidepromotion_add']['error']['ImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['guidepromotion_add']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['guidepromotion_add']['ok']==1) { ?>
    <div class="notify">Guide Promotion created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['guidepromotion_edit']['error']['count']>0) { ?>
    <?php if ($data['page']['guidepromotion_edit']['error']['ImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['guidepromotion_edit']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['guidepromotion_edit']['ok']==1) { ?>
    <div class="notify">Guide Promotion edited successfully.</div>
    <?php } ?>
<?php } ?>
<form action="<?php echo $data['config']['SITE_DIR']; ?>/agent/guidepromotion/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post" enctype="multipart/form-data" name="edit_form" class="admin_table_nocell"  id="edit_form">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Agent</label></th>
      <td><select name="AgentID" class="validate[] chosen">
                        <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($data['content'][0]['AgentID']==$data['agent'][0]['ID']){ ?> selected="selected" <?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?></option>    
                        <?php familyTree($data['agent'][0]['Child'], $data['content'][0]['AgentID']); ?>
                  </select>
          </td>
    </tr>
    <tr>
      <th scope="row"><label>Image</label></th>
      <td><?php if ($data['content'][0]['ImageURL']=="") { ?>
        No image uploaded.
        <?php } else { ?>
        <img src="<?php echo $data['content'][0]['ImageURLCover']; ?>" height="45" width="146" /><br />
        <label>
        <input name="ImageURLRemove" type="checkbox" id="ImageURLRemove" value="1" />
        Remove this image</label>
        <br />
        <?php } ?>
        <br />
        <input type="hidden" name="ImageURLCurrent" value="<?php echo $data['content'][0]['ImageURL']; ?>" />
        <input name="ImageURL" type="file" />
        <br />
        <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 146px x 45px.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>URL</label></th>
      <td><input name="Description" type="text" class="validate[]" value="<?php echo $data['content'][0]['Description']; ?>" size="40" /></td>
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
    <?php /*?><tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr><?php */?>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/guidepromotion/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
