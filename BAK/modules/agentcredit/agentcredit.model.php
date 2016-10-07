<?php
// Require required models
Core::requireModel('member');
Core::requireModel('transaction');
Core::requireModel('transactiontype');
Core::requireModel('transactionstatus');
Core::requireModel('product');
Core::requireModel('wallet');
Core::requireModel('producttype');
Core::requireModel('staff');
Core::requireModel('agent');


class AgentCreditModel extends BaseModel
{
	private $output = array();
    private $module_name = "Agent Credit";
	private $module_dir = "modules/agentcredit/";
    private $module_default_url = "/main/agentcredit/index";
    private $module_default_admin_url = "/admin/agentcredit/index";
    private $module_default_member_url = "/member/agentcredit/index";
    private $module_default_agent_url = "/agent/agentcredit/index";
    private $module_default_agentgroup_url = "/agent/agentcredit/group";

    private $member_module_name = "Member";
    private $member_module_dir = "modules/member/";

	private $reseller_module_name = "Agent";
    private $reseller_module_dir = "modules/agent/";
	private $module_default_reseller_url = "/agent/agent/index";
        

	public function __construct()
	{
		parent::__construct();
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM reseller_credit WHERE 1 = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/resellercredit/index';
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

		$sql = "SELECT * FROM reseller_credit WHERE 1 = 1 ORDER BY TypeID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MemberID' => $row['MemberID'],
			'Description' => $row['Description'],
			'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			'Debit' => $row['Debit'],
			'Credit' => $row['Credit'],
			'Status' => $row['Status']);

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Transactions", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM reseller_credit WHERE ID = '".$param."' AND 1 = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MemberID' => $row['MemberID'],
			'Description' => $row['Description'],
			'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			'Debit' => $row['Debit'],
			'Credit' => $row['Credit'],
			'Status' => $row['Status']);

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/view.inc.php'),
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
		
		
		
			if ($_POST['Trigger']=='search_form'){
			
			// Reset Query Variable
			$_SESSION['agentcredit_'.__FUNCTION__] = "";
					
			$query_condition .= $crud->queryCondition("TypeID",$TypeID,"=");
			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=");
			$query_condition .= $crud->queryCondition("Description",$Description,"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$RejectedRemark,"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($DateFrom),">=");
            $query_condition .= $crud->queryCondition("Date",($DateTo!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']) : Helper::dateDisplaySQL($DateTo),"<=");
			$query_condition .= $crud->queryCondition("Debit",$Debit,"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$Credit,"LIKE");
			$query_condition .= $crud->queryCondition("Status",$Status,"LIKE");

			$_SESSION['agentcredit_'.__FUNCTION__]['param']['TypeID'] = $TypeID;
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Description'] = $Description;
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['RejectedRemark'] = $RejectedRemark;
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['DateFrom'] = $DateFrom;
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['DateTo'] = $DateTo;
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Debit'] = $Debit;
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Credit'] = $Credit;
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Status'] = $Status;

			// Set Query Variable
			$_SESSION['agentcredit_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentcredit_'.__FUNCTION__]['query_title'] = "Search Results";
			
			}
			// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentcredit_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agentcredit_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM agent_credit ".$_SESSION['agentcredit_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/agentcredit/index';
		$limit = 100;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM agent_credit ".$_SESSION['agentcredit_'.__FUNCTION__]['query_condition']." ORDER BY `Date` DESC LIMIT $start, $limit";
		/*echo $sql;
		exit;*/
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'AgentID' => AgentModel::getAgent($row['AgentID']),
			'Description' => $row['Description'],
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
			'DepositBonus' => $row['DepositBonus'],
			'DepositChannel' => $row['DepositChannel'],
			'ReferenceCode' => $row['ReferenceCode'],
			'In' => Helper::displayCurrency($row['Debit']),
			'Out' => Helper::displayCurrency($row['Credit']),
			'Amount' => Helper::displayCurrency((int)$row['Amount']),
			'Bank' => $row['Bank'],
			'StaffID' => StaffModel::getStaff($row['StaffID']),
			'ModifiedDate' => $row['ModifiedDate'],
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;

		}
			
			
				
			
		AgentModel::getAgentAdminCreditReport();
		
                $result2 = AgentModel::getAdminAgentAllParentChild();
			
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Credit Transactions", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'transaction_delete' => $_SESSION['admin']['transaction_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'summary' => AgentModel::getAgentAdminCreditReport(),
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList(), 'agent_list1' => $result2['result2'], 'agent_list2' => $result2['result3']),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Agent Credit Transactions", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Reseller Credit Transactions"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agentcredit_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(TypeID, AgentID, Description, RejectedRemark, Date, TransferTo, TransferFrom, Debit, Credit, Amount, DepositBonus, DepositChannel, ReferenceCode, Bank, StaffID, ModifiedDate, Status)";
		$value = "('".$_POST['TypeID']."', '".$_POST['AgentID']."', '".$_POST['Description']."', '".$_POST['RejectedRemark']."', '".Helper::dateTimeDisplaySQL($_POST['Date'])."', '".$_POST['TransferTo']."', '".$_POST['TransferFrom']."', '".$_POST['Debit']."', '".$_POST['Credit']."', '".$_POST['Amount']."', '".$_POST['DepositBonus']."', '".$_POST['DepositChannel']."', '".$_POST['ReferenceCode']."', '".$_POST['Bank']."', '".$_POST['StaffID']."', '".Helper::dateDisplaySQL($_POST['ModifiedDate'])."', '".$_POST['Status']."')";

		$sql = "INSERT INTO agent_credit ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Resellet Credit...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM agent_credit WHERE ID = '".$param."'";

		$result = array();
		$i = 0;


		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
                        'AgentID' => $row['AgentID'],
			'MemberID' => $row['MemberID'],
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
			'StaffID' => StaffModel::getStaff($row['StaffID']),
			'ModifiedDate' => Helper::dateSQLToDisplay($row['ModifiedDate']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;

		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Agent Credit Transactions", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'transaction_add' => $_SESSION['admin']['agentcredit_add'], 'transaction_edit' => $_SESSION['admin']['agentcredit_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Agent Credit Transactions"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['reseller_add']);
		unset($_SESSION['admin']['reseller_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
        #Debug::displayArray($_POST);
        #exit();

		$ModifierDetails = TransactionModel::getTransactionFull($param);

        if ($_POST['Status']!='1')
        {

            $staff_id = (($ModifierDetails['StaffID']=="")||($ModifierDetails['StaffID']=="0")) ? $_SESSION['admin']['ID'] : $ModifierDetails['StaffID'];
            $modified_date = (($ModifierDetails['ModifiedDate']=="")||($ModifierDetails['ModifiedDate']=="0000-00-00 00:00:00")) ? date('YmdHis') : $ModifierDetails['ModifiedDate'];
        }
        else
        {
            $staff_id = $ModifierDetails['StaffID'];
            $modified_date = $ModifierDetails['ModifiedDate'];
        }

		$sql = "UPDATE agent_credit SET TypeID='".$_POST['TypeID']."', AgentID='".$_POST['AgentID']."', Description='".$_POST['Description']."', RejectedRemark='".$_POST['RejectedRemark']."', Date='".Helper::dateTimeDisplaySQL($_POST['Date'])."', TransferTo='".$_POST['TransferTo']."', TransferFrom='".$_POST['TransferFrom']."', Debit='".$_POST['Debit']."', Credit='".$_POST['Credit']."', Amount='".$_POST['Amount']."', DepositBonus='".$_POST['DepositBonus']."', DepositChannel='".$_POST['DepositChannel']."', ReferenceCode='".$_POST['ReferenceCode']."', Bank='".$_POST['Bank']."', Status='".$_POST['Status']."', StaffID = '".$staff_id."', ModifiedDate = '".$modified_date."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Transaction...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM agent_credit WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Transaction...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminReseller($param)

	{
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form' || $_POST['Trigger']=='')
		{
			if ($_POST['Trigger']=='search_form'){
			// Reset Query Variable
			$_SESSION['resellercredit_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("t.TypeID",$_POST['TypeID'],"=",1);
			$query_condition .= $crud->queryCondition("t.MemberID",$_POST['MemberID'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("t.RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("t.Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']): Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("t.Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Credit",$_POST['Out'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Status",$_POST['Status'],"LIKE");

			$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.TypeID'] = $_POST['TypeID'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.Description'] = $_POST['Description'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.MemberID'] = $_POST['MemberID'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateTo'] = $_POST['DateTo'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.Debit'] = $_POST['Debit'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.Credit'] = $_POST['Credit'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['resellercredit_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['resellercredit_'.__FUNCTION__]['query_title'] = "Search Results";

		}
		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['resellercredit_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['resellercredit_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) FROM reseller_credit AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['resellercredit_'.__FUNCTION__]['query_condition']." AND m.Reseller = '".$param."'";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/resellercredit/reseller/'.$param;
		$limit = 100;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);



		//$sql = "SELECT * FROM reseller_credit WHERE MemberID = '".$_SESSION['member']['ID']."' ".$_SESSION['resellercredit_'.__FUNCTION__]['query_condition']." ORDER BY `Date` DESC LIMIT $start, $limit";

		/*$sql = "SELECT ID FROM member WHERE Reseller = '".$_SESSION['reseller']['ID']."'";
		//echo $sql;

		$result = array();
		$i = 0;

		foreach ($this->dbconnect->query($sql) as $row)
		{

			$result[$i] = array('ID' => $row['ID']);

			$i += 1;


		}

		$result['count'] = $i;

		for ($i=0; $i <$result['count'] ; $i++) {*/

			//$sql = "SELECT * FROM reseller_credit WHERE MemberID = '".$result[$i]['ID']."'";
			//ORDER BY m.ProfileID ASC, m.Name
			 $sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.RejectedRemark AS t_RejectedRemark, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status FROM reseller_credit AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['resellercredit_'.__FUNCTION__]['query_condition']." AND m.Reseller = '".$param."' Order By t.Date DESC LIMIT $start, $limit";


			/*echo $sql;
			exit;*/
			$transaction = array();
			//$transaction['count'] = $result['count'];
			$i = 0;

			foreach ($this->dbconnect->query($sql) as $row)
			{

				$transaction[$i] = array(
				'ID' => $row['t_ID'],
				'TypeID' => TransactionTypeModel::getTransactionType($row['t_TypeID']),
				'Report' => ResellerModel::getResellerReport($param, $filename),
				'UnformattedMemberID' => $row['t_MemberID'],
				'MemberID' => MemberModel::getMemberName($row['t_MemberID']),
				'Description' => $row['t_Description'],
				'RejectedRemark' => $row['t_RejectedRemark'],
				'Date' => Helper::dateTimeSQLToDisplay($row['t_Date']),
				'TransferTo' => $row['t_TransferTo'],
				'TransferFrom' => $row['t_TransferFrom'],
				'DepositBonus' => $row['t_DepositBonus'],
				'DepositChannel' => $row['t_DepositChannel'],
				'ReferenceCode' => $row['t_ReferenceCode'],
	            'Bank' => $row['t_Bank'],
				'In' => Helper::displayCurrency($row['t_Debit']),
				'Out' => Helper::displayCurrency($row['t_Credit']),
				'Amount' => Helper::displayCurrency($row['t_Amount']),
				'Status' => TransactionStatusModel::getTransactionStatus($row['t_Status']));

				$i += 1;


			}

			$transaction['count'] = $i;

			}


			$report = array();
			$report = ResellerModel::getResellerReport($param, $filename);
			//echo $total_In.'<br />';
			//echo $total_Out;
			//exit;
		/*Debug::displayArray($transaction);
		exit;*/

		/*$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{*/
			// if ($row['TranferTo']&&$row['TransferFrom']=='0') {
				// $result[$i] = array(
			// 'ID' => $row['ID'],
			// 'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			// 'MemberID' => $row['MemberID'],
			// 'Description' => $row['Description'],
			// 'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			// 'TransferTo' => 'Not Available',
			// 'TransferFrom' => 'Not Available',
			// 'DepositBonus' => $row['DepositBonus'],
			// 'DepositChannel' => $row['DepositChannel'],
			// 'ReferenceCode' => $row['ReferenceCode'],
			// 'In' => $row['Debit'],
			// 'Out' => $row['Credit'],
			// 'Amount' => $row['Amount'],
			// 'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));
//
			// $i += 1;
			// } else {
			// $result[$i] = array(
			// 'ID' => $row['ID'],
			// 'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			// 'MemberID' => $row['MemberID'],
			// 'Description' => $row['Description'],
			// 'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			// 'TransferTo' => ProductModel::IDToProductName($row['TransferTo']),
			// 'TransferFrom' => ProductModel::IDToProductName($row['TransferFrom']),
			// 'DepositBonus' => $row['DepositBonus'],
			// 'DepositChannel' => $row['DepositChannel'],
			// 'ReferenceCode' => $row['ReferenceCode'],
			// 'In' => $row['Debit'],
			// 'Out' => $row['Credit'],
			// 'Amount' => $row['Amount'],
			// 'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));
//
			// $i += 1;
			// }

			/*$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'MemberID' => MemberModel::getMemberName($row['MemberID']),
			'Description' => $row['Description'],
			'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
			'DepositBonus' => $row['DepositBonus'],
			'DepositChannel' => $row['DepositChannel'],
			'ReferenceCode' => $row['ReferenceCode'],
            'Bank' => $row['Bank'],
			'In' => Helper::displayCurrency($row['Debit']),
			'Out' => Helper::displayCurrency($row['Credit']),
			'Amount' => Helper::displayCurrency($row['Amount']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;
		}*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Reseller Transactions", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/reseller.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
        'membertotal' =>  $membertotal,
		'breadcrumb' => HTML::getBreadcrumb($this->reseller_module_name,$this->module_default_admin_url,"admin",$this->config,"Reseller Transactions"),
		'content' => $transaction,
		'report' => $report,
		'ID' => $param,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberListByReseller($param), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		//unset($_SESSION['admin']['transaction_delete']);
		/*Debug::displayArray($this->output);
		exit;*/

		return $this->output;
	}

	public function MemberIndex($param)

	{

		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['resellercredit_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=",1);
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']): Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Out'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['resellercredit_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['DateFrom'] = $_POST['DateFrom'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['DateTo'] = $_POST['DateTo'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			$_SESSION['resellercredit_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['resellercredit_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['resellercredit_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['resellercredit_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['resellercredit_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM reseller_credit WHERE MemberID = '".$_SESSION['member']['ID']."' ".$_SESSION['resellercredit_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/member/resellercredit/index';
		$limit = 100;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM reseller_credit WHERE MemberID = '".$_SESSION['member']['ID']."' ".$_SESSION['resellercredit_'.__FUNCTION__]['query_condition']." ORDER BY `Date` DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			// if ($row['TranferTo']&&$row['TransferFrom']=='0') {
				// $result[$i] = array(
			// 'ID' => $row['ID'],
			// 'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			// 'MemberID' => $row['MemberID'],
			// 'Description' => $row['Description'],
			// 'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			// 'TransferTo' => 'Not Available',
			// 'TransferFrom' => 'Not Available',
			// 'DepositBonus' => $row['DepositBonus'],
			// 'DepositChannel' => $row['DepositChannel'],
			// 'ReferenceCode' => $row['ReferenceCode'],
			// 'In' => $row['Debit'],
			// 'Out' => $row['Credit'],
			// 'Amount' => $row['Amount'],
			// 'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));
//
			// $i += 1;
			// } else {
			// $result[$i] = array(
			// 'ID' => $row['ID'],
			// 'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			// 'MemberID' => $row['MemberID'],
			// 'Description' => $row['Description'],
			// 'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			// 'TransferTo' => ProductModel::IDToProductName($row['TransferTo']),
			// 'TransferFrom' => ProductModel::IDToProductName($row['TransferFrom']),
			// 'DepositBonus' => $row['DepositBonus'],
			// 'DepositChannel' => $row['DepositChannel'],
			// 'ReferenceCode' => $row['ReferenceCode'],
			// 'In' => $row['Debit'],
			// 'Out' => $row['Credit'],
			// 'Amount' => $row['Amount'],
			// 'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));
//
			// $i += 1;
			// }

			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
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
			'In' => Helper::displayCurrency($row['Debit']),
			'Out' => Helper::displayCurrency($row['Credit']),
			'Amount' => Helper::displayCurrency($row['Amount']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "My Transactions", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/index.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		//unset($_SESSION['admin']['transaction_delete']);

		return $this->output;
	}


	public function AgentIndex($param)
	{
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form' || $_POST['Trigger']=='')
		{
			if ($_POST['Trigger']=='search_form'){
			// Reset Query Variable
			$_SESSION['agentcredit_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=",1);
			/*$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");*/
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']) : Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Out'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"=");

			$_SESSION['agentcredit_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['DateFrom'] = Helper::dateTimeDisplaySQL($_POST['DateFrom']);
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['DateTo'] = Helper::dateTimeDisplaySQL($_POST['DateTo']);
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['agentcredit_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentcredit_'.__FUNCTION__]['query_title'] = "Search Results";

		}
		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentcredit_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agentcredit_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) FROM agent_credit WHERE AgentID = '".$_SESSION['agent']['ID']."' ".$_SESSION['agentcredit_'.__FUNCTION__]['query_condition'];
		/*echo $query_count;
		exit;*/
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/agent/agentcredit/index';
		$limit = 100;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);



		//$sql = "SELECT * FROM reseller_credit WHERE MemberID = '".$_SESSION['member']['ID']."' ".$_SESSION['resellercredit_'.__FUNCTION__]['query_condition']." ORDER BY `Date` DESC LIMIT $start, $limit";

		/*$sql = "SELECT ID FROM member WHERE Reseller = '".$_SESSION['reseller']['ID']."'";
		//echo $sql;

		$result = array();
		$i = 0;

		foreach ($this->dbconnect->query($sql) as $row)
		{

			$result[$i] = array('ID' => $row['ID']);

			$i += 1;


		}

		$result['count'] = $i;

		for ($i=0; $i <$result['count'] ; $i++) {*/

			//$sql = "SELECT * FROM reseller_credit WHERE MemberID = '".$result[$i]['ID']."'";
			//ORDER BY m.ProfileID ASC, m.Name
			 $sql = "SELECT * FROM agent_credit WHERE AgentID = '".$_SESSION['agent']['ID']."' ".$_SESSION['agentcredit_'.__FUNCTION__]['query_condition']." Order By Date DESC LIMIT $start, $limit";

			/*echo $sql;
			exit;*/	
			/*echo $sql;
			exit;*/
			$transaction = array();
			//$transaction['count'] = $result['count'];
			$i = 0;

			foreach ($this->dbconnect->query($sql) as $row)
			{

				$transaction[$i] = array(
				'ID' => $row['ID'],
				'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
				'Report' => AgentModel::getAgentReport($_SESSION['agent']['ID'], $filename),
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

				

				$i += 1;				
						
				
				
			}

			

			$transaction['count'] = $i;

			}


			$report = array();
			$report = AgentModel::getAgentReport($_SESSION['agent']['ID'], $filename);
			//echo $total_In.'<br />';
			//echo $total_Out;
			//exit;
		/*Debug::displayArray($transaction);
		exit;*/
		
/*Debug::displayArray($In);
exit;*/
		/*$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{*/
			// if ($row['TranferTo']&&$row['TransferFrom']=='0') {
				// $result[$i] = array(
			// 'ID' => $row['ID'],
			// 'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			// 'MemberID' => $row['MemberID'],
			// 'Description' => $row['Description'],
			// 'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			// 'TransferTo' => 'Not Available',
			// 'TransferFrom' => 'Not Available',
			// 'DepositBonus' => $row['DepositBonus'],
			// 'DepositChannel' => $row['DepositChannel'],
			// 'ReferenceCode' => $row['ReferenceCode'],
			// 'In' => $row['Debit'],
			// 'Out' => $row['Credit'],
			// 'Amount' => $row['Amount'],
			// 'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));
//
			// $i += 1;
			// } else {
			// $result[$i] = array(
			// 'ID' => $row['ID'],
			// 'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			// 'MemberID' => $row['MemberID'],
			// 'Description' => $row['Description'],
			// 'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			// 'TransferTo' => ProductModel::IDToProductName($row['TransferTo']),
			// 'TransferFrom' => ProductModel::IDToProductName($row['TransferFrom']),
			// 'DepositBonus' => $row['DepositBonus'],
			// 'DepositChannel' => $row['DepositChannel'],
			// 'ReferenceCode' => $row['ReferenceCode'],
			// 'In' => $row['Debit'],
			// 'Out' => $row['Credit'],
			// 'Amount' => $row['Amount'],
			// 'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));
//
			// $i += 1;
			// }

			/*$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'MemberID' => MemberModel::getMemberName($row['MemberID']),
			'Description' => $row['Description'],
			'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
			'DepositBonus' => $row['DepositBonus'],
			'DepositChannel' => $row['DepositChannel'],
			'ReferenceCode' => $row['ReferenceCode'],
            'Bank' => $row['Bank'],
			'In' => Helper::displayCurrency($row['Debit']),
			'Out' => Helper::displayCurrency($row['Credit']),
			'Amount' => Helper::displayCurrency($row['Amount']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;
		}*/
		
		//$filename = __FUNCTION__;
                        
		
		$param = $_SESSION['agent']['ID'];
		AgentModel::getAgentCredit($_SESSION['agent']['ID']);
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "My Agent Credit Transactions", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/index.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
        'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
        'membertotal' =>  $membertotal,                    
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"My Agent Credit Transactions"),
		'content' => $transaction,
		//'report' => $report,
		'report' => AgentModel::getAgentCreditReport($filename),
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		//unset($_SESSION['admin']['transaction_delete']);
		/*Debug::displayArray($this->output);
		exit;*/

		return $this->output;
	}
        
        public function AgentAdd()
	{
            $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                    $result2 = array();
                    $z = 0;
                    $tier = 1;
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                            $result2[$z] = array(
                                    'ID' => $row2['ID'],
                                    'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                    'Name' => $row2['Name'],
                                    'Company' => $row2['Company']);

                            $z += 1;
                    }

                    $result2['count'] = $z;
                    
                if($_SESSION['agent']['redirect'] == 'AgentGroup')
                {    
                    $breadcrumb = $this->module_default_agentgroup_url; 
                }
                elseif($_SESSION['agent']['redirect'] == 'AgentIndex')
                {
                    $breadcrumb = $this->module_default_agent_url;
                }  
                else 
                {
                    $breadcrumb = $this->module_default_agent_url;
                }    
            
		$this->output = array(
		'config' => $this->config,
                'content' => $result2,   
		'page' => array('title' => "Create Agent Credit Transactions", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/add.inc.php', 'agentcredit_add' => $_SESSION['agent']['transaction_add']),
		'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$breadcrumb,"",$this->config,"Create Agent Credit Transactions"),
                'back' => $_SESSION['agent']['redirect'],     
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

                unset($_SESSION['agent']['redirect']);
		unset($_SESSION['agent']['agentcredit_add']);

		return $this->output;
	}

	public function AgentAddProcess()
	{
		$key = "(TypeID, AgentID, Description, RejectedRemark, Date, TransferTo, TransferFrom, Debit, Credit, Amount, DepositBonus, DepositChannel, ReferenceCode, Bank, StaffID, ModifiedDate, Status)";
		$value = "('".$_POST['TypeID']."', '".$_POST['AgentID']."', '".$_POST['Description']."', '".$_POST['RejectedRemark']."', '".Helper::dateTimeDisplaySQL($_POST['Date'])."', '".$_POST['TransferTo']."', '".$_POST['TransferFrom']."', '".$_POST['Debit']."', '".$_POST['Credit']."', '".$_POST['Amount']."', '".$_POST['DepositBonus']."', '".$_POST['DepositChannel']."', '".$_POST['ReferenceCode']."', '".$_POST['Bank']."', '".$_POST['StaffID']."', '".Helper::dateDisplaySQL($_POST['ModifiedDate'])."', '".$_POST['Status']."')";

		$sql = "INSERT INTO agent_credit ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Resellet Credit...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentEdit($param)
	{
		$sql = "SELECT * FROM agent_credit WHERE ID = '".$param."'";

		$result = array();
		$i = 0;


		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
                        'AgentID' => $row['AgentID'],
			'MemberID' => $row['MemberID'],
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
			'StaffID' => StaffModel::getStaff($row['StaffID']),
			'ModifiedDate' => Helper::dateSQLToDisplay($row['ModifiedDate']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;

		}
                
                
                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";
                //echo $sql2;
                    $result2 = array();
                    $z = 0;
                    $tier = 1;
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                            $result2[$z] = array(
                                    'ID' => $row2['ID'],
                                    'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                    'Name' => $row2['Name'],
                                    'Company' => $row2['Company']);

                            $z += 1;
                    }
                    //Debug::displayArray($result2); 
                    //exit;
                    $result2['count'] = $z;
                    
                if($_SESSION['agent']['redirect'] == 'AgentGroup')
                {    
                    $breadcrumb = $this->module_default_agentgroup_url; 
                }
                elseif($_SESSION['agent']['redirect'] == 'AgentIndex')
                {
                    $breadcrumb = $this->module_default_agent_url;
                }
                else 
                {
                    $breadcrumb = $this->module_default_agent_url;
                }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Agent Credit Transactions", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php', 'agent_add' => $_SESSION['agent']['agentcredit_add'], 'transaction_edit' => $_SESSION['agent']['agentcredit_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$breadcrumb,"",$this->config,"Edit Agent Credit Transactions"),
                'back' => $_SESSION['agent']['redirect'],     
                'agent' => $result2,     
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

                unset($_SESSION['agent']['redirect']);
		unset($_SESSION['agent']['agent_add']);
		unset($_SESSION['agent']['agent_edit']);

		return $this->output;
	}

	public function AgentEditProcess($param)
	{
        #Debug::displayArray($_POST);
        #exit();

		$ModifierDetails = TransactionModel::getTransactionFull($param);

        if ($_POST['Status']!='1')
        {

            $staff_id = (($ModifierDetails['StaffID']=="")||($ModifierDetails['StaffID']=="0")) ? $_SESSION['agent']['ID'] : $ModifierDetails['StaffID'];
            $modified_date = (($ModifierDetails['ModifiedDate']=="")||($ModifierDetails['ModifiedDate']=="0000-00-00 00:00:00")) ? date('YmdHis') : $ModifierDetails['ModifiedDate'];
        }
        else
        {
            $staff_id = $ModifierDetails['StaffID'];
            $modified_date = $ModifierDetails['ModifiedDate'];
        }

		$sql = "UPDATE agent_credit SET TypeID='".$_POST['TypeID']."', AgentID='".$_POST['AgentID']."', Description='".$_POST['Description']."', RejectedRemark='".$_POST['RejectedRemark']."', Date='".Helper::dateTimeDisplaySQL($_POST['Date'])."', TransferTo='".$_POST['TransferTo']."', TransferFrom='".$_POST['TransferFrom']."', Debit='".$_POST['Debit']."', Credit='".$_POST['Credit']."', Amount='".$_POST['Amount']."', DepositBonus='".$_POST['DepositBonus']."', DepositChannel='".$_POST['DepositChannel']."', ReferenceCode='".$_POST['ReferenceCode']."', Bank='".$_POST['Bank']."', Status='".$_POST['Status']."', StaffID = '".$staff_id."', ModifiedDate = '".$modified_date."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Transaction...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        
        public function AgentGroupEdit($param)
	{
		$sql = "SELECT * FROM agent_credit WHERE ID = '".$param."'";

		$result = array();
		$i = 0;


		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
                        'AgentID' => $row['AgentID'],
			'MemberID' => $row['MemberID'],
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
			'StaffID' => StaffModel::getStaff($row['StaffID']),
			'ModifiedDate' => Helper::dateSQLToDisplay($row['ModifiedDate']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;

		}
                
                
                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";
                //echo $sql2;
                    $result2 = array();
                    $z = 0;
                    $tier = 1;
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                            $result2[$z] = array(
                                    'ID' => $row2['ID'],
                                    'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                    'Name' => $row2['Name'],
                                    'Company' => $row2['Company']);

                            $z += 1;
                    }
                    //Debug::displayArray($result2); 
                    //exit;
                    $result2['count'] = $z;

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Agent Credit Transactions", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php', 'agent_add' => $_SESSION['agent']['agentcredit_add'], 'transaction_edit' => $_SESSION['agent']['agentcredit_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Edit Agent Credit Transactions"),
                'agent' => $result2,     
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['reseller_add']);
		unset($_SESSION['admin']['reseller_edit']);

		return $this->output;
	}

	public function AgentGroupEditProcess($param)
	{
        #Debug::displayArray($_POST);
        #exit();

		$ModifierDetails = TransactionModel::getTransactionFull($param);

        if ($_POST['Status']!='1')
        {

            $staff_id = (($ModifierDetails['StaffID']=="")||($ModifierDetails['StaffID']=="0")) ? $_SESSION['admin']['ID'] : $ModifierDetails['StaffID'];
            $modified_date = (($ModifierDetails['ModifiedDate']=="")||($ModifierDetails['ModifiedDate']=="0000-00-00 00:00:00")) ? date('YmdHis') : $ModifierDetails['ModifiedDate'];
        }
        else
        {
            $staff_id = $ModifierDetails['StaffID'];
            $modified_date = $ModifierDetails['ModifiedDate'];
        }

		$sql = "UPDATE agent_credit SET TypeID='".$_POST['TypeID']."', ResellerID='".$_POST['ResellerID']."', Description='".$_POST['Description']."', RejectedRemark='".$_POST['RejectedRemark']."', Date='".Helper::dateTimeDisplaySQL($_POST['Date'])."', TransferTo='".$_POST['TransferTo']."', TransferFrom='".$_POST['TransferFrom']."', Debit='".$_POST['Debit']."', Credit='".$_POST['Credit']."', Amount='".$_POST['Amount']."', DepositBonus='".$_POST['DepositBonus']."', DepositChannel='".$_POST['DepositChannel']."', ReferenceCode='".$_POST['ReferenceCode']."', Bank='".$_POST['Bank']."', Status='".$_POST['Status']."', StaffID = '".$staff_id."', ModifiedDate = '".$modified_date."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Transaction...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentDelete($param)
	{
		$sql = "DELETE FROM agent_credit WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Transaction...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        
        public function AgentGroupDelete($param)
	{
		$sql = "DELETE FROM agent_credit WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Transaction...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        public function AgentGroup($param)
	{
                                   
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form' || $_POST['Trigger']=='')
		{
			//if ($_POST['Trigger']=='search_form'){
			// Reset Query Variable
			$_SESSION['agentcredit_'.__FUNCTION__] = "";
                        
                        
                          
                        $query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=",1);                           
			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']) : Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Out'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['agentcredit_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
                        $_SESSION['agentcredit_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['DateFrom'] = Helper::dateTimeDisplaySQL($_POST['DateFrom']);
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['DateTo'] = Helper::dateTimeDisplaySQL($_POST['DateTo']);
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['agentcredit_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentcredit_'.__FUNCTION__]['query_title'] = "Search Results";

		}
		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentcredit_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agentcredit_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
                        $search = "on";
		}
		else
		{
			$query_title = "All Results";
                        $search = "off";
		}
                
                /*$_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_SESSION['agent']['ID']);
                
                $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);
                
                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_SESSION['agent']['ID']);
                }
                
                
                $child = implode(',', $_SESSION['agentchild']);
                
                unset($_SESSION['agentchild']);*/
                
                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_SESSION['agent']['ID']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_SESSION['agent']['ID']);
                }


                $child = implode(',', $_SESSION['agentchild']);
                //echo $child;
                //exit;

                unset($_SESSION['agentchild']);


                    if(isset($_SESSION['agentcredit_'.__FUNCTION__]['param']['AgentID'])===true && empty($_SESSION['agentcredit_'.__FUNCTION__]['param']['AgentID'])===false)
                    {
                        $query_part = "";
                    }
                    else
                    {
                        $query_part = "AND AgentID IN (".$child.")";
                    }
                
                
                        
                
                        // Prepare Pagination
                        $query_count = "SELECT COUNT(*) FROM agent_credit WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentcredit_'.__FUNCTION__]['query_condition'];
                    
                    
                        /*echo $query_count;
                        exit;*/
                        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                        $targetpage = $data['config']['SITE_DIR'].'/agent/agentcredit/group';
                        $limit = 100;
                        $stages = 3;
                        $page = mysql_escape_string($_GET['page']);
                        if ($page) {
                                $start = ($page - 1) * $limit;
                        } else {
                                $start = 0;
                        }

                        // Initialize Pagination
                        $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

                        $sql = "SELECT * FROM agent_credit WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentcredit_'.__FUNCTION__]['query_condition']." Order By Date DESC LIMIT $start, $limit";
                    
                    
                    
                    
			$transaction = array();
			//$transaction['count'] = $result['count'];
			$i = 0;

			foreach ($this->dbconnect->query($sql) as $row)
			{

				$transaction[$i] = array(
				'ID' => $row['ID'],
                                'AgentID' => AgentModel::getAgent($row['AgentID'], "Name"),   
				'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
				'Report' => AgentModel::getAgentReport($_SESSION['agent']['ID'], $filename),
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

				

				$i += 1;				
						
				
				
			}

			

			$transaction['count'] = $i;

			//}


			$report = array();
			$report = AgentModel::getAgentReport($_SESSION['agent']['ID'], $filename);
			//echo $total_In.'<br />';
			//echo $total_Out;
			//exit;
		/*Debug::displayArray($transaction);
		exit;*/
		
/*Debug::displayArray($In);
exit;*/
		/*$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{*/
			// if ($row['TranferTo']&&$row['TransferFrom']=='0') {
				// $result[$i] = array(
			// 'ID' => $row['ID'],
			// 'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			// 'MemberID' => $row['MemberID'],
			// 'Description' => $row['Description'],
			// 'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			// 'TransferTo' => 'Not Available',
			// 'TransferFrom' => 'Not Available',
			// 'DepositBonus' => $row['DepositBonus'],
			// 'DepositChannel' => $row['DepositChannel'],
			// 'ReferenceCode' => $row['ReferenceCode'],
			// 'In' => $row['Debit'],
			// 'Out' => $row['Credit'],
			// 'Amount' => $row['Amount'],
			// 'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));
//
			// $i += 1;
			// } else {
			// $result[$i] = array(
			// 'ID' => $row['ID'],
			// 'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			// 'MemberID' => $row['MemberID'],
			// 'Description' => $row['Description'],
			// 'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			// 'TransferTo' => ProductModel::IDToProductName($row['TransferTo']),
			// 'TransferFrom' => ProductModel::IDToProductName($row['TransferFrom']),
			// 'DepositBonus' => $row['DepositBonus'],
			// 'DepositChannel' => $row['DepositChannel'],
			// 'ReferenceCode' => $row['ReferenceCode'],
			// 'In' => $row['Debit'],
			// 'Out' => $row['Credit'],
			// 'Amount' => $row['Amount'],
			// 'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));
//
			// $i += 1;
			// }

			/*$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'MemberID' => MemberModel::getMemberName($row['MemberID']),
			'Description' => $row['Description'],
			'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
			'DepositBonus' => $row['DepositBonus'],
			'DepositChannel' => $row['DepositChannel'],
			'ReferenceCode' => $row['ReferenceCode'],
            'Bank' => $row['Bank'],
			'In' => Helper::displayCurrency($row['Debit']),
			'Out' => Helper::displayCurrency($row['Credit']),
			'Amount' => Helper::displayCurrency($row['Amount']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;
		}*/
		
		//$filename = __FUNCTION__;
                        
                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                $result2 = array();
                $z = 0;
                $tier = 1;
                foreach ($this->dbconnect->query($sql2) as $row2)
                {
                        $result2[$z] = array(
                                'ID' => $row2['ID'],
                                'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                'Name' => $row2['Name'],
                                'Company' => $row2['Company']);

                        $z += 1;
                }

                $result2['count'] = $z;        
		
		$param = $_SESSION['agent']['ID'];
		AgentModel::getAgentCredit($_SESSION['agent']['ID']);
                
                
                $groupReport = AgentModel::getGroupAgentCreditReport($filename);
                    
                
                
                $_SESSION['agent']['redirect'] = __FUNCTION__;
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "My Group Transactions", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/index.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
                'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
                'membertotal' =>  $membertotal,
                'agent' => $result2,    
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentgroup_url,"",$this->config,"My Group Transactions"),
		'content' => $transaction,
		//'report' => $report,
		'report' => $groupReport,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'agent_list' => AgentModel::getAgentListByParent($_SESSION['agent']['ID'])),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		//unset($_SESSION['admin']['transaction_delete']);
		/*Debug::displayArray($this->output);
		exit;*/

		return $this->output;
	}


	public function MemberDeposit()
	{
        $result[1] = BlockModel::getBlockContent(47);
        $result[2] = BlockModel::getBlockContent(48);
        $result[3] = BlockModel::getBlockContent(49);
        $result[4] = BlockModel::getBlockContent(50);
        $result[5] = BlockModel::getBlockContent(51);
        $result[6] = BlockModel::getBlockContent(52);
        $result[7] = BlockModel::getBlockContent(53);
        $result[8] = BlockModel::getBlockContent(54);
        $result[9] = BlockModel::getBlockContent(55);
        $result[10] = BlockModel::getBlockContent(56);

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deposit", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/deposit.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,"Deposit"),
		'content' => $result,
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_add']);

		return $this->output;
	}

	public function MemberDepositProcess()
	{
		$date_deposit = "Date of Deposit: ".$_POST['DateDeposit'];
        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$key = "(MemberID, TypeID, Description, Date, DepositChannel, ReferenceCode, Bank, Debit, Status)";
		$value = "('".$_SESSION['member']['ID']."', '2', '".$date_deposit."', '".$date_posted."', '".$_POST['DepositChannel']."', '".$_POST['ReferenceCode']."', '".$_POST['bank']."', '".$_POST['Amount']."', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

        $member = MemberModel::getMember($_SESSION['member']['ID']);
        $reseller = ResellerModel::getReseller($member[0]['Reseller']);
        $reseller_email = $reseller[0]['Email'];

		$message = "<br /><br />Reseller:\t".$reseller[0]['Name']."<br />";
        $message .= "Description:\t".$date_deposit."<br />";
        $message .= "Date Posted:\t".$date_posted_display."<br />";
        $message .= "Deposit Channel:\t".$_POST['DepositChannel']."<br />";
        $message .= "Reference Code:\t".$_POST['ReferenceCode']."<br />";
        $message .= "Bank:\t".$_POST['bank']."<br />";
        $message .= "In (MYR):\t".$_POST['Amount']."<br /><br />";
        $message .= "Promo:\t".$_POST['PromoSpecial']."<br />";

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Deposit...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID, 'reseller_email' => $reseller_email),
		'message' => $message,
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MemberTransfer()
	{
		$productType = ProductTypeModel::getProductTypeList();

		$product = ProductModel::getProductList();

		$result = WalletModel::getWalletList();

		$nonmainwalletproduct = ProductModel::getNonMainWalletProduct();

		$mainwalletproduct = ProductModel::getMainWalletProduct();

        $product_list['casino'] = ProductModel::getProductListByType('1');

        $product_list['soccer'] = ProductModel::getProductListByType('2');

        $product_list['horse'] = ProductModel::getProductListByType('3');

        $product_list['poker'] = ProductModel::getProductListByType('6');

        $product_list['games'] = ProductModel::getProductListByType('7');

        $product_list['fourd'] = ProductModel::getProductListByType('8');

        $product_list['main'] = ProductModel::getProductListByType('5');

		#$total = WalletModel::getWalletTotal();

		//$product = ProductModel::getProductByType($productType[$i]['ID']);
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Transfer", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/transfer.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,"Transfer"),
		'content' => $result,
		'ProductType' =>$productType,
		'Product' =>$product,
		'WalletTotal' => $total,
		'content2' => $product_list,
		//'Product' => $product,
		'nonmainwallet' => $nonmainwalletproduct,
		'mainwallet' => $mainwalletproduct,
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'count' => $count),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_add']);

		return $this->output;
	}

	public function MemberTransferProcess()
	{

        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$transferFrom = WalletModel::getWalletByProductID($_POST['TransferFrom']);

		//if ($_POST['Amount']>$transferFrom) {
			//$valid = '0';
		//}elseif($_POST['Amount']<=$transferFrom){
			$key = "(MemberID, TypeID, Description, Date, TransferTo, TransferFrom, Amount, Status)";
			$value = "('".$_SESSION['member']['ID']."', '1', '".$_POST['description']."', '".$date_posted."', '".ProductModel::IDToProductName($_POST['TransferTo'])."', '".ProductModel::IDToProductName($_POST['TransferFrom'])."', '".$_POST['Amount']."', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		//}

        $member = MemberModel::getMember($_SESSION['member']['ID']);
        $reseller = ResellerModel::getReseller($member[0]['Reseller']);
        $reseller_email = $reseller[0]['Email'];

        $message = "<br /><br />Reseller:\t".$reseller[0]['Name']."<br />";
        $message .= "Date Posted:\t".$date_posted_display."<br />";
        $message .= "Transfer From:\t".ProductModel::IDToProductName($_POST['TransferFrom'])."<br />";
        $message .= "Transfer To:\t".ProductModel::IDToProductName($_POST['TransferTo'])."<br />";
        $message .= "Transfer Amount (MYR):\t".$_POST['Amount']."<br />";

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Transfer...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID, 'reseller_email' => $reseller_email),
        'message' => $message,
		//'valid' =>$valid,
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MemberWithdrawal()
	{
		$result = MemberModel::getMember($_SESSION['member']['ID']);
        $result['MainWallet'] = WalletModel::getMainWalletTotal();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Withdrawal", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/withdrawal.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,"Withdrawal"),
		'content' => $result,
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_add']);

		return $this->output;
	}

	public function MemberWithdrawalProcess()
	{
        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$BankDetails = MemberModel::getMember($_SESSION['member']['ID']);

        $description = "Bank: ".$_POST['Bank']." | Bank Account No: ".$_POST['BankAccountNo']." | Secondary Bank: ".$_POST['SecondaryBank']." | Secondary Bank Account No: ".$_POST['SecondaryBankAccountNo'];

		$key = "(MemberID, TypeID, Description, `Date`, Bank, Credit, Status)";
		$value = "('".$_SESSION['member']['ID']."', '3', '".$description."', '".$date_posted."', '".$_POST['Bank']."', '".$_POST['Amount']."', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		$sql = "UPDATE member SET Bank = '".$_POST['Bank']."', BankAccountNo = '".$_POST['BankAccountNo']."', SecondaryBank = '".$_POST['SecondaryBank']."', SecondaryBankAccountNo = '".$_POST['SecondaryBankAccountNo']."' WHERE ID = '".$BankDetails['content'][0]['ID']."'";

		$this->dbconnect->exec($sql);

        $member = MemberModel::getMember($_SESSION['member']['ID']);
        $reseller = ResellerModel::getReseller($member[0]['Reseller']);
        $reseller_email = $reseller[0]['Email'];

        $message = "<br /><br />Reseller:\t".$reseller[0]['Name']."<br />";
        $message .= "Description:\t".$description."<br />";
        $message .= "Date Posted:\t".$date_posted_display."<br />";
        $message .= "Bank:\t".$_POST['Bank']."<br />";
        $message .= "Out (MYR):\t".$_POST['Amount']."<br />";

        $member = MemberModel::getMember($_SESSION['member']['ID']);
        $reseller = ResellerModel::getReseller($member[0]['Reseller']);
        $reseller_email = $reseller[0]['Email'];

        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Deposit...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID, 'reseller_email' => $reseller_email),
        'message' => $message,
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	
	public function getResellerCredit($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM reseller_credit WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MemberID' => $row['MemberID'],
			'Description' => $row['Description'],
			'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			'Debit' => $row['Debit'],
			'Credit' => $row['Credit'],
			'Status' => $row['Status']);

			$i += 1;
		}

		$result = $result[0]['TypeID'];

		return $result;
	}

	public function getCreditSummary($post)
	{
		
		// Initialise query conditions
		$query_condition = "";
		
		$crud = new CRUD();
		
		
		

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['resellersummary_'.__FUNCTION__]);
		}

		
		
		//$summary = array();
		
		if($post == 'empty'){
			//echo '1';
			
		if ($_POST['Trigger']=='search_form')
		{
			
			// Reset Query Variable
			$_SESSION['resellersummary_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=", 1);
			//$query_condition .= $crud->queryCondition("ResellerID",$_POST['ResellerID'],"=");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
            $query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']) : Helper::dateDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['Debit'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Credit'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['resellersummary_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			//$_SESSION['resellersummary_'.__FUNCTION__]['param']['ResellerID'] = $_POST['ResellerID'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['DateFrom'] = Helper::dateTimeDisplaySQL($_POST['DateFrom']);
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['DateTo'] = Helper::dateTimeDisplaySQL($_POST['DateTo']);
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['resellersummary_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['resellersummary_'.__FUNCTION__]['query_title'] = "Search Results";
		}	
		
		$reseller = ResellerModel::getResellerList();
		//$summary = array();
		
		for ($i=0; $i <$reseller['count'] ; $i++) { 
			
	
			$sql = "SELECT * FROM reseller_credit WHERE ResellerID = '".$reseller[$i]['ID']."' ".$_SESSION['resellersummary_'.__FUNCTION__]['query_condition']." ORDER BY `Date` DESC";
			//echo $sql.'<br />';
			
			foreach ($this->dbconnect->query($sql) as $row)
			{
				
	
				$In += $row['Debit'];
				$Out += $row['Credit'];
	
			}
			
			$Balance = $In - $Out;
			
			
			
			
			$summary[$i] = array('Name'=>ResellerModel::getResellerNameWithoutKey($reseller[$i]['ID']), 'TotalIn' => Helper::displayCurrency($In), 'TotalOut' => Helper::displayCurrency($Out), 'Balance' => Helper::displayCurrency($Balance));
			//Debug::displayArray($summary);
		    
			unset($Balance);
			unset($In);
			unset($Out);
        }
		//exit;
		/*Debug::displayArray($summary);
		exit;*/
			
		$summary['count'] = $i;	
		
		return $summary;
		}elseif($post != 'empty'){
			//echo '2';
			if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['resellersummary_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=", 1);
			$query_condition .= $crud->queryCondition("ResellerID",$_POST['ResellerID'],"=");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
            $query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']) : Helper::dateDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['Debit'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Credit'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['resellersummary_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['ResellerID'] = $_POST['ResellerID'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['DateFrom'] = Helper::dateTimeDisplaySQL($_POST['DateFrom']);
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['DateTo'] = Helper::dateTimeDisplaySQL($_POST['DateTo']);
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			$_SESSION['resellersummary_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['resellersummary_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['resellersummary_'.__FUNCTION__]['query_title'] = "Search Results";
		}
			
			//$reseller = ResellerModel::getResellerList();
		
		 
			
			
			$sql = "SELECT * FROM reseller_credit WHERE ResellerID = '".$post."' ".$_SESSION['resellersummary_'.__FUNCTION__]['query_condition']." ORDER BY `Date` DESC";
	
			
			foreach ($this->dbconnect->query($sql) as $row)
			{
				
	
				$In += $row['Debit'];
				$Out += $row['Credit'];
	
			}
			
			$Balance = $In - $Out;
			
			$summary[0] = array('Name'=>ResellerModel::getResellerNameWithoutKey($post), 'TotalIn' => Helper::displayCurrency($In), 'TotalOut' => Helper::displayCurrency($Out), 'Balance' => Helper::displayCurrency($Balance));
	        
				
			$summary['count'] = 1;	
			
			return $summary;
		}
		/*Debug::displayArray($summary);
		exit;*/	
		
	}

	
    public function getTransactionFull($param)
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM reseller_credit WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'TypeID' => $row['TypeID'],
            'MemberID' => $row['MemberID'],
            'Description' => $row['Description'],
            'Date' => Helper::dateSQLToLongDisplay($row['Date']),
            'Debit' => $row['Debit'],
            'Credit' => $row['Credit'],
            'StaffID' => $row['StaffID'],
            'ModifiedDate' => $row['ModifiedDate'],
            'Status' => $row['Status']);

            $i += 1;
        }

        $result = $result[0];

        return $result;
    }

	public function getTransactionList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM reseller_credit ORDER BY Date DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MemberID' => $row['MemberID'],
			'Description' => $row['Description'],
			'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			'Debit' => $row['Debit'],
			'Credit' => $row['Credit'],
			'Status' => $row['Status']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function AdminResellerExport($argument)
	{
		$param = strstr($argument, 'Ex', TRUE);
		$ID = strstr($argument, 'Ex');
		$ID = str_replace('Ex' ,'',$ID);
		//echo $param.'<br />';
		//echo $ID;
		//exit;


		$sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status FROM reseller_credit AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['resellercredit_'.$param]['query_condition']." AND m.Reseller = '".$ID."' Order By t.Date DESC";


			//echo $sql;
			//exit;
			/*$transaction = array();
			//$transaction['count'] = $result['count'];
			$i = 0;

			foreach ($this->dbconnect->query($sql) as $row)
			{

				$transaction[$i] = array(
				'ID' => $row['t_ID'],
				'TypeID' => TransactionTypeModel::getTransactionType($row['t_TypeID']),
				'Report' => ResellerModel::getResellerReport($ID),
				'UnformattedMemberID' => $row['t_MemberID'],
				'MemberID' => MemberModel::getMemberName($row['t_MemberID']),
				'Description' => $row['t_Description'],
				'Date' => Helper::dateTimeSQLToDisplay($row['t_Date']),
				'TransferTo' => $row['t_TransferTo'],
				'TransferFrom' => $row['t_TransferFrom'],
				'DepositBonus' => $row['t_DepositBonus'],
				'DepositChannel' => $row['t_DepositChannel'],
				'ReferenceCode' => $row['t_ReferenceCode'],
	            'Bank' => $row['t_Bank'],
				'In' => Helper::displayCurrency($row['t_Debit']),
				'Out' => Helper::displayCurrency($row['t_Credit']),
				'Amount' => Helper::displayCurrency($row['t_Amount']),
				'Status' => TransactionStatusModel::getTransactionStatus($row['t_Status']));

				$i += 1;


			}*/




		//echo $sql;
		//exit;






		//------------------------------------------------------------------------------
		//$sql = "SELECT * FROM reseller_credit ".$_SESSION['resellercredit_'.$param]['query_condition']." ORDER BY `Date` DESC";
		$Resname = array();
		//$MemName = array();
		$Resname = ResellerModel::getReseller($ID);
		$MemName = MemberModel::getMemberName($_SESSION['resellercredit_'.$param]['param']['t.MemberID']);
		$result = array();
		$Report  = array();
		$result['content'] = '';
		$result['filename'] = $this->config['SITE_NAME']."_Transaction";
		//$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			//$_SESSION['resellercredit_'.__FUNCTION__]['param']['t.DateTo']
		$Report = ResellerModel::getResellerReport($ID, $param);
		$result['header'] = $this->config['SITE_NAME']." | Transaction (" . date('Y-m-d H:i:s') . ")<br /><br />";
		$result['header'] .= "\"Search filter\",";
		$result['header'] .= "\"Reseller\":,";
		$result['header'] .= "\"".$Resname[0]['Name']."\",";
		if($_SESSION['resellercredit_'.$param]['param']['t.DateFrom'] != ''){
		$result['header'] .= "\"Date From\":,";
		$result['header'] .= "\"".Helper::dateSQLToDisplay($_SESSION['resellercredit_'.$param]['param']['t.DateFrom'])."\",";
		}
		if($_SESSION['resellercredit_'.$param]['param']['t.DateTo'] != ''){
		$result['header'] .= "\"Date To\":,";
		$result['header'] .= "\"".Helper::dateSQLToDisplay($_SESSION['resellercredit_'.$param]['param']['t.DateTo'])."\",";
		}
		if($_SESSION['resellercredit_'.$param]['param']['t.MemberID'] != ''){
		$result['header'] .= "\"Member\":,";
		$result['header'] .= "\"".$MemName."\",";
		}
        if($_SESSION['resellercredit_'.$param]['param']['t.TypeID'] != ''){
		$result['header'] .= "\"Type\":,";
		$result['header'] .= "\"".TransactionTypeModel::getTransactionType($_SESSION['resellercredit_'.$param]['param']['t.TypeID'])."\",";
		}
        $result['header'] .= "\"Status\":,";
		$result['header'] .= "\"Completed\"<br />";
		$result['header'].="<br />In (MYR), Out (MYR), Profit (MYR), Profit Sharing (%), Profit Sharing (MYR)<br />";
		$result['header'] .= "\"".$Report['In']."\",";
		$result['header'] .= "\"".$Report['Out']."\",";
		$result['header'] .= "\"".$Report['Profit']."\",";
		$result['header'] .= "\"".$Report['Profitsharing']."\",";
		$result['header'] .= "\"".$Report['Percentage']."\"<br />";


		 $result['content'] .= "Date Posted, Type, Member, Description, Transfer From, Transfer To, Deposit Channel, Reference Code, Bank, In (MYR), Out (MYR), Transfer (MYR), Status<br />";


		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{

            $result['content'] .= "\"".Helper::dateTimeSQLToDisplay($row['t_Date'])."\",";
			$result['content'] .= "\"".TransactionTypeModel::getTransactionType($row['t_TypeID'])."\",";
			$result['content'] .= "\"".MemberModel::getMemberName($row['t_MemberID'])."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['t_Description'])."\",";
            $result['content'] .= "\"".$row['t_TransferFrom']."\",";
            $result['content'] .= "\"".$row['t_TransferTo']."\",";
            $result['content'] .= "\"".$row['t_DepositChannel']."\",";
            $result['content'] .= "\"".$row['t_ReferenceCode']."\",";
            $result['content'] .= "\"".$row['t_Bank']."\",";
            $result['content'] .= "\"".$row['t_Debit']."\",";
            $result['content'] .= "\"".$row['t_Credit']."\",";
			$result['content'] .= "\"".$row['t_Amount']."\",";
            //$result['content'] .= "\"".StaffModel::getStaff($row['t_StaffID'])."\",";
            //$result['content'] .= "\"".$row['t_ModifiedDate']."\",";
			$result['content'] .= "\"".TransactionStatusModel::getTransactionStatus($row['t_Status'])."\"<br />";

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

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM reseller_credit ".$_SESSION['resellercredit_'.$param]['query_condition']." ORDER BY `Date` DESC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Transaction";
		$result['header'] = $this->config['SITE_NAME']." | Transaction (" . date('Y-m-d H:i:s') . ")<br /><br />Date Posted, Type, Member, Description, Transfer From, Transfer To, Deposit Channel, Reference Code, Bank, In (MYR), Out (MYR), Transfer (MYR), Staff, Modified Date, Status";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
            $result['content'] .= "\"".Helper::dateTimeSQLToDisplay($row['Date'])."\",";
			$result['content'] .= "\"".TransactionTypeModel::getTransactionType($row['TypeID'])."\",";
			$result['content'] .= "\"".MemberModel::getMemberName($row['MemberID'])."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Description'])."\",";
            $result['content'] .= "\"".$row['TransferFrom']."\",";
            $result['content'] .= "\"".$row['TransferTo']."\",";
            $result['content'] .= "\"".$row['DepositChannel']."\",";
            $result['content'] .= "\"".$row['ReferenceCode']."\",";
            $result['content'] .= "\"".$row['Bank']."\",";
			$result['content'] .= "\"".$row['Debit']."\",";
			$result['content'] .= "\"".$row['Credit']."\",";
            $result['content'] .= "\"".$row['Amount']."\",";
            $result['content'] .= "\"".StaffModel::getStaff($row['StaffID'])."\",";
            $result['content'] .= "\"".$row['ModifiedDate']."\",";
			$result['content'] .= "\"".TransactionStatusModel::getTransactionStatus($row['Status'])."\"<br />";

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

	public function BlockIndex() 
    {

        $sql = "SELECT * FROM agent_credit WHERE AgentID = '".$_SESSION['agent']['ID']."' AND Status = '2'";
		//echo $sql;
		
		$transaction = array();
		$i = 0;
                
                
                $In = 0;
                $Out = 0;
                $Bonus = 0;
                $winLose = 0;
                $Profit = 0;

                $SecIn = 0;
                $SecBonus = 0;
                $SecProfit = 0;

                $ThirdIn = 0;
                $ThirdBonus = 0;
                $ThirdProfit = 0;

                $FourthIn = 0;
                $FourthBonus = 0;
                $FourthProfit = 0;
                
                $Plus = 0;
                $Minus = 0;
                $balance = 0;
                

		foreach ($this->dbconnect->query($sql) as $row)
		{

			$Plus += $row['Debit'];
			$Minus += $row['Credit'];

			$i += 1;				
					
			
			
		}
                
                
                //$count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);
                $report = array();
                $result = array();
                
                $profitSharing = AgentModel::getAgent($_SESSION['agent']['ID'], "Profitsharing");
              
                //if($count>'0')
                //{                 
                    
                    
                
                    
                    
                    
                    //for ($i = 0; $i < $firstChildren['count']; $i++) {
          
                        
                        $result = AgentModel::getCreditSelfAgentAffiliatedReporting($_SESSION['agent']['ID'], $profitSharing);
                       
                        //Debug::displayArray($result);
                        //exit;
                        /*$In = $result['First']['In']; 
                        $Out = $result['First']['Out'];
                        $Bonus = $result['First']['Bonus'];
                        $winLose = $result['First']['winLose'];
                        $Profit = $result['First']['Profit'];
                        
                        $SecIn = $result['Sec']['In'];
                        $SecBonus = $result['Sec']['Bonus'];
                        $SecProfit = $result['Sec']['Profit'];
                        
                        $ThirdIn = $result['Third']['In'];
                        $ThirdBonus = $result['Third']['Bonus'];*/
                        $ThirdProfit = $result;
                        
                        /*$FourthIn = $result['Fourth']['In'];
                        $FourthBonus = $result['Fourth']['Bonus'];
                        $FourthProfit = $result['Fourth']['Profit'];*/
                         //Debug::displayArray($data[$i]);
                    //}
                   
                    
               
                //}
                //elseif($count=='0')
                //{
                    
                //}    
                    
                //Debug::displayArray($result);

                //$profitLoss = $Plus - $Minus;
                //echo $ThirdProfit;
                //exit;
                $_SESSION['profitLoss'] = Helper::displayCurrency($ThirdProfit);
		$balance = $Plus - $Minus + ($ThirdProfit);
                //$balance += ;
                //$balance +

		//echo $balance;	
        $this->output = array( 
        'config' => $this->config,
        'page' => array('title' => "", 'template' => 'common.tpl.php','custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/blockindex.inc.php',),
        'report' => array('Balance' => Helper::displayCurrency($balance)),
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'secure' => NULL,
        'meta' => array('active' => "on"));
                    
        return $this->output;
    }
	
}
?>