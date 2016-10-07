<?php 
function familyTree($array)
	{
           
           
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                             if ($array[$index]['ID']==$_SESSION['bankinfo_AgentIndex']['param']['AgentID']) { 
                                $selected= 'selected="selected"'; 

                             }                     
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].' | '. $array[$index]['Company'].'</option>';    
                       
                            echo $data;
           
                            unset($selected);
                           familyTree($array[$index]['Child']);
                      }
                     
                  
                }
                
        }
                               
?>
<?php if ($data['page']['bankinfo_delete']['ok']==1) { ?>
<div class="notify">Bank Info deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/bankinfo/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Agent</label></th>
	      	<td>
                    <select name="AgentID" class="chosen_full">
                    <option value="">--Select All--</option>    
                    <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($data['agent'][0]['ID']==$_SESSION['bankinfo_AgentIndex']['param']['AgentID']){ ?> selected="selected"<?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?> | <?php echo $data['agent'][0]['Company']; ?></option>
	            <?php familyTree($data['agent'][0]['Child']); ?>
                    </select>
                </td>
	        <td>&nbsp;</td>
	        <td>Name</td>
            <td><select name="Name" class="chosen">
	            <option value="" selected="selected">All Name</option>
	            <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if ($data['content_param']['bank_list'][$i]['Label']==$_SESSION['bankinfo_AgentIndex']['param']['Name']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Description</label></th>
            <td><input name="Description" type="text" value="<?php echo $_SESSION['bankinfo_AgentIndex']['param']['Description']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><?php /*?><label>Image URL</label><?php */?></th>
	        <td><?php /*?><input name="ImageURL" type="text" value="<?php echo $_SESSION['bankinfo_AdminIndex']['param']['ImageURL']; ?>" size="" /><?php */?></td>
	      </tr>
	      <?php /*?><tr>
	        <th scope="row"><label>Cover</label></th>
	        <td><input name="Cover" type="text" value="<?php echo $_SESSION['bankinfo_AdminIndex']['param']['Cover']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Position</label></th>
	        <td><input name="Position" type="text" value="<?php echo $_SESSION['bankinfo_AdminIndex']['param']['Position']; ?>" size="" /></td>
	      </tr><?php */?>
	      <tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <?php /*?><th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['bankinfo_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr><?php */?>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/bankinfo/index?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
	      </tr>
	    </table>
	  </form>
  </div>
</div>
<div class="admin_results">
  <div class="results_left">
    <h2><?php echo $data['content_param']['query_title']; ?></h2>
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right">
      <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
      <a href='/agent/bankinfo/add/'>
    <input type="button" class="button" value="Create Bank Info">
    </a><a href='/agent/bankinfo/manage?page=all'>
    <input type="button" class="button" value="Bulk Update">
    </a>
      <?php } ?>     
      <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
      <a href='/agent/bankinfo/add/'>
    <input type="button" class="button" value="Create Bank Info">
    </a><a href='/agent/bankinfo/manage?page=all'>
    <input type="button" class="button" value="Bulk Update">
    </a>
      <?php } ?> 
        <?php /*?><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/bankinfo/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php */?><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Agent</th>
    <th>Name</th>
    <th>Image URL</th>
    <th class="center">Description</th>
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <th>&nbsp;</th>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <th>&nbsp;</th>
    <?php } ?>
    <?php } ?>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['AgentID']; ?></td>
    <td><?php echo $data['content'][$i]['Name']; ?></td>
    <td><img src="<?php echo $data['content'][$i]['ImageURL']; ?>" width="146" height="45" /></td>
    <td class="center"><?php echo $data['content'][$i]['Description']; ?></td>
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/bankinfo/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/bankinfo/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
    <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/bankinfo/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/bankinfo/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
    <?php } ?>
    <?php } ?>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
