<?php
class DeliveryMethodModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['deliverymethod'] = array(
        'name' => "Delivery Method",
        'dir' => "modules/deliverymethod/",
        'default_url' => "/main/deliverymethod/index",
        'admin_url' => "/admin/deliverymethod/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM delivery_method WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/main/deliverymethod/index';
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
		
		$sql = "SELECT * FROM delivery_method WHERE Enabled = 1 ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['deliverymethod']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "What's New", 'template' => 'common.tpl.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM delivery_method WHERE ID = '".$param."' ORDER BY Name ASC LIMIT 0, 5";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['deliverymethod']['name'], "Link" => $this->module['deliverymethod']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php'),
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
			$_SESSION['deliverymethod_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ID",$_POST['ID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			
			$_SESSION['deliverymethod_'.__FUNCTION__]['param']['ID'] = $_POST['ID'];
			$_SESSION['deliverymethod_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			
			// Set Query Variable
			$_SESSION['deliverymethod_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['deliverymethod_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['deliverymethod_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['deliverymethod_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM delivery_method ".$_SESSION['deliverymethod_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/admin/deliverymethod/index';
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
		
		$sql = "SELECT * FROM delivery_method ".$_SESSION['deliverymethod_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['deliverymethod']['name'], "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Delivery Methods", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['deliverymethod']['dir'].'inc/admin/index.inc.php', 'deliverymethod_delete' => $_SESSION['admin']['deliverymethod_delete']),
		'block' => array('side_nav' => $this->module['deliverymethod']['dir'].'inc/admin/side_nav.deliverymethod_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['deliverymethod_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['deliverymethod']['name'], "Link" => $this->module['deliverymethod']['admin_url']),
            array("Title" => "Create Delivery Method", "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Delivery Method", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['deliverymethod']['dir'].'inc/admin/add.inc.php', 'deliverymethod_add' => $_SESSION['admin']['deliverymethod_add']),
		'block' => array('side_nav' => $this->module['deliverymethod']['dir'].'inc/admin/side_nav.deliverymethod_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['deliverymethod_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(Name)";
		$value = "('".$_POST['Name']."')";

		$sql = "INSERT INTO delivery_method ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Delivery Method...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM delivery_method WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['deliverymethod']['name'], "Link" => $this->module['deliverymethod']['admin_url']),
            array("Title" => "Edit Delivery Method", "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Delivery Method", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['deliverymethod']['dir'].'inc/admin/edit.inc.php', 'deliverymethod_add' => $_SESSION['admin']['deliverymethod_add'], 'deliverymethod_edit' => $_SESSION['admin']['deliverymethod_edit']),
		'block' => array('side_nav' => $this->module['deliverymethod']['dir'].'inc/admin/side_nav.deliverymethod_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['deliverymethod_add']);
		unset($_SESSION['admin']['deliverymethod_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE delivery_method SET Name='".$_POST['Name']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Delivery Method...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM delivery_method WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Delivery Method...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function getDeliveryMethod($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM delivery_method WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name']);
			
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

	public function getDeliveryMethodList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM delivery_method ORDER BY ID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM delivery_method ".$_SESSION['deliverymethod_'.$param]['query_condition']." ORDER BY Name ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Delivery_Methods";
		$result['header'] = $this->config['SITE_NAME']." | Delivery Methods (" . date('Y-m-d H:i:s') . ")\n\nID, Name";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
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