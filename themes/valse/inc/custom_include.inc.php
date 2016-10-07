<?php 
if ($data['page']['custom_inc']=="on") 
{
    // Set custom include file
    $custom_inc_loc_override = "override/".$data['page']['custom_inc_loc'];
    
    // Check if override files exist
    if (file_exists($custom_inc_loc_override)==1) 
    {
        $data['page']['custom_inc_loc'] = $custom_inc_loc_override;
    }
        
    require($data['page']['custom_inc_loc']);
}
?>
