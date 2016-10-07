<?php
        function CheckChildExist($array, $parent)
	{     
            
            
              for ($index = 0; $index < $array['count']; $index++) {
                  echo '<tr data-tt-id="'.$array[$index]['Name'].'" data-tt-parent-id="'.$parent.'">';
                  echo '<td>'.$array[$index]['Name'].'</td>';

                  if(empty($array)===FALSE)
                  { 
                     CheckChildExist($array[$index]['Child'], $array[$index]['Name']);
                  }
                  echo '</tr>';
              }
              

            return;
                
           
        }
?>
<div class="admin_results">
<!--<table id="treetable">
        <tbody><tr data-tt-id="0">
          <td>app</td>
        </tr>
        <tr data-tt-id="1" data-tt-parent-id="0">
          <td>controllers</td>
        </tr>
        <tr data-tt-id="5" data-tt-parent-id="1">
          <td>application_controller.rb</td>
        </tr>
        <tr data-tt-id="5" data-tt-parent-id="1">
          <td>helpers</td>
        </tr>
        <tr data-tt-id="3" data-tt-parent-id="0">
          <td>models</td>
        </tr>
        <tr data-tt-id="4" data-tt-parent-id="0">
          <td>views</td>
        </tr>
      </tbody></table>-->
  <div class="results_right">
      <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
        <a href='/agent/agent/add/'>
        <input type="button" class="button" value="Create Agent">
        </a> 
        <a href='/agent/agent/editindex/'>
        <input type="button" class="button" value="Edit Agent">
        </a> 
      <?php } ?>
      <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
        <a href='/agent/agent/add/'>
        <input type="button" class="button" value="Create Agent">
        </a> 
        <a href='/agent/agent/editindex/'>
        <input type="button" class="button" value="Edit Agent">
        </a> 
      <?php } ?>
    <?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>

<br>
<!--<div style="background-color: #EFEFEF;padding: 10px;border-radius: 5px;">-->
    <table id="treetable">
        <tr data-tt-id="<?php echo $data['content'][0]["Name"]; ?>">
            <td><?php echo $data['content'][0]["Name"]; ?></td>
        </tr>
        <?php 

                CheckChildExist($data['content'][0]['Child'], $data['content'][0]["Name"]);         
        ?>       
    </table>    
<!--</div>-->