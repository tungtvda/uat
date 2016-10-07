<?php
// Require required models
Core::requireModel('country');

class StateModel extends BaseModel
{
	private $output = array();
    private $module_name = "State";
	private $module_dir = "modules/state/";
    private $module_default_url = "/main/state/index";
    private $module_default_admin_url = "/admin/state/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM state WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_DIR'].'/main/state/index';
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
		
		$sql = "SELECT * FROM state WHERE Enabled = 1 ORDER BY CountryID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => $row['CountryID'],
			'Name' => $row['Name']);
			
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
		$sql = "SELECT * FROM state WHERE ID = '".$param."' ORDER BY CountryID ASC LIMIT 0, 5";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => $row['CountryID'],
			'Name' => $row['Name']);
			
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
			$_SESSION['state_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("CountryID",$_POST['CountryID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			
			$_SESSION['state_'.__FUNCTION__]['param']['CountryID'] = $_POST['CountryID'];
			$_SESSION['state_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			
			// Set Query Variable
			$_SESSION['state_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['state_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['state_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['state_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM state ".$_SESSION['state_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/state/index';
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
		
		$sql = "SELECT * FROM state ".$_SESSION['state_'.__FUNCTION__]['query_condition']." ORDER BY CountryID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => CountryModel::getCountry($row['CountryID']),
			'Name' => $row['Name']);
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "States", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'state_delete' => $_SESSION['admin']['state_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.state_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['state_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create State", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'state_add' => $_SESSION['admin']['state_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.state_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create State"),
		'content_param' => array('country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['state_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(CountryID, Name)";
		$value = "('".$_POST['CountryID']."', '".$_POST['Name']."')";

		$sql = "INSERT INTO state ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating State...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM state WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => $row['CountryID'],
			'Name' => $row['Name']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit State", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'state_add' => $_SESSION['admin']['state_add'], 'state_edit' => $_SESSION['admin']['state_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.state_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit State"),
		'content' => $result,
		'content_param' => array('count' => $i, 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['state_add']);
		unset($_SESSION['admin']['state_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE state SET CountryID='".$_POST['CountryID']."', Name='".$_POST['Name']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing State...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM state WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting State...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function getState($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM state WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => CountryModel::getCountry($row['CountryID']),
			'Name' => $row['Name']);
			
			$i += 1;
		}
		
		$result = $result[0]['Name'];
		
		return $result;
	}

	public function getStateList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM state ORDER BY ID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => CountryModel::getCountry($row['CountryID']),
			'Name' => $row['Name']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM state ".$_SESSION['state_'.$param]['query_condition']." ORDER BY CountryID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_States";
		$result['header'] = $this->config['SITE_NAME']." | States (" . date('Y-m-d H:i:s') . ")\n\nID, Country, Name";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['CountryID']."\",";
			$result['content'] .= "\"".$row['Name']."\"\n";

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
}
?>