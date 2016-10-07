<?php
// Require required models
Core::requireModel('theme');

class TemplateModel extends BaseModel
{
	private $output = array();
    private $module_name = "Template";
	private $module_dir = "modules/template/";
    private $module_default_url = "/main/template/index";
    private $module_default_admin_url = "/admin/template/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM template WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/template/index';
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
		
		$sql = "SELECT * FROM template WHERE Enabled = 1 ORDER BY ThemeID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ThemeID' => $row['ThemeID'],
			'Name' => $row['Name'],
			'Filename' => $row['Filename'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
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
		$sql = "SELECT * FROM template WHERE ID = '".$param."' ORDER BY ThemeID ASC LIMIT 0, 5";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ThemeID' => $row['ThemeID'],
			'Name' => $row['Name'],
			'Filename' => $row['Filename'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
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
			$_SESSION['template_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ThemeID",$_POST['ThemeID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Filename",$_POST['Filename'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['template_'.__FUNCTION__]['param']['ThemeID'] = $_POST['ThemeID'];
			$_SESSION['template_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['template_'.__FUNCTION__]['param']['Filename'] = $_POST['Filename'];
			$_SESSION['template_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['template_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['template_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['template_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['template_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM template ".$_SESSION['template_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/template/index';
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
		
		$sql = "SELECT * FROM template ".$_SESSION['template_'.__FUNCTION__]['query_condition']." ORDER BY ThemeID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ThemeID' => ThemeModel::getTheme($row['ThemeID']),
			'Name' => $row['Name'],
			'Filename' => $row['Filename'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Templates", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'template_delete' => $_SESSION['admin']['template_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.template_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'theme_list' => ThemeModel::getThemeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['template_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Template", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'template_add' => $_SESSION['admin']['template_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.template_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Template"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'theme_list' => ThemeModel::getThemeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['template_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(ThemeID, Name, Filename, Enabled)";
		$value = "('".$_POST['ThemeID']."', '".$_POST['Name']."', '".$_POST['Filename']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO template ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Template...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM template WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ThemeID' => $row['ThemeID'],
			'Name' => $row['Name'],
			'Filename' => $row['Filename'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Template", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'template_add' => $_SESSION['admin']['template_add'], 'template_edit' => $_SESSION['admin']['template_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.template_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Template"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'theme_list' => ThemeModel::getThemeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['template_add']);
		unset($_SESSION['admin']['template_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE template SET ThemeID='".$_POST['ThemeID']."', Name='".$_POST['Name']."', Filename='".$_POST['Filename']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Template...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM template WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Template...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM template ".$_SESSION['template_'.$param]['query_condition']." ORDER BY ThemeID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Template";
		$result['header'] = $this->config['SITE_NAME']." | Template (" . date('Y-m-d H:i:s') . ")\n\nID, Theme, Name, Filename, Enabled";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ThemeModel::getTheme($row['ThemeID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['Filename']."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Enabled'])."\"\n";

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

	public function getTemplate($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM template WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ThemeID' => ThemeModel::getTheme($row['ThemeID']),
			'Name' => $row['Name'],
			'Filename' => $row['Filename'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$result = $result[0]['Name'];
		
		return $result;
	}

	public function getTemplateList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM template ORDER BY Name ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ThemeID' => ThemeModel::getTheme($row['ThemeID']),
			'Name' => $row['Name'],
			'Filename' => $row['Filename'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$result['count'] = $i;
		
		return $result;
	}

	public function getTemplateFilename($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM template WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Filename' => $row['Filename']);
			
			$i += 1;
		}
		
		$result = $result[0]['Filename'];
		
		return $result;
	}
}
?>