<?php
class LanguageModel extends BaseModel
{
	private $output = array();
        //private $module = array();
        private $module_name = "Language";
	private $module_dir = "modules/language/";
        private $module_default_url = "/main/language/index";
        private $module_default_admin_url = "/admin/language/index";
        private $module_default_member_url = "/member/language/index";

	public function __construct()
	{
		parent::__construct();

        /*$this->module['language'] = array(
        'name' => "Language",
        'dir' => "modules/language/",
        'default_url' => "/main/language/index",
        'admin_url' => "/admin/language/index");*/
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM language WHERE 1 = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/language/index';
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
		
		$sql = "SELECT * FROM language WHERE 1 = 1 ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Display' => $row['Display'],
			'Code' => $row['Code'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['language']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Languages", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['language']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['language']['dir'].'meta/main/index.inc.php'));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM language WHERE ID = '".$param."' AND 1 = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Display' => $row['Display'],
			'Code' => $row['Code'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['language']['name'], "Link" => $this->module['language']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['language']['dir'].'inc/main/view.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['language']['dir'].'meta/main/view.inc.php'));
					
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
			$_SESSION['language_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Display",$_POST['Display'],"LIKE");
			$query_condition .= $crud->queryCondition("Code",$_POST['Code'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['language_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['language_'.__FUNCTION__]['param']['Display'] = $_POST['Display'];
			$_SESSION['language_'.__FUNCTION__]['param']['Code'] = $_POST['Code'];
			$_SESSION['language_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['language_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['language_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['language_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['language_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM language ".$_SESSION['language_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/language/index';
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
		
		$sql = "SELECT * FROM language ".$_SESSION['language_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Display' => $row['Display'],
			'Code' => $row['Code'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['language']['name'], "Link" => "")
        );*/
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Languages", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'language_delete' => $_SESSION['admin']['language_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.language_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['language_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['language']['name'], "Link" => $this->module['language']['admin_url']),
            array("Title" => "Create Language", "Link" => "")
        );*/
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Language", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'language_add' => $_SESSION['admin']['language_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.language_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Language"),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['language_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(Name, Display, Code, Enabled)";
		$value = "('".$_POST['Name']."', '".$_POST['Display']."', '".$_POST['Code']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO language ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Language...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM language WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Display' => $row['Display'],
			'Code' => $row['Code'],
			'Enabled' => $row['Enabled']);
			
			$i += 1;
		}

        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['language']['name'], "Link" => $this->module['language']['admin_url']),
            array("Title" => "Edit Language", "Link" => "")
        );*/

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Language", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'language_add' => $_SESSION['admin']['language_add'], 'language_edit' => $_SESSION['admin']['language_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.language_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Language"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['language_add']);
		unset($_SESSION['admin']['language_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE language SET Name='".$_POST['Name']."', Display='".$_POST['Display']."', Code='".$_POST['Code']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Language...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM language WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Language...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function getLanguage($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM language WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Display' => $row['Display'],
			'Code' => $row['Code'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
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
        
        public function getLanguageID($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM language WHERE Code = '".$param."'";
		
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['ID'];
						
		}
		
		

		return $result;
	}

	public function getLanguageList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM language ORDER BY Name DESC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Display' => $row['Display'],
			'Code' => $row['Code'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM language ".$_SESSION['language_'.$param]['query_condition']." ORDER BY Name ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Language";
		$result['header'] = $this->config['SITE_NAME']." | Language (" . date('Y-m-d H:i:s') . ")\n\nID, Name, Display, Code, Enabled";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['Display']."\",";
			$result['content'] .= "\"".$row['Code']."\",";
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
}
?>