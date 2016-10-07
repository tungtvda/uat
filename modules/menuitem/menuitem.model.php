<?php
// Require required models
Core::requireModel('menu');

class MenuItemModel extends BaseModel
{
	private $output = array();
    private $module_name = "Menu Item";
	private $module_dir = "modules/menuitem/";
    private $module_default_url = "/main/menuitem/index";
    private $module_default_admin_url = "/admin/menuitem/index";
	private $module_sub_url = "/main/menuitem/menuindex";
    private $module_sub_admin_url = "/admin/menuitem/menuindex";
    
    private $parent_module_name = "Menu";
    private $parent_module_dir = "modules/menu/";
    private $parent_module_default_url = "/main/menu/index";
    private $parent_module_default_admin_url = "/admin/menu/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM menu_item WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/menuitem/index';
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
		
		$sql = "SELECT * FROM menu_item WHERE Enabled = 1 ORDER BY Title DESC, ID DESC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MenuID' => $row['MenuID'],
			'ParentID' => $row['ParentID'],
			'Title' => $row['Title'],
			'LinkURL' => $row['LinkURL'],
			'Position' => $row['Position'],
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
		$sql = "SELECT * FROM menu_item WHERE ID = '".$param."' And Enabled=1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MenuID' => $row['MenuID'],
			'ParentID' => $row['ParentID'],
			'Title' => $row['Title'],
			'LinkURL' => $row['LinkURL'],
			'Position' => $row['Position'],
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
			$_SESSION['menuitem_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("MenuID",$_POST['MenuID'],"=");
			$query_condition .= $crud->queryCondition("ParentID",$_POST['ParentID'],"=");
			$query_condition .= $crud->queryCondition("Title",$_POST['Title'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['menuitem_'.__FUNCTION__]['param']['MenuID'] = $_POST['MenuID'];
			$_SESSION['menuitem_'.__FUNCTION__]['param']['ParentID'] = $_POST['ParentID'];
			$_SESSION['menuitem_'.__FUNCTION__]['param']['Title'] = $_POST['Title'];
			$_SESSION['menuitem_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['menuitem_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['menuitem_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['menuitem_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['menuitem_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM menu_item ".$_SESSION['menuitem_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/menuitem/index';
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
		
		$sql = "SELECT * FROM menu_item ".$_SESSION['menuitem_'.__FUNCTION__]['query_condition']." ORDER BY Title DESC, ID DESC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MenuID' => MenuModel::getMenu($row['MenuID']),
			'ParentID' => $row['ParentID'],
			'Title' => $row['Title'],
			'LinkURL' => $row['LinkURL'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Menu Items", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'menuitem_delete' => $_SESSION['admin']['menuitem_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.menuitem_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'menu_list' => MenuModel::getMenuList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['menuitem_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Menu Item", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'menuitem_add' => $_SESSION['admin']['menuitem_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.menuitem_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Menu Item"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'menu_list' => MenuModel::getMenuList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['menuitem_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(MenuID, ParentID, Title, LinkURL, Position, Enabled)";
		$value = "('".$_POST['MenuID']."', '".$_POST['ParentID']."', '".$_POST['Title']."', '".$_POST['LinkURL']."', '".$_POST['Position']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO menu_item ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Menu Item...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM menu_item WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MenuID' => $row['MenuID'],
			'ParentID' => $row['ParentID'],
			'Title' => $row['Title'],
			'LinkURL' => $row['LinkURL'],
			'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Menu Item", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'menuitem_add' => $_SESSION['admin']['menuitem_add'], 'menuitem_edit' => $_SESSION['admin']['menuitem_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.menuitem_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Menu Item"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'menu_list' => MenuModel::getMenuList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['menuitem_add']);
		unset($_SESSION['admin']['menuitem_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE menu_item SET MenuID='".$_POST['MenuID']."', ParentID='".$_POST['ParentID']."', Title='".$_POST['Title']."', LinkURL='".$_POST['LinkURL']."', Position='".$_POST['Position']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Menu Item...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM menu_item WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Menu Item...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminMenuIndex($param) 
	{
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = MenuModel::getMenu($param);
        $item['url'] = "/admin/menu/edit/".$param;
				
		// Initialise query conditions
		$query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['menuitem_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("MenuID",$_POST['MenuID'],"=",1);
			$query_condition .= $crud->queryCondition("ParentID",$_POST['ParentID'],"=");
			$query_condition .= $crud->queryCondition("Title",$_POST['Title'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]['param']['MenuID'] = $_POST['MenuID'];
			$_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]['param']['ParentID'] = $_POST['ParentID'];
			$_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]['param']['Title'] = $_POST['Title'];
			$_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]['query_condition'] = $query_condition;
			$_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]);
		}

		// Determine Title
		if (isset($_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]))
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
		$query_count = "SELECT COUNT(*) AS num FROM menu_item WHERE MenuID = '".$item['id']."' ".$_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/menuitem/menuindex/'.$item['id'];
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
		
		$sql = "SELECT * FROM menu_item WHERE MenuID = '".$item['id']."' ".$_SESSION['menuitem_'.__FUNCTION__.'_'.$item['id']]['query_condition']." ORDER BY Title DESC, ID DESC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MenuID' => $row['MenuID'],
			'ParentID' => $row['ParentID'],
			'Title' => $row['Title'],
			'LinkURL' => $row['LinkURL'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Menu Items", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/menuindex.inc.php', 'menuitem_menudelete' => $_SESSION['admin']['menuitem_menudelete']),
		'block' => array('side_nav' => $this->parent_module_dir.'inc/admin/side_nav.menu.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin", $this->config, "", 2, $item['title'], $item['url'], $this->module_name),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['menuitem_menudelete']);
					
		return $this->output;
	}

	public function AdminMenuAdd($param) 
	{
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = MenuModel::getMenu($param);
        $item['url'] = "/admin/menu/edit/".$param;
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Create Menu Item", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/menuadd.inc.php', 'menuitem_menuadd' => $_SESSION['admin']['menuitem_menuadd']),
		'block' => array('side_nav' => $this->parent_module_dir.'inc/admin/side_nav.menu.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin", $this->config, "Create Menu Item", 2, $item['title'], $item['url'], $this->module_name, $this->module_sub_admin_url."/".$item['id']),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['menuitem_menuadd']);
					
		return $this->output;
	}

	public function AdminMenuAddProcess($param)
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MenuModel::getMenu($param[0]);
        $item['url'] = "/admin/menu/edit/".$param[0];
		
		$key = "(MenuID, ParentID, Title, LinkURL, Position, Enabled)";
		$value = "('".$item['id']."', '".$_POST['ParentID']."', '".$_POST['Title']."', '".$_POST['LinkURL']."', '".$_POST['Position']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO menu_item ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Creating Menu Item...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminMenuEdit($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MenuModel::getMenu($param[0]);
        $item['url'] = "/admin/menu/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "SELECT * FROM menu_item WHERE ID = '".$item['child']."' AND MenuID = '".$item['id']."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MenuID' => $row['MenuID'],
			'ParentID' => $row['ParentID'],
			'Title' => $row['Title'],
			'LinkURL' => $row['LinkURL'],
			'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Edit Menu Item", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/menuedit.inc.php', 'menuitem_menuadd' => $_SESSION['admin']['menuitem_menuadd'], 'menuitem_menuedit' => $_SESSION['admin']['menuitem_menuedit']),
		'block' => array('side_nav' => $this->parent_module_dir.'inc/admin/side_nav.menu.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin",$this->config,"Edit Menu Item", 2, $item['title'], $item['url'], $this->module_name, $this->module_sub_admin_url."/".$item['id']),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['menuitem_menuadd']);
		unset($_SESSION['admin']['menuitem_menuedit']);
					
		return $this->output;
	}

	public function AdminMenuEditProcess($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MenuModel::getMenu($param[0]);
        $item['url'] = "/admin/menu/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "UPDATE menu_item SET ParentID='".$_POST['ParentID']."', Title='".$_POST['Title']."', LinkURL='".$_POST['LinkURL']."', Position='".$_POST['Position']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$item['child']."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
        'current' => array('id' => $item['child']),
		'page' => array('title' => "Editing Menu Item...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminMenuDelete($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MenuModel::getMenu($param[0]);
        $item['url'] = "/admin/menu/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "DELETE FROM menu_item WHERE ID = '".$item['child']."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Deleting Menu Item...", 'template' => 'admin.common.tpl.php'),
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
            $sql = "UPDATE menu_item SET Position='".$i."' WHERE ID='".$id."'";
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

        $sql = "SELECT * FROM menu_item WHERE ID = '".$param."'";
        
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
	
	public function getMenuItem($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM menu_item WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MenuID' => $row['MenuID'],
			'ParentID' => $row['ParentID'],
			'Title' => $row['Title'],
			'LinkURL' => $row['LinkURL'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$result = $result[0]['Title'];
		
		return $result;
	}

	public function getMenuItemList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM menu_item ORDER BY Title DESC, ID DESC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MenuID' => $row['MenuID'],
			'ParentID' => $row['ParentID'],
			'Title' => $row['Title'],
			'LinkURL' => $row['LinkURL'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM menu_item ".$_SESSION['menuitem_'.$param]['query_condition']." ORDER BY Title DESC, ID DESC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Menu Items";
		$result['header'] = $this->config['SITE_NAME']." | Menu Items (" . date('Y-m-d H:i:s') . ")\n\nID, Menu, Parent ID, Title, Link URL, Position, Enabled";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".MenuModel::getMenu($row['MenuID'])."\",";
			$result['content'] .= "\"".$row['ParentID']."\",";
			$result['content'] .= "\"".$row['Title']."\",";
			$result['content'] .= "\"".$row['LinkURL']."\",";
			$result['content'] .= "\"".$row['Position']."\",";
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