<?php
// Require required models
Core::requireModel('module');

class MetaDataModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['metadata'] = array(
        'name' => "Meta Data",
        'dir' => "modules/metadata/",
        'default_url' => "/main/metadata/index",
        'admin_url' => "/admin/metadata/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM meta_data WHERE 1 = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/main/metadata/index';
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
		
		$sql = "SELECT * FROM meta_data WHERE 1 = 1 ORDER BY ModuleID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'Section' => $row['Section'],
			'Controller' => $row['Controller'],
			'Action' => $row['Action'],
			'Key' => $row['Key'],
			'Value' => $row['Value']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['metadata']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Meta Datas", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['metadata']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM meta_data WHERE ID = '".$param."' AND 1 = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'Section' => $row['Section'],
			'Controller' => $row['Controller'],
			'Action' => $row['Action'],
			'Key' => $row['Key'],
			'Value' => $row['Value']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['metadata']['name'], "Link" => $this->module['metadata']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['metadata']['dir'].'inc/main/view.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
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
			$_SESSION['metadata_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ModuleID",$_POST['ModuleID'],"=");
			$query_condition .= $crud->queryCondition("Section",$_POST['Section'],"LIKE");
			$query_condition .= $crud->queryCondition("Controller",$_POST['Controller'],"LIKE");
			$query_condition .= $crud->queryCondition("Action",$_POST['Action'],"LIKE");
			$query_condition .= $crud->queryCondition("Key",$_POST['Key'],"LIKE");
			$query_condition .= $crud->queryCondition("Value",$_POST['Value'],"LIKE");
			
			$_SESSION['metadata_'.__FUNCTION__]['param']['ModuleID'] = $_POST['ModuleID'];
			$_SESSION['metadata_'.__FUNCTION__]['param']['Section'] = $_POST['Section'];
			$_SESSION['metadata_'.__FUNCTION__]['param']['Controller'] = $_POST['Controller'];
			$_SESSION['metadata_'.__FUNCTION__]['param']['Action'] = $_POST['Action'];
			$_SESSION['metadata_'.__FUNCTION__]['param']['Key'] = $_POST['Key'];
			$_SESSION['metadata_'.__FUNCTION__]['param']['Value'] = $_POST['Value'];
			
			// Set Query Variable
			$_SESSION['metadata_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['metadata_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['metadata_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['metadata_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM meta_data ".$_SESSION['metadata_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/admin/metadata/index';
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
		
		$sql = "SELECT * FROM meta_data ".$_SESSION['metadata_'.__FUNCTION__]['query_condition']." ORDER BY ModuleID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => ModuleModel::getModule($row['ModuleID'], "Name"),
			'Section' => $row['Section'],
			'Controller' => $row['Controller'],
			'Action' => $row['Action'],
			'Key' => $row['Key'],
			'Value' => $row['Value']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['metadata']['name'], "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Meta Datas", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['metadata']['dir'].'inc/admin/index.inc.php', 'metadata_delete' => $_SESSION['admin']['metadata_delete']),
		'block' => array('side_nav' => $this->module['metadata']['dir'].'inc/admin/side_nav.metadata_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'module_list' => ModuleModel::getModuleList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['metadata_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['metadata']['name'], "Link" => $this->module['metadata']['admin_url']),
            array("Title" => "Create Meta Data", "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Meta Data", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['metadata']['dir'].'inc/admin/add.inc.php', 'metadata_add' => $_SESSION['admin']['metadata_add']),
		'block' => array('side_nav' => $this->module['metadata']['dir'].'inc/admin/side_nav.metadata_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'module_list' => ModuleModel::getModuleList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['metadata_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(ModuleID, Section, Controller, Action, Key, Value)";
		$value = "('".$_POST['ModuleID']."', '".$_POST['Section']."', '".$_POST['Controller']."', '".$_POST['Action']."', '".$_POST['Key']."', '".$_POST['Value']."')";

		$sql = "INSERT INTO meta_data ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Meta Data...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM meta_data WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'Section' => $row['Section'],
			'Controller' => $row['Controller'],
			'Action' => $row['Action'],
			'Key' => $row['Key'],
			'Value' => $row['Value']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['metadata']['name'], "Link" => $this->module['metadata']['admin_url']),
            array("Title" => "Edit Meta Data", "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Meta Data", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['metadata']['dir'].'inc/admin/edit.inc.php', 'metadata_add' => $_SESSION['admin']['metadata_add'], 'metadata_edit' => $_SESSION['admin']['metadata_edit']),
		'block' => array('side_nav' => $this->module['metadata']['dir'].'inc/admin/side_nav.metadata_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'module_list' => ModuleModel::getModuleList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['metadata_add']);
		unset($_SESSION['admin']['metadata_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE meta_data SET ModuleID='".$_POST['ModuleID']."', Section='".$_POST['Section']."', Controller='".$_POST['Controller']."', Action='".$_POST['Action']."', Key='".$_POST['Key']."', Value='".$_POST['Value']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Meta Data...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM meta_data WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Meta Data...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function getMetaData($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM meta_data WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'Section' => $row['Section'],
			'Controller' => $row['Controller'],
			'Action' => $row['Action'],
			'Key' => $row['Key'],
			'Value' => $row['Value']);
			
			$i += 1;
		}
		
		// Determine if get all fields or one specific field
        if ($column!="")
        {
            $result = $result[0][$column];
        }
        else
        {
            $result = $result[0];
        }

		return $result;
	}

	public function getMetaDataList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM meta_data ORDER BY ModuleID DESC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'Section' => $row['Section'],
			'Controller' => $row['Controller'],
			'Action' => $row['Action'],
			'Key' => $row['Key'],
			'Value' => $row['Value']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM meta_data ".$_SESSION['metadata_'.$param]['query_condition']." ORDER BY ModuleID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Meta_Data";
		$result['header'] = $this->config['SITE_NAME']." | Meta Data (" . date('Y-m-d H:i:s') . ")\n\nID, Module, Section, Controller, Action, Key, Value";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ModuleModel::getModule($row['ModuleID'])."\",";
			$result['content'] .= "\"".$row['Section']."\",";
			$result['content'] .= "\"".$row['Controller']."\",";
			$result['content'] .= "\"".$row['Action']."\",";
			$result['content'] .= "\"".$row['Key']."\",";
			$result['content'] .= "\"".$row['Value']."\"\n";

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