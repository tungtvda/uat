<?php
// Require required models
Core::requireModel('dealer');
Core::requireModel('state');
Core::requireModel('country');

class DealerAddressModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['dealeraddress'] = array(
        'name' => "Dealer Address",
        'dir' => "modules/dealeraddress/",
        'default_url' => "/main/dealeraddress/index",
        'dealer_url' => "/main/dealeraddress/index",
        'admin_url' => "/admin/dealeraddress/index");

        $this->module['dealer'] = array(
        'name' => "Dealer",
        'dir' => "modules/dealer/",
        'default_url' => "/main/dealer/index",
        'dealer_url' => "/dealer/dealer/index",
        'admin_url' => "/admin/dealer/index");
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM dealer_address WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/dealeraddress/index';
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

		$sql = "SELECT * FROM dealer_address WHERE Enabled = 1 ORDER BY DealerID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
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
            array("Title" => $this->module['dealeraddress']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Dealer Addresses", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealeraddress']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM dealer_address WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
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
            array("Title" => $this->module['dealeraddress']['name'], "Link" => $this->module['dealeraddress']['default_url']),
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

	public function dealerIndex($param)
    {
        $crud = new CRUD();

        // Prepare Pagination
        $query_count = "SELECT COUNT(*) AS num FROM dealer_address WHERE dealerID = '".$_SESSION['dealer']['ID']."'";
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

        $targetpage = $data['config']['SITE_URL'].'/dealer/dealeraddress/index';
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

        $sql = "SELECT * FROM dealer_address WHERE dealerID = '".$_SESSION['dealer']['ID']."' ORDER BY Title ASC LIMIT $start, $limit";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'DealerID' => $row['DealerID'],
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

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => "My Address", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "My Addresses", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealeraddress']['dir'].'inc/dealer/index.inc.php'),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
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
			$_SESSION['dealeraddress_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("DealerID",$_POST['DealerID'],"=");
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

			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['DealerID'] = $_POST['DealerID'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['Title'] = $_POST['Title'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['Street'] = $_POST['Street'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['City'] = $_POST['City'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['State'] = $_POST['State'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['Country'] = $_POST['Country'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['dealeraddress_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['dealeraddress_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['dealeraddress_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['dealeraddress_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['dealeraddress_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM dealer_address ".$_SESSION['dealeraddress_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/dealeraddress/index';
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

		$sql = "SELECT * FROM dealer_address ".$_SESSION['dealeraddress_'.__FUNCTION__]['query_condition']." ORDER BY DealerID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => DealerModel::getDealer($row['DealerID'], "Name"),
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

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealeraddress']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Dealer Addresses", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealeraddress']['dir'].'inc/admin/index.inc.php', 'dealeraddress_delete' => $_SESSION['admin']['dealeraddress_delete']),
		'block' => array('side_nav' => $this->module['dealeraddress']['dir'].'inc/admin/side_nav.dealeraddress_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'dealer_list' => DealerModel::getDealerList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['dealeraddress_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealeraddress']['name'], "Link" => $this->module['dealeraddress']['admin_url']),
            array("Title" => "Create Dealer Address", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Dealer Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealeraddress']['dir'].'inc/admin/add.inc.php', 'dealeraddress_add' => $_SESSION['admin']['dealeraddress_add']),
		'block' => array('side_nav' => $this->module['dealeraddress']['dir'].'inc/admin/side_nav.dealeraddress_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'dealer_list' => DealerModel::getDealerList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['dealeraddress_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(DealerID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
		$value = "('".$_POST['DealerID']."', '".$_POST['Title']."', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO dealer_address ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Dealer Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM dealer_address WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
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
            array("Title" => $this->module['dealeraddress']['name'], "Link" => $this->module['dealeraddress']['admin_url']),
            array("Title" => "Edit Dealer Address", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Dealer Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealeraddress']['dir'].'inc/admin/edit.inc.php', 'dealeraddress_add' => $_SESSION['admin']['dealeraddress_add'], 'dealeraddress_edit' => $_SESSION['admin']['dealeraddress_edit']),
        'block' => array('side_nav' => $this->module['dealeraddress']['dir'].'inc/admin/side_nav.dealeraddress_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'dealer_list' => DealerModel::getDealerList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['dealeraddress_add']);
		unset($_SESSION['admin']['dealeraddress_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		$sql = "UPDATE dealer_address SET DealerID='".$_POST['DealerID']."', Title='".$_POST['Title']."', Street='".$_POST['Street']."', Street2='".$_POST['Street2']."', City='".$_POST['City']."', State='".$_POST['State']."', Postcode='".$_POST['Postcode']."', Country='".$_POST['Country']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', Email='".$_POST['Email']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Dealer Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM dealer_address WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Dealer Address...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDealerIndex($param)
	{
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = DealerModel::getDealer($param, "Name");
        $item['url'] = "/admin/dealer/edit/".$param;

        // Initialise query conditions
        $query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['dealeraddress_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("DealerID",$_POST['DealerID'],"=",1);
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

			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['DealerID'] = $_POST['DealerID'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['Title'] = $_POST['Title'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['Street'] = $_POST['Street'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['City'] = $_POST['City'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['State'] = $_POST['State'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['Country'] = $_POST['Country'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['Email'] = $_POST['Email'];
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['query_condition'] = $query_condition;
			$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]);
		}

		// Determine Title
		if (isset($_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]))
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
		$query_count = "SELECT COUNT(*) AS num FROM dealer_address WHERE dealerID = '".$item['id']."' ".$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['query_condition'];
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

        $targetpage = $data['config']['SITE_URL'].'/admin/dealeraddress/dealerindex/'.$item['id'];
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

		$sql = "SELECT * FROM dealer_address WHERE DealerID = '".$item['id']."' ".$_SESSION['dealeraddress_'.__FUNCTION__.'_'.$item['id']]['query_condition']." ORDER BY Title ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => DealerModel::getDealer($row['DealerID'], "Name"),
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
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => "Dealer Address", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Dealer Addresses", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealeraddress']['dir'].'inc/admin/dealerindex.inc.php', 'dealeraddress_dealerdelete' => $_SESSION['admin']['dealeraddress_dealerdelete']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/admin/side_nav.dealer.inc.php'),
        #'breadcrumb' => HTML::getBreadcrumb($this->parent_module_name, $this->parent_module_default_admin_url, "admin", $this->config, "", 2, $item['title'], $item['url'], $this->module_name),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'dealer_list' => DealerModel::getDealerList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['dealeraddress_dealerdelete']);

		return $this->output;
	}

	public function AdminDealerAdd($param)
	{
		// Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = DealerModel::getDealer($param, "Name");
        $item['url'] = "/admin/dealer/edit/".$param;

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => "Create Address", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Create Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealeraddress']['dir'].'inc/admin/dealeradd.inc.php', 'dealeraddress_dealeradd' => $_SESSION['admin']['dealeraddress_dealeradd']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/admin/side_nav.dealer.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'dealer_list' => DealerModel::getDealerList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['dealeraddress_dealeradd']);

		return $this->output;
	}

	public function AdminDealerAddProcess($param)
	{
		$param = explode(",",$param);

        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = DealerModel::getDealer($param[0], "Name");
        $item['url'] = "/admin/dealer/edit/".$param[0];

		$key = "(DealerID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
		$value = "('".$item['id']."', '".$_POST['Title']."', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO dealer_address ".$key." VALUES ". $value;

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

	public function AdminDealerEdit($param)
	{
		$param = explode(",",$param);

        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = DealerModel::getDealer($param[0], "Name");
        $item['url'] = "/admin/dealer/edit/".$param[0];
        $item['child'] = $param[1];

        $sql = "SELECT * FROM dealer_address WHERE ID = '".$item['child']."' AND DealerID = '".$item['id']."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
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
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => "Edit Address", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Edit Address", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealeraddress']['dir'].'inc/admin/dealeredit.inc.php', 'dealeraddress_dealeradd' => $_SESSION['admin']['dealeraddress_dealeradd'], 'dealeraddress_dealeredit' => $_SESSION['admin']['dealeraddress_dealeredit']),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/admin/side_nav.dealer.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'dealer_list' => DealerModel::getDealerList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['dealeraddress_dealeradd']);
		unset($_SESSION['admin']['dealeraddress_dealeredit']);

		return $this->output;
	}

	public function AdminDealerEditProcess($param)
	{
		$param = explode(",",$param);

        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = DealerModel::getDealer($param[0], "Name");
        $item['url'] = "/admin/dealer/edit/".$param[0];
        $item['child'] = $param[1];

		$sql = "UPDATE dealer_address SET Title='".$_POST['Title']."', Street='".$_POST['Street']."', Street2='".$_POST['Street2']."', City='".$_POST['City']."', State='".$_POST['State']."', Postcode='".$_POST['Postcode']."', Country='".$_POST['Country']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', Email='".$_POST['Email']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$item['child']."'";

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

	public function AdminDealerDelete($param)
	{
		$param = explode(",",$param);

        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = DealerModel::getDealer($param[0], "Name");
        $item['url'] = "/admin/dealer/edit/".$param[0];
        $item['child'] = $param[1];

		$sql = "DELETE FROM dealer_address WHERE ID = '".$item['child']."'";
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

	public function getDealerAddress($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM dealer_address WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
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

	public function getDealerAddressList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM dealer_address ORDER BY Title ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
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
		$sql = "SELECT * FROM dealer_address ".$_SESSION['dealeraddress_'.$param]['query_condition']." ORDER BY DealerID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Dealer_Addresses";
		$result['header'] = $this->config['SITE_NAME']." | Dealer Addresses (" . date('Y-m-d H:i:s') . ")\n\nID, Dealer, Title, Street, Street 2, City, State, Postcode, Country, Phone No, Fax No, Email, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".DealerModel::getDealer($row['DealerID'])."\",";
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