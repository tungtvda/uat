<?php
class PageCategoryModel extends BaseModel
{
	private $output = array();
    private $module_name = "Page Category";
	private $module_dir = "modules/pagecategory/";
    private $module_default_url = "/main/pagecategory/index";
    private $module_default_admin_url = "/admin/pagecategory/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM page_category WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_DIR'].'/main/pagecategory/index';
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
		
		$sql = "SELECT * FROM page_category WHERE Enabled = 1 ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => $row['ParentID'],
			'Name' => $row['Name'],
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Page Categories", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM page_category WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => $row['ParentID'],
			'Name' => $row['Name'],
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
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
			$_SESSION['pagecategory_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ParentID",$_POST['ParentID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['pagecategory_'.__FUNCTION__]['param']['ParentID'] = $_POST['ParentID'];
			$_SESSION['pagecategory_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['pagecategory_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['pagecategory_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['pagecategory_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['pagecategory_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['pagecategory_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM page_category ".$_SESSION['pagecategory_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/pagecategory/index';
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
		
		$sql = "SELECT * FROM page_category ".$_SESSION['pagecategory_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => PageCategoryModel::getPageCategory($row['ParentID']),
			'Name' => $row['Name'],
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Page Categories", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'pagecategory_delete' => $_SESSION['admin']['pagecategory_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.pagecategory_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'pagecategory_list' => PageCategoryModel::getPageCategoryList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['pagecategory_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Page Category", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'pagecategory_add' => $_SESSION['admin']['pagecategory_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.pagecategory_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Page Category"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'pagecategory_list' => PageCategoryModel::getPageCategoryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['pagecategory_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(ParentID, Name, Enabled, Position)";
		$value = "('".$_POST['ParentID']."', '".$_POST['Name']."', '".$_POST['Enabled']."', '".$_POST['Position']."')";

		$sql = "INSERT INTO page_category ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Page Category...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM page_category WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => $row['ParentID'],
			'Name' => $row['Name'],
			'Enabled' => $row['Enabled'],
			'Position' => $row['Position']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Page Category", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'pagecategory_add' => $_SESSION['admin']['pagecategory_add'], 'pagecategory_edit' => $_SESSION['admin']['pagecategory_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.pagecategory_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Page Category"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'pagecategory_list' => PageCategoryModel::getPageCategoryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['pagecategory_add']);
		unset($_SESSION['admin']['pagecategory_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE page_category SET ParentID='".$_POST['ParentID']."', Name='".$_POST['Name']."', Enabled='".$_POST['Enabled']."', Position='".$_POST['Position']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Page Category...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM page_category WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Page Category...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminSort() 
    {  
        $param = explode(",",$_POST['param']);
        
        $i = 0;
        foreach($param as $id) 
        {
            $sql = "UPDATE page_category SET Position='".$i."' WHERE ID='".$id."'";
            $count = $this->dbconnect->exec($sql);
            
            $i++;
        }

        $result = $i;
                    
        return $result;
    }
    
    public function AdminPosition() 
    {
        $param = $_POST['param']; 
       
        $crud = new CRUD();

        $sql = "SELECT * FROM page_category WHERE ID = '".$param."'";
        
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Position' => $row['Position']);
            
            $i += 1;
        }
        
        $result = $result[0]['ID'].",".$result[0]['Position'];
        
        return $result;
    }
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM page_category ".$_SESSION['pagecategory_'.$param]['query_condition']." ORDER BY Name ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Page Categories";
		$result['header'] = $this->config['SITE_NAME']." | Page Categories (" . date('Y-m-d H:i:s') . ")\n\nID, Parent, Name, Enabled, Position";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".PageCategoryModel::getPageCategory($row['ParentID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Enabled'])."\",";
			$result['content'] .= "\"".$row['Position']."\"\n";

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

	public function getPageCategory($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM page_category WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			#'ParentID' => PageCategoryModel::getPageCategory($row['ParentID']),
			'Name' => $row['Name'],
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}
		
		$result = $result[0]['Name'];
		
		return $result;
	}

	public function getPageCategoryList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM page_category ORDER BY Name ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => PageCategoryModel::getPageCategory($row['ParentID']),
			'Name' => $row['Name'],
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}
		
		$result['count'] = $i;
		
		return $result;
	}
}
?>