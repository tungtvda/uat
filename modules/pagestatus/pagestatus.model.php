<?php
class PageStatusModel extends BaseModel
{
	private $output = array();
    private $module_name = "Page Status";
	private $module_dir = "modules/pagestatus/";
    private $module_default_url = "/main/pagestatus/index";
    private $module_default_admin_url = "/admin/pagestatus/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM page_status WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/pagestatus/index';
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
		
		$sql = "SELECT * FROM page_status WHERE Enabled = 1 ORDER BY ID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label'],
			'Color' => $row['Color'],
			'BGColor' => $row['BGColor']);
			
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
		$sql = "SELECT * FROM page_status WHERE ID = '".$param."' ORDER BY ID ASC LIMIT 0, 5";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label'],
			'Color' => $row['Color'],
			'BGColor' => $row['BGColor']);
			
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
			$_SESSION['pagestatus_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ID",$_POST['ID'],"=");
			$query_condition .= $crud->queryCondition("Label",$_POST['Label'],"LIKE");
			$query_condition .= $crud->queryCondition("Color",$_POST['Color'],"LIKE");
			$query_condition .= $crud->queryCondition("BGColor",$_POST['BGColor'],"LIKE");
			
			$_SESSION['pagestatus_'.__FUNCTION__]['param']['ID'] = $_POST['ID'];
			$_SESSION['pagestatus_'.__FUNCTION__]['param']['Label'] = $_POST['Label'];
			$_SESSION['pagestatus_'.__FUNCTION__]['param']['Color'] = $_POST['Color'];
			$_SESSION['pagestatus_'.__FUNCTION__]['param']['BGColor'] = $_POST['BGColor'];
			
			// Set Query Variable
			$_SESSION['pagestatus_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['pagestatus_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['pagestatus_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['pagestatus_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM page_status ".$_SESSION['pagestatus_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/pagestatus/index';
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
		
		$sql = "SELECT * FROM page_status ".$_SESSION['pagestatus_'.__FUNCTION__]['query_condition']." ORDER BY ID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label'],
			'Color' => $row['Color'],
			'BGColor' => $row['BGColor']);
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Page Statuses", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'pagestatus_delete' => $_SESSION['admin']['pagestatus_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.pagestatus_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['pagestatus_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Page Status", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'pagestatus_add' => $_SESSION['admin']['pagestatus_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.pagestatus_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Page Status"),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['pagestatus_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(Label, Color, BGColor)";
		$value = "('".$_POST['Label']."', '".$_POST['Color']."', '".$_POST['BGColor']."')";

		$sql = "INSERT INTO page_status ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Page Status...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM page_status WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label'],
			'Color' => $row['Color'],
			'BGColor' => $row['BGColor']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Page Status", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'pagestatus_add' => $_SESSION['admin']['pagestatus_add'], 'pagestatus_edit' => $_SESSION['admin']['pagestatus_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.pagestatus_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Page Status"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['pagestatus_add']);
		unset($_SESSION['admin']['pagestatus_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE page_status SET Label='".$_POST['Label']."', Color='".$_POST['Color']."', BGColor='".$_POST['BGColor']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Page Status...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM page_status WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Page Status...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM page_status ".$_SESSION['pagestatus_'.$param]['query_condition']." ORDER BY ID ASC";
		
		$result = array();
		
		$result['fileLabel'] = $this->config['SITE_Label']."_Page Status";
		$result['header'] = $this->config['SITE_Label']." | Page Status (" . date('Y-m-d H:i:s') . ")\n\nID, Label, Color, BG Color";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['Label']."\",";
			$result['content'] .= "\"".$row['Color']."\"\n";

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

	public function getPageStatus($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM page_status WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label'],
			'Color' => $row['Color'],
			'BGColor' => $row['BGColor']);
			
			$i += 1;
		}
		
		$result = "<span class='label label_long' style='background-color:".$result[0]['BGColor']."; color:".$result[0]['Color']."'>".$result[0]['Label']."</span>";
		
		return $result;
	}

	public function getPageStatusList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM page_status ORDER BY ID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label'],
			'Color' => $row['Color'],
			'BGColor' => $row['BGColor']);
			
			$i += 1;
		}
		
		$result['count'] = $i;
		
		return $result;
	}
}
?>