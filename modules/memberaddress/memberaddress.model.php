<?php
// Require required models
Core::requireModel('member');
Core::requireModel('state');
Core::requireModel('country');

class MemberAddressModel extends BaseModel
{
	private $output = array();
    private $module_name = "Address";
	private $module_dir = "modules/memberaddress/";
    private $module_default_url = "/main/memberaddress/index";
    private $module_default_admin_url = "/admin/memberaddress/index";
	private $module_sub_url = "/main/memberaddress/memberindex";
    private $module_sub_admin_url = "/admin/memberaddress/memberindex";
    
    private $parent_module_name = "Member";
    private $parent_module_dir = "modules/member/";
    private $parent_module_default_url = "/main/member/index";
    private $parent_module_default_admin_url = "/admin/member/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM member_address WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/memberaddress/index';
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
		
		$sql = "SELECT * FROM member_address WHERE Enabled = 1 ORDER BY MemberID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
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

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Member Addresses", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM member_address WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
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

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,$result[0]['Title']),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function MemberIndex($param) 
    {
        $crud = new CRUD();

        // Prepare Pagination
        $query_count = "SELECT COUNT(*) AS num FROM member_address WHERE MemberID = '".$_SESSION['member']['ID']."'";
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_DIR'].'/member/memberaddress/index';
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
        
        $sql = "SELECT * FROM member_address WHERE MemberID = '".$_SESSION['member']['ID']."' ORDER BY Title ASC LIMIT $start, $limit";
        
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'MemberID' => $row['MemberID'],
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
        'page' => array('title' => "My Addresses", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/index.inc.php'),
        'block' => array('side_nav' => $this->parent_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"member",$this->config,"My Addresses"),
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
			$_SESSION['memberaddress_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");
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
			
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['Title'] = $_POST['Title'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['Street'] = $_POST['Street'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['City'] = $_POST['City'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['State'] = $_POST['State'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['Country'] = $_POST['Country'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['memberaddress_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['memberaddress_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['memberaddress_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['memberaddress_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['memberaddress_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM member_address ".$_SESSION['memberaddress_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/memberaddress/index';
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
		
		$sql = "SELECT * FROM member_address ".$_SESSION['memberaddress_'.__FUNCTION__]['query_condition']." ORDER BY MemberID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => MemberModel::getMember($row['MemberID']),
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
		'page' => array('title' => "Member Addresses", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'memberaddress_delete' => $_SESSION['admin']['memberaddress_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.memberaddress_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['memberaddress_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Member Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'memberaddress_add' => $_SESSION['admin']['memberaddress_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.memberaddress_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Member Address"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['memberaddress_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(MemberID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
		$value = "('".$_POST['MemberID']."', '".$_POST['Title']."', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO member_address ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Member Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM member_address WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
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
		'page' => array('title' => "Edit Member Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'memberaddress_add' => $_SESSION['admin']['memberaddress_add'], 'memberaddress_edit' => $_SESSION['admin']['memberaddress_edit']),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.memberaddress_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit memberaddress"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['memberaddress_add']);
		unset($_SESSION['admin']['memberaddress_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE member_address SET MemberID='".$_POST['MemberID']."', Title='".$_POST['Title']."', Street='".$_POST['Street']."', Street2='".$_POST['Street2']."', City='".$_POST['City']."', State='".$_POST['State']."', Postcode='".$_POST['Postcode']."', Country='".$_POST['Country']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', Email='".$_POST['Email']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Member Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM member_address WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Member Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminMemberIndex($param) 
	{		
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = MemberModel::getMember($param);
        $item['url'] = "/admin/member/edit/".$param;
           
        // Initialise query conditions
        $query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['memberaddress_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=",1);
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
			
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Title'] = $_POST['Title'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Street'] = $_POST['Street'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['City'] = $_POST['City'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['State'] = $_POST['State'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Country'] = $_POST['Country'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Email'] = $_POST['Email'];
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['query_condition'] = $query_condition;
			$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]); 			
		}

		// Determine Title
		if (isset($_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']])) 
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
		$query_count = "SELECT COUNT(*) AS num FROM member_address WHERE MemberID = '".$item['id']."' ".$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['query_condition'];
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_DIR'].'/admin/memberaddress/memberindex/'.$item['id'];
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
		
		$sql = "SELECT * FROM member_address WHERE MemberID = '".$item['id']."' ".$_SESSION['memberaddress_'.__FUNCTION__.'_'.$item['id']]['query_condition']." ORDER BY Title ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => MemberModel::getMember($row['MemberID']),
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
        'parent' => $item,
		'page' => array('title' => "Addresses", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/memberindex.inc.php', 'memberaddress_memberdelete' => $_SESSION['admin']['memberaddress_memberdelete']),
		'block' => array('side_nav' => $this->parent_module_dir.'inc/admin/side_nav.member.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin", $this->config, "", 2, $item['title'], $item['url'], $this->module_name),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['memberaddress_memberdelete']);
					
		return $this->output;
	}

	public function AdminMemberAdd($param) 
	{
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = MemberModel::getMember($param);
        $item['url'] = "/admin/member/edit/".$param;
		
		$this->output = array( 
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Create Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/memberadd.inc.php', 'memberaddress_memberadd' => $_SESSION['admin']['memberaddress_memberadd']),
		'block' => array('side_nav' => $this->parent_module_dir.'inc/admin/side_nav.member.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin", $this->config, "Create Address", 2, $item['title'], $item['url'], $this->module_name, $this->module_sub_admin_url."/".$item['id']),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['memberaddress_memberadd']);
					
		return $this->output;
	}

	public function AdminMemberAddProcess($param)
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MemberModel::getMember($param[0]);
        $item['url'] = "/admin/member/edit/".$param[0];
		
		$key = "(MemberID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
		$value = "('".$item['id']."', '".$_POST['Title']."', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO member_address ".$key." VALUES ". $value;

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

	public function AdminMemberEdit($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MemberModel::getMember($param[0]);
        $item['url'] = "/admin/member/edit/".$param[0];
        $item['child'] = $param[1];
       
        $sql = "SELECT * FROM member_address WHERE ID = '".$item['child']."' AND MemberID = '".$item['id']."'";	
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
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
		'page' => array('title' => "Edit Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/memberedit.inc.php', 'memberaddress_memberadd' => $_SESSION['admin']['memberaddress_memberadd'], 'memberaddress_memberedit' => $_SESSION['admin']['memberaddress_memberedit']),
        'block' => array('side_nav' => $this->parent_module_dir.'inc/admin/side_nav.member.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin",$this->config,"Edit Address", 2, $item['title'], $item['url'], $this->module_name, $this->module_sub_admin_url."/".$item['id']),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['memberaddress_memberadd']);
		unset($_SESSION['admin']['memberaddress_memberedit']);
					
		return $this->output;
	}

	public function AdminMemberEditProcess($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MemberModel::getMember($param[0]);
        $item['url'] = "/admin/member/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "UPDATE member_address SET Title='".$_POST['Title']."', Street='".$_POST['Street']."', Street2='".$_POST['Street2']."', City='".$_POST['City']."', State='".$_POST['State']."', Postcode='".$_POST['Postcode']."', Country='".$_POST['Country']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', Email='".$_POST['Email']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$item['child']."'";

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
	
	public function AdminMemberDelete($param) 
	{
		$param = explode(",",$param);
        
        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = MemberModel::getMember($param[0]);
        $item['url'] = "/admin/member/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "DELETE FROM member_address WHERE ID = '".$item['child']."'";
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
	
		public function getMemberAddress($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member_address WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
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
		
		$result = $result[0]['Title'];
		
		return $result;
	}

	public function getMemberAddressList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member_address ORDER BY Title ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
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
		$sql = "SELECT * FROM member_address ".$_SESSION['memberaddress_'.$param]['query_condition']." ORDER BY MemberID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Member_Addresses";
		$result['header'] = $this->config['SITE_NAME']." | Member Addresses (" . date('Y-m-d H:i:s') . ")\n\nID, Member, Title, Street, Street 2, City, State, Postcode, Country, Phone No, Fax No, Email, Enabled";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".MemberModel::getMember($row['MemberID'])."\",";
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