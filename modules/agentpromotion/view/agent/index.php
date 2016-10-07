<?php 
function familyTree($array)
{


        if(is_array($array)===TRUE)
        {   


              for ($index = 0; $index < $array['count']; $index++) {

                     if ($array[$index]['ID']==$_SESSION['agentpromotion_AgentIndex']['param']['AgentID']) { 
                        $selected= 'selected="selected"'; 

                     }                     

                    $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].' | '. $array[$index]['Company'].'</option>';    

                    echo $data;

                    unset($selected);
                   familyTree($array[$index]['Child']);
              }


        }

}

function familyUsernameTree($array)
{


        if(is_array($array)===TRUE)
        {   


              for ($index = 0; $index < $array['count']; $index++) {

                     if ($array[$index]['ID']==$_SESSION['agentpromotion_AgentIndex']['param']['AgentUsernameID']) { 
                        $selected= 'selected="selected"'; 

                     }                     

                    $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Username'].' - '. $array[$index]['ID'].'</option>';    

                    echo $data;

                    unset($selected);
                   familyTree($array[$index]['Child']);
              }


        }

}
                               
?>
<?php if ($data['page']['agentpromotion_delete']['ok']==1) { ?>
<div class="notify">Agent Promotion deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentpromotion/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Agent</label></th>
	      	<td>
                    <select name="AgentID" class="chosen_full">
                    <option value="">--Select All--</option>    
                    <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($_SESSION['agentpromotion_AgentIndex']['param']['AgentID']==$data['agent'][0]['ID']){ ?>selected="selected"<?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?> | <?php echo $data['agent'][0]['Company']; ?></option>
	            <?php familyTree($data['agent'][0]['Child']); ?>
                    </select>
                </td>
	        <td>&nbsp;</td>
                <th>Agent Username</th>
                <td>
                    <select name="AgentUsernameID" class="chosen_full">
                    <option value="">--Select All--</option>    
                    <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($_SESSION['agentpromotion_AgentIndex']['param']['AgentUsernameID']==$data['agent'][0]['ID']){ ?>selected="selected"<?php } ?>><?php echo $data['agent'][0]['Username']; ?> - <?php echo $data['agent'][0]['ID']; ?></option>
	            <?php familyUsernameTree($data['agent'][0]['Child']); ?>
                    </select>
                </td>      
	      </tr>
	      <tr>
                  <th>Title</th>
            <td><input name="Title" type="text" value="<?php echo $_SESSION['agentpromotion_AgentIndex']['param']['Title']; ?>" /></td>
            <td>&nbsp;</td>
               <th scope="row"><label>First</label></th>
	        <td><select name="First">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['Value']; ?>" <?php if ($_SESSION['agentpromotion_AdminIndex']['param']['First']==$data['content_param']['enabled_list'][$i]['Value']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>	        	        
	      </tr>
	      <tr>
	             
                <th><label>Enabled</label></th>
                    <td><select name="Enabled">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['agentpromotion_AgentIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
                    </select>
                    </td>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentpromotion/index?page=all">
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
      <a href='/agent/agentpromotion/add/'><input type="button" class="button" value="Create Agent Promotion"></a>
      <a href='/agent/agentpromotion/manage?page=all'><input type="button" class="button" value="Bulk Update"></a>
      <?php } ?>
      <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
      <a href='/agent/agentpromotion/add/'><input type="button" class="button" value="Create Agent Promotion"></a>
      <a href='/agent/agentpromotion/manage?page=all'><input type="button" class="button" value="Bulk Update"></a>
      <?php } ?>      
          <?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" id="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Agent</th>
    <th>Agent Username</th>
    <th>Title</th>
    <th>Position</th>
    <th>First</th>
    <th class="center">Enabled</th>
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
  <tbody <?php if ($data['content_param']['sort']==TRUE) { ?>class="sortable"<?php } ?>>
	<?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  	<tr data-id="<?php echo $data['content'][$i]['ID']; ?>">
    <td><?php echo $data['content'][$i]['AgentID']; ?></td>
    <td><?php echo $data['content'][$i]['AgentUsername']; ?></td>
    <td><?php echo $data['content'][$i]['Title']; ?></td>
    <td class="center"><span class="sortable_position" id="sortable_position_<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Position']; ?></span></td>
    <td><?php echo $data['content'][$i]['First']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/agentpromotion/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/agentpromotion/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
    <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/agentpromotion/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/agent/agentpromotion/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
    <?php } ?>
    <?php } ?>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
