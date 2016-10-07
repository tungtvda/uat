<?php
// Require required models
Core::requireModel('member');
Core::requireModel('listing');
Core::requireModel('dealer');
Core::requireModel('merchant');
Core::requireModel('bookingstatus');

class BookingModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['booking'] = array(
        'name' => "Booking",
        'dir' => "modules/booking/",
        'default_url' => "/main/booking/index",
        'admin_url' => "/admin/booking/index",
		'merchant_url' => "/merchant/booking/index",
		'dealer_url' => "/dealer/booking/index");
		
		$this->module['merchant'] = array(
        'name' => "Merchant",
        'dir' => "modules/merchant/",
        'default_url' => "/merchant/merchant/index",
        'admin_url' => "/admin/merchant/index");
		
		$this->module['dealer'] = array(
        'name' => "Dealer",
        'dir' => "modules/dealer/",
        'default_url' => "/main/dealer/index",
        'dealer_url' => "/dealer/dealer/index",
        'admin_url' => "/admin/dealer/index");

        $this->module['listing'] = array(
        'name' => "Listing",
        'dir' => "modules/listing/",
        'default_url' => "/main/listing/index",
        'admin_url' => "/admin/listing/index");
		
	}

	public function Index($param)
	{
		/*echo $param;
		exit;*/
		//if($param !=""){	
		$passcode = BookingModel::getBookingByListing($param, "PassCode");
		//$passcode = "12345678";
		$passcode = Secure::mcDecrypt($passcode, "aseanfnb");
		/*echo $passcode;
		exit;*/
		
		/*if(){
			
		}*/
		/*echo $passcode.' ';
		echo $_POST['PassCode'];*/
		
		if($_POST['PassCode'] =="" && !isset($_SESSION['passcode'])){
			
			$_SESSION['passcode'] = "";
			
		}elseif(isset($_SESSION['passcode'])){
			
			
			
		}
		
		
		if($passcode == $_POST['PassCode']){
			/*echo 'ok';*/
			
		$_SESSION['passcode'] = Secure::mcEncrypt($_POST['PassCode'], "aseanfnb");
		
		}
		
		/*echo $_SESSION['passcode'];
		exit;*/
	    //}
		
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['booking_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Pax",$_POST['Pax'],"=");
			$query_condition .= $crud->queryCondition("Remarks",$_POST['Remarks'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"=");
			$query_condition .= $crud->queryCondition("DateBooked",Helper::dateDisplaySQL($_POST['DateBookedFrom']),">=");
			$query_condition .= $crud->queryCondition("DateBooked",Helper::dateDisplaySQL($_POST['DateBookedTo']),"<=");
			$query_condition .= $crud->queryCondition("DateArrival",Helper::dateDisplaySQL($_POST['DateArrivalFrom']),">=");
			$query_condition .= $crud->queryCondition("DateArrival",Helper::dateDisplaySQL($_POST['DateArrivalTo']),"<=");

			$_SESSION['booking_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['booking_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['booking_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Pax'] = $_POST['Pax'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Remarks'] = $_POST['Remarks'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedFrom'] = $_POST['DateBookedFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedTo'] = $_POST['DateBookedTo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalFrom'] = $_POST['DateArrivalFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalTo'] = $_POST['DateArrivalTo'];

			// Set Query Variable
			$_SESSION['booking_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['booking_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['booking_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['booking_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM booking ".$_SESSION['booking_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/booking/index/'.$param;
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

		$sql = "SELECT * FROM booking ".$_SESSION['booking_'.__FUNCTION__]['query_condition']." ORDER BY MemberID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => MemberModel::getMember($row['MemberID'], "Name"),
			'ListingID' => ListingModel::getListing($row['ListingID'], "Name"),
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'ListingID' => BookingStatusModel::getBookingStatus($row['Status'], "Label"),
			'DateBooked' => Helper::dateSQLToLongDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateSQLToLongDisplay($row['DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['booking']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bookings", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/main/index.inc.php', 'passcode' => $_SESSION['passcode']),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'block' => array('common' => "false"),
		'content' => $result,
		'listingID' => $param,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'sort' => $sort),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM booking WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'Status' => $row['Status'],
			'DateBooked' => Helper::dateSQLToLongDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateSQLToLongDisplay($row['DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['booking']['name'], "Link" => $this->module['booking']['default_url']),
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

	public function Logout($param)
	{
        

		$this->output = array(
		'config' => $this->config,
		/*'page' => array('title' => "Create Booking", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/dealer/add.inc.php', 'booking_add' => $_SESSION['dealer']['booking_add']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList()),*/
		'secure' => TRUE,
		'listingID' => $param,
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
			$_SESSION['booking_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Pax",$_POST['Pax'],"=");
			$query_condition .= $crud->queryCondition("Remarks",$_POST['Remarks'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"=");
			$query_condition .= $crud->queryCondition("DateBooked",Helper::dateTimeDisplaySQL($_POST['DateBookedFrom']),">=");
			$query_condition .= $crud->queryCondition("DateBooked",Helper::dateTimeDisplaySQL($_POST['DateBookedTo']),"<=");
			$query_condition .= $crud->queryCondition("DateArrival",Helper::dateTimeDisplaySQL($_POST['DateArrivalFrom']),">=");
			$query_condition .= $crud->queryCondition("DateArrival",Helper::dateTimeDisplaySQL($_POST['DateArrivalTo']),"<=");

			$_SESSION['booking_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['booking_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['booking_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Pax'] = $_POST['Pax'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Remarks'] = $_POST['Remarks'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedFrom'] = $_POST['DateBookedFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedTo'] = $_POST['DateBookedTo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalFrom'] = $_POST['DateArrivalFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalTo'] = $_POST['DateArrivalTo'];

			// Set Query Variable
			$_SESSION['booking_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['booking_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['booking_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['booking_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM booking ".$_SESSION['booking_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/booking/index';
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

		$sql = "SELECT * FROM booking ".$_SESSION['booking_'.__FUNCTION__]['query_condition']." ORDER BY MemberID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => MemberModel::getMember($row['MemberID'], "Name"),
			'ListingID' => ListingModel::getListing($row['ListingID'], "Name"),
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'Status' => BookingStatusModel::getBookingStatus($row['Status'], "Label"),
			'DateBooked' => Helper::dateTimeSQLToLongDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateTimeSQLToLongDisplay($row['DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['booking']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bookings", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/admin/index.inc.php', 'booking_delete' => $_SESSION['admin']['booking_delete']),
		'block' => array('side_nav' => $this->module['booking']['dir'].'inc/admin/side_nav.booking_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'bookingstatus_list' => BookingStatusModel::getBookingStatusList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['booking_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['booking']['name'], "Link" => $this->module['booking']['admin_url']),
            array("Title" => "Create Booking", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Booking", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/admin/add.inc.php', 'booking_add' => $_SESSION['admin']['booking_add']),
		'block' => array('side_nav' => $this->module['booking']['dir'].'inc/admin/side_nav.booking_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'bookingstatus_list' => BookingStatusModel::getBookingStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['booking_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(MemberID, ListingID, Name, MobileNo, Pax, Remarks, Status, DateBooked, DateArrival)";
		$value = "('".$_POST['MemberID']."', '".$_POST['ListingID']."', '".$_POST['Name']."', '".$_POST['MobileNo']."', '".$_POST['Pax']."', '".$_POST['Remarks']."', '".$_POST['Status']."', '".Helper::dateDisplaySQL($_POST['DateBooked'])."', '".Helper::dateTimeDisplaySQL($_POST['DateArrival'])."')";

		$sql = "INSERT INTO booking ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Booking...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM booking WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'Status' => $row['Status'],
			'DateBooked' => Helper::dateTimeSQLToDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateTimeSQLToDisplay($row['DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['booking']['name'], "Link" => $this->module['booking']['admin_url']),
            array("Title" => "Edit Booking", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Booking", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/admin/edit.inc.php', 'booking_add' => $_SESSION['admin']['booking_add'], 'booking_edit' => $_SESSION['admin']['booking_edit']),
        'block' => array('side_nav' => $this->module['booking']['dir'].'inc/admin/side_nav.booking_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'bookingstatus_list' => BookingStatusModel::getBookingStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['booking_add']);
		unset($_SESSION['admin']['booking_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		$sql = "UPDATE booking SET MemberID='".$_POST['MemberID']."', ListingID='".$_POST['ListingID']."', Name='".$_POST['Name']."', MobileNo='".$_POST['MobileNo']."', Pax='".$_POST['Pax']."', Remarks='".$_POST['Remarks']."', Status='".$_POST['Status']."', DateBooked='".Helper::dateTimeDisplaySQL($_POST['DateBooked'])."', DateArrival='".Helper::dateTimeDisplaySQL($_POST['DateArrival'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Booking...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM booking WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Booking...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminListingIndex($param)
	{
        // Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = ListingModel::getListing($param, "Name");
        $item['url'] = "/admin/listing/edit/".$param;
        
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['booking_'.__FUNCTION__.'_'.$item['id']] = "";

			$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=",1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Pax",$_POST['Pax'],"=");
			$query_condition .= $crud->queryCondition("Remarks",$_POST['Remarks'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"=");
			$query_condition .= $crud->queryCondition("DateBooked",Helper::dateTimeDisplaySQL($_POST['DateBookedFrom']),">=");
			$query_condition .= $crud->queryCondition("DateBooked",Helper::dateTimeDisplaySQL($_POST['DateBookedTo']),"<=");
			$query_condition .= $crud->queryCondition("DateArrival",Helper::dateTimeDisplaySQL($_POST['DateArrivalFrom']),">=");
			$query_condition .= $crud->queryCondition("DateArrival",Helper::dateTimeDisplaySQL($_POST['DateArrivalTo']),"<=");

			$_SESSION['booking_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['booking_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Pax'] = $_POST['Pax'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Remarks'] = $_POST['Remarks'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedFrom'] = $_POST['DateBookedFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedTo'] = $_POST['DateBookedTo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalFrom'] = $_POST['DateArrivalFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalTo'] = $_POST['DateArrivalTo'];

			// Set Query Variable
			$_SESSION['booking_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['booking_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['booking_'.__FUNCTION__.'_'.$item['id']]);
		}

		// Determine Title
		if (isset($_SESSION['booking_'.__FUNCTION__.'_'.$item['id']]))
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
		$query_count = "SELECT COUNT(*) AS num FROM booking WHERE ListingID = '".$item['id']."' ".$_SESSION['booking_'.__FUNCTION__.'_'.$item['id']]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/booking/listingindex/'.$item['id'];
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

		$sql = "SELECT * FROM booking WHERE ListingID = '".$item['id']."' ".$_SESSION['booking_'.__FUNCTION__.'_'.$item['id']]['query_condition']." ORDER BY MemberID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => MemberModel::getMember($row['MemberID'], "Name"),
			'ListingID' => ListingModel::getListing($row['ListingID'], "Name"),
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'Status' => BookingStatusModel::getBookingStatus($row['Status'], "Label"),
			'DateBooked' => Helper::dateTimeSQLToLongDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateTimeSQLToLongDisplay($row['DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => $this->module['booking']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Bookings", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/admin/listingindex.inc.php', 'booking_listingdelete' => $_SESSION['admin']['booking_listingdelete']),
		'block' => array('side_nav' => $this->module['booking']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'bookingstatus_list' => BookingStatusModel::getBookingStatusList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['booking_listingdelete']);

		return $this->output;
	}

	public function AdminListingAdd($param)
	{
        // Load item data
        $item = array();
        $item['id'] = $param;
        $item['title'] = ListingModel::getListing($param, "Name");
        $item['url'] = "/admin/listing/edit/".$param;

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => "Create Booking", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Create Booking", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/admin/listingadd.inc.php', 'booking_listingadd' => $_SESSION['admin']['booking_listingadd']),
		'block' => array('side_nav' => $this->module['booking']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'bookingstatus_list' => BookingStatusModel::getBookingStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['booking_listingadd']);

		return $this->output;
	}

	public function AdminListingAddProcess($param)
	{
        $param = explode(",",$param);

        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = ListingModel::getListing($param[0]);
        $item['url'] = "/admin/listing/edit/".$param[0];
		
		$key = "(MemberID, ListingID, Name, MobileNo, Pax, Remarks, Status, DateBooked, DateArrival)";
		$value = "('".$_POST['MemberID']."', '".$item['id']."', '".$_POST['Name']."', '".$_POST['MobileNo']."', '".$_POST['Pax']."', '".$_POST['Remarks']."', '".$_POST['Status']."', '".Helper::dateDisplaySQL($_POST['DateBooked'])."', '".Helper::dateTimeDisplaySQL($_POST['DateArrival'])."')";

		$sql = "INSERT INTO booking ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Creating Booking...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminListingEdit($param)
	{
        $param = explode(",",$param);

        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = ListingModel::getListing($param[0], "Name");
        $item['url'] = "/admin/listing/edit/".$param[0];
        $item['child'] = $param[1];
        
		$sql = "SELECT * FROM booking WHERE ID = '".$item['child']."' AND ListingID = '".$item['id']."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'Status' => $row['Status'],
			'DateBooked' => Helper::dateTimeSQLToDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateTimeSQLToDisplay($row['DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => "Edit Booking", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Edit Booking", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/admin/listingedit.inc.php', 'booking_listingadd' => $_SESSION['admin']['booking_listingadd'], 'booking_listingedit' => $_SESSION['admin']['booking_listingedit']),
        'block' => array('side_nav' => $this->module['booking']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'bookingstatus_list' => BookingStatusModel::getBookingStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['booking_listingadd']);
		unset($_SESSION['admin']['booking_listingedit']);

		return $this->output;
	}

	public function AdminListingEditProcess($param)
	{
        $param = explode(",",$param);

        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = ListingModel::getListing($param[0]);
        $item['url'] = "/admin/listing/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "UPDATE booking SET MemberID='".$_POST['MemberID']."', Name='".$_POST['Name']."', MobileNo='".$_POST['MobileNo']."', Pax='".$_POST['Pax']."', Remarks='".$_POST['Remarks']."', Status='".$_POST['Status']."', DateBooked='".Helper::dateTimeDisplaySQL($_POST['DateBooked'])."', DateArrival='".Helper::dateTimeDisplaySQL($_POST['DateArrival'])."' WHERE ID='".$item['child']."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
        'current' => array('id' => $item['child']),
		'page' => array('title' => "Editing Booking...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminListingDelete($param)
	{
        $param = explode(",",$param);

        // Load item data
        $item = array();
        $item['id'] = $param[0];
        $item['title'] = ListingModel::getListing($param[0]);
        $item['url'] = "/admin/listing/edit/".$param[0];
        $item['child'] = $param[1];
		
		$sql = "DELETE FROM booking WHERE ID = '".$item['child']."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Deleting Booking...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	public function MerchantIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['booking_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Pax",$_POST['Pax'],"=");
			$query_condition .= $crud->queryCondition("Remarks",$_POST['Remarks'],"LIKE");
			$query_condition .= $crud->queryCondition("DateBooked",Helper::dateTimeDisplaySQL($_POST['DateBookedFrom']),">=");
			$query_condition .= $crud->queryCondition("DateBooked",Helper::dateTimeDisplaySQL($_POST['DateBookedTo']),"<=");
			$query_condition .= $crud->queryCondition("DateArrival",Helper::dateTimeDisplaySQL($_POST['DateArrivalFrom']),">=");
			$query_condition .= $crud->queryCondition("DateArrival",Helper::dateTimeDisplaySQL($_POST['DateArrivalTo']),"<=");

			$_SESSION['booking_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['booking_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['booking_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Pax'] = $_POST['Pax'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Remarks'] = $_POST['Remarks'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedFrom'] = $_POST['DateBookedFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedTo'] = $_POST['DateBookedTo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalFrom'] = $_POST['DateArrivalFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalTo'] = $_POST['DateArrivalTo'];

			// Set Query Variable
			$_SESSION['booking_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['booking_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['booking_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['booking_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM booking ".$_SESSION['booking_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/merchant/booking/index';
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

		$sql = "SELECT * FROM booking ".$_SESSION['booking_'.__FUNCTION__]['query_condition']." ORDER BY MemberID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => MemberModel::getMember($row['MemberID'], "Name"),
			'ListingID' => ListingModel::getListing($row['ListingID'], "Name"),
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'PassCode' => Secure::mcDecrypt($row['PassCode'], "aseanfnb"),
			'DateBooked' => Helper::dateTimeSQLToLongDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateTimeSQLToLongDisplay($row['DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['booking']['name'], "Link" => ""),
            //array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bookings", 'template' => 'common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/merchant/index.inc.php', 'booking_delete' => $_SESSION['merchant']['booking_delete']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['booking_delete']);

		return $this->output;
	}

	public function MerchantAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['booking']['name'], "Link" => $this->module['booking']['merchant_url']),
            array("Title" => "Add Booking", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Booking", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/merchant/add.inc.php', 'booking_add' => $_SESSION['merchant']['booking_add']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['booking_add']);

		return $this->output;
	}

	public function MerchantAddProcess($param)
	{
		$key = "(MemberID, ListingID, Name, MobileNo, Pax, Remarks, PassCode, DateBooked, DateArrival)";
		$value = "('".$_POST['MemberID']."', '".$_POST['ListingID']."', '".$_POST['Name']."', '".$_POST['MobileNo']."', '".$_POST['Pax']."', '".$_POST['Remarks']."', '".Secure::mcEncrypt($_POST['PassCode'], "aseanfnb")."', '".Helper::dateTimeDisplaySQL($_POST['DateBooked'])."', '".Helper::dateTimeDisplaySQL($_POST['DateArrival'])."')";

		$sql = "INSERT INTO booking ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Booking...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MerchantEdit($param)
	{
		$sql = "SELECT * FROM booking WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'PassCode' => Secure::mcDecrypt($row['PassCode'], "aseanfnb"),
			'DateBooked' => Helper::dateTimeSQLToDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateTimeSQLToDisplay($row['DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['booking']['name'], "Link" => $this->module['booking']['merchant_url']),
            array("Title" => "Edit Booking", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Booking", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/merchant/edit.inc.php', 'booking_add' => $_SESSION['merchant']['booking_add'], 'booking_edit' => $_SESSION['merchant']['booking_edit']),
        'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['booking_add']);
		unset($_SESSION['merchant']['booking_edit']);

		return $this->output;
	}

	public function MerchantEditProcess($param)
	{
		$sql = "UPDATE booking SET MemberID='".$_POST['MemberID']."', ListingID='".$_POST['ListingID']."', Name='".$_POST['Name']."', MobileNo='".$_POST['MobileNo']."', PassCode='".Secure::mcEncrypt($_POST['PassCode'], "aseanfnb")."', Pax='".$_POST['Pax']."', Remarks='".$_POST['Remarks']."', DateBooked='".Helper::dateTimeDisplaySQL($_POST['DateBooked'])."', DateArrival='".Helper::dateTimeDisplaySQL($_POST['DateArrival'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Booking...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MerchantDelete($param)
	{
		$sql = "DELETE FROM booking WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Booking...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	public function DealerIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['booking_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("bk.MemberID",$_POST['MemberID'],"=",1);
			$query_condition .= $crud->queryCondition("bk.ListingID",$_POST['ListingID'],"=");
			$query_condition .= $crud->queryCondition("bk.Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("bk.MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("bk.Pax",$_POST['Pax'],"=");
			$query_condition .= $crud->queryCondition("bk.Remarks",$_POST['Remarks'],"LIKE");
			$query_condition .= $crud->queryCondition("bk.DateBooked",Helper::dateTimeDisplaySQL($_POST['DateBookedFrom']),">=");
			$query_condition .= $crud->queryCondition("bk.DateBooked",Helper::dateTimeDisplaySQL($_POST['DateBookedTo']),"<=");
			$query_condition .= $crud->queryCondition("bk.DateArrival",Helper::dateTimeDisplaySQL($_POST['DateArrivalFrom']),">=");
			$query_condition .= $crud->queryCondition("bk.DateArrival",Helper::dateTimeDisplaySQL($_POST['DateArrivalTo']),"<=");

			$_SESSION['booking_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['booking_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['booking_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Pax'] = $_POST['Pax'];
			$_SESSION['booking_'.__FUNCTION__]['param']['Remarks'] = $_POST['Remarks'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedFrom'] = $_POST['DateBookedFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateBookedTo'] = $_POST['DateBookedTo'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalFrom'] = $_POST['DateArrivalFrom'];
			$_SESSION['booking_'.__FUNCTION__]['param']['DateArrivalTo'] = $_POST['DateArrivalTo'];

			// Set Query Variable
			$_SESSION['booking_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['booking_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['booking_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['booking_'.__FUNCTION__]))
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
		//$query_count = "SELECT COUNT(*) AS num FROM booking ".$_SESSION['booking_'.__FUNCTION__]['query_condition'];
		
		$query_count = "SELECT COUNT(*) AS num FROM booking AS bk, listing AS l, merchant AS m  WHERE l.ID = bk.ListingID AND l.MerchantID = m.ID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['booking_'.__FUNCTION__]['query_condition'];
		//echo $query_count;
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/dealer/booking/index';
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

		$sql = "SELECT bk.ID AS bk_ID, bk.MemberID AS bk_MemberID, bk.ListingID AS bk_ListingID, bk.Name AS bk_Name, bk.MobileNo AS bk_MobileNo, bk.Pax AS bk_Pax, bk.Remarks AS bk_Remarks, bk.PassCode AS bk_PassCode, bk.DateBooked AS bk_DateBooked, bk.DateArrival AS bk_DateArrival FROM booking AS bk, listing AS l, merchant AS m  WHERE l.ID = bk.ListingID AND l.MerchantID = m.ID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['booking_'.__FUNCTION__]['query_condition']." ORDER BY bk_MemberID ASC LIMIT $start, $limit";
		/*echo $sql;
		exit;*/
		
		//$sql = "SELECT m.ID AS m_ID, m.DealerID AS m_DealerID, md.ID AS md_ID, md.ListingID AS md_ListingID, md.MerchantID AS md_MerchantID, md.ImageURL AS md_ImageURL, md.DateExpiry AS md_DateExpiry FROM merchant_deal AS bk, merchant AS m  WHERE m.ID = md.MerchantID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition']." ORDER BY md_ListingID ASC, md_ImageURL DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['bk_ID'],
			'MemberID' => MemberModel::getMember($row['bk_MemberID'], "Name"),
			'ListingID' => ListingModel::getListing($row['bk_ListingID'], "Name"),
			'Name' => $row['bk_Name'],
			'MobileNo' => $row['bk_MobileNo'],
			'Pax' => $row['bk_Pax'],
			'Remarks' => $row['bk_Remarks'],
			'PassCode' => Secure::mcDecrypt($row['bk_PassCode'], "aseanfnb"),
			'DateBooked' => Helper::dateTimeSQLToLongDisplay($row['bk_DateBooked']),
			'DateArrival' => Helper::dateTimeSQLToLongDisplay($row['bk_DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['booking']['name'], "Link" => ""),
            //array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bookings", 'template' => 'common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/dealer/index.inc.php', 'booking_delete' => $_SESSION['dealer']['booking_delete']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['booking_delete']);

		return $this->output;
	}

	public function DealerAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['booking']['name'], "Link" => $this->module['booking']['dealer_url']),
            array("Title" => "Add Booking", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Booking", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/dealer/add.inc.php', 'booking_add' => $_SESSION['dealer']['booking_add']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['booking_add']);

		return $this->output;
	}


	public function DealerAddProcess($param)
	{
		$key = "(MemberID, ListingID, Name, MobileNo, Pax, Remarks, PassCode, DateBooked, DateArrival)";
		$value = "('".$_POST['MemberID']."', '".$_POST['ListingID']."', '".$_POST['Name']."', '".$_POST['MobileNo']."', '".$_POST['Pax']."', '".$_POST['Remarks']."', '".Secure::mcEncrypt($_POST['PassCode'], "aseanfnb")."', '".Helper::dateTimeDisplaySQL($_POST['DateBooked'])."', '".Helper::dateTimeDisplaySQL($_POST['DateArrival'])."')";

		$sql = "INSERT INTO booking ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Booking...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerEdit($param)
	{
		$sql = "SELECT * FROM booking WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'PassCode' => Secure::mcDecrypt($row['PassCode'], "aseanfnb"),
			'DateBooked' => Helper::dateTimeSQLToDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateTimeSQLToDisplay($row['DateArrival']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['booking']['name'], "Link" => $this->module['booking']['dealer_url']),
            array("Title" => "Edit Booking", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Booking", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['booking']['dir'].'inc/dealer/edit.inc.php', 'booking_add' => $_SESSION['dealer']['booking_add'], 'booking_edit' => $_SESSION['dealer']['booking_edit']),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['booking_add']);
		unset($_SESSION['dealer']['booking_edit']);

		return $this->output;
	}

	public function DealerEditProcess($param)
	{
		$sql = "UPDATE booking SET MemberID='".$_POST['MemberID']."', ListingID='".$_POST['ListingID']."', Name='".$_POST['Name']."', MobileNo='".$_POST['MobileNo']."', Pax='".$_POST['Pax']."', Remarks='".$_POST['Remarks']."', PassCode='".Secure::mcEncrypt($_POST['PassCode'], "aseanfnb")."', DateBooked='".Helper::dateTimeDisplaySQL($_POST['DateBooked'])."', DateArrival='".Helper::dateTimeDisplaySQL($_POST['DateArrival'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Booking...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerDelete($param)
	{
		$sql = "DELETE FROM booking WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Booking...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	public function BookingControl()
	{
		$crud = new CRUD();
		
		$sql = "SELECT TypeID FROM merchanT WHERE ID = '".$_SESSION['merchant']['ID']."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['TypeID'];
		}
		
		return $result;
	}
	
	
	public function CronCheck() 
    {
        // Downgrade Expired Members
        $crud = new CRUD();
		//date('Ymd', strtotime("+{$_SESSION['cart']['SubYear']} year"));
		$last6hours = date('Y-m-d h:i:s', strtotime('-6 hours'));
		$last5hours = date('Y-m-d h:i:s', strtotime('-5 hours'));
		//echo $last6hours.'<br />';
		//echo $last5hours.'<br />';
		//exit;
		$sql = "SELECT * FROM booking WHERE DateArrival <= '".$last5hours."' AND DateArrival >= '".$last6hours."'";
        //echo $sql;
        /*exit;*/
        //echo $sql;
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => MemberModel::getMember($row['MemberID']),
			'ListingID' => ListingModel::getListing($row['ListingID'], "Name"),
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'DateBooked' => Helper::dateSQLToLongDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateSQLToLongDisplay($row['DateArrival']));

			$i += 1;
        }
		
		$count = $i;
		/*Debug::displayArray($result);
		
		exit;*/
		/*Debug::displayArray($result);
		exit;*/
        
        /*for ($j=0; $j < $i; $j++)
        { 
            if ($j==0)
            {
                $query .= "(ID = '".$result[$j]['ID']."')";
            }
            else
            {
                $query .= " OR (ID = '".$result[$j]['ID']."')";
            }
        }
        
        if ($j>0)
        {
            $query_start = "WHERE (";
            $query = $query_start.$query;
            $query = $query.")";
    
            $sql = "UPDATE merchant SET TypeID='1' ".$query;
            $count = $this->dbconnect->exec($sql);
            
            echo "Updated: ".$sql;
        }
        else
        {
            echo "No changes made.";
        }*/
		
        
        /*// Notify Expiring Members
        $crud = new CRUD();

        $sql = "SELECT * FROM merchant WHERE TypeID = '2' AND Expiry < '".date('Y-m-d', strtotime('+30 days'))."'";
        
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'FirstName' => $row['FirstName'],
            'Email' => $row['Email'],
            'Expiry' => $row['Expiry']);
            
            $i += 1;
        }*/
        
        
        
        for ($j=0; $j < $count; $j++)
        {
            //require_once('classes/class.mailer.php');
			
			
                
            // Send Mail
            $mailer = new BaseMailer();
			echo $result[$j]['Email'] . '<br />';
            $mailer->From = "no-reply@aseanfnb.com.my";
            $mailer->AddReplyTo = "admin@aseanfnb.com.my";
            $mailer->FromName = "aseanF&B";
    
            $mailer->Subject = "[aseanF&B] Your Booking(s) is expiring on ".Helper::dateSQLToLongDisplay($result[$j]['DateArrival']);
    
            $mailer->AddAddress($result[$j]['Email'], '');
            //$mailer->AddBCC('general@valse.com.my', '');
    
            $mailer->IsHTML(true);
    
            $mailer->Body = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <title>Expiration</title>
              
              <div style="width: 550px; border:1px solid #ddd; padding:10px; margin:10px">
              <table style="font-family:Arial,sans-serif; font-size:12px;
                color:#333; width: 550px;">
                <tbody>
                  <tr>
                    <td align="left" style="font-size:16px; font-weight:bold; text-transform:uppercase"><img src="http://chopinsociety.com.my/themes/valse/img/logo.png" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left">Hello <strong style="color:#FB7D00;">'.$result[$j]['Name'].'</strong>,<br /><br />Please be reminded that your booking(s) is expiring on '.Helper::dateSQLToLongDisplay($result[$j]['DateArrival']).' To check your booking(s), please login to your account at <a href="http://aseanfnb.com.my">http://aseanfnb.com.my</a>. Thank you for your continuous support.</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="border-top: 1px solid #ddd;" align="center"> <a moz-do-not-send="true" href="" style="color:#FB7D00; font-weight:bold; text-decoration:none;">aseanF&B</a>
                    </td>
                  </tr>
                </tbody>
              </table>
              </div>';
    
            /*$days = (strtotime($result[$j]['Expiry']) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
            
            if (($days=='15')||($days=='7')||($days=='3')||($days=='1'))
            {*/
                $mailer->Send();
            /*}*/
            }
			//require_once('classes/class.mailer.php');

                
            // Send Mail
            /*$mailer2 = new BaseMailer();
            $mailer2->From = "no-reply@aseanfnb.com.my";
            $mailer2->AddReplyTo = "admin@aseanfnb.com.my";
            $mailer2->FromName = "aseanF&B";
    
            $mailer2->Subject = "[aseanF&B] Your Member: ".$result[$j]['Name']."  is expiring on ".Helper::dateSQLToLongDisplay($result[$j]['Expiry']);
    
            $mailer2->AddAddress($result[$j]['DealerEmail'], '');
            //$mailer->AddBCC('decweng.chan@valse.com.my', '');
    
            $mailer2->IsHTML(true);
    
            $mailer2->Body = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <title>Member(s) Expiration</title>
              
              <div style="width: 550px; border:1px solid #ddd; padding:10px; margin:10px">
              <table style="font-family:Arial,sans-serif; font-size:12px;
                color:#333; width: 550px;">
                <tbody>
                  <tr>
                    <td align="left" style="font-size:16px; font-weight:bold; text-transform:uppercase"><img src="http://chopinsociety.com.my/themes/valse/img/logo.png" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left">Hello <strong style="color:#FB7D00;">'.$result[$j]['DealerName'].'</strong>,<br /><br />Please be reminded that your member <strong style="color:#FB7D00;">'.$result[$j]['Name'].'</strong> is expiring on '.Helper::dateSQLToLongDisplay($result[$j]['Expiry']).' To renew, please login to your account at <a href="http://aseanfnb.com.my">http://aseanfnb.com.my</a>. Thank you for your continuous support.</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="border-top: 1px solid #ddd;" align="center"> <a moz-do-not-send="true" href="" style="color:#FB7D00; font-weight:bold; text-decoration:none;">aseanF&B</a>
                    </td>
                  </tr>
                </tbody>
              </table>
              </div>';
    
            $days = (strtotime($result[$j]['Expiry']) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
            
            if (($days=='15')||($days=='7')||($days=='3')||($days=='1'))
            {
                $mailer2->Send();
            }
			
			
			
        }*/
        
        /*if ($j>0)
        {
            echo "<br />Expiring members: ".$j;
        }
        else
        {
            echo "<br />No expiring members.";
        }*/
            
        $this->output = array( 
        'config' => $this->config,
        'page' => array('title' => "Editing Member...", 'template' => 'common.tpl.php'),
        'content_param' => array('count' => $count),
        'meta' => array('active' => "on"));
                    
        return $this->output;
    }
	
	
	public function APIIndex($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
            	
				$minusedtimestamp = strtotime('-30 minute');
				
				$crud = new CRUD();
		
				$sql = "SELECT * FROM booking WHERE MemberID = '".$param."' AND DateArrival >= '". date('Y-m-d H:i:s', $minusedtimestamp)."' ORDER BY ID DESC";
		
				$result = array();
				$i = 0;
				foreach ($this->dbconnect->query($sql) as $row)
				{
					$result[$i] = array(
					'ID' => $row['ID'],
					'MemberID' => MemberModel::getMember($row['MemberID'], "Name"),
					'ListingID' => ListingModel::getListing($row['ListingID'],"ID"),
					'ListingName' => ListingModel::getListing($row['ListingID'],"Name"),
					/*'ListingID' => array(ListingModel::getListing($row['ListingID'])),*/
					'Name' => $row['Name'],
					'MobileNo' => $row['MobileNo'],
					'Pax' => $row['Pax'],
					'Remarks' => $row['Remarks'],
					'DateBooked' => Helper::dateTimeSQLToLongDisplay($row['DateBooked']),
					'DateArrival' => Helper::dateTimeSQLToLongDisplay($row['DateArrival']),
					'Status' => $row['Status'],
					'RawDateArrival' => $row['DateArrival']
					);
		
					$i += 1;
				}
				
                $output['Count'] = $i;
                $output['Content'] = $result;

                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode($output);
                    $restapi->setResponse('200', 'OK', $result);
                }
                else
                {
                    $restapi->setResponse('404', 'Resource Not Found');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

	public function APIAddProcess($param)
    {
    	header('Content-type: text/html; charset=utf-8');
    	//ini_set('default_charset', 'utf-8');
    	/*echo $_SERVER['HTTP_JSON'];
		exit;*/
		//json_last_error() ;
        // Initiate REST API class
        //Debug::displayArray($_GET['SAME']);
		//exit;
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
        	
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                $key = "(MemberID, ListingID, Name, MobileNo, Pax, Remarks, DateBooked, DateArrival, Status)";
				$value = "('".$request_data['MemberID']."', '".$request_data['ListingID']."', '".$request_data['Name']."', '".$request_data['MobileNo']."', '".$request_data['Pax']."', '".$request_data['Remarks']."',  '".Helper::dateTimeDisplaySQL($request_data['DateBooked'])."', '".Helper::dateTimeDisplaySQL($request_data['DateArrival'])."', '1')";
		
				$sql = "INSERT INTO booking ".$key." VALUES ". $value;
				/*echo $sql;
				exit;*/
				$count = $this->dbconnect->exec($sql);

                $output['Count'] = $count;
                //$output['Content'] = $result;
                
                $error_message = "Error ocurred";

                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode(array('Status' =>'Created Booking Successfully'));
                    $restapi->setResponse('200', 'OK', $result);
					
                }elseif($output['Count']==0){
                	
					$restapi->setResponse('400', $error_message);
					
                }
                else
                {
                    $restapi->setResponse('404', 'Resource Not Found');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }
    
    public function APIDeleteProcess($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
        	
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
               $minusedtimestamp = strtotime('-30 minute');
			   
				$sql = "DELETE FROM booking WHERE MemberID = '".$request_data['MemberID']."' AND ListingID = '".$request_data['ListingID']."' AND DateArrival >= '".date('Y-m-d H:i:s', $minusedtimestamp)."'";
				/*echo $sql;
				exit;*/
				$count = $this->dbconnect->exec($sql);

                $output['Count'] = $count;
                //$output['Content'] = $result;
                
                $error_message = "Error ocurred";

                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode(array('Status' =>'Deleted Booking Successfully'));
                    $restapi->setResponse('200', 'OK', $result);
					
                }elseif($output['Count']==0){
                	
					$restapi->setResponse('400', $error_message);
					
                }
                else
                {
                    $restapi->setResponse('404', 'Resource Not Found');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

	public function getBooking($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM booking WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'DateBooked' => Helper::dateSQLToLongDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateSQLToLongDisplay($row['DateArrival']));

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

	public function getBookingByListing($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM booking WHERE ListingID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			"PassCode" => $row['PassCode'],
			'DateBooked' => Helper::dateSQLToLongDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateSQLToLongDisplay($row['DateArrival']));

			$i += 1;
		}
		/*Debug::displayArray($result);
		exit;*/
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

	public function getBookingList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM booking ORDER BY MemberID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Name' => $row['Name'],
			'MobileNo' => $row['MobileNo'],
			'Pax' => $row['Pax'],
			'Remarks' => $row['Remarks'],
			'DateBooked' => Helper::dateSQLToLongDisplay($row['DateBooked']),
			'DateArrival' => Helper::dateSQLToLongDisplay($row['DateArrival']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM booking ".$_SESSION['booking_'.$param]['query_condition']." ORDER BY MemberID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Booking";
		$result['header'] = $this->config['SITE_NAME']." | Booking (" . date('Y-m-d H:i:s') . ")\n\nID, Member, Listing, Name, Mobile No, Pax, Remarks, Status, Date Booked, Date Arrival";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".MemberModel::getMember($row['MemberID'])."\",";
			$result['content'] .= "\"".ListingModel::getListing($row['ListingID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['MobileNo']."\",";
			$result['content'] .= "\"".$row['Pax']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Remarks'])."\",";
			$result['content'] .= "\"".BookingStatusModel::getBookingStatus($row['Status'])."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DateBooked'])."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DateArrival'])."\"\n";

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