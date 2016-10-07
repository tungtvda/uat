<?php
// Require required models
Core::requireModel('product');

class MemberWishlistModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['memberwishlist'] = array(
        'name' => "Member Wishlist",
        'dir' => "modules/memberwishlist/",
        'default_url' => "/main/memberwishlist/index",
        'admin_url' => "/admin/memberwishlist/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM member_wishlist WHERE 1 = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/main/memberwishlist/index';
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
		
		$sql = "SELECT * FROM member_wishlist WHERE 1 = 1 ORDER BY ProductID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProductID' => $row['ProductID'],
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberwishlist']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Member Wishlists", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['memberwishlist']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM member_wishlist WHERE ID = '".$param."' AND 1 = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProductID' => $row['ProductID'],
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberwishlist']['name'], "Link" => $this->module['memberwishlist']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['memberwishlist']['dir'].'inc/main/view.inc.php'),
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
			$_SESSION['memberwishlist_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ProductID",$_POST['ProductID'],"=");
			$query_condition .= $crud->queryCondition("DatePosted",Helper::dateDisplaySQL($_POST['DatePostedFrom']),">=");
			$query_condition .= $crud->queryCondition("DatePosted",Helper::dateDisplaySQL($_POST['DatePostedTo']),"<=");
			
			$_SESSION['memberwishlist_'.__FUNCTION__]['param']['ProductID'] = $_POST['ProductID'];
			$_SESSION['memberwishlist_'.__FUNCTION__]['param']['DatePostedFrom'] = $_POST['DatePostedFrom'];
			$_SESSION['memberwishlist_'.__FUNCTION__]['param']['DatePostedTo'] = $_POST['DatePostedTo'];
			
			// Set Query Variable
			$_SESSION['memberwishlist_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['memberwishlist_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['memberwishlist_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['memberwishlist_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM member_wishlist ".$_SESSION['memberwishlist_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/admin/memberwishlist/index';
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
		
		$sql = "SELECT * FROM member_wishlist ".$_SESSION['memberwishlist_'.__FUNCTION__]['query_condition']." ORDER BY ProductID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProductID' => ProductModel::getProduct($row['ProductID'], "Name"),
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberwishlist']['name'], "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Member Wishlists", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['memberwishlist']['dir'].'inc/admin/index.inc.php', 'memberwishlist_delete' => $_SESSION['admin']['memberwishlist_delete']),
		'block' => array('side_nav' => $this->module['memberwishlist']['dir'].'inc/admin/side_nav.memberwishlist_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['memberwishlist_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberwishlist']['name'], "Link" => $this->module['memberwishlist']['admin_url']),
            array("Title" => "Create Member Wishlist", "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Member Wishlist", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['memberwishlist']['dir'].'inc/admin/add.inc.php', 'memberwishlist_add' => $_SESSION['admin']['memberwishlist_add']),
		'block' => array('side_nav' => $this->module['memberwishlist']['dir'].'inc/admin/side_nav.memberwishlist_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['memberwishlist_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(ProductID, DatePosted)";
		$value = "('".$_POST['ProductID']."', '".Helper::dateDisplaySQL($_POST['DatePosted'])."')";

		$sql = "INSERT INTO member_wishlist ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Member Wishlist...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM member_wishlist WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProductID' => $row['ProductID'],
			'DatePosted' => Helper::dateSQLToDisplay($row['DatePosted']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberwishlist']['name'], "Link" => $this->module['memberwishlist']['admin_url']),
            array("Title" => "Edit Member Wishlist", "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Member Wishlist", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['memberwishlist']['dir'].'inc/admin/edit.inc.php', 'memberwishlist_add' => $_SESSION['admin']['memberwishlist_add'], 'memberwishlist_edit' => $_SESSION['admin']['memberwishlist_edit']),
		'block' => array('side_nav' => $this->module['memberwishlist']['dir'].'inc/admin/side_nav.memberwishlist_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['memberwishlist_add']);
		unset($_SESSION['admin']['memberwishlist_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE member_wishlist SET ProductID='".$_POST['ProductID']."', DatePosted='".Helper::dateDisplaySQL($_POST['DatePosted'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Member Wishlist...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM member_wishlist WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Member Wishlist...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function getMemberWishlist($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member_wishlist WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProductID' => $row['ProductID'],
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']));
			
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

	public function getMemberWishlistList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member_wishlist ORDER BY DatePosted DESC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProductID' => $row['ProductID'],
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']));
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM member_wishlist ".$_SESSION['memberwishlist_'.$param]['query_condition']." ORDER BY ProductID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Member_Wishlist";
		$result['header'] = $this->config['SITE_NAME']." | Member Wishlist (" . date('Y-m-d H:i:s') . ")\n\nID, Product, Date Posted";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ProductModel::getProduct($row['ProductID'])."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DatePosted'])."\"\n";

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