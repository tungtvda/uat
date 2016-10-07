<?php
// Require required models
Core::requireModel('module');
Core::requireModel('profile');

class PermissionModel extends BaseModel
{
	private $output = array();
    private $module_name = "Permission";
	private $module_dir = "modules/permission/";
    private $module_default_url = "/main/permission/index";
    private $module_default_admin_url = "/admin/permission/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM permission WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/permission/index';
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
		
		$sql = "SELECT * FROM permission WHERE Enabled = 1 ORDER BY ProfileID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProfileID' => $row['ProfileID'],
			'ModuleID' => $row['ModuleID'],
			'View' => CRUD::isActive($row['View']),
			'Add' => CRUD::isActive($row['Add']),
			'Edit' => CRUD::isActive($row['Edit']),
			'Delete' => CRUD::isActive($row['Delete']));
			
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
		$sql = "SELECT * FROM permission WHERE ID = '".$param."' ORDER BY ProfileID ASC LIMIT 0, 5";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProfileID' => $row['ProfileID'],
			'ModuleID' => $row['ModuleID'],
			'View' => CRUD::isActive($row['View']),
			'Add' => CRUD::isActive($row['Add']),
			'Edit' => CRUD::isActive($row['Edit']),
			'Delete' => CRUD::isActive($row['Delete']));
			
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

    public function AdminManage($param) 
    {       
        // Initialise query conditions
        $query_condition = "";
        
        $crud = new CRUD();
        
        if ($_POST['Trigger']=='search_form')
        {
            // Reset Query Variable
            $_SESSION['permission_'.__FUNCTION__] = "";
            
            $query_condition .= $crud->queryCondition("p.ProfileID",$_POST['ProfileID'],"=",1);
            $query_condition .= $crud->queryCondition("p.ModuleID",$_POST['ModuleID'],"=");
            $query_condition .= $crud->queryCondition("p.View",$_POST['View'],"=");
            $query_condition .= $crud->queryCondition("p.Add",$_POST['Add'],"=");
            $query_condition .= $crud->queryCondition("p.Edit",$_POST['Edit'],"=");
            $query_condition .= $crud->queryCondition("p.Delete",$_POST['Delete'],"=");
            
            $_SESSION['permission_'.__FUNCTION__]['param']['ProfileID'] = $_POST['ProfileID'];
            $_SESSION['permission_'.__FUNCTION__]['param']['ModuleID'] = $_POST['ModuleID'];
            $_SESSION['permission_'.__FUNCTION__]['param']['View'] = $_POST['View'];
            $_SESSION['permission_'.__FUNCTION__]['param']['Add'] = $_POST['Add'];
            $_SESSION['permission_'.__FUNCTION__]['param']['Edit'] = $_POST['Edit'];
            $_SESSION['permission_'.__FUNCTION__]['param']['Delete'] = $_POST['Delete'];
            
            // Set Query Variable
            $_SESSION['permission_'.__FUNCTION__]['query_condition'] = $query_condition;
            $_SESSION['permission_'.__FUNCTION__]['query_title'] = "Search Results";
        }

        // Reset query conditions
        if ($_GET['page']=="all")
        {
            $_GET['page'] = "";
            unset($_SESSION['permission_'.__FUNCTION__]);           
        }

        // Determine Title
        if (isset($_SESSION['permission_'.__FUNCTION__]))
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
        
        $query_count = "SELECT COUNT(p.ID) AS num FROM permission AS p WHERE 1=1 ".$_SESSION['permission_'.__FUNCTION__]['query_condition'];
        
        /*echo $query_count;
        exit();*/
        
        #echo $query_count;
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_DIR'].'/admin/permission/index';
        $limit = 10000;
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
        
        $sql = "SELECT p.ID AS p_ID, p.ProfileID AS p_ProfileID, p.ModuleID AS p_ModuleID, p.View AS p_View, p.Add AS p_Add, p.Edit AS p_Edit, p.Delete AS p_Delete, m.Name, m.ID FROM permission AS p, module AS m WHERE p.ModuleID = m.ID ".$_SESSION['permission_'.__FUNCTION__]['query_condition']." ORDER BY p.ProfileID ASC, m.Name ASC LIMIT $start, $limit";
        
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['p_ID'],
            'ProfileID' => $row['p_ProfileID'],
            'ProfileIDText' => ProfileModel::getProfile($row['p_ProfileID']),
            'ModuleID' => ModuleModel::getModule($row['p_ModuleID']),
            'View' => $row['p_View'],
            'Add' => $row['p_Add'],
            'Edit' => $row['p_Edit'],
            'Delete' => $row['p_Delete']);
            
            $i += 1;
        }
        
        $this->output = array( 
        'config' => $this->config,
        'page' => array('title' => "Manage Permissions", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/manage.inc.php'),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.permission_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'profile_list' => ProfileModel::getProfileList(), 'module_list' => ModuleModel::getModuleList()),
        'secure' => TRUE,
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
			$_SESSION['permission_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ProfileID",$_POST['ProfileID'],"=");
			$query_condition .= $crud->queryCondition("ModuleID",$_POST['ModuleID'],"=");
			$query_condition .= $crud->queryCondition("View",$_POST['View'],"=");
			$query_condition .= $crud->queryCondition("Add",$_POST['Add'],"=");
			$query_condition .= $crud->queryCondition("Edit",$_POST['Edit'],"=");
			$query_condition .= $crud->queryCondition("Delete",$_POST['Delete'],"=");
			
			$_SESSION['permission_'.__FUNCTION__]['param']['ProfileID'] = $_POST['ProfileID'];
			$_SESSION['permission_'.__FUNCTION__]['param']['ModuleID'] = $_POST['ModuleID'];
			$_SESSION['permission_'.__FUNCTION__]['param']['View'] = $_POST['View'];
			$_SESSION['permission_'.__FUNCTION__]['param']['Add'] = $_POST['Add'];
			$_SESSION['permission_'.__FUNCTION__]['param']['Edit'] = $_POST['Edit'];
			$_SESSION['permission_'.__FUNCTION__]['param']['Delete'] = $_POST['Delete'];
			
			// Set Query Variable
			$_SESSION['permission_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['permission_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['permission_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['permission_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM permission ".$_SESSION['permission_'.__FUNCTION__]['query_condition'];
		#echo $query_count;
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/permission/index';
		$limit = 50;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;	
		}	
		
		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
		
		$sql = "SELECT * FROM permission ".$_SESSION['permission_'.__FUNCTION__]['query_condition']." ORDER BY ProfileID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProfileID' => ProfileModel::getProfile($row['ProfileID']),
			'ModuleID' => ModuleModel::getModule($row['ModuleID']),
			'View' => CRUD::isActive($row['View']),
			'Add' => CRUD::isActive($row['Add']),
			'Edit' => CRUD::isActive($row['Edit']),
			'Delete' => CRUD::isActive($row['Delete']));
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Permissions", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'permission_delete' => $_SESSION['admin']['permission_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.permission_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'profile_list' => ProfileModel::getProfileList(), 'module_list' => ModuleModel::getModuleList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['permission_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Permission", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'permission_add' => $_SESSION['admin']['permission_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.permission_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Permission"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'profile_list' => ProfileModel::getProfileList(), 'module_list' => ModuleModel::getModuleList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['permission_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(ProfileID, ModuleID, View, `Add`, Edit, `Delete`)";
		$value = "('".$_POST['ProfileID']."', '".$_POST['ModuleID']."', '".$_POST['View']."', '".$_POST['Add']."', '".$_POST['Edit']."', '".$_POST['Delete']."')";

		$sql = "INSERT INTO permission ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Permission...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM permission WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProfileID' => $row['ProfileID'],
			'ModuleID' => $row['ModuleID'],
			'View' => $row['View'],
			'Add' => $row['Add'],
			'Edit' => $row['Edit'],
			'Delete' => $row['Delete']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Permission", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'permission_add' => $_SESSION['admin']['permission_add'], 'permission_edit' => $_SESSION['admin']['permission_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.permission_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Permission"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'profile_list' => ProfileModel::getProfileList(), 'module_list' => ModuleModel::getModuleList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['permission_add']);
		unset($_SESSION['admin']['permission_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE permission SET ProfileID='".$_POST['ProfileID']."', ModuleID='".$_POST['ModuleID']."', View='".$_POST['View']."', `Add`='".$_POST['Add']."', Edit='".$_POST['Edit']."', `Delete`='".$_POST['Delete']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Permission...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM permission WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Permission...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

    public function AdminBulkUpdate() 
    {
        foreach($_POST["permission"] as $key => $value)
        {
            // Set Profile Restrictions
            
            // Administrator
            if ($value[0]==1)
            {
                // Do nothing - no permission changes allowed for Administrators
            }
            else // Non-Administrator
            {
                $value[1]==1 ? $view=1 : $view=0;
                $value[2]==1 ? $add=1 : $add=0;
                $value[3]==1 ? $edit=1 : $edit=0;
                $value[4]==1 ? $delete=1 : $delete=0;
                
                $sql = "UPDATE permission SET View='".$view."', `Add`='".$add."', Edit='".$edit."', `Delete`='".$delete."' WHERE ID='".$key."'";
                
                $this->dbconnect->exec($sql);
            }
        }
    }

	public function accessCheck($controller,$mode) 
	{
		// Get Module
		$moduleID = ModuleModel::getModuleID($controller);
		
		$sql = "SELECT * FROM permission WHERE ModuleID = '".$moduleID."' AND ProfileID = '".$_SESSION['admin']['Profile']."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProfileID' => $row['ProfileID'],
			'ModuleID' => $row['ModuleID'],
			'View' => $row['View'],
			'Add' => $row['Add'],
			'Edit' => $row['Edit'],
			'Delete' => $row['Delete']);
			
			$i += 1;
		}
		
		switch ($mode)
		{
			case 1:
				$result = $result[0]['View'];
				break;
			case 2:
				$result = $result[0]['Add'];
				break;
			case 3:
				$result = $result[0]['Edit'];
				break;
			case 4:
				$result = $result[0]['Delete'];
				break;
			default:
				echo "No result found.";
		}
					
		// Set Status
        $ok = ($result==1) ? 1 : "";
        
        if ($result!=1)
        {
            $error['count'] = 1;
            $error['Permission'] = "Denied";
        }
        
        $this->output = array( 
        'status' => array('ok' => $ok, 'error' => $error));
                    
        return $this->output;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM permission ".$_SESSION['permission_'.$param]['query_condition']." ORDER BY ProfileID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Permissions";
		$result['header'] = $this->config['SITE_NAME']." | Permissions (" . date('Y-m-d H:i:s') . ")\n\nID, Profile, Module, View, Add, Edit, Delete";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ProfileModel::getProfile($row['ProfileID'])."\",";
			$result['content'] .= "\"".ModuleModel::getModule($row['ModuleID'])."\",";
			$result['content'] .= "\"".CRUD::isActive($row['View'])."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Add'])."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Edit'])."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Delete'])."\"\n";

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

	public function getPermission($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM permission WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProfileID' => $row['ProfileID'],
			'ModuleID' => $row['ModuleID'],
			'View' => $row['View'],
			'Add' => $row['Add'],
			'Edit' => $row['Edit'],
			'Delete' => $row['Delete']);
			
			$i += 1;
		}
		
		$result = $result[0]['ProfileID'];
		
		return $result;
	}

	public function getPermissionList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM permission ORDER BY ProfileID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProfileID' => $row['ProfileID'],
			'ModuleID' => $row['ModuleID'],
			'View' => $row['View'],
			'Add' => $row['Add'],
			'Edit' => $row['Edit'],
			'Delete' => $row['Delete']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
}
?>