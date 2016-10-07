<?php
// Require required models
Core::requireModel('state');
Core::requireModel('country');
Core::requireModel('bankinfo');
Core::requireModel('product');
Core::requireModel('transaction');

class ResellerModel extends BaseModel
{
	private $output = array();
    private $module_name = "Reseller";
	private $module_dir = "modules/reseller/";
    private $module_default_url = "/main/reseller/index";
    private $module_default_admin_url = "/admin/reseller/index";
    private $module_default_reseller_url = "/reseller/reseller/index";


	public function __construct()
	{
		parent::__construct();
	}

	public function BlockHomeIndex(){
		$sql = "SELECT Total FROM wallet WHERE ResellerID = '".$_SESSION['reseller']['ID']."' AND ProductID = '30'";

		$res = $this->dbconnect->query($sql);
		$result = $res->fetchColumn();


        $this->output = array(
        'config' => $this->config,
        //'page' => array('title' => "News", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'secure' => NULL,
        'meta' => array('active' => "on"));

        return $this->output;
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM reseller WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/reseller/index';
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

		$sql = "SELECT * FROM reseller WHERE Enabled = 1 ORDER BY Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToLongDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Resellers", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminReport($param)
	{
		$filename = __FUNCTION__;

		$query_condition = "";

		$crud = new CRUD();

		// Reset Query Variable
		$_SESSION['reseller_'.__FUNCTION__] = "";

		$_SESSION['reseller_'.__FUNCTION__]['Reseller'] = $_POST['Reseller'];

		$_SESSION['reseller_'.__FUNCTION__]['Month'] = $_POST['Month'];

		$_SESSION['reseller_'.__FUNCTION__]['Year'] = $_POST['Year'];

		if($_POST['Trigger'] =='search_form' && $_POST['Month'] != '0'){
		// Initialise query conditions


			/*$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=",1);
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateDisplaySQL($_POST['DateTo'])." 23:59:59" : Helper::dateDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Out'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['reseller_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['DateFrom'] = $_POST['DateFrom'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['DateTo'] = $_POST['DateTo'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['reseller_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['reseller_'.__FUNCTION__]['query_title'] = "Search Results";*/



		if ($_GET['page']=="all")
		{
			//echo $_GET['page'];
			//echo 'hi';
			$_GET['page'] = "";
			unset($_SESSION['reseller_'.__FUNCTION__]);
			//unset($_SESSION['reseller_'.__FUNCTION__]['Year']);
		}

		if ($_POST['Trigger'] =='search_form' && $_POST['Year'] != '' && $_POST['Month'] != '0' && $_POST['Reseller'] == '')
		{




		/*echo $_SESSION['reseller_'.__FUNCTION__]['Month'].'<br />';
		echo $_SESSION['reseller_'.__FUNCTION__]['Year'].'<br />';
		exit;*/
		//$targetpage = $data['config']['SITE_DIR'].'/admin/reseller/report';
		//echo $_GET['page'];
		//exit;
		// Reset query conditions


		// Determine Title
		if (isset($_SESSION['reseller_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

        //echo $_SESSION['reseller_'.__FUNCTION__]['query_condition'];
		//exit;
		// Prepare Pagination

		/*$query_count = "SELECT COUNT(*) AS NUM FROM reseller ";
		//$query_count = "SELECT COUNT(*) AS NUM FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['reseller_'.__FUNCTION__]['query_condition']." AND m.Reseller != '0'";
		//echo $query_count;
		//exit;
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		targetpage = $data['config']['SITE_DIR'].'/admin/reseller/report';
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);*/


		/* $sql = "SELECT * FROM reseller ORDER BY Name ASC LIMIT $start, $limit";
		//echo $sql;
		//exit;
		$result = array();
		$i = 0;*/

		/*$DateFrom = Helper::dateDisplaySQL($_POST['DateFrom']);
		$DateTo = Helper::dateDisplaySQL($_POST['DateTo'])." 23:59:59";
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Report' => ResellerModel::getResellerReport($row['ID']),
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
            'NationalityID' => $row['Nationality'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => CRUD::isActive($row['Prompt']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}*/




		//$month = date('m', strtotime($_POST['Month']));
		//$month = date_parse($month);
	    //Debug::displayArray($month);
	    $transaction = array();


		$sql_resellers = "SELECT * FROM reseller ORDER BY Name ASC";
		$resellers = array();
		$j = 0;

		foreach ($this->dbconnect->query($sql_resellers) as $row)
		{
			$resellers[$j] = array('ID' => $row['ID']);

			$j += 1;
		}
		$resellers['count'] = $j;
		//echo $resellers['count'];

		for ($z=0; $z <$resellers['count'] ; $z++) {

			//$sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Reseller = '".$resellers[$z]['ID']."' AND t.Date >= '{$_POST['Year']}/{$month}/01' and Date <= '{$_POST['Year']}/{$month}/31' AND t.Status = '2'";
			//echo $sql.'<br />';

			//$transaction['count'] = $result['count'];
			//$i = 0;

			//foreach ($this->dbconnect->query($sql) as $row)
			//{

				$transaction[$z] = array(
				'Report' => ResellerModel::getResellerAdminReport($resellers[$z]['ID'], $filename)
				);

				//$i += 1;


			//}





		}

		/*elseif($_POST['Trigger'] =='search_form' && $_POST['Reseller'] != '' && $_POST['Month'] !='0'){

			$transaction[0] = array(
				'Report' => ResellerModel::getResellerAdminReport($_POST['Reseller'], $filename)
				);
		}*/

		$transaction['count'] = $z;
		}

		}

		/*Debug::displayArray($transaction);
		exit;*/
		$month = array();

		$month[1] = 'January';
		$month[2] = 'February';
		$month[3] = 'March';
		$month[4] = 'April';
		$month[5] = 'May';
		$month[6] = 'June';
		$month[7] = 'July';
		$month[8] = 'August';
		$month[9] = 'September';
		$month[10] = 'October';
		$month[11] = 'November';
		$month[12] = 'December';

		$month['count'] = '12';



		$years = array();
		$startyear =  '2013';
		$currentyear = date("Y");
		if($startyear == $currentyear){

		  	$years[0] = $startyear;
			$years['count'] = 1;
		}else{

		  $yeardifference = $currentyear - $startyear;
		  //echo $yeardifference.'<br />';

			for ($z=0; $z <= $yeardifference; $z++) {
				//echo 'hi <br />';
			$years[$z] = $startyear + $z;

		    }
   			$years['count'] = $z;
		}

		if($_POST['Trigger'] =='search_form' && $_POST['Month'] == '0' && $_POST['Reseller'] == ''){

			$monthsreport = ResellerModel::getResellersMonthsReport($filename, $reseller);
		}elseif($_POST['Trigger'] =='search_form' && $_POST['Month'] != '0'  && $_POST['Reseller'] != ''){
			//echo 'hi';
			/*echo $filename.'<br />';
			echo  $_POST['Reseller'];*/
			$resellermonthsreport = ResellerModel::getResellerMonthsReport($filename, $_POST['Reseller']);
			//exit;
			/*Debug::displayArray($resellermonthsreport);
			exit;*/
		}elseif($_POST['Trigger'] =='search_form' && $_POST['Month'] == '0'  && $_POST['Reseller'] != ''){

			$resellerallmonthsreport = ResellerModel::getResellerAllMonthsReport($_POST['Reseller']);

		}



		/*Debug::displayArray($transaction);
		exit;*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "View Report By Month", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/report.inc.php', 'reseller_delete' => $_SESSION['admin']['reseller_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.reseller_common.inc.php'),
		//'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_reseller_url,"",$this->config,"Dashboard"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"View Report By Month"),
		'content' => $transaction,
		'months' => $monthsreport,
		'resellermonths' => $resellermonthsreport,
		'resellerallmonths' => $resellerallmonthsreport,
		'filters' => array('years' => array_reverse($years), 'months' => $month),
		'content_param' => array('query_title' => $query_title, 'search' => $search, 'reseller_list' => ResellerModel::getResellerList(), 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['reseller_delete']);

		return $this->output;
	}

	public function ResellerReport($param)
	{

		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		$filename = __FUNCTION__;

		if ($_GET['page']=="all")
		{
			//echo $_GET['page'];
			//echo 'hi';
			$_GET['page'] = "";
			unset($_SESSION['reseller_'.__FUNCTION__]);
			//unset($_SESSION['reseller_'.__FUNCTION__]['Year']);
		}

		if ($_POST['Trigger'] =='search_form' || $_SESSION['reseller_'.__FUNCTION__] !='')
		{
			if($_POST['Trigger'] =='search_form'){
			// Reset Query Variable
			$_SESSION['reseller_'.__FUNCTION__] = "";

			/*$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=",1);
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateDisplaySQL($_POST['DateTo'])." 23:59:59" : Helper::dateDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Out'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['reseller_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['DateFrom'] = $_POST['DateFrom'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['DateTo'] = $_POST['DateTo'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['reseller_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['reseller_'.__FUNCTION__]['query_title'] = "Search Results";*/

		$_SESSION['reseller_'.__FUNCTION__]['Month'] = $_POST['Month'];

		$_SESSION['reseller_'.__FUNCTION__]['Year'] = $_POST['Year'];

		}



		/*echo $_SESSION['reseller_'.__FUNCTION__]['Month'].'<br />';
		echo $_SESSION['reseller_'.__FUNCTION__]['Year'].'<br />';
		exit;*/
		//$targetpage = $data['config']['SITE_DIR'].'/admin/reseller/report';
		//echo $_GET['page'];
		//exit;
		// Reset query conditions


		// Determine Title
		if (isset($_SESSION['reseller_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

        //echo $_SESSION['reseller_'.__FUNCTION__]['query_condition'];
		//exit;
		// Prepare Pagination

		/*$query_count = "SELECT COUNT(*) AS NUM FROM reseller ";
		//$query_count = "SELECT COUNT(*) AS NUM FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['reseller_'.__FUNCTION__]['query_condition']." AND m.Reseller != '0'";
		//echo $query_count;
		//exit;
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		targetpage = $data['config']['SITE_DIR'].'/admin/reseller/report';
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);*/


		/* $sql = "SELECT * FROM reseller ORDER BY Name ASC LIMIT $start, $limit";
		//echo $sql;
		//exit;
		$result = array();
		$i = 0;*/

		/*$DateFrom = Helper::dateDisplaySQL($_POST['DateFrom']);
		$DateTo = Helper::dateDisplaySQL($_POST['DateTo'])." 23:59:59";
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Report' => ResellerModel::getResellerReport($row['ID']),
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
            'NationalityID' => $row['Nationality'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => CRUD::isActive($row['Prompt']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}*/




		//$month = date('m', strtotime($_POST['Month']));
		//$month = date_parse($month);
	    //Debug::displayArray($month);
		$sql_resellers = "SELECT * FROM reseller WHERE ID = '".$_SESSION['reseller']['ID']."' ORDER BY Name ASC";
		$resellers = array();
		$j = 0;

		foreach ($this->dbconnect->query($sql_resellers) as $row)
		{
			$resellers[$j] = array('ID' => $row['ID']);

			$j += 1;
		}
		$resellers['count'] = $j;
		//echo $resellers['count'];
		$transaction = array();
		for ($z=0; $z <$resellers['count'] ; $z++) {

			//$sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Reseller = '".$resellers[$z]['ID']."' AND t.Date >= '{$_POST['Year']}/{$month}/01' and Date <= '{$_POST['Year']}/{$month}/31' AND t.Status = '2'";
			//echo $sql.'<br />';

			//$transaction['count'] = $result['count'];
			//$i = 0;

			//foreach ($this->dbconnect->query($sql) as $row)
			//{

				$transaction[$z] = array(
				'Report' => ResellerModel::getResellerAdminReport($resellers[$z]['ID'], $filename)
				);

				//$i += 1;


			//}





		}
		$transaction['count'] = $z;
		//Debug::displayArray($transaction);
		//exit;
		}
		$month = array();

		$month[1] = 'January';
		$month[2] = 'February';
		$month[3] = 'March';
		$month[4] = 'April';
		$month[5] = 'May';
		$month[6] = 'June';
		$month[7] = 'July';
		$month[8] = 'August';
		$month[9] = 'September';
		$month[10] = 'October';
		$month[11] = 'November';
		$month[12] = 'December';

		$month['count'] = '12';



		$years = array();
		$startyear =  '2013';
		$currentyear = date("Y");
		if($startyear == $currentyear){

		  	$years[0] = $startyear;
			$years['count'] = 1;
		}else{

		  $yeardifference = $currentyear - $startyear;
		  //echo $yeardifference.'<br />';

			for ($z=0; $z <= $yeardifference; $z++) {
				//echo 'hi <br />';
			$years[$z] = $startyear + $z;

		    }
   			$years['count'] = $z;
		}

		/*for ($z=0; $z < ; $z++) {
			$year[$b] = $b;
		}*/


		/*Debug::displayArray($month);*/
		//exit;

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Dashboard", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/reseller/report.inc.php', 'reseller_delete' => $_SESSION['reseller']['reseller_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/reseller/side_nav.reseller.inc.php', 'common' => "false"),
		//'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_reseller_url,"",$this->config,"Dashboard"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_reseller_url,"",$this->config,"Report"),
		'content' => $transaction,
		'filters' => array('years' => array_reverse($years), 'months' => $month),
		'content_param' => array('query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['reseller']['reseller_delete']);

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM reseller WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToLongDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
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

    public function ResellerDashboard()
    {
    	//unset($_SESSION['reseller']['Credit']);
        $product_list['casino'] = ProductModel::getProductListByType('1');

        $product_list['soccer'] = ProductModel::getProductListByType('2');

        $product_list['horse'] = ProductModel::getProductListByType('3');

        $product_list['main'] = ProductModel::getProductListByType('5');

		ResellerModel::getResellerCredit($_SESSION['reseller']['ID']);

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Dashboard", 'template' => 'reseller.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/dashboard.inc.php'),
        'block' => array('side_nav' => $this->module_dir.'inc/reseller/side_nav.reseller.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_reseller_url,"",$this->config,"Dashboard"),
        'content2' => $product_list,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['reseller']['reseller_login']);
		/*Debug::displayArray($this->output['breadcrumb']);
		exit;*/
        return $this->output;
    }

    public function ResellerProfile()
    {
        $sql = "SELECT * FROM reseller WHERE ID = '".$_SESSION['reseller']['ID']."'";
		/*echo $sql;
		exit;*/
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'GenderID' => $row['GenderID'],
            'Profitsharing' => $row['Profitsharing'],
            'Name' => $row['Name'],
            'Company' => $row['Company'],
            'Bank' => $row['Bank'],
            'BankAccountNo' => $row['BankAccountNo'],
            'SecondaryBank' => $row['SecondaryBank'],
            'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
            'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
            'Nationality' => $row['Nationality'],
            'Username' => $row['Username'],
            'PhoneNo' => $row['PhoneNo'],
            'FaxNo' => $row['FaxNo'],
            'MobileNo' => $row['MobileNo'],
            'Email' => $row['Email']);

            $i += 1;
        }

		// Debug::displayArray($result);
		// exit;

        if ($_SESSION['reseller']['reseller_profile_info']!="")
        {
            $form_input = $_SESSION['reseller']['reseller_profile_info'];

            // Unset temporary reseller info input
            unset($_SESSION['reseller']['reseller_profile_info']);
        }

		ResellerModel::getResellerCredit($_SESSION['reseller']['ID']);

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "My Profile", 'template' => 'reseller.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/reseller/profile.inc.php', 'reseller_profile' => $_SESSION['reseller']['reseller_profile']),
        'block' => array('side_nav' => $this->module_dir.'inc/reseller/side_nav.reseller.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_reseller_url,"",$this->config,"My Profile"),
        'content' => $result,
        'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['reseller']['reseller_profile']);

        return $this->output;
    }

    public function ResellerProfileProcess()
    {
        if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM reseller WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$_SESSION['reseller']['ID']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                #$i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM reseller WHERE Passport = '".$_POST['Passport']."' AND ID != '".$_SESSION['reseller']['ID']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                #$i_passport += 1;
            }
        }

        $error['count'] = $i_nric + $i_passport;

        if ($error['count']>0)
        {
            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            $_SESSION['reseller']['reseller_profile_info'] = Helper::unescape($_POST);
        }
        else
        {
            $sql = "UPDATE reseller SET GenderID='".$_POST['GenderID']."', Name='".$_POST['Name']."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Company='".$_POST['Company']."', DOB='".Helper::dateDisplaySQL($_POST['DOB'])."', Nationality='".$_POST['Nationality']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', Bank='".$_POST['Bank']."', BankAccountNo='".$_POST['BankAccountNo']."', SecondaryBank='".$_POST['SecondaryBank']."', SecondaryBankAccountNo='".$_POST['SecondaryBankAccountNo']."' WHERE ID='".$_SESSION['reseller']['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Updating Profile...", 'template' => 'common.tpl.php'),
        'content' => Helper::unescape($_POST),
        'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function ResellerPassword()
    {
    	ResellerModel::getResellerCredit($_SESSION['reseller']['ID']);

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Change Password", 'template' => 'reseller.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/reseller/password.inc.php', 'reseller_password' => $_SESSION['reseller']['reseller_password']),
        'block' => array('side_nav' => $this->module_dir.'inc/reseller/side_nav.reseller.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_reseller_url,"",$this->config,"Change Password"),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['reseller']['reseller_password']);

        return $this->output;
    }

    public function ResellerPasswordProcess()
    {
        // Update new password if current password is entered correctly
        $bcrypt = new Bcrypt(9);
        $verify = $bcrypt->verify($_POST['Password'], $this->getHash($_SESSION['reseller']['ID']));

        if ($verify==1)
        {
            $hash = $bcrypt->hash($_POST['PasswordNew']);

            // Save new password and disable Prompt
            $sql = "UPDATE reseller SET Password='".$hash."', Prompt = 0 WHERE ID='".$_SESSION['reseller']['ID']."'";
            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }
        else
        {
            // Current password incorrect
            $error['count'] += 1;
            $error['Password'] = 1;
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Updating Password...", 'template' => 'common.tpl.php'),
        'content_param' => array('count' => $count),
        'secure' => TRUE,
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function ResellerIndex()
    {
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Reseller Home", 'template' => 'reseller.common.tpl.php'),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function ResellerRegister()
    {
        if ($_SESSION['admin']['reseller_register_info']!="")
        {
            $form_input = $_SESSION['admin']['reseller_register_info'];

            // Unset temporary reseller info input
            unset($_SESSION['admin']['reseller_register_info']);
        }

        $captcha[0] = rand(1,5);
        $captcha[1] = rand(1,4);

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Register", 'template' => 'reseller.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/reseller/register.inc.php', 'reseller_register' => $_SESSION['reseller']['reseller_register']),
        'block' => array('side_nav' => $this->module_dir.'inc/reseller/side_nav.reseller_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_reseller_url,"",$this->config,"Register"),
        'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
        'form_param' => $form_input,
        'captcha' => $captcha,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['admin']['reseller_register']);

        return $this->output;
    }

    public function ResellerRegisterProcess()
    {
        if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM reseller WHERE NRIC = '".$_POST['NRIC']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                #$i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM reseller WHERE Passport = '".$_POST['Passport']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                #$i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM reseller WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        // Check if security question is correct
        $i_security = 0;

        if ($_POST['C1']+$_POST['C2']!=$_POST['SQ'])
        {
            $i_security += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport + $i_security;

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            if ($i_security>0)
            {
                $error['SQ'] = 1;
            }

            $_SESSION['admin']['reseller_register_info'] = Helper::unescape($_POST);
        }
        else
        {
            // Insert new reseller
            $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            $key = "(GenderID, Name, NRIC, Passport, Company, Bank, BankAccountNo, DOB, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, Enabled)";
            $value = "('".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Company']."', '".$_POST['Bank']."', '".$_POST['BankAccountNo']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '0', '1')";

            $sql = "INSERT INTO reseller ".$key." VALUES ". $value;

            $count = $this->dbconnect->exec($sql);
            $newID = $this->dbconnect->lastInsertId();

            // Create all product wallets for new reseller
			$Product = ProductModel::getProductList();

			for ($i=0; $i <$Product['count'] ; $i++)
			{
    			$key = "(Total, ProductID, ResellerID, Enabled)";
    			$value = "('0', '".$Product[$i]['ID']."', '".$newID."', '1')";

    			$sql = "INSERT INTO wallet ".$key." VALUES ". $value;
                $this->dbconnect->exec($sql);
			}

            // Insert new reseller's first address
            /*$key_address = "(ResellerID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
            $value_address = "('".$newID."', 'My First Address', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '1')";

            $sql_address = "INSERT INTO reseller_address ".$key_address." VALUES ". $value_address;

            $count_address = $this->dbconnect->exec($sql_address);*/

            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Registering...", 'template' => 'common.tpl.php'),
        'content' => Helper::unescape($_POST),
        'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function ResellerLogin()
    {
        if ($_SESSION['reseller']['reseller_login_info']!="")
        {
            $form_input = $_SESSION['reseller']['reseller_login_info'];

            // Unset temporary reseller info input
            unset($_SESSION['reseller']['reseller_login_info']);
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Reseller Login", 'template' => 'reseller.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/login.inc.php', 'reseller_login' => $_SESSION['reseller']['reseller_login'], 'reseller_logout' => $_SESSION['reseller']['reseller_logout'], 'reseller_password' => $_SESSION['reseller']['reseller_password'], 'reseller_register' => $_SESSION['reseller']['reseller_register'], 'reseller_forgotpassword' => $_SESSION['reseller']['reseller_forgotpassword']),
        'block' => array(/*'side_nav' => $this->module_dir.'inc/member/side_nav.reseller_out.inc.php',*/ 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_reseller_url,"",$this->config,"Login"),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['reseller']['reseller_login']);
        unset($_SESSION['reseller']['reseller_logout']);
        unset($_SESSION['reseller']['reseller_password']);
        unset($_SESSION['reseller']['reseller_register']);
        unset($_SESSION['reseller']['reseller_forgotpassword']);

        return $this->output;
    }

    public function ResellerLoginProcess()
    {
        $sql = "SELECT * FROM reseller WHERE Enabled = 1 AND Username = '".$_POST['Username']."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Username' => $row['Username'],
            'Password' => $row['Password'],
            'CookieHash' => $row['CookieHash'],
            'Email' => $row['Email'],
            'Name' => $row['Name'],
            'Prompt' => $row['Prompt']);

            $i += 1;
        }

        if ($i==1)
        {
            $bcrypt = new Bcrypt(9);
            $verify = $bcrypt->verify($_POST['Password'], $result[0]['Password']);

            // Set Status
            $ok = ($verify==1) ? 1 : "";

            if ($verify!=1)
            {
                // Username and password do not match
                $error['count'] += 1;
                $error['Login'] = 1;

                $_SESSION['reseller']['reseller_login_info'] = Helper::unescape($_POST);
            }
        }
        else
        {
            // Invalid username
            $error['count'] += 1;
            $error['Login'] = 1;

            $_SESSION['reseller']['reseller_login_info'] = Helper::unescape($_POST);
        }

        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Logging In..."),
        'content' => $result,
        'content_param' => array('count' => $i),
        'status' => array('ok' => $ok, 'error' => $error),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function ResellerLogout()
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey),
        'page' => array('title' => "Logging Out..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function ResellerForgotPassword()
    {
        if ($_SESSION['reseller']['reseller_forgotpassword_info']!="")
        {
            $form_input = $_SESSION['reseller']['reseller_forgotpassword_info'];

            // Unset temporary reseller info input
            unset($_SESSION['reseller']['reseller_forgotpassword_info']);
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Forgot Your Password?", 'template' => 'reseller.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/reseller/forgotpassword.inc.php', 'reseller_forgotpassword' => $_SESSION['reseller']['reseller_forgotpassword']),
        'block' => array(/*'side_nav' => $this->module_dir.'inc/reseller/side_nav.reseller_out.inc.php',*/ 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_reseller_url,"",$this->config,"Forgot Password"),
        'content_param' => array('enabled_list' => CRUD::getActiveList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['reseller']['reseller_forgotpassword']);

        return $this->output;
    }

    public function ResellerForgotPasswordProcess()
    {
        $sql = "SELECT * FROM reseller WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' LIMIT 0,1";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Expiry' => $row['Expiry'],
            'Username' => $row['Username'],
            'Password' => $row['Password'],
            'CookieHash' => $row['CookieHash'],
            'Email' => $row['Email'],
            'Name' => $row['Name'],

            'Prompt' => $row['Prompt']);

            $i += 1;
        }

        if ($i==1)
        {
            // Generate New Password
            $bcrypt = new Bcrypt(9);
            $new_password = uniqid();
            $hash = $bcrypt->hash($new_password);

            $sql = "UPDATE reseller SET Password='".$hash."', Prompt='1' WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' AND ID='".$result[0]['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }
        else
        {
            // Username and email do not match
            $error['count'] += 1;
            $error['NoMatch'] = 1;

            $_SESSION['reseller']['reseller_forgotpassword_info'] = Helper::unescape($_POST);
        }

        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Logging In..."),
        'content' => $result,
        'content_param' => array('count' => $i, 'new_password' => $new_password),
        'status' => array('ok' => $ok, 'error' => $error),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function ResellerAccess()
    {
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Checking Access..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function ResellerAutologin()
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Auto Logging In..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

	public function AdminIndex($param)
	{
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['reseller_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("Reseller",$_POST['Reseller'],"LIKE");
			$query_condition .= $crud->queryCondition("GenderID",$_POST['GenderID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
			$query_condition .= $crud->queryCondition("Bank",$_POST['Bank'],"LIKE");
			$query_condition .= $crud->queryCondition("BankAccountNo",$_POST['BankAccountNo'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBank",$_POST['SecondaryBank'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBankAccountNo",$_POST['SecondaryBankAccountNo'],"LIKE");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBFrom']),">=");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBTo']),"<=");
			$query_condition .= $crud->queryCondition("NRIC",$_POST['NRIC'],"LIKE");
			$query_condition .= $crud->queryCondition("Passport",$_POST['Passport'],"LIKE");
			$query_condition .= $crud->queryCondition("Nationality",$_POST['Nationality'],"=");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("FaxNo",$_POST['FaxNo'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
			$query_condition .= $crud->queryCondition("Prompt",$_POST['Prompt'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['reseller_'.__FUNCTION__]['param']['Reseller'] = $_POST['Reseller'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['GenderID'] = $_POST['GenderID'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Bank'] = $_POST['Bank'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['BankAccountNo'] = $_POST['BankAccountNo'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['SecondaryBank'] = $_POST['SecondaryBank'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['SecondaryBankAccountNo'] = $_POST['SecondaryBankAccountNo'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['DOBFrom'] = $_POST['DOBFrom'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['DOBTo'] = $_POST['DOBTo'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['NRIC'] = $_POST['NRIC'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Passport'] = $_POST['Passport'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Nationality'] = $_POST['Nationality'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Prompt'] = $_POST['Prompt'];
			$_SESSION['reseller_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['reseller_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['reseller_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['reseller_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['reseller_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM reseller ".$_SESSION['reseller_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/reseller/index';
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

		$sql = "SELECT * FROM reseller ".$_SESSION['reseller_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Report' => ResellerModel::getResellerReport($row['ID'], $filename),
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
            'NationalityID' => $row['Nationality'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => CRUD::isActive($row['Prompt']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		/*Debug::displayArray($result);
		exit;*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Resellers", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'reseller_delete' => $_SESSION['admin']['reseller_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.reseller_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['reseller_delete']);

		return $this->output;
	}



	public function AdminAdd()
	{
	    if ($_SESSION['admin']['reseller_add_info']!="")
        {
            $form_input = $_SESSION['admin']['reseller_add_info'];

            // Unset temporary reseller info input
            unset($_SESSION['admin']['reseller_add_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Reseller", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'reseller_add' => $_SESSION['admin']['reseller_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.reseller_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Reseller"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'bank_list' => BankModel::getBankList()), /*'country_list' => CountryModel::getCountryList()),*/
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['reseller_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
	   /* if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM reseller WHERE NRIC = '".$_POST['NRIC']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM reseller WHERE Passport = '".$_POST['Passport']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM reseller WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/
            
        $i_bank = 0;
        
        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {
            
            
            
        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);
        
            if($bankCount == '0')
            {
                
            }
            else
            {
                $i_bank += 1;
            } 
            
        }     

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }
                       
            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            $_SESSION['admin']['reseller_add_info'] = Helper::unescape($_POST);
        }
        else
        {
    	    $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

			// echo $_POST['SecondaryBank'];
			// echo $_POST['SecondaryBankAccountNo'];


    		$key = "(Credit, GenderID, Name, Profitsharing, Company, Bank, BankAccountNo, SecondaryBank, SecondaryBankAccountNo, DOB, NRIC, Passport, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Colour, Prompt, Enabled)";
    		$value = "('".$_POST['Credit']."', '".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['Profitsharing']."', '".$_POST['Company']."', '".$_POST['Bank']."', '".$_POST['BankAccountNo']."', '".$_POST['SecondaryBank']."', '".$_POST['SecondaryBankAccountNo']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$_POST['Colour']."', '".$_POST['Prompt']."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO reseller ".$key." VALUES ". $value;
// echo $sql;
// exit;
    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();


					/*$Product = ProductModel::getProductList();

					for ($i=0; $i <$Product['count'] ; $i++) {
					$key = "(Total, ProductID, MemberID, Enabled)";
					$value = "('0', '".$Product[$i]['ID']."', '".$newID."', '1')";


					$sql = "INSERT INTO wallet ".$key." VALUES ". $value;
					//echo $sql;
					$this->dbconnect->exec($sql);
					}*/



            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Reseller...", 'template' => 'admin.common.tpl.php'),
		'content' => Helper::unescape($_POST),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM reseller WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => $row['GenderID'],
			'Name' => $row['Name'],
			'Profitsharing' => $row['Profitsharing'],
			'Company' => $row['Company'],
			'Credit' => $row['Credit'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
                        'Colour' => $row['Colour'],    
			'Prompt' => $row['Prompt'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        if ($_SESSION['admin']['reseller_edit_info']!="")
        {
            $form_input = $_SESSION['admin']['reseller_edit_info'];

            // Unset temporary reseller info input
            unset($_SESSION['admin']['reseller_edit_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Reseller", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'reseller_add' => $_SESSION['admin']['reseller_add'], 'reseller_edit' => $_SESSION['admin']['reseller_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.reseller_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Reseller"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'reseller_list' => ResellerModel::getResellerList(), 'bank_list' => BankModel::getBankList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['reseller_add']);
		unset($_SESSION['admin']['reseller_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
	    /*if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM reseller WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$param."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM reseller WHERE Passport = '".$_POST['Passport']."' AND ID != '".$param."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM reseller WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/
            
        $i_bank = 0;
        
        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {
            
            
            
        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);
        
            if($bankCount == '0')
            {
                
            }
            else
            {
                $i_bank += 1;
            } 
            
        }    

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }
            
            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            $_SESSION['admin']['reseller_edit_info'] = Helper::unescape($_POST);
        }
        else
        {
            if ($_POST['NewPassword']==1)
            {
                $bcrypt = new Bcrypt(9);
                $hash = $bcrypt->hash($_POST['Password']);
            }
            else
            {
                $hash = $this->getHash($param);
            }

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

    		$sql = "UPDATE reseller SET Credit='".$_POST['Credit']."', GenderID='".$_POST['GenderID']."', Name='".$_POST['Name']."', Profitsharing='".$_POST['Profitsharing']."', Company='".$_POST['Company']."', Bank='".$_POST['Bank']."', BankAccountNo='".$_POST['BankAccountNo']."', SecondaryBank='".$_POST['SecondaryBank']."', SecondaryBankAccountNo='".$_POST['SecondaryBankAccountNo']."', DOB='".Helper::dateDisplaySQL($_POST['DOB'])."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Nationality='".$_POST['Nationality']."', Username='".$_POST['Username']."', Password='".$hash."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', Colour='".$_POST['Colour']."', Prompt='".$_POST['Prompt']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";
			//echo $sql;
			//exit;
    		$count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Reseller...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM reseller WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Reseller...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getAllResellerID(){
		$sql = "SELECT COUNT(ID) FROM reseller";
		$result = $this->dbconnect->query($sql);
		$result = $result->fetchColumn();
		if ($result==1) {
			$sql = "SELECT ID FROM reseller";
			$result = $this->dbconnect->query($sql);
			$result = $result->fetchColumn();
		} else {
			$sql = "SELECT ID FROM reseller";

			foreach($this->dbconnect->query($sql) as $row){
				$ID .= $row['ID'].',';
			}
			$ID = rtrim($ID,',');
			$result = '('.$ID.')';
		}

		return $result;

	}

	public function getResellerCredit()
	{

		$sql = "SELECT * FROM reseller WHERE ID = '".$_SESSION['reseller']['ID']."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array('Credit' => $row['Credit']);
		}
		$_SESSION['reseller']['Credit'] = $result[0]['Credit'];
	}

	public function getReseller($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM reseller WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Credit' => $row['Credit'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
                        'Colour' => $row['Colour'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}



		return $result;
	}

	public function getResellerNameWithoutKey($param)
	{

		$sql = "SELECT Name FROM reseller WHERE ID = '".$param."'";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['Name'];
		}

		return $result;
	}

	public function getResellerAdminReport($param, $filename)
	{
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$param."'";
		foreach ($this->dbconnect->query($sql) as $row)
			{

				//$result[$i] = array('In' => Helper::displayCurrency($row['t_Debit']),'Out' => Helper::displayCurrency($row['t_Credit']));
				$Profitsharing = $row['Profitsharing'];
				//$i += 1;


			}


		$month = date('m', strtotime($_SESSION['reseller_'.$filename]['Month']));

		$year = $_SESSION['reseller_'.$filename]['Year'];
		//echo $param;

		/*if ($_POST['Month']=='') {
		    $DateFrom = "";
		} else {
		    $DateFrom = " AND t.Date BETWEEN '".$_POST['Month']."'";
		}

		if ($_POST['Year']=='') {
		    $DateTo = "";
		} else {
		    $DateTo = " AND '".$_POST['Year']."'";
		}*/


			$sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$param."' AND t.MemberID = m.ID AND t.Date >= '{$year}-{$month}-01 00:00:00' and t.Date <= '{$year}-{$month}-31 23:59:59' AND t.Status = '2'";
			/*echo $sql;
			exit;*/
			$result = array();
			//$transaction['count'] = $result['count'];
			//$i = 0;



			foreach ($this->dbconnect->query($sql) as $row)
			{

				//$result[$i] = array('In' => Helper::displayCurrency($row['t_Debit']),'Out' => Helper::displayCurrency($row['t_Credit']));
				$In += $row['t_Debit'];
				$Out += $row['t_Credit'];
				$Bonus += $row['t_Bonus'];
				$Commission += $row['t_Commission'];
				//$i += 1;


			}


			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			/*if($In != 0){

			$Total = $Total/$In;

			$Percentage = $Total * 100;

			}*/
			$Percentage = $profit * ($Profitsharing/100);

			$result = array('Reseller' => ResellerModel::getReseller($param),'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));
			/*Debug::displayArray($result);
			exit;*/


		unset($profit);
		unset($In);
		unset($Out);
		unset($Total);
		unset($Percentage);

		return $result;
	}

    public function getResellersMonthsReport($filename, $reseller)
	{
		$result = array();

		$year = $_SESSION['reseller_'.$filename]['Year'];
		/*echo $year;
		exit;*/

		$sql = "SELECT group_concat(`ID` separator ',') AS IDs FROM reseller";

		foreach ($this->dbconnect->query($sql) as $row){

			$IDs = $row['IDs'];

		}
		//echo $IDs;
		$ID = explode(",", $IDs);
		$ID['count'] = count($ID);

		/*Debug::displayArray($ID);
		exit;*/
		//for ($i=1; $i <= 12; $i++) {

		$crud = new CRUD();



				for ($i=1; $i <= 12; $i++) {



				if($i == 1) {


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}
				    //case "1":
				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-01-01 00:00:00' AND t.Date <= '{$year}-01-31 23:59:59' AND t.Status = '2'";

		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			       }
            $result[$i]['month'] = "January";
			$result[$i]['year'] = $year;
				 /*Debug::displayArray($result);
				 exit;*/
				    }elseif($i == 2){



		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";
			foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-02-01 00:00:00' AND t.Date <= '{$year}-02-28 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}    //break;

			$result[$i]['month'] = 'February';
			$result[$i]['year'] = $year;

				    }elseif($i == 3){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-03-01 00:00:00' AND t.Date <= '{$year}-03-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


			}

			$result[$i]['month'] = 'March';
			$result[$i]['year'] = $year;

				    }elseif($i == 4){

				for ($z=0; $z < $ID['count']; $z++) {



		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-04-01 00:00:00' AND t.Date <= '{$year}-04-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);
				        //break;

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}

			$result[$i]['month'] = 'April';
			$result[$i]['year'] = $year;

					}elseif($i == 5){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-05-01 00:00:00' AND t.Date <= '{$year}-05-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			  }

				$result[$i]['month'] = 'May';
				$result[$i]['year'] = $year;

					}elseif($i == 6){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-06-01 00:00:00' AND t.Date <= '{$year}-06-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}
				    $result[$i]['month'] = 'June';
					$result[$i]['year'] = $year;

					}elseif($i == 7){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-07-01 00:00:00' AND t.Date <= '{$year}-07-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}
				     $result[$i]['month'] = 'July';
					 $result[$i]['year'] = $year;

					}elseif($i == 8){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-08-01 00:00:00' AND t.Date <= '{$year}-08-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}

					$result[$i]['month'] = 'August';
					$result[$i]['year'] = $year;

					}elseif($i == 9){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-09-01 00:00:00' AND t.Date <= '{$year}-09-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}

				   $result[$i]['month'] = 'September';
				   $result[$i]['year'] = $year;

					}elseif($i == 10){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-10-01 00:00:00' AND t.Date <= '{$year}-10-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}
				        //break;
				    $result[$i]['month'] = 'October';
					$result[$i]['year'] = $year;

					}elseif($i == 11){

				for ($z=0; $z < $ID['count']; $z++) {



		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-11-01 00:00:00' AND t.Date <= '{$year}-11-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

				               }

					$result[$i]['month'] = 	'November';
					$result[$i]['year'] = $year;

					}elseif($i == 12){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-12-01 00:00:00' AND t.Date <= '{$year}-12-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Reseller'] = ResellerModel::getReseller($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			/*'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));*/

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				}
				$result[$i]['month'] = 'December';
				$result[$i]['year'] = $year;

				}



			//}

        }
        /*Debug::displayArray($result);
        exit;*/
        $result['count'] = $ID['count'];
		return $result;

	}

	public function getResellerMonthsReport($filename, $reseller)
	{
		$result = array();

		$year = $_SESSION['reseller_'.$filename]['Year'];
		$month = $_SESSION['reseller_'.$filename]['Month'];
		/*echo $month;
		exit;*/

		/*$sql = "SELECT group_concat(`ID` separator ',') AS IDs FROM reseller";

		foreach ($this->dbconnect->query($sql) as $row){

			$IDs = $row['IDs'];

		}
		//echo $IDs;
		$ID = explode(",", $IDs);
		$ID['count'] = count($ID);*/

		/*Debug::displayArray($ID);
		exit;*/
		//for ($i=1; $i <= 12; $i++) {
		/*echo $reseller;
		exit;*/


		$crud = new CRUD();







				if($month == 'January') {





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}
				    //case "1":
				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-01-01 00:00:00' AND t.Date <= '{$year}-01-31 23:59:59' AND t.Status = '2'";

		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


            $result['0']['month'] = "January";
			$result['0']['year'] = $year;
				 /*Debug::displayArray($result);
				 exit;*/
				    }elseif($month == 'February'){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";
			foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-02-01 00:00:00' AND t.Date <= '{$year}-02-28 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			    //break;

			$result['0']['month'] = 'February';
			$result['0']['year'] = $year;

				    }elseif($month == 'March'){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-03-01 00:00:00' AND t.Date <= '{$year}-03-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);




			$result['0']['month'] = 'March';
			$result['0']['year'] = $year;

				    }elseif($month == 'April'){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-04-01 00:00:00' AND t.Date <= '{$year}-04-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);
				        //break;

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			/*Debug::displayArray($result);
			exit;*/
			//$result['0']['month'] = 'April';
			//$result['0']['year'] = $year;

					}elseif($month == 'May'){




		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-05-01 00:00:00' AND t.Date <= '{$year}-05-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result['0']['month'] = 'May';
				$result['0']['year'] = $year;

					}elseif($month == 'June'){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-06-01 00:00:00' AND t.Date <= '{$year}-06-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				    $result['0']['month'] = 'June';
					$result['0']['year'] = $year;

					}elseif($month == 'July'){




		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-07-01 00:00:00' AND t.Date <= '{$year}-07-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

				     $result['0']['month'] = 'July';
					 $result['0']['year'] = $year;

					}elseif($month == 'August'){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-08-01 00:00:00' AND t.Date <= '{$year}-08-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result['0']['month'] = 'August';
					$result['0']['year'] = $year;

					}elseif($month == 'September'){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-09-01 00:00:00' AND t.Date <= '{$year}-09-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				   $result['0']['month'] = 'September';
				   $result['0']['year'] = $year;

					}elseif($month == 'October'){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-10-01 00:00:00' AND t.Date <= '{$year}-10-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				        //break;
				    $result['0']['month'] = 'October';
					$result['0']['year'] = $year;

					}elseif($month == 'November'){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-11-01 00:00:00' AND t.Date <= '{$year}-11-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result['0']['month'] = 	'November';
					$result['0']['year'] = $year;

					}elseif($month == 'December'){




		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-12-01 00:00:00' AND t.Date <= '{$year}-12-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			/*'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));*/

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result['0']['month'] = 'December';
				$result['0']['year'] = $year;

				}



			//}


        /*Debug::displayArray($result);
        exit;*/
        $result['count'] = count($result);
		return $result;

	}

	public function getResellerAllMonthsReport($reseller)
	{
		$result = array();

		$year = $_SESSION['reseller_AdminReport']['Year'];
		/*echo $year;
		exit;*/


		/*Debug::displayArray($ID);
		exit;*/
		//for ($i=1; $i <= 12; $i++) {

		$crud = new CRUD();



				for ($i=1; $i <= 12; $i++) {



				if($i == 1) {





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}
				    //case "1":
				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-01-01 00:00:00' AND t.Date <= '{$year}-01-31 23:59:59' AND t.Status = '2'";

		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


            $result[$i]['0']['month'] = "January";
			$result[$i]['0']['year'] = $year;
				 /*Debug::displayArray($result);
				 exit;*/
				    }elseif($i == 2){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";
			foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-02-01 00:00:00' AND t.Date <= '{$year}-02-28 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			   //break;

			$result[$i]['0']['month'] = 'February';
			$result[$i]['0']['year'] = $year;

				    }elseif($i == 3){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-03-01 00:00:00' AND t.Date <= '{$year}-03-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);




			$result[$i]['0']['month'] = 'March';
			$result[$i]['0']['year'] = $year;

				    }elseif($i == 4){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-04-01 00:00:00' AND t.Date <= '{$year}-04-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);
				        //break;

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


			$result[$i]['0']['month'] = 'April';
			$result[$i]['0']['year'] = $year;

					}elseif($i == 5){




		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-05-01 00:00:00' AND t.Date <= '{$year}-05-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result[$i]['0']['month'] = 'May';
				$result[$i]['0']['year'] = $year;

					}elseif($i == 6){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-06-01 00:00:00' AND t.Date <= '{$year}-06-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				    $result[$i]['0']['month'] = 'June';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 7){




		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-07-01 00:00:00' AND t.Date <= '{$year}-07-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

				     $result[$i]['0']['month'] = 'July';
					 $result[$i]['0']['year'] = $year;

					}elseif($i == 8){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-08-01 00:00:00' AND t.Date <= '{$year}-08-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result[$i]['0']['month'] = 'August';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 9){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-09-01 00:00:00' AND t.Date <= '{$year}-09-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				   $result[$i]['0']['month'] = 'September';
				   $result[$i]['0']['year'] = $year;

					}elseif($i == 10){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-10-01 00:00:00' AND t.Date <= '{$year}-10-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				        //break;
				    $result[$i]['0']['month'] = 'October';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 11){





		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-11-01 00:00:00' AND t.Date <= '{$year}-11-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result[$i]['0']['month'] = 	'November';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 12){



		        $sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$reseller."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Reseller = '".$reseller."' AND t.MemberID = m.ID AND t.Date >= '{$year}-12-01 00:00:00' AND t.Date <= '{$year}-12-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Reseller'] = ResellerModel::getReseller($reseller);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			/*'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));*/

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result[$i]['0']['month'] = 'December';
				$result[$i]['0']['year'] = $year;

				}



			//}

        }
        /*Debug::displayArray($result);
        exit;*/
        $result['count'] = count($result);
		return $result;

	}

	public function getResellerReport($param, $filename)
	{
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$param."'";
		#echo $sql;

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}

        // Set Date From
		if ($_SESSION['transaction_'.$filename]['param']['t.DateFrom']=='')
		{
		    $DateFrom = "";
		}
		else
		{
		    $DateFrom = " AND t.Date >= '".Helper::dateTimeDisplaySQL($_SESSION['transaction_'.$filename]['param']['t.DateFrom'])."'";
		}

        // Set Date To
		if ($_SESSION['transaction_'.$filename]['param']['t.DateTo']=='')
		{
		    $DateTo = "";
		}
		else
		{
		    $DateTo = " AND t.Date <='".Helper::dateTimeDisplaySQL($_SESSION['transaction_'.$filename]['param']['t.DateTo'])."'";
		}

		if ($_SESSION['transaction_'.$filename]['param']['t.MemberID']=='')
		{
			$sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Reseller = '".$param."' AND t.Status = '2'".$DateFrom.$DateTo;

			/*echo $sql;
			exit;*/
		}

		if ($_SESSION['transaction_'.$filename]['param']['t.MemberID']!='')
		{
			$sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t WHERE t.MemberID = '".$_SESSION['transaction_'.$filename]['param']['t.MemberID']."' AND t.Status = '2'".$DateFrom.$DateTo;

		    /*echo $sql;
			exit;*/
        }

        /*if ($_SERVER['REMOTE_ADDR'] == '60.50.121.163') {
            echo $sql;
        }*/

		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$In += $row['t_Debit'];
			$Out += $row['t_Credit'];
			$Commission += $row['t_Commission'];
			$Bonus += $row['t_Bonus'];

            /*if ($_SERVER['REMOTE_ADDR'] == '60.50.121.163') {
                echo $In;
                echo "<br />";
                echo $Out;
                echo "<br />";
                echo $Commission;
                echo "<br />";
                echo $Bonus;
                echo "<br />";
                echo "<br />";
            }*/
		}

		$profit = $In - $Out - $Commission - $Bonus;
		$Total = $In - $Out - $Commission - $Bonus;

		$Percentage = $profit * ($Profitsharing/100);
		//double

		$result = array('In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Commission'=> Helper::displayCurrency($Commission),'Bonus'=> Helper::displayCurrency($Bonus), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));

		#Debug::displayArray($result);

		unset($profit);
		unset($In);
		unset($Out);
        unset($Commission);
        unset($Bonus);
		unset($Total);
		unset($Percentage);

		return $result;
	}

	public function getResellerCreditReport()
	{
		$crud = new CRUD();

		// Initialise query conditions
		$query_condition = "";

		//if ($_POST['Trigger']=='search_form'){
			// Reset Query Variable
			$_SESSION['resellercredit_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=",1);
			/*$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");*/
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']) : Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Out'],"LIKE");
			//$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['resellercredit_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['DateFrom'] = Helper::dateTimeDisplaySQL($_POST['DateFrom']);
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['DateTo'] = Helper::dateTimeDisplaySQL($_POST['DateTo']);
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			//$_SESSION['resellercredit_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['resellercredit_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['resellercredit_'.__FUNCTION__]['query_title'] = "Search Results";

		//}
		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['resellercredit_'.__FUNCTION__]);
		}


		if ($_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateFrom']=='')
		{
		    $DateFrom = "";
		}
		else
		{
		    $DateFrom = " AND t.Date >= '".$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateFrom']."'";
		}

        // Set Date To
		if ($_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateTo']=='')
		{
		    $DateTo = "";
		}
		else
		{
		    $DateTo = " AND t.Date <='".$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateTo']."'";
		}

		$sql = "SELECT * FROM reseller_credit WHERE ResellerID = '".$_SESSION['reseller']['ID']."' AND Status = '2' ".$_SESSION['resellercredit_'.__FUNCTION__]['query_condition']." Order By Date DESC";
		/*echo $sql;
		exit;
		/*foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}*/

        // Set Date From

		$result = array();

		$i = 0;

		foreach ($this->dbconnect->query($sql) as $row)
			{

				$transaction[$i] = array(
				'ID' => $row['ID'],
				'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
				'Report' => ResellerModel::getResellerReport($_SESSION['reseller']['ID'], $filename),
				'MemberID' => MemberModel::getMemberName($row['MemberID']),
				'Description' => $row['Description'],
				'RejectedRemark' => $row['RejectedRemark'],
				'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
				'TransferTo' => $row['TransferTo'],
				'TransferFrom' => $row['TransferFrom'],
				'DepositBonus' => $row['DepositBonus'],
				'DepositChannel' => $row['DepositChannel'],
				'ReferenceCode' => $row['ReferenceCode'],
	            'Bank' => $row['Bank'],
				'In' => $row['Debit'],
				'Out' => $row['Credit'],
				'Amount' => $row['Amount'],
				'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

				$In += $transaction[$i]['In'];
			    $Out += $transaction[$i]['Out'];

				$i += 1;

			}

		$balance = $In - $Out;


		$report =array('TotalIn' => Helper::displayCurrency($In), 'TotalOut' => Helper::displayCurrency($Out), 'Balance' => Helper::displayCurrency($balance));

		#Debug::displayArray($result);

		/*unset($profit);
		unset($In);
		unset($Out);
        unset($Commission);
        unset($Bonus);
		unset($Total);
		unset($Percentage);*/

		return $report;
	}

	public function getResellerAdminCreditReport()
	{
		$crud = new CRUD();

		// Initialise query conditions
		$query_condition = "";

		//if ($_POST['Trigger']=='search_form'){
			// Reset Query Variable
			$_SESSION['resellercredit_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=", 1);
			$query_condition .= $crud->queryCondition("ResellerID",$_POST['ResellerID'],"=");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']) : Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Out'],"LIKE");
			//$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['resellercredit_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['ResellerID'] = $_POST['ResellerID'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['DateFrom'] = Helper::dateTimeDisplaySQL($_POST['DateFrom']);
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['DateTo'] = Helper::dateTimeDisplaySQL($_POST['DateTo']);
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			//$_SESSION['resellercredit_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['resellercredit_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['resellercredit_'.__FUNCTION__]['query_title'] = "Search Results";

		//}
		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['resellercredit_'.__FUNCTION__]);
		}


		if ($_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateFrom']=='')
		{
		    $DateFrom = "";
		}
		else
		{
		    $DateFrom = " AND t.Date >= '".$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateFrom']."'";
		}

        // Set Date To
		if ($_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateTo']=='')
		{
		    $DateTo = "";
		}
		else
		{
		    $DateTo = " AND t.Date <='".$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateTo']."'";
		}

		$sql = "SELECT * FROM reseller_credit WHERE Status = '2' ".$_SESSION['resellercredit_'.__FUNCTION__]['query_condition']."  Order By Date DESC";
		/*echo $sql;
		exit;
		/*foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}*/

        // Set Date From

		$result = array();

		$i = 0;

		foreach ($this->dbconnect->query($sql) as $row)
			{

				$transaction[$i] = array(
				'ID' => $row['ID'],
				'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
				'Report' => ResellerModel::getResellerReport($_SESSION['reseller']['ID'], $filename),
				'MemberID' => MemberModel::getMemberName($row['MemberID']),
				'Description' => $row['Description'],
				'RejectedRemark' => $row['RejectedRemark'],
				'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
				'TransferTo' => $row['TransferTo'],
				'TransferFrom' => $row['TransferFrom'],
				'DepositBonus' => $row['DepositBonus'],
				'DepositChannel' => $row['DepositChannel'],
				'ReferenceCode' => $row['ReferenceCode'],
	            'Bank' => $row['Bank'],
				'In' => $row['Debit'],
				'Out' => $row['Credit'],
				'Amount' => $row['Amount'],
				'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

				$In += $transaction[$i]['In'];
			    $Out += $transaction[$i]['Out'];

				$i += 1;

			}

		$balance = $In - $Out;


		$report =array('TotalIn' => Helper::displayCurrency($In), 'TotalOut' => Helper::displayCurrency($Out), 'Balance' => Helper::displayCurrency($balance));

		#Debug::displayArray($result);

		/*unset($profit);
		unset($In);
		unset($Out);
        unset($Commission);
        unset($Bonus);
		unset($Total);
		unset($Percentage);*/

		return $report;
	}

	public function getResellerMemberReport($param)
	{
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM reseller WHERE ID = '".$_SESSION['reseller']['ID']."'";
		foreach ($this->dbconnect->query($sql) as $row)
			{

				//$result[$i] = array('In' => Helper::displayCurrency($row['t_Debit']),'Out' => Helper::displayCurrency($row['t_Credit']));
				$Profitsharing = $row['Profitsharing'];
				//$i += 1;


			}

		if ($_POST['DateFrom']=='') {
		    $DateFrom = "";
		} else {
		    $DateFrom = " AND t.Date BETWEEN '".$_POST['DateFrom']."'";
		}

		if ($_POST['DateTo']=='') {
		    $DateTo = "";
		} else {
		    $DateTo = " AND '".$_POST['DateTo']."'";
		}

			$sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE t.MemberID = '".$param."' AND t.Status = '2'".$DateFrom.$DateTo;
			//echo $sql;
			//exit;
			$result = array();
			//$transaction['count'] = $result['count'];
			//$i = 0;



			foreach ($this->dbconnect->query($sql) as $row)
			{

				//$result[$i] = array('In' => Helper::displayCurrency($row['t_Debit']),'Out' => Helper::displayCurrency($row['t_Credit']));
				$In += $row['t_Debit'];
				$Out += $row['t_Credit'];
				$Bonus += $row['t_Bonus'];
				$Commission += $row['t_Commission'];
				//$i += 1;


			}


			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			/*if($In != 0){

			$Total = $Total/$In;

			$Percentage = $Total * 100;

			}*/
			$Percentage = $profit * ($Profitsharing/100);

			$result = array('In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' =>Helper::displayCurrency($Percentage));



		unset($profit);
		unset($In);
		unset($Out);
		unset($Total);
		unset($Percentage);

		return $result;
	}


	public function getResellerName($param)
	{
		$crud = new CRUD();

		$sql = "SELECT Name FROM reseller WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'Name' => $row['Name']);

			$i += 1;
		}
		$result = $result[0]['Name'];
		return $result;
	}

	public function getResellerList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM reseller ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			#'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

    public function getResellerListArray()
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM agent";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = $row['ID'];

            $i += 1;
        }

        return $result;
    }

	public function getResellerMemberList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member WHERE Agent = '".$_SESSION['reseller']['ID']."' ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function getResellerCount(){
		$sql = "SELECT COUNT(ID) FROM reseller";
		$result = $this->dbconnect->query($sql);
		$result = $result->fetchColumn();
		return $result;
	}

	public function AdminReportExport($param)
	{
		//$sql = "SELECT * FROM reseller ORDER BY Name ASC";

		//$month = date('m', strtotime($_SESSION['reseller_'.__FUNCTION__]['Month']));
		//$month = date_parse($month);
	    //Debug::displayArray($_SESSION['reseller_AdminReport']['Month']);
	    //Debug::displayArray($_SESSION['reseller_AdminReport']['Year']);
		//exit;


		$sql_resellers = "SELECT * FROM reseller ORDER BY Name ASC";
		$resellers = array();
		$j = 0;

		foreach ($this->dbconnect->query($sql_resellers) as $row)
		{
			$resellers[$j] = array('ID' => $row['ID']);

			$j += 1;
		}

		$resellers['count'] = $j;


		$result = array();
		$Report  = array();

		$result['content'] = '';
		$result['filename'] = $this->config['SITE_NAME']."_Resellers";



		$result['header'] .= $this->config['SITE_NAME']." | Resellers (" . date('Y-m-d H:i:s') . ")\n\n";
		$result['header'] .= "\"Search filter\",";
		$result['header'] .= "\"Month\":,";
		$result['header'] .= "\"".$_SESSION['reseller_AdminReport']['Month']."\",";
		$result['header'] .= "\"Year\":,";
		$result['header'] .= "\"".$_SESSION['reseller_AdminReport']['Year']."\"";

		//echo $resellers['count'];

		$result['content'].="\nReseller, In (MYR), Out (MYR), Bonus (MYR), Commission (MYR), Profit (MYR), Profit Sharing (%), Profit Sharing(MYR)\n\n";
		//$transaction = array();
		for ($z=0; $z <$resellers['count'] ; $z++) {

			//$sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Reseller = '".$resellers[$z]['ID']."' AND t.Date >= '{$_POST['Year']}/{$month}/01' and Date <= '{$_POST['Year']}/{$month}/31' AND t.Status = '2'";
			//echo $sql.'<br />';

			//$transaction['count'] = $result['count'];
			//$i = 0;

			//foreach ($this->dbconnect->query($sql) as $row)
			//{


				$Report = ResellerModel::getResellerAdminReport($resellers[$z]['ID'],$param);


				//$i += 1;


				/*$i = 0;
				/*foreach ($this->dbconnect->query($sql) as $row)
				{*/
					//$result['content'] .= "\"".$row['ID']."\",";
					$result['content'] .= "\"".$Report['Reseller'][0]['Name']."\",";
					$result['content'] .= "\"".$Report['In']."\",";
					$result['content'] .= "\"".$Report['Out']."\",";
					$result['content'] .= "\"".$Report['Bonus']."\",";
					$result['content'] .= "\"".$Report['Commission']."\",";
					/*$result['content'] .= "\"".$row['Company']."\",";
					$result['content'] .= "\"".$row['Bank']."\",";
					$result['content'] .= "\"".$row['BankAccountNo']."\",";
					$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DOB'])."\",";
					$result['content'] .= "\"".$row['NRIC']."\",";
					$result['content'] .= "\"".$row['Passport']."\",";
					$result['content'] .= "\"".CountryModel::getCountry($row['Nationality'])."\",";
					$result['content'] .= "\"".$row['Username']."\",";
					$result['content'] .= "\"".$row['Password']."\",";
					$result['content'] .= "\"".$row['PhoneNo']."\",";
					$result['content'] .= "\"".$row['FaxNo']."\",";
					$result['content'] .= "\"".$row['MobileNo']."\",";
					$result['content'] .= "\"".$row['Email']."\",";
					$result['content'] .= "\"".$row['Prompt']."\",";*/
					$result['content'] .= "\"".$Report['Profit']."\",";
					$result['content'] .= "\"".$Report['Profitsharing']."\",";
					$result['content'] .= "\"".$Report['Percentage']."\"\n";

					//$i += 1;
				//}


			//}





		}
		//$transaction['count'] = $z;

		//Helper::exportCSV($result['header'], $result['content'], $result['filename']);

		//Debug::displayArray($result['content']);
		//exit;


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Exporting..."),
		'content' => $result,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM reseller ".$_SESSION['reseller_'.$param]['query_condition']." ORDER BY Name ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Resellers";
		$result['header'] = $this->config['SITE_NAME']." | Resellers (" . date('Y-m-d H:i:s') . ")\n\nID, Credit, Gender, Name, Company, Bank, Bank Account No, DOB, NRIC, Passport, Nationality, Username, Phone No, Fax No, Mobile No, Email, Prompt, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
            $result['content'] .= "\"".$row['Credit']."\",";
			$result['content'] .= "\"".CRUD::getGender($row['GenderID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['Company']."\",";
			$result['content'] .= "\"".$row['Bank']."\",";
			$result['content'] .= "\"".$row['BankAccountNo']."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DOB'])."\",";
			$result['content'] .= "\"".$row['NRIC']."\",";
			$result['content'] .= "\"".$row['Passport']."\",";
			$result['content'] .= "\"".CountryModel::getCountry($row['Nationality'])."\",";
			$result['content'] .= "\"".$row['Username']."\",";
			$result['content'] .= "\"".$row['PhoneNo']."\",";
			$result['content'] .= "\"".$row['FaxNo']."\",";
			$result['content'] .= "\"".$row['MobileNo']."\",";
			$result['content'] .= "\"".$row['Email']."\",";
			$result['content'] .= "\"".$row['Prompt']."\",";
			$result['content'] .= "\"".$row['Enabled']."\"\n";

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

    public function getHash($param)
    {
        $sql = "SELECT Password FROM reseller WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Password' => $row['Password']);

            $i += 1;
        }

        return $result[0]['Password'];
    }


    public function verifyCookie($cookie_data)
    {
        $cookie_data = json_decode($cookie_data['Value'],true);

        $sql = "SELECT * FROM reseller WHERE Username = '".$cookie_data['Username']."' AND CookieHash = '".$cookie_data['Hash']."' AND Enabled = 1";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Username' => $row['Username'],
            'Email' => $row['Email'],
            'Name' => $row['Name']);

            $i += 1;
        }

        $result['count'] = $i;

        $this->output = array(
        'verify' => $result);

        return $this->output;
    }

}
?>