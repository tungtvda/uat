<?php
class OrderStatusModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['orderstatus'] = array(
        'name' => "Order Status",
        'dir' => "modules/orderstatus/",
        'default_url' => "/main/orderstatus/index",
        'admin_url' => "/admin/orderstatus/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM order_status WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_URL'].'/main/orderstatus/index';
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
		
		$sql = "SELECT * FROM order_status WHERE Enabled = 1 ORDER BY ID ASC LIMIT $start, $limit";
		
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

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderstatus']['name'], "Link" => "")
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
		$sql = "SELECT * FROM order_status WHERE ID = '".$param."' ORDER BY ID ASC LIMIT 0, 5";
		
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

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderstatus']['name'], "Link" => $this->module['orderstatus']['default_url']),
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
			$_SESSION['orderstatus_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("Label",$_POST['Label'],"LIKE");
			$query_condition .= $crud->queryCondition("Color",$_POST['Color'],"LIKE");
			$query_condition .= $crud->queryCondition("BGColor",$_POST['BGColor'],"LIKE");
			
			$_SESSION['orderstatus_'.__FUNCTION__]['param']['Label'] = $_POST['Label'];
			$_SESSION['orderstatus_'.__FUNCTION__]['param']['Color'] = $_POST['Color'];
			$_SESSION['orderstatus_'.__FUNCTION__]['param']['BGColor'] = $_POST['BGColor'];
			
			// Set Query Variable
			$_SESSION['orderstatus_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['orderstatus_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['orderstatus_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['orderstatus_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM order_status ".$_SESSION['orderstatus_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/admin/orderstatus/index';
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
		
		$sql = "SELECT * FROM order_status ".$_SESSION['orderstatus_'.__FUNCTION__]['query_condition']." ORDER BY ID ASC LIMIT $start, $limit";
		
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

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderstatus']['name'], "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Order Statuses", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderstatus']['dir'].'inc/admin/index.inc.php', 'orderstatus_delete' => $_SESSION['admin']['orderstatus_delete']),
		'block' => array('side_nav' => $this->module['orderstatus']['dir'].'inc/admin/side_nav.orderstatus_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['orderstatus_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderstatus']['name'], "Link" => $this->module['orderstatus']['admin_url']),
            array("Title" => "Create Order Status", "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Order Status", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderstatus']['dir'].'inc/admin/add.inc.php', 'orderstatus_add' => $_SESSION['admin']['orderstatus_add']),
		'block' => array('side_nav' => $this->module['orderstatus']['dir'].'inc/admin/side_nav.orderstatus_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['orderstatus_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(Label, Color, BGColor)";
		$value = "('".$_POST['Label']."', '".$_POST['Color']."', '".$_POST['BGColor']."')";

		$sql = "INSERT INTO order_status ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Order Status...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM order_status WHERE ID = '".$param."'";
	
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

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderstatus']['name'], "Link" => $this->module['orderstatus']['admin_url']),
            array("Title" => "Edit Order Status", "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Order Status", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderstatus']['dir'].'inc/admin/edit.inc.php', 'orderstatus_add' => $_SESSION['admin']['orderstatus_add'], 'orderstatus_edit' => $_SESSION['admin']['orderstatus_edit']),
		'block' => array('side_nav' => $this->module['orderstatus']['dir'].'inc/admin/side_nav.orderstatus_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['orderstatus_add']);
		unset($_SESSION['admin']['orderstatus_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE order_status SET Label='".$_POST['Label']."', Color='".$_POST['Color']."', BGColor='".$_POST['BGColor']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Order Status...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM order_status WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Order Status...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function getOrderStatus($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM order_status WHERE ID = '".$param."'";
		
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
		
		// $result = "<span class='label label_long' style='background-color:".$result[0]['BGColor']."; color:".$result[0]['Color']."'>".$result[0]['Label']."</span>";
		
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

	public function getOrderStatusList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM order_status ORDER BY ID ASC";
		
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
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM order_status ".$_SESSION['orderstatus_'.$param]['query_condition']." ORDER BY ID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Order_Statuses";
		$result['header'] = $this->config['SITE_NAME']." | Order Statuses (" . date('Y-m-d H:i:s') . ")\n\nID, Label, Color, BG Color";
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
}
?>