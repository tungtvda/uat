<?php
// Require required models
Core::requireModel('merchant');
Core::requireModel('state');
Core::requireModel('country');

class MerchantAddressModel extends BaseModel
{
	private $output = array();
    private $module = array();
	private $module_sub_url = "/main/merchantaddress/merchantindex";
    private $module_sub_admin_url = "/admin/merchantaddress/merchantindex";
    
    private $parent_module_name = "Merchant";
    private $parent_module_dir = "modules/merchant/";
    private $parent_module_default_url = "/main/merchant/index";
    private $parent_module_default_admin_url = "/admin/merchant/index";
	
	public function __construct()
	{
		parent::__construct();

        $this->module['merchantaddress'] = array(
        'name' => "Merchant Address",
        'dir' => "modules/merchantaddress/",
        'default_url' => "/main/merchantaddress/index",
        'admin_url' => "/admin/merchantaddress/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM merchant_address WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/main/merchantaddress/index';
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
		
		$sql = "SELECT * FROM merchant_address WHERE Enabled = 1 ORDER BY MerchantID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'Title' => $row['Title'],
			'Street' => $row['Street'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'State' => $row['State'],
			'Postcode' => $row['Postcode'],
			'Country' => $row['Country'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'Email' => $row['Email'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantaddress']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Merchant Addresses", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantaddress']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM merchant_address WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'Title' => $row['Title'],
			'Street' => $row['Street'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'State' => $row['State'],
			'Postcode' => $row['Postcode'],
			'Country' => $row['Country'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'Email' => $row['Email'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantaddress']['name'], "Link" => $this->module['merchantaddress']['default_url']),
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

	public function MerchantIndex($param) 
    {
        $crud = new CRUD();

        // Prepare Pagination
        $query_count = "SELECT COUNT(*) AS num FROM merchant_address WHERE MerchantID = '".$_SESSION['merchant']['ID']."'";
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_URL'].'/merchant/merchantaddress/index';
        $limit = 2;
        $stages = 3;
        $page = mysql_escape_string($_GET['page']);
        if ($page) {
            $start = ($page - 1) * $limit; 
        } else {
            $start = 0; 
        }   
        
        // Initialize Pagination
        $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
        
        $sql = "SELECT * FROM merchant_address WHERE MerchantID = '".$_SESSION['merchant']['ID']."' ORDER BY Title ASC LIMIT $start, $limit";
        
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'MerchantID' => $row['MerchantID'],
            'Title' => $row['Title'],
            'Street' => $row['Street'],
            'Street2' => $row['Street2'],
            'City' => $row['City'],
            'State' => StateModel::getState($row['State']),
            'Postcode' => $row['Postcode'],
            'Country' => CountryModel::getCountry($row['Country']),
            'PhoneNo' => $row['PhoneNo'],
            'FaxNo' => $row['FaxNo'],
            'Email' => $row['Email'],
            'Enabled' => CRUD::isActive($row['Enabled']));
            
            $i += 1;
        }

        $this->output = array( 
        'config' => $this->config,
        'page' => array('title' => "My Addresses", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantaddress']['dir'].'inc/merchant/index.inc.php'),
        'block' => array('side_nav' => $this->parent_module_dir.'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
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
			$_SESSION['merchantaddress_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=");
			$query_condition .= $crud->queryCondition("Title",$_POST['Title'],"LIKE");
			$query_condition .= $crud->queryCondition("Street",$_POST['Street'],"LIKE");
			$query_condition .= $crud->queryCondition("Street2",$_POST['Street2'],"LIKE");
			$query_condition .= $crud->queryCondition("City",$_POST['City'],"LIKE");
			$query_condition .= $crud->queryCondition("State",$_POST['State'],"LIKE");
			$query_condition .= $crud->queryCondition("Postcode",$_POST['Postcode'],"LIKE");
			$query_condition .= $crud->queryCondition("Country",$_POST['Country'],"LIKE");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("FaxNo",$_POST['FaxNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['Title'] = $_POST['Title'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['Street'] = $_POST['Street'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['City'] = $_POST['City'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['State'] = $_POST['State'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['Country'] = $_POST['Country'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['merchantaddress_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['merchantaddress_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['merchantaddress_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['merchantaddress_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['merchantaddress_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM merchant_address ".$_SESSION['merchantaddress_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/admin/merchantaddress/index';
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
		
		$sql = "SELECT * FROM merchant_address ".$_SESSION['merchantaddress_'.__FUNCTION__]['query_condition']." ORDER BY MerchantID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID'], "Name"),
			'Title' => $row['Title'],
			'Street' => $row['Street'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'State' => StateModel::getState($row['State'], "Name"),
			'Postcode' => $row['Postcode'],
			'Country' => CountryModel::getCountry($row['Country'], "Name"),
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'Email' => $row['Email'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantaddress']['name'], "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Merchant Addresses", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantaddress']['dir'].'inc/admin/index.inc.php', 'merchantaddress_delete' => $_SESSION['admin']['merchantaddress_delete']),
		'block' => array('side_nav' => $this->module['merchantaddress']['dir'].'inc/admin/side_nav.merchantaddress_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantaddress_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantaddress']['name'], "Link" => $this->module['merchantaddress']['admin_url']),
            array("Title" => "Create Merchant Address", "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Merchant Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantaddress']['dir'].'inc/admin/add.inc.php', 'merchantaddress_add' => $_SESSION['admin']['merchantaddress_add']),
		'block' => array('side_nav' => $this->module['merchantaddress']['dir'].'inc/admin/side_nav.merchantaddress_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['merchantaddress_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(MerchantID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
		$value = "('".$_POST['MerchantID']."', '".$_POST['Title']."', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO merchant_address ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Merchant Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM merchant_address WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'Title' => $row['Title'],
			'Street' => $row['Street'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'State' => $row['State'],
			'Postcode' => $row['Postcode'],
			'Country' => $row['Country'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'Email' => $row['Email'],
			'Enabled' => $row['Enabled']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantaddress']['name'], "Link" => $this->module['merchantaddress']['admin_url']),
            array("Title" => "Edit Merchant Address", "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Merchant Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantaddress']['dir'].'inc/admin/edit.inc.php', 'merchantaddress_add' => $_SESSION['admin']['merchantaddress_add'], 'merchantaddress_edit' => $_SESSION['admin']['merchantaddress_edit']),
        'block' => array('side_nav' => $this->module['merchantaddress']['dir'].'inc/admin/side_nav.merchantaddress_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantaddress_add']);
		unset($_SESSION['admin']['merchantaddress_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE merchant_address SET MerchantID='".$_POST['MerchantID']."', Title='".$_POST['Title']."', Street='".$_POST['Street']."', Street2='".$_POST['Street2']."', City='".$_POST['City']."', State='".$_POST['State']."', Postcode='".$_POST['Postcode']."', Country='".$_POST['Country']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', Email='".$_POST['Email']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Merchant Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM merchant_address WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Merchant Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminMerchantIndex($param) 
	{		
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = MerchantModel::getMerchant($param, "Name");
        $item['url'] = "/admin/merchant/edit/".$param;
           
        // Initialise query conditions
        $query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['merchantaddress_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=",1);
			$query_condition .= $crud->queryCondition("Title",$_POST['Title'],"LIKE");
			$query_condition .= $crud->queryCondition("Street",$_POST['Street'],"LIKE");
			$query_condition .= $crud->queryCondition("Street2",$_POST['Street2'],"LIKE");
			$query_condition .= $crud->queryCondition("City",$_POST['City'],"LIKE");
			$query_condition .= $crud->queryCondition("State",$_POST['State'],"LIKE");
			$query_condition .= $crud->queryCondition("Postcode",$_POST['Postcode'],"LIKE");
			$query_condition .= $crud->queryCondition("Country",$_POST['Country'],"LIKE");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("FaxNo",$_POST['FaxNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Title'] = $_POST['Title'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Street'] = $_POST['Street'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['City'] = $_POST['City'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['State'] = $_POST['State'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Country'] = $_POST['Country'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Email'] = $_POST['Email'];
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['query_condition'] = $query_condition;
			$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]); 			
		}

		// Determine Title
		if (isset($_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']])) 
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
		$query_count = "SELECT COUNT(*) AS num FROM merchant_address WHERE MerchantID = '".$item['id']."' ".$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['query_condition'];
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_URL'].'/admin/merchantaddress/merchantindex/'.$item['id'];
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
		
		$sql = "SELECT * FROM merchant_address WHERE MerchantID = '".$item['id']."' ".$_SESSION['merchantaddress_'.__FUNCTION__.'_'.$item['id']]['query_condition']." ORDER BY Title ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID'], "Name"),
			'Title' => $row['Title'],
			'Street' => $row['Street'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'State' => StateModel::getState($row['State'], "Name"),
			'Postcode' => $row['Postcode'],
			'Country' => CountryModel::getCountry($row['Country'], "Name"),
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'Email' => $row['Email'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Addresses", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantaddress']['dir'].'inc/admin/merchantindex.inc.php', 'merchantaddress_merchantdelete' => $_SESSION['admin']['merchantaddress_merchantdelete']),
		'block' => array('side_nav' => $this->parent_module_dir.'inc/admin/side_nav.merchant.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin", $this->config, "", 2, $item['title'], $item['url'], $this->module_name),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantaddress_merchantdelete']);
					
		return $this->output;
	}

	public function AdminMerchantAdd($param) 
	{
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = MerchantModel::getMerchant($param, "Name");
        $item['url'] = "/admin/merchant/edit/".$param;
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Create Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantaddress']['dir'].'inc/admin/merchantadd.inc.php', 'merchantaddress_merchantadd' => $_SESSION['admin']['merchantaddress_merchantadd']),
		'block' => array('side_nav' => $this->parent_module_dir.'inc/admin/side_nav.merchant.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin", $this->config, "Create Address", 2, $item['title'], $item['url'], $this->module_name, $this->module_sub_admin_url."/".$item['id']),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['merchantaddress_merchantadd']);
					
		return $this->output;
	}

	public function AdminMerchantAddProcess($param)
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MerchantModel::getMerchant($param[0]);
        $item['url'] = "/admin/merchant/edit/".$param[0];
		
		$key = "(MerchantID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
		$value = "('".$item['id']."', '".$_POST['Title']."', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO merchant_address ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
        'page' => array('title' => "Creating Address...", 'template' => 'admin.common.tpl.php'),
        'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminMerchantEdit($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MerchantModel::getMerchant($param[0], "Name");
        $item['url'] = "/admin/merchant/edit/".$param[0];
        $item['child'] = $param[1];
       
        $sql = "SELECT * FROM merchant_address WHERE ID = '".$item['child']."' AND MerchantID = '".$item['id']."'";	
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'Title' => $row['Title'],
			'Street' => $row['Street'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'State' => $row['State'],
			'Postcode' => $row['Postcode'],
			'Country' => $row['Country'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'Email' => $row['Email'],
			'Enabled' => $row['Enabled']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Edit Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantaddress']['dir'].'inc/admin/merchantedit.inc.php', 'merchantaddress_merchantadd' => $_SESSION['admin']['merchantaddress_merchantadd'], 'merchantaddress_merchantedit' => $_SESSION['admin']['merchantaddress_merchantedit']),
        'block' => array('side_nav' => $this->parent_module_dir.'inc/admin/side_nav.merchant.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin",$this->config,"Edit Address", 2, $item['title'], $item['url'], $this->module_name, $this->module_sub_admin_url."/".$item['id']),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantaddress_merchantadd']);
		unset($_SESSION['admin']['merchantaddress_merchantedit']);
					
		return $this->output;
	}

	public function AdminMerchantEditProcess($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MerchantModel::getMerchant($param[0]);
        $item['url'] = "/admin/merchant/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "UPDATE merchant_address SET Title='".$_POST['Title']."', Street='".$_POST['Street']."', Street2='".$_POST['Street2']."', City='".$_POST['City']."', State='".$_POST['State']."', Postcode='".$_POST['Postcode']."', Country='".$_POST['Country']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', Email='".$_POST['Email']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$item['child']."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
        'current' => array('id' => $item['child']),
        'page' => array('title' => "Editing Address...", 'template' => 'admin.common.tpl.php'),
        'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminMerchantDelete($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MerchantModel::getMerchant($param[0]);
        $item['url'] = "/admin/merchant/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "DELETE FROM merchant_address WHERE ID = '".$item['child']."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Deleting Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
		public function getMerchantAddress($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM merchant_address WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'Title' => $row['Title'],
			'Street' => $row['Street'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'State' => $row['State'],
			'Postcode' => $row['Postcode'],
			'Country' => $row['Country'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'Email' => $row['Email'],
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

	public function getMerchantAddressList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM merchant_address ORDER BY Title ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'Title' => $row['Title'],
			'Street' => $row['Street'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'State' => $row['State'],
			'Postcode' => $row['Postcode'],
			'Country' => $row['Country'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'Email' => $row['Email'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM merchant_address ".$_SESSION['merchantaddress_'.$param]['query_condition']." ORDER BY MerchantID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Merchant_Addresses";
		$result['header'] = $this->config['SITE_NAME']." | Merchant Addresses (" . date('Y-m-d H:i:s') . ")\n\nID, Merchant, Title, Street, Street 2, City, State, Postcode, Country, Phone No, Fax No, Email, Enabled";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".MerchantModel::getMerchant($row['MerchantID'])."\",";
			$result['content'] .= "\"".$row['Title']."\",";
			$result['content'] .= "\"".$row['Street']."\",";
			$result['content'] .= "\"".$row['Street2']."\",";
			$result['content'] .= "\"".$row['City']."\",";
			$result['content'] .= "\"".StateModel::getState($row['State'])."\",";
			$result['content'] .= "\"".$row['Postcode']."\",";
			$result['content'] .= "\"".CountryModel::getCountry($row['Country'])."\",";
			$result['content'] .= "\"".$row['PhoneNo']."\",";
			$result['content'] .= "\"".$row['FaxNo']."\",";
			$result['content'] .= "\"".$row['Email']."\",";
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