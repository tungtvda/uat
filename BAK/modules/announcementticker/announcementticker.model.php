<?php
// Require required models
Core::requireModel('agent');
Core::requireModel('bank');

class AnnouncementTickerModel extends BaseModel
{
	private $output = array();
        private $module_name = "Announcement Ticker";
	private $module_dir = "modules/announcementticker/";
        private $module_default_url = "/main/announcementticker/index";
        private $module_default_admin_url = "/admin/announcementticker/index";
        private $module_default_agent_url = "/agent/announcementticker/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM bank_info WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/bankinfo/index';
		$limit = 5;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;	
		}	
		
		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
		
		$sql = "SELECT * FROM bank_info WHERE Enabled = 1 ORDER BY ResellerID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'cover');
			}
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'ResellerID' => $row['ResellerID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'Description' => $row['Description']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Bank Infos", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
        
        
        public function AdminBulkUpdate() 
    {
        //Debug::displayArray($_POST);
        //exit;
        
         if(empty($_POST['Agent'])===FALSE)
         {
             
            //Check agent exist    

            foreach ($_POST['Agent'] as $resellerID) {
                //Get each agent ID   

                if(empty($_POST['Announcementticker'][$resellerID])===FALSE)
                {
                    //Check if Product empty    

                    foreach ($_POST['Announcementticker'] as $Agent => $Product) {

                    //Separate and get each part of product                           

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $announcementTickerCount = count($_POST['Announcementticker'][$Agent]);




                            for ($i=0; $i<$announcementTickerCount; $i++) {

                                    $concat.=$_POST['Announcementticker'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$announcementTickerCount){



                                     }
                                     else 
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $announcementTicker = array();

                            for ($i=0; $i<$announcementTickerCount; $i++) {
                                array_push($announcementTicker, $_POST['Announcementticker'][$Agent][$i]);
                            }



                            // Get Agent product created before this process
                            $AnnouncementTickerList = AnnouncementTickerModel::getAnnouncementTickerListWithoutCounter($Agent);

                            $AnnouncementTickerList = explode(',', $AnnouncementTickerList);

                            $AnnouncementTickerList['count'] = count($AnnouncementTickerList);
                            
                            
                            //Reason to use array_diff and array_intersect are to prevent wallet duplications
                            
                            //Get products similarity between selected and created
                            
                            $intersect = array_intersect($announcementTicker, $AnnouncementTickerList);

                            $intersect = array_values($intersect);
                            
                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {

                                $sql = "DELETE FROM announcement_ticker WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else 
                            {    
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM announcement_ticker WHERE AgentID = '".$Agent."'";

                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$announcementTickerCount; $i++) {
                                        
                                        
                                        
                                        $key = "(AgentID, Content, Position, Enabled)";
                                        $value = "('".$Agent."', '".$_POST['Announcementticker'][$Agent][$i]."', '', '1')";

                                        $sql2 = "INSERT INTO announcement_ticker ".$key." VALUES ". $value;

                                        $this->dbconnect->exec($sql2);

                                        
                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $announcementtickerdeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM announcement_ticker WHERE AgentID = '".$Agent."' AND Position NOT IN (".$announcementtickerdeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newAnnouncementTickerList = AnnouncementTickerModel::getAnnouncementTickerListWithoutCounter($Agent);

                                    $newAnnouncementTickerList = explode(',', $newAnnouncementTickerList);


                                    // Get selected products not included in created products     
                                    $newAnnouncementTicker = array_diff($announcementTicker, $newAnnouncementTickerList);

                                    if(empty($newAnnouncementTicker)===TRUE)
                                    {
                                        

                                    }
                                    else
                                    {
                                        $newAnnouncementTicker = array_values($newAnnouncementTicker);
                                        $newAnnouncementTicker['count'] = count($newAnnouncementTicker);

                                        for ($i=0; $i<$newAnnouncementTicker['count']; $i++) {
                                            
                                                $key = "(AgentID, Content, Position, Enabled)";
                                                $value = "('".$Agent."', '".$_POST['Announcementticker'][$Agent][$i]."', '', '1')";

                                                $sql2 = "INSERT INTO announcement_ticker ".$key." VALUES ". $value;

                                                $this->dbconnect->exec($sql2);
                                            
                                            
                                        }

                                    }    

                                }
                            }
                   

                            //$sql6 = "UPDATE agent SET Product='".$concat."' WHERE ID='".$Agent."'";			
                            //$this->dbconnect->exec($sql6);




                      } 
                    }       
                }
                else 
                {
                    //echo 'hi<br>';
                    
                    
                    //$sql = "UPDATE agent_block SET Product='' WHERE ID='".$resellerID."'";			
                    //$this->dbconnect->exec($sql);
                    //echo $sql.'<br>';
                    
                    $sql2 = "DELETE FROM announcement_ticker WHERE AgentID = '".$resellerID."'";
                    //echo $sql2.'<br>';
                    //exit;
                    $count = $this->dbconnect->exec($sql2);
                }
            }  
        }

    }
    
   public function AdminManage($param) 
    {   
        // Initialise query conditions
        $query_condition = "";
        
        $crud = new CRUD();
        
        if ($_POST['Trigger']=='search_form')
        {    
            
        // Reset Query Variable
                $_SESSION['announcementticker_'.__FUNCTION__] = "";

                $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=");
                //$query_condition .= $crud->queryCondition("ID",$_POST['AgentBlock'],"=");
                //$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
                //$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

                $_SESSION['announcementticker_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
                $_SESSION['announcementticker_'.__FUNCTION__]['param']['AgentBlock'] = $_POST['AgentBlock'];
                $_SESSION['announcementticker_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
                $_SESSION['announcementticker_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

                // Set Query Variable
                $_SESSION['announcementticker_'.__FUNCTION__]['query_condition'] = $query_condition;
                $_SESSION['announcementticker_'.__FUNCTION__]['query_title'] = "Search Results";
        }

        // Reset query conditions
        if ($_GET['page']=="all")
        {
            $_GET['page'] = "";
            unset($_SESSION['announcementticker_'.__FUNCTION__]);           
        }

        // Determine Title
        if (isset($_SESSION['announcementticker_'.__FUNCTION__]))
        {
            $query_title = "Search Results";
            $search = "on";
        }
        else
        {
            $query_title = "All Results";
            $search = "off";
        }

        // Prepare Pagination
        #$query_count = "SELECT COUNT(*) AS num FROM permission ".$_SESSION['permission_'.__FUNCTION__]['query_condition'];
        
        $query_count = "SELECT COUNT(*) AS num FROM agent ".$_SESSION['announcementticker_'.__FUNCTION__]['query_condition'];
        
        /*echo $query_count;
        exit();*/
        
        #echo $query_count;
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_DIR'].'/admin/announcementticker/manage';
        $limit = 10;
        $stages = 3;
        $page = mysql_escape_string($_GET['page']);
        if ($page) {
            $start = ($page - 1) * $limit; 
        } else {
            $start = 0; 
        }   
        
        // Initialize Pagination
        $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
        
        #$sql = "SELECT * FROM permission ".$_SESSION['permission_'.__FUNCTION__]['query_condition']." ORDER BY ProfileID ASC LIMIT $start, $limit";
        
        $sql = "SELECT * FROM agent ".$_SESSION['announcementticker_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
        //echo $sql;
        //exit;
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'Announcementticker' => AnnouncementTickerModel::getAnnouncementTickerList($row['ID']),
            'announcementticker_list' => AnnouncementTickerModel::getAnnouncementTickerList($row['ID']),
            'Enabled' => CRUD::isActive($row['Enabled']));
            
            $i += 1;
        }
                
                $result['count'] = $i;
                       
                $result2 = AgentModel::getAdminAgentAllParentChild();
 
               
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Bulk Update", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/manage.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agentblock_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Manage"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'test1' => $result2['result2'], 'test2' => $result2['result3']),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

					
		return $this->output;
    }
    
    public function AgentManage($param) 
    {       
        // Initialise query conditions
		$query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['announcementticker_'.__FUNCTION__] = "";
			
                                                
                        
                        $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=", 1);    
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
                        $query_condition .= $crud->queryCondition("Position",$_POST['Position'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['announcementticker_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
			$_SESSION['announcementticker_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['announcementticker_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
                        $_SESSION['announcementticker_'.__FUNCTION__]['param']['Position'] = $_POST['Position'];
			$_SESSION['announcementticker_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['announcementticker_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['announcementticker_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['announcementticker_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['announcementticker_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}
                
                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_SESSION['agent']['ID']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);
                
                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_SESSION['agent']['ID']);
                }
                
                
                $child = implode(',', $_SESSION['agentchild']);
                
                unset($_SESSION['agentchild']);
                
                if(isset($_SESSION['announcementticker_'.__FUNCTION__]['param']['Agent'])===true && empty($_SESSION['announcementticker_'.__FUNCTION__]['param']['Agent'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND ID IN (".$child.")";
                }
                
                               
                
                    
                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition'];
                    //echo $query_count;
                    //exit;
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 

                    $targetpage = $data['config']['SITE_DIR'].'/agent/announcementticker/manage';
                    $limit = 10;
                    $stages = 3;
                    $page = mysql_escape_string($_GET['page']);
                    if ($page) {
                            $start = ($page - 1) * $limit; 
                    } else {
                            $start = 0;	
                    }	

                    // Initialize Pagination
                    $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

                    $sql = "SELECT * FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['announcementticker_'.__FUNCTION__]['query_condition']." ORDER BY Name DESC LIMIT $start, $limit";
                    
                
                                        
                
                
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
                        'ID' => $row['ID'],
                        'Name' => $row['Name'],
                        'Announcementticker' => AnnouncementTickerModel::getAnnouncementTickerList($row['ID']),
                        'announcementticker_list' => AnnouncementTickerModel::getAnnouncementTickerList($row['ID']),    
                        'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
                
                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);
                        if($count>'0')
                        {   
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }
                        }
                        else
                        {
                         foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }   
                        }    

                        $result2['count'] = $z;

        
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Bulk Update", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/manage.inc.php', 'custom_bottom_inc' => 'off', 'custom_bottom_inc_loc' => $this->module_dir.'inc/agent/index.bottom.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agentblock_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Index"),
		'content' => $result,
                'agent' => $result2,    
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

					
		return $this->output;
    }
    

    public function AgentBulkUpdate() 
    {
        //Debug::displayArray($_POST);
        //exit;
        
         if(empty($_POST['Agent'])===FALSE)
         {
             
            //Check agent exist    

            foreach ($_POST['Agent'] as $resellerID) {
                //Get each agent ID   

                if(empty($_POST['Announcementticker'][$resellerID])===FALSE)
                {
                    //Check if Product empty    

                    foreach ($_POST['Announcementticker'] as $Agent => $Product) {

                    //Separate and get each part of product                           

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $announcementTickerCount = count($_POST['Announcementticker'][$Agent]);




                            for ($i=0; $i<$announcementTickerCount; $i++) {

                                    $concat.=$_POST['Announcementticker'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$announcementTickerCount){



                                     }
                                     else 
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $announcementTicker = array();

                            for ($i=0; $i<$announcementTickerCount; $i++) {
                                array_push($announcementTicker, $_POST['Announcementticker'][$Agent][$i]);
                            }



                            // Get Agent product created before this process
                            $AnnouncementTickerList = AnnouncementTickerModel::getAnnouncementTickerListWithoutCounter($Agent);

                            $AnnouncementTickerList = explode(',', $AnnouncementTickerList);

                            $AnnouncementTickerList['count'] = count($AnnouncementTickerList);
                            
                            
                            //Reason to use array_diff and array_intersect are to prevent wallet duplications
                            
                            //Get products similarity between selected and created
                            
                            $intersect = array_intersect($announcementTicker, $AnnouncementTickerList);

                            $intersect = array_values($intersect);
                            
                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {

                                $sql = "DELETE FROM announcement_ticker WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else 
                            {    
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM announcement_ticker WHERE AgentID = '".$Agent."'";

                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$announcementTickerCount; $i++) {
                                        
                                        
                                        
                                        $key = "(AgentID, Content, Position, Enabled)";
                                        $value = "('".$Agent."', '".$_POST['Announcementticker'][$Agent][$i]."', '', '1')";

                                        $sql2 = "INSERT INTO announcement_ticker ".$key." VALUES ". $value;

                                        $this->dbconnect->exec($sql2);

                                        
                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $announcementtickerdeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM announcement_ticker WHERE AgentID = '".$Agent."' AND Position NOT IN (".$announcementtickerdeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newAnnouncementTickerList = AnnouncementTickerModel::getAnnouncementTickerListWithoutCounter($Agent);

                                    $newAnnouncementTickerList = explode(',', $newAnnouncementTickerList);


                                    // Get selected products not included in created products     
                                    $newAnnouncementTicker = array_diff($announcementTicker, $newAnnouncementTickerList);

                                    if(empty($newAnnouncementTicker)===TRUE)
                                    {
                                        

                                    }
                                    else
                                    {
                                        $newAnnouncementTicker = array_values($newAnnouncementTicker);
                                        $newAnnouncementTicker['count'] = count($newAnnouncementTicker);

                                        for ($i=0; $i<$newAnnouncementTicker['count']; $i++) {
                                            
                                                $key = "(AgentID, Content, Position, Enabled)";
                                                $value = "('".$Agent."', '".$_POST['Announcementticker'][$Agent][$i]."', '', '1')";

                                                $sql2 = "INSERT INTO announcement_ticker ".$key." VALUES ". $value;

                                                $this->dbconnect->exec($sql2);
                                            
                                            
                                        }

                                    }    

                                }
                            }
                   

                            //$sql6 = "UPDATE agent SET Product='".$concat."' WHERE ID='".$Agent."'";			
                            //$this->dbconnect->exec($sql6);




                      } 
                    }       
                }
                else 
                {
                    //echo 'hi<br>';
                    
                    
                    //$sql = "UPDATE agent_block SET Product='' WHERE ID='".$resellerID."'";			
                    //$this->dbconnect->exec($sql);
                    //echo $sql.'<br>';
                    
                    $sql2 = "DELETE FROM announcement_ticker WHERE AgentID = '".$resellerID."'";
                    //echo $sql2.'<br>';
                    //exit;
                    $count = $this->dbconnect->exec($sql2);
                }
            }  
        }

    }
    
    
	public function View($param) 
	{
		$sql = "SELECT * FROM bank_info WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ResellerID' => $row['ResellerID'],
			'Name' => $row['Name'],
			'ImageURL' => $row['ImageURL'],
			'Description' => $row['Description']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/view.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,$result[0]['Title']),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminIndex($param) 
	{		
		// Initialise query conditions
		$query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['announcementticker_'.__FUNCTION__] = "";
			
                        $query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
                        $query_condition .= $crud->queryCondition("Position",$_POST['Position'],"=");
                        $query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
                        
			
                        $_SESSION['announcementticker_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['announcementticker_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
                        $_SESSION['announcementticker_'.__FUNCTION__]['param']['Position'] = $_POST['Position'];
                        $_SESSION['announcementticker_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['announcementticker_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['announcementticker_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['announcementticker_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['announcementticker_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
			$sort = TRUE;
		}

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM announcement_ticker ".$_SESSION['announcementticker_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/announcementticker/index';
		$limit = 100000;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;	
		}	
		
		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
		
		$sql = "SELECT * FROM announcement_ticker ".$_SESSION['announcementticker_'.__FUNCTION__]['query_condition']." ORDER BY Position ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			
			
			$result[$i] = array(
			'ID' => $row['ID'],
                        'Agent' => AgentModel::getAgent($row['AgentID'], "Name"),    
			'Content' => $row['Content'],
                        'Position' => $row['Position'],    
                        'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
                
                $result2 = AgentModel::getAdminAgentAllParentChild();
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Announcement Ticker", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'announcementticker_delete' => $_SESSION['admin']['announcementticker_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.announcementticker_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Index"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list1' => $result2['result2'], 'agent_list2' => $result2['result3']),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['announcementticker_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Announcement Ticker", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'announcementticker_add' => $_SESSION['admin']['announcementticker_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.announcementticker_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Announcement Ticker"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['announcementticker_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		
		
		$key = "(AgentID, Content, Position, Enabled)";
		$value = "('".$_POST['AgentID']."', '".$_POST['Content']."', '".$_POST['Position']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO announcement_ticker ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Guide Promotion...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM announcement_ticker WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			
			
			$result[$i] = array(
			'ID' => $row['ID'],
                        'AgentID' => $row['AgentID'], 
			'Content' => $row['Content'],
                        'Position' => $row['Position'],    
                        'Enabled' => $row['Enabled']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Announcement Ticker",
					'template' => 'admin.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php',
					'announcementticker_add' => $_SESSION['admin']['announcementticker_add'], 
                    'announcementticker_edit' => $_SESSION['admin']['announcementticker_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.announcementticker_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Announcement Ticker"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['announcementticker_add']);
		unset($_SESSION['admin']['announcementticker_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		
		
		$sql = "UPDATE announcement_ticker SET Content='".$_POST['Content']."', AgentID='".$_POST['AgentID']."', Position='".$_POST['Position']."', Enabled = '".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
					
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Guide Promotion...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		// Delete Images
        $crud = new CRUD();
        

		// Delete entry from table
		$sql = "DELETE FROM announcement_ticker WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Bank Info...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
        
        public function AgentIndex($param) 
	{
            //error_reporting(1);
            
		// Initialise query conditions
		$query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
                    
			// Reset Query Variable
			$_SESSION['announcementticker_'.__FUNCTION__] = "";
                        
            			
			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=", 1);
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
                        $query_condition .= $crud->queryCondition("Position",$_POST['Position'],"=");
                        $query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
                        
			
                        $_SESSION['announcementticker_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['announcementticker_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
                        $_SESSION['announcementticker_'.__FUNCTION__]['param']['Position'] = $_POST['Position'];
                        $_SESSION['announcementticker_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['announcementticker_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['announcementticker_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['announcementticker_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['announcementticker_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
			$sort = TRUE;
		}
                
                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_SESSION['agent']['ID']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);
                
                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_SESSION['agent']['ID']);
                }
                
                
                $child = implode(',', $_SESSION['agentchild']);
                
                unset($_SESSION['agentchild']);
                
                
                if(isset($_SESSION['announcementticker_'.__FUNCTION__]['param']['AgentID'])===true && empty($_SESSION['announcementticker_'.__FUNCTION__]['param']['AgentID'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND AgentID IN (".$child.")";
                }
                
                

                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM announcement_ticker WHERE TRUE = TRUE ".$query_part." ".$_SESSION['announcementticker_'.__FUNCTION__]['query_condition'];
                    //echo $query_count;
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 

                    $targetpage = $data['config']['SITE_DIR'].'/agent/announcementticker/index';
                    $limit = 10;
                    $stages = 3;
                    $page = mysql_escape_string($_GET['page']);
                    if ($page) {
                            $start = ($page - 1) * $limit; 
                    } else {
                            $start = 0;	
                    }	

                    // Initialize Pagination
                    $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

                    $sql = "SELECT * FROM announcement_ticker WHERE TRUE = TRUE ".$query_part." ".$_SESSION['announcementticker_'.__FUNCTION__]['query_condition']." ORDER BY AgentID ASC LIMIT $start, $limit";
                
                
                     //echo $sql;
                     //exit;
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => AgentModel::getAgent($row['AgentID'] ,"Name"),
			'Content' => $row['Content'],
                        'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
                
                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }

                        $result2['count'] = $z;
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Announcement Ticker", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'announcementticker_delete' => $_SESSION['agent']['announcementticker_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.announcementticker_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Index"),
		'content' => $result,
                'agent' => $result2,   
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['announcementticker_delete']);
					
		return $this->output;
	}
                
        public function AgentAdd() 
	{
            $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                $result2 = array();
                $z = 0;
                $tier = 1;
                foreach ($this->dbconnect->query($sql2) as $row2)
                {
                        $result2[$z] = array(
                                'ID' => $row2['ID'],
                                'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                'Name' => $row2['Name'],
                                'Company' => $row2['Company']);

                        $z += 1;
                }

                $result2['count'] = $z;
            
            
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Announcement Ticker", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/add.inc.php', 'announcementticker_add' => $_SESSION['agent']['announcementticker_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.announcementticker_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"admin",$this->config,"Create Announcement Ticker"),
                'agent' => $result2,   
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['agent']['announcementticker_add']);
					
		return $this->output;
	}

	public function AgentAddProcess()
	{
		
		
		$key = "(AgentID, Content, Position, Enabled)";
		$value = "('".$_POST['AgentID']."', '".$_POST['Content']."', '".$_POST['Position']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO announcement_ticker ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Bank Info...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AgentEdit($param) 
	{
		$sql = "SELECT * FROM announcement_ticker WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Content' => $row['Content'],
                        'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);
			
			$i += 1;
		}
                
                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                $result2 = array();
                $z = 0;
                $tier = 1;
                foreach ($this->dbconnect->query($sql2) as $row2)
                {
                        $result2[$z] = array(
                                'ID' => $row2['ID'],
                                'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                'Name' => $row2['Name'],
                                'Company' => $row2['Company']);

                        $z += 1;
                }

                $result2['count'] = $z;

		$this->output = array( 
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Announcement Ticker",
					'template' => 'agent.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php',
					'announcementticker_add' => $_SESSION['agent']['announcementticker_add'], 
                    'announcementticker_edit' => $_SESSION['agent']['announcementticker_edit']),
                'agent' => $result2,    
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.announcementticker_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"admin",$this->config,"Edit Announcement Ticker"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['announcementticker_add']);
		unset($_SESSION['agent']['announcementticker_edit']);
					
		return $this->output;
	}

	public function AgentEditProcess($param) 
	{
				
		$sql = "UPDATE announcement_ticker SET AgentID='".$_POST['AgentID']."', Content='".$_POST['Content']."', Position='".$_POST['Position']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
                $ok = ($count==1) ? 1 : "";
					
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Bank Info...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AgentDelete($param) 
	{
		
                $crud = new CRUD();


		// Delete entry from table
		$sql = "DELETE FROM announcement_ticker WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Bank Info...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM bank_info ".$_SESSION['bankinfo_'.$param]['query_condition']." ORDER BY ResellerID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Bank_Info";
		$result['header'] = $this->config['SITE_NAME']." | Bank Info (" . date('Y-m-d H:i:s') . ")\n\nID, Reseller, Name, ImageURL, Description";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ResellerModel::getReseller($row['ResellerID'] ,"Name")."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['ImageURL']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Description'])."\"\n";

			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Exporting..."),
		'content' => $result,
		'secure' => TRUE,
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function getBankInfo($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM bank_info WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ResellerID' => $row['ResellerID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'Description' => $row['Description']);
			
			$i += 1;
		}
		
		$result = $result[0]['ProductID'];
		
		return $result;
	}

	public function getBankInfoList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM bank_info ORDER BY ResellerID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ResellerID' => $row['ResellerID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'Description' => $row['Description']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
        
        public function getUniqueBank($Bank, $BankAccountNo) 
	{		
                
		$sql = "SELECT COUNT(*) AS bank_count FROM member WHERE Bank = '".$Bank."' AND BankAccountNo = '".$BankAccountNo."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['bank_count'];
		}
		
		return $result;
	}
        
        public function getAgentBankInfoList($param) 
	{		
              
                $sql2 = "SELECT Agent FROM member WHERE ID = '".$param."'";
		
		foreach ($this->dbconnect->query($sql2) as $row2)
		{
			$agent = $row2['Agent'];
					
		}

		$sql = "SELECT * FROM bank_info WHERE AgentID = '".$agent."' ORDER BY AgentID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'ImageURL' => $this->config['SITE_URL'].$row['ImageURL'],
			'Description' => $row['Description']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
        
        public function getAPIAnnouncementTickerList($param) 
	{		
                      
		$sql = "SELECT * FROM announcement_ticker WHERE Enabled = '1' AND AgentID = '".$param."' ORDER BY Position ASC";
                               		
		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{
						
                        array_push($result, $row['Content']);    
		}
		

		return $result;
	}
        
        public function getAnnouncementTickerList($param) 
	{		
                      
		$sql = "SELECT * FROM announcement_ticker WHERE Enabled = '1' AND AgentID = '".$param."' ORDER BY Position ASC";
                               		
		$result = array();
		$i = 0;

		foreach ($this->dbconnect->query($sql) as $row)
		{
						
                        $result[$i] = $row['Content']; 
                        
                        $i += 1;
		}
                
                $result['count'] = $i;
		

		return $result;
	}
        
        
        public function getAnnouncementTickerListWithoutCounter($param) 
	{		
                      
		$sql = "SELECT * FROM announcement_ticker WHERE Enabled = '1' AND AgentID = '".$param."' ORDER BY Position ASC";
                               		
		$result = '';
                

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$content = "'".$row['Content']."'";
			$result .= $content.',';
                        
                        
            
		}
                
                $result = rtrim($result, ',');
		

		return $result;
	}
        
        public function getBankInfoListByAgent($param) 
	{		
                            
		$sql = "SELECT * FROM bank_info WHERE AgentID = '".$param."' ORDER BY Name ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
                    /*if ($row['ImageURL']=='')
                    {
                            $cover_image = $this->config['THEME_DIR'].'img/no_image.png';
                    }
                    else
                    {
                            $cover_image = Image::getImage($row['ImageURL'],'cover');
                    }*/
                    
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'ImageURL' => $row['ImageURL'],
			'Description' => $row['Description']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
        
        public function getBankInfoListByAgentCount($param) 
	{		
                            
		$sql = "SELECT COUNT(*) AS agentCount FROM bank_info WHERE AgentID = '".$param."' ORDER BY Name ASC";
				
		foreach ($this->dbconnect->query($sql) as $row)
		{
                    
                    
			$result = $row['agentCount'];
			
		}
		

		return $result;
	}
        
        
}
?>