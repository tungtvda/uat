<?php
class ConfigModel extends BaseModel
{
	private $output = array();
    private $module_name = "Config";
	private $module_dir = "modules/config/";
    private $module_default_url = "/main/config/index";
    private $module_default_admin_url = "/admin/config/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM config WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_DIR'].'/main/config/index';
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
		
		$sql = "SELECT * FROM config WHERE Enabled = 1 ORDER BY ConfigName ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ConfigName' => $row['ConfigName'],
			'ConfigValue' => $row['ConfigValue']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "What's New", 'template' => 'common.tpl.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM config WHERE ID = '".$param."' ORDER BY ConfigName ASC LIMIT 0, 5";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ConfigName' => $row['ConfigName'],
			'ConfigValue' => $row['ConfigValue']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php'),
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
			$_SESSION['config_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ConfigName",$_POST['ConfigName'],"LIKE");
			$query_condition .= $crud->queryCondition("ConfigValue",$_POST['ConfigValue'],"LIKE");
			
			$_SESSION['config_'.__FUNCTION__]['param']['ConfigName'] = $_POST['ConfigName'];
			$_SESSION['config_'.__FUNCTION__]['param']['ConfigValue'] = $_POST['ConfigValue'];
			
			// Set Query Variable
			$_SESSION['config_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['config_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['config_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['config_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM config ".$_SESSION['config_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/config/index';
		$limit = 100;
		$stages = 3;
		$page = mysql_real_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;	
		}	
		
		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
		
		$sql = "SELECT * FROM config ".$_SESSION['config_'.__FUNCTION__]['query_condition']." ORDER BY ConfigName ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ConfigName' => $row['ConfigName'],
			'ConfigValue' => $row['ConfigValue']);
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Config", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'config_delete' => $_SESSION['admin']['config_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.config_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['config_delete']);
					
		return $this->output;
	}
        
        public function APIConfigList()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

                        $sql = "SELECT * FROM config ORDER BY ConfigName";

			$result = array();
			$i = 0;

			foreach ($this->dbconnect->query($sql) as $row) {

                            $result[$i] = array(
                            'ID' => $row['ID'],
                            'ConfigName' => $row['ConfigName'],
                            'ConfigValue' => $row['ConfigValue']);
			
			    $i += 1;
                        }
		

            $output['Count'] = $i;
            $output['Content'] = $result;

            // Set output
            if ($output['Count']>0)
            {
                $result = json_encode($output);
                $restapi->setResponse('200', 'OK', $result);
            }
            else
            {
                $restapi->setResponse('404', 'Resource Not Found');
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Config", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'config_add' => $_SESSION['admin']['config_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.config_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Config"),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['config_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(ConfigName, ConfigValue)";
		$value = "('".$_POST['ConfigName']."', '".$_POST['ConfigValue']."')";

		$sql = "INSERT INTO config ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Config...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM config WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ConfigName' => $row['ConfigName'],
			'ConfigValue' => $row['ConfigValue']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Config", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'config_add' => $_SESSION['admin']['config_add'], 'config_edit' => $_SESSION['admin']['config_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.config_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Config"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['config_add']);
		unset($_SESSION['admin']['config_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
                if($_POST['ConfigName']=='DEFAULT_LANGUAGE')
                {
                    if($_POST['ConfigValue']=='zh_CN')
                    {  
                        //$_POST['ConfigValue'] = 'zhCN';
                        $_SESSION['admin']['DEFAULT_LANGUAGE'] = 'zhCN';
                    }
                    else
                    {                        
                        $_SESSION['admin']['DEFAULT_LANGUAGE'] = $_POST['ConfigValue'];
                    }    
                    
                }    
            
		$sql = "UPDATE config SET ConfigName='".$_POST['ConfigName']."', ConfigValue='".$_POST['ConfigValue']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Config...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM config WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Config...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function getConfig($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM config WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ConfigName' => $row['ConfigName'],
			'ConfigValue' => $row['ConfigValue']);
			
			$i += 1;
		}
		
		$result = $result[0]['Name'];
		
		return $result;
	}

	public function getConfigList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM config ORDER BY ID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ConfigName' => $row['ConfigName'],
			'ConfigValue' => $row['ConfigValue']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM config ".$_SESSION['config_'.$param]['query_condition']." ORDER BY ConfigName ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Configs";
		$result['header'] = $this->config['SITE_NAME']." | Configs (" . date('Y-m-d H:i:s') . ")\n\nID, Config Name, Config Value";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['ConfigName']."\",";
			$result['content'] .= "\"".$row['ConfigValue']."\"\n";

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

	public function getConfigValue($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM config WHERE ConfigName = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ConfigValue' => $row['ConfigValue']);
			
			$i += 1;
		}
		
		$result = $result[0]['ConfigValue'];
		
		return $result;
	}
        
       
}
?>