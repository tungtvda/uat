<?php
// Require required models
Core::requireModel('order');
Core::requireModel('product');

class OrderItemModel extends BaseModel
{
	private $output = array();
    private $module = array();
	
	public function __construct()
	{
		parent::__construct();

        $this->module['orderitem'] = array(
        'name' => "Order Item",
        'dir' => "modules/orderitem/",
        'default_url' => "/main/orderitem/index",
        'admin_url' => "/admin/orderitem/index");
		
		parent::__construct();

        $this->module['order'] = array(
        'name' => "Order",
        'dir' => "modules/order/",
        'default_url' => "/main/order/index",
        'admin_url' => "/admin/order/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM order_item WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/main/orderitem/index';
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
		
		$sql = "SELECT * FROM order_item WHERE Enabled = 1 ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'OrderID' => $row['OrderID'],
            'ProductID' => $row['ProductID'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'Price' => $row['Price'],
            'Quantity' => $row['Quantity']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderitem']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Order Items", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderitem']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM order_item WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'OrderID' => $row['OrderID'],
            'ProductID' => $row['ProductID'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'Price' => $row['Price'],
            'Quantity' => $row['Quantity']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderitem']['name'], "Link" => $this->module['orderitem']['default_url']),
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
			$_SESSION['orderitem_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("OrderID",$_POST['OrderID'],"=");
			$query_condition .= $crud->queryCondition("ProductID",$_POST['ProductID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Price",$_POST['Price'],"LIKE");
			$query_condition .= $crud->queryCondition("Quantity",$_POST['Quantity'],"=");
			
			$_SESSION['orderitem_'.__FUNCTION__]['param']['OrderID'] = $_POST['OrderID'];
			$_SESSION['orderitem_'.__FUNCTION__]['param']['ProductID'] = $_POST['ProductID'];
			$_SESSION['orderitem_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['orderitem_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['orderitem_'.__FUNCTION__]['param']['Price'] = $_POST['Price'];
			$_SESSION['orderitem_'.__FUNCTION__]['param']['Quantity'] = $_POST['Quantity'];
			
			// Set Query Variable
			$_SESSION['orderitem_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['orderitem_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['orderitem_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['orderitem_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM order_item ".$_SESSION['orderitem_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/admin/orderitem/index';
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
		
		$sql = "SELECT * FROM order_item ".$_SESSION['orderitem_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'OrderID' => OrderModel::getOrder($row['OrderID'], "Subtotal"),
            'ProductID' => ProductModel::getProduct($row['ProductID'], "Name"),
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'Price' => $row['Price'],
            'Quantity' => $row['Quantity']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderitem']['name'], "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Order Items", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderitem']['dir'].'inc/admin/index.inc.php', 'orderitem_delete' => $_SESSION['admin']['orderitem_delete']),
		'block' => array('side_nav' => $this->module['orderitem']['dir'].'inc/admin/side_nav.orderitem_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'order_list' => OrderModel::getOrderList(), 'product_list' => ProductModel::getProductList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['orderitem_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderitem']['name'], "Link" => $this->module['orderitem']['admin_url']),
            array("Title" => "Create Order Item", "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Order Item", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderitem']['dir'].'inc/admin/add.inc.php', 'orderitem_add' => $_SESSION['admin']['orderitem_add']),
		'block' => array('side_nav' => $this->module['orderitem']['dir'].'inc/admin/side_nav.orderitem_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'order_list' => OrderModel::getOrderList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['orderitem_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(OrderID, ProductID, Name, Description, Price, Quantity)";
		$value = "('".$_POST['OrderID']."', '".$_POST['ProductID']."', '".$_POST['Name']."', '".$_POST['Description']."', '".$_POST['Price']."', '".$_POST['Quantity']."')";

		$sql = "INSERT INTO order_item ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Order Item...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM order_item WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'OrderID' => $row['OrderID'],
            'ProductID' => $row['ProductID'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'Price' => $row['Price'],
            'Quantity' => $row['Quantity']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['orderitem']['name'], "Link" => $this->module['orderitem']['admin_url']),
            array("Title" => "Edit Order Item", "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Order Item", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderitem']['dir'].'inc/admin/edit.inc.php', 'orderitem_add' => $_SESSION['admin']['orderitem_add'], 'orderitem_edit' => $_SESSION['admin']['orderitem_edit']),
        'block' => array('side_nav' => $this->module['orderitem']['dir'].'inc/admin/side_nav.orderitem_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'order_list' => OrderModel::getOrderList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['orderitem_add']);
		unset($_SESSION['admin']['orderitem_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE order_item SET OrderID='".$_POST['OrderID']."', ProductID='".$_POST['ProductID']."', Name='".$_POST['Name']."', Description='".$_POST['Description']."', Price='".$_POST['Price']."', Quantity='".$_POST['Quantity']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Order Item...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM order_item WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Order Item...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminOrderIndex($param) 
	{		
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = OrderModel::getOrder($param, "Subtotal");
        $item['url'] = "/admin/order/edit/".$param;
           
        // Initialise query conditions
        $query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['orderitem_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("OrderID",$_POST['OrderID'],"=",1);
			$query_condition .= $crud->queryCondition("ProductID",$_POST['ProductID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Price",$_POST['Price'],"LIKE");
			$query_condition .= $crud->queryCondition("Quantity",$_POST['Quantity'],"=");
			
			$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['param']['OrderID'] = $_POST['OrderID'];
			$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['param']['ProductID'] = $_POST['ProductID'];
			$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['param']['Name'] = $_POST['Name'];
			$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['param']['Description'] = $_POST['Description'];
			$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['param']['Price'] = $_POST['Price'];
			$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['param']['Quantity'] = $_POST['Quantity'];
			
			// Set Query Variable
			$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['query_condition'] = $query_condition;
			$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]); 			
		}

		// Determine Title
		if (isset($_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']])) 
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
		$query_count = "SELECT COUNT(*) AS num FROM order_item WHERE OrderID = '".$item['id']."' ".$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['query_condition'];
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_URL'].'/admin/orderitem/orderindex/'.$item['id'];
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
		
		$sql = "SELECT * FROM order_item WHERE OrderID = '".$item['id']."' ".$_SESSION['orderitem_'.__FUNCTION__.'_'.$item['id']]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'OrderID' => OrderModel::getOrder($row['OrderID']),
            'ProductID' => ProductModel::getProduct($row['ProductID']),
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'Price' => $row['Price'],
            'Quantity' => $row['Quantity']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['order']['name'], "Link" => $this->module['order']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => $this->module['orderitem']['name'], "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Order Items", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderitem']['dir'].'inc/admin/orderindex.inc.php', 'orderitem_orderdelete' => $_SESSION['admin']['orderitem_orderdelete']),
		'block' => array('side_nav' => $this->module['order']['dir'].'inc/admin/side_nav.order.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'order_list' => OrderModel::getOrderList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['orderitem_orderdelete']);
					
		return $this->output;
	}

	public function AdminOrderAdd($param) 
	{
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = OrderModel::getOrder($param, "Subtotal");
        $item['url'] = "/admin/order/edit/".$param;

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['order']['name'], "Link" => $this->module['order']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => "Create Order Item", "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Create Order Item", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderitem']['dir'].'inc/admin/orderadd.inc.php', 'orderitem_orderadd' => $_SESSION['admin']['orderitem_orderadd']),
		'block' => array('side_nav' => $this->module['order']['dir'].'inc/admin/side_nav.order.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'order_list' => OrderModel::getOrderList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['orderitem_orderadd']);
					
		return $this->output;
	}

	public function AdminOrderAddProcess($param)
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = OrderModel::getOrder($param[0]);
        $item['url'] = "/admin/order/edit/".$param[0];
		
		$key = "(OrderID, ProductID, Name, Description, Price, Quantity)";
		$value = "('".$item['id']."', '".$_POST['ProductID']."', '".$_POST['Name']."', '".$_POST['Description']."', '".$_POST['Price']."', '".$_POST['Quantity']."')";

		$sql = "INSERT INTO order_item ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
        'page' => array('title' => "Creating Order Item...", 'template' => 'admin.common.tpl.php'),
        'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminOrderEdit($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = OrderModel::getOrder($param[0], "Subtotal");
        $item['url'] = "/admin/order/edit/".$param[0];
        $item['child'] = $param[1];
       
        $sql = "SELECT * FROM order_item WHERE ID = '".$item['child']."' AND OrderID = '".$item['id']."'";	
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'OrderID' => $row['OrderID'],
            'ProductID' => $row['ProductID'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'Price' => $row['Price'],
            'Quantity' => $row['Quantity']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['order']['name'], "Link" => $this->module['order']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => "Edit Order Item", "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Edit Order Item", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['orderitem']['dir'].'inc/admin/orderedit.inc.php', 'orderitem_orderadd' => $_SESSION['admin']['orderitem_orderadd'], 'orderitem_orderedit' => $_SESSION['admin']['orderitem_orderedit']),
        'block' => array('side_nav' => $this->module['order']['dir'].'inc/admin/side_nav.order.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'order_list' => OrderModel::getOrderList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['orderitem_orderadd']);
		unset($_SESSION['admin']['orderitem_orderedit']);
					
		return $this->output;
	}

	public function AdminOrderEditProcess($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = OrderModel::getOrder($param[0]);
        $item['url'] = "/admin/order/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "UPDATE order_item SET OrderID='".$_POST['OrderID']."', ProductID='".$_POST['ProductID']."', Name='".$_POST['Name']."', Description='".$_POST['Description']."', Price='".$_POST['Price']."', Quantity='".$_POST['Quantity']."' WHERE ID='".$item['child']."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
        'current' => array('id' => $item['child']),
        'page' => array('title' => "Editing Order Item...", 'template' => 'admin.common.tpl.php'),
        'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminOrderDelete($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = OrderModel::getOrder($param[0]);
        $item['url'] = "/admin/order/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "DELETE FROM order_item WHERE ID = '".$item['child']."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Deleting Order Item...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
		public function getOrderItem($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM order_item WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'OrderID' => $row['OrderID'],
            'ProductID' => $row['ProductID'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'Price' => $row['Price'],
            'Quantity' => $row['Quantity']);
			
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

	public function getOrderItemList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM order_item ORDER BY Name ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'OrderID' => $row['OrderID'],
            'ProductID' => $row['ProductID'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'Price' => $row['Price'],
            'Quantity' => $row['Quantity']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM order_item ".$_SESSION['orderitem_'.$param]['query_condition']." ORDER BY OrderID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Order_Item";
		$result['header'] = $this->config['SITE_NAME']." | Order Item (" . date('Y-m-d H:i:s') . ")\n\nID, Order, Product, Name, Description, Price, Quantity";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".OrderModel::getOrder($row['OrderID'])."\",";
			$result['content'] .= "\"".ProductModel::getProduct($row['ProductID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Description'])."\",";
			$result['content'] .= "\"".$row['Price']."\",";
			$result['content'] .= "\"".$row['Quantity']."\"\n";

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