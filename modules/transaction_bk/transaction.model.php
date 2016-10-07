<?php
// Require required models
Core::requireModel('member');
Core::requireModel('transactiontype');
Core::requireModel('transactionstatus');
Core::requireModel('product');
Core::requireModel('wallet');
Core::requireModel('producttype');
Core::requireModel('staff');
Core::requireModel('reseller');
Core::requireModel('bankinslip');
Core::requireModel('bankinfo');
Core::requireModel('rejectmessage');



class TransactionModel extends BaseModel
{
	private $output = array();
    private $module_name = "Transactions";
	private $module_dir = "modules/transaction/";
    private $module_default_url = "/main/transaction/index";
    private $module_default_admin_url = "/admin/transaction/index";
    private $module_default_member_url = "/member/transaction/index";

    private $member_module_name = "Member";
    private $member_module_dir = "modules/member/";

	private $reseller_module_name = "Reseller";
    private $reseller_module_dir = "modules/reseller/";
	private $module_default_reseller_url = "/reseller/reseller/index";

	public function __construct()
	{
		parent::__construct();
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM transaction WHERE 1 = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/transaction/index';
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

		$sql = "SELECT * FROM transaction WHERE 1 = 1 ORDER BY TypeID ASC LIMIT $start, $limit";

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
		$sql = "SELECT * FROM transaction WHERE ID = '".$param."' AND 1 = 1";

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
                $promo[1] = BlockModel::getBlockContent(47);
                $promo[2] = BlockModel::getBlockContent(48);
                $promo[3] = BlockModel::getBlockContent(49);
                $promo[4] = BlockModel::getBlockContent(50);
                $promo[5] = BlockModel::getBlockContent(51);
                $promo[6] = BlockModel::getBlockContent(52);
                $promo[7] = BlockModel::getBlockContent(53);
                $promo[8] = BlockModel::getBlockContent(54);
                $promo[9] = BlockModel::getBlockContent(55);
                $promo[10] = BlockModel::getBlockContent(56);
                
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['transaction_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=");
			$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
                        $query_condition .= $crud->queryCondition("Promotion",$_POST['Promotion'],"LIKE");
                        $query_condition .= $crud->queryCondition("BankSlip",$_POST['BankSlip'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
            $query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['Debit'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Credit'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");
            $query_condition .= $crud->queryCondition("DepositBonus",$_POST['DepositBonus'],"LIKE");
            $query_condition .= $crud->queryCondition("DepositChannel",$_POST['DepositChannel'],"LIKE");
            $query_condition .= $crud->queryCondition("ReferenceCode",$_POST['ReferenceCode'],"LIKE");
            $query_condition .= $crud->queryCondition("Bank",$_POST['Bank'],"LIKE");
            $query_condition .= $crud->queryCondition("TransferFrom",$_POST['TransferFrom'],"LIKE");
            $query_condition .= $crud->queryCondition("TransferTo",$_POST['TransferTo'],"LIKE");
            $query_condition .= $crud->queryCondition("Amount",$_POST['Amount'],"LIKE");
            $query_condition .= $crud->queryCondition("Bonus",$_POST['Bonus'],">=");
            $query_condition .= $crud->queryCondition("Commission",$_POST['Commission'],">=");



			$_SESSION['transaction_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['Promotion'] = $_POST['Promotion'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['BankSlip'] = $_POST['BankSlip'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['DateFrom'] = $_POST['DateFrom'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['DateTo'] = $_POST['DateTo'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];
            $_SESSION['transaction_'.__FUNCTION__]['param']['DepositBonus'] = $_POST['DepositBonus'];
            $_SESSION['transaction_'.__FUNCTION__]['param']['DepositChannel'] = $_POST['DepositChannel'];
            $_SESSION['transaction_'.__FUNCTION__]['param']['ReferenceCode'] = $_POST['ReferenceCode'];
            $_SESSION['transaction_'.__FUNCTION__]['param']['Bank'] = $_POST['Bank'];
            $_SESSION['transaction_'.__FUNCTION__]['param']['TransferFrom'] = $_POST['TransferFrom'];
            $_SESSION['transaction_'.__FUNCTION__]['param']['TransferTo'] = $_POST['TransferTo'];
            $_SESSION['transaction_'.__FUNCTION__]['param']['Amount'] = $_POST['Amount'];
            $_SESSION['transaction_'.__FUNCTION__]['param']['Bonus'] = $_POST['Bonus'];
            $_SESSION['transaction_'.__FUNCTION__]['param']['Commission'] = $_POST['Commission'];

			// Set Query Variable
			$_SESSION['transaction_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['transaction_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['transaction_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['transaction_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM transaction ".$_SESSION['transaction_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/transaction/index';
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

		$sql = "SELECT * FROM transaction ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." ORDER BY `Date` DESC, `ID` DESC LIMIT $start, $limit";
		/*echo $sql;
		exit;*/
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
                    //echo $row['ModifiedDate'];
                    
                        if($row['ModifiedDate']=='0000-00-00 00:00:00')
                        {
                            $ModifiedDate = '0000-00-00 00:00:00';
                        }  
                        else
                        {
                            $ModifiedDate = date("d-m-Y | h.i", strtotime(Helper::dateTimeSQLToDisplay($row['ModifiedDate'])));
                        } 
                        
                        if($row['UpdatedDate']=='0000-00-00 00:00:00')
                        {
                            $UpdatedDate = '0000-00-00 00:00:00';
                        }  
                        else
                        {
                            $UpdatedDate = date("d-m-Y | h.i", strtotime(Helper::dateTimeSQLToDisplay($row['UpdatedDate'])));
                        }
                        //exit;
                        
                        $this->getTransactionCumulation($row['MemberID']);
                        
                        $reseller = MemberModel::getMemberResellerID($row['MemberID']);
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'MemberID' => MemberModel::getMemberName($row['MemberID']),
                         'RawMemberID' => $row['MemberID'],
            'MemberUsername' => MemberModel::getMemberUsername($row['MemberID']),
            'Reseller' => MemberModel::getMemberReseller($row['MemberID']),
                        'Colour' => ResellerModel::getReseller($reseller),    
			'Description' => $row['Description'],
                        'Promotion' => $row['Promotion'],
                        'BankSlip' => $row['BankSlip'],    
                        'GameUsername' => WalletModel::getWalletUsername($row['MemberID'], $row['ProductID']), 
                        'MainWallet' =>  Helper::displayCurrency(WalletModel::getMemberWalletTotal($row['MemberID'])),   
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => date("d-m-Y | h.i", strtotime(Helper::dateTimeSQLToDisplay($row['Date']))),
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
			'DepositBonus' => $row['DepositBonus'],
			'DepositChannel' => $row['DepositChannel'],
			'ReferenceCode' => $row['ReferenceCode'],
			'Bonus' => $row['Bonus'],
			'Commission' => $row['Commission'],
			'In' => Helper::displayCurrency($row['Debit']),
			'Out' => Helper::displayCurrency($row['Credit']),
			'Amount' => Helper::displayCurrency($row['Amount']),
			'Bank' => $row['Bank'],
			'StaffID' => ($row['StaffID']=='0')?'0':StaffModel::getStaffDetails($row['StaffID']),
            'StaffIDUpdated' => StaffModel::getStaffDetails($row['StaffIDUpdated']),
			'ModifiedDate' => $ModifiedDate,
            'UpdatedDate' =>  $UpdatedDate,
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;

		}
     // Debug::displayArray($query_condition);
			//exit;
		/*Debug::displayArray($result);
		exit;*/
                /*Debug::displayArray($promo);*/
                /*Debug::displayArray($_SESSION);
                exit;*/
                
                if($_SESSION['transaction_'.__FUNCTION__]['param']['Promotion']!="")
                        {    
                            for ($index = 0; $index < 10; $index++) {

                                    if($promo[$index]==$_SESSION['transaction_'.__FUNCTION__]['param']['Promotion']){
                                        $promotionspecial = $index;
                                    }

                            }
                        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Transactions", 'template' => 'admin.transaction.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'transaction_delete' => $_SESSION['admin']['transaction_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
                'promo' => $promo,
                'promotionspecial' => $promotionspecial,    
		'summary' => $this->getTransactionReport(),               
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'rejecte_message' => RejectMessageModel::getRejectMessageList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_delete']);
		/*Debug::displayArray($this->output['summary']);
		exit;*/
		return $this->output;
	}

	public function AdminAdd()
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
            
            
            /*$product = ProductModel::getProductListWithWallet();

		$result = WalletModel::getWalletList();*/

		$nonmainwalletproduct = ProductModel::getNonMainWalletProduct();

		/*$mainwalletproduct = ProductModel::getMainWalletProduct();*/
            
            
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Transaction", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Transaction"),
                'nonmainwallet' => $nonmainwalletproduct,   
                'content' => $result,    
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
            /*if($_POST['TypeID']=='1')
            {
                
            }*/
            
            
		$key = "(TypeID, MemberID, Description, Promotion, ProductID, BankSlip, RejectedRemark, Date, TransferTo, TransferFrom, Debit, Credit, Bonus, Commission, Amount, DepositBonus, DepositChannel, ReferenceCode, Bank, StaffID, ModifiedDate, Status)";
		$value = "('".$_POST['TypeID']."', '".$_POST['MemberID']."', '".$_POST['Description']."', '".$_POST['PromoSpecial']."', '".$_POST['ProductID']."', '".$_POST['BankSlip']."', '".$_POST['RejectedRemark']."', '".Helper::dateTimeDisplaySQL($_POST['Date'])."', '".$_POST['TransferTo']."', '".$_POST['TransferFrom']."', '".$_POST['Debit']."', '".$_POST['Credit']."', '".$_POST['Bonus']."', '".$_POST['Commission']."', '".$_POST['Amount']."', '".$_POST['DepositBonus']."', '".$_POST['DepositChannel']."', '".$_POST['ReferenceCode']."', '".$_POST['Bank']."', '', '', '".$_POST['Status']."')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;
		/*echo $sql;
		exit;*/
		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";
        
                $this->getTransactionCumulation($_POST['MemberID']);

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Transaction...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
            
            $promotion[1] = BlockModel::getBlockContent(47);
            $promotion[2] = BlockModel::getBlockContent(48);
            $promotion[3] = BlockModel::getBlockContent(49);
            $promotion[4] = BlockModel::getBlockContent(50);
            $promotion[5] = BlockModel::getBlockContent(51);
            $promotion[6] = BlockModel::getBlockContent(52);
            $promotion[7] = BlockModel::getBlockContent(53);
            $promotion[8] = BlockModel::getBlockContent(54);
            $promotion[9] = BlockModel::getBlockContent(55);
            $promotion[10] = BlockModel::getBlockContent(56);
            
		$sql = "SELECT * FROM transaction WHERE ID = '".$param."'";

		$result = array();
		$i = 0;


		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MemberID' => $row['MemberID'],
			'Description' => $row['Description'],
                        'Promotion' => $row['Promotion'],
                        'BankSlip' => $row['BankSlip'],    
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
                        'ProductID' => $row['ProductID'],
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
			'DepositBonus' => $row['DepositBonus'],
			'DepositChannel' => $row['DepositChannel'],
			'ReferenceCode' => $row['ReferenceCode'],
			'Bonus' => $row['Bonus'],
			'Commission' => $row['Commission'],
            'Bank' => $row['Bank'],
			'In' => $row['Debit'],
			'Out' => $row['Credit'],
			'Amount' => $row['Amount'],
			'StaffID' => StaffModel::getStaff($row['StaffID']),
			'ModifiedDate' => Helper::dateSQLToDisplay($row['ModifiedDate']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;

		}
                
                $nonmainwalletproduct = ProductModel::getNonMainWalletProduct();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Transaction", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add'], 'transaction_edit' => $_SESSION['admin']['transaction_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Transaction"),
                'nonmainwallet' => $nonmainwalletproduct,    
		'content' => $result,
                'promotion' => $promotion,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_add']);
		unset($_SESSION['admin']['transaction_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
        
       $ModifierDetails = TransactionModel::getTransactionFull($param); 
       
       if($ModifierDetails['StaffID']=='0')
       {
           $staff_id = $_SESSION['admin']['ID'];           
            $modified_date = date("YmdHis");
           $StaffIDUpdated = $_SESSION['admin']['ID'];
           $UpdatedDate = date("YmdHis");
           
       }
       else
       {
           $staff_id = $ModifierDetails['StaffID'];
            $modified_date = $ModifierDetails['ModifiedDate'];
            $StaffIDUpdated = $_SESSION['admin']['ID'];
            $UpdatedDate = date("YmdHis");
            
       }    
            
            
            
            $sql = "UPDATE transaction SET TypeID='".$_POST['TypeID']."', MemberID='".$_POST['MemberID']."', Description='".$_POST['Description']."', Promotion='".$_POST['PromoSpecial']."', ProductID='".$_POST['ProductID']."', BankSlip='".$_POST['BankSlip']."', RejectedRemark='".$_POST['RejectedRemark']."', Date='".Helper::dateTimeDisplaySQL($_POST['Date'])."', TransferTo='".$_POST['TransferTo']."', TransferFrom='".$_POST['TransferFrom']."', Debit='".$_POST['Debit']."', Credit='".$_POST['Credit']."', Amount='".$_POST['Amount']."', DepositBonus='".$_POST['DepositBonus']."', Bonus='".$_POST['Bonus']."', Commission='".$_POST['Commission']."', ReferenceCode='".$_POST['ReferenceCode']."', Bank='".$_POST['Bank']."', Status='".$_POST['Status']."', StaffID = '".$staff_id."', StaffIDUpdated = '".$StaffIDUpdated."', ModifiedDate = '".$modified_date."', UpdatedDate = '".$UpdatedDate."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";
            
        

		$this->getTransactionCumulation($ModifierDetails['MemberID']);

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Transaction...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        public function AdminQuickEdit($param)
	{
                         
		$sql = "SELECT * FROM transaction WHERE ID = '".$param."'";

		$result = array();
		$i = 0;


		foreach ($this->dbconnect->query($sql) as $row)
		{
                    
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MemberID' => $row['MemberID'],
                        'MemberName' => MemberModel::getMemberName($row['MemberID']),    
			'Description' => $row['Description'],    
                        'Promotion' => $row['Promotion'],
                        'BankSlip' => $row['BankSlip'],    
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
			'DepositBonus' => $row['DepositBonus'],
			'DepositChannel' => $row['DepositChannel'],
			'ReferenceCode' => $row['ReferenceCode'],
			'Bonus' => $row['Bonus'],
			'Commission' => $row['Commission'],
            'Bank' => $row['Bank'],
			'In' => $row['Debit'],
			'Out' => $row['Credit'],
			'Amount' => $row['Amount'],
			'StaffID' => StaffModel::getStaff($row['StaffID']),
			'ModifiedDate' => Helper::dateSQLToDisplay($row['ModifiedDate']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;

		}
                /*Debug::displayArray($result);*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Transaction", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'off', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add'], 'transaction_edit' => $_SESSION['admin']['transaction_edit']),
                'content' => $result,
                'ID' => $param,    
		/*'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Transaction"),
		
                'promotion' => $promotion,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),*/
                'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'reject_message' => RejectMessageModel::getRejectMessageList()),    
		'secure' => TRUE,
		'meta' => array('active' => "on"));
	
		return $this->output;
	}
        
        public function AdminQuickEditProcess($param)
	{
            
        if($_POST['RejectedRemarkSelect']!='')
        {
            $_POST['RejectedRemark'] = $_POST['RejectedRemarkSelect'];
            $_POST['RejectedRemarkManual'] = '';
        } 
        
        if($_POST['RejectedRemarkManual']!='')
        {
            $_POST['RejectedRemark'] = $_POST['RejectedRemarkManual'];
        }    
       
       $ModifierDetails = TransactionModel::getTransactionFull($param); 
       /*Debug::displayArray($ModifierDetails);
       exit;*/
       
       if($ModifierDetails['StaffID']=='0')
       {
           $staff_id = $_SESSION['admin']['ID'];           
            $modified_date = date("YmdHis");
           $StaffIDUpdated = $_SESSION['admin']['ID'];
           $UpdatedDate = date("YmdHis");
           
       }
       else
       {
           $staff_id = $ModifierDetails['StaffID'];
            $modified_date = $ModifierDetails['ModifiedDate'];
            $StaffIDUpdated = $_SESSION['admin']['ID'];
            $UpdatedDate = date("YmdHis");
            
       }    
            
            
            
            $sql = "UPDATE transaction SET RejectedRemark='".$_POST['RejectedRemark']."', Bonus='".$_POST['Bonus']."', Commission='".$_POST['Commission']."', Status='".$_POST['Status']."', StaffID = '".$staff_id."', StaffIDUpdated = '".$StaffIDUpdated."', ModifiedDate = '".$modified_date."', UpdatedDate = '".$UpdatedDate."' WHERE ID='".$param."'";
            /*echo $sql;
            exit;*/
		$count = $this->dbconnect->exec($sql);

		// Set Status
                $ok = ($count<=1) ? 1 : "";
                
                
                $sql2 = "UPDATE wallet SET Total='".$_POST['wallet']."' WHERE MemberID='".$ModifierDetails['MemberID']."' AND ProductID = '30' AND Enabled = '1'";

		$count2 = $this->dbconnect->exec($sql2);
                
                /*echo $sql2;
                exit;*/
                
		// Set Status
                $ok2 = ($count2<=1) ? 1 : "";
                
                $this->getTransactionCumulation($ModifierDetails['MemberID']);
                    
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
		$sql = "DELETE FROM transaction WHERE ID ='".$param."'";
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
            
            $promo[1] = BlockModel::getBlockContent(47);
            $promo[2] = BlockModel::getBlockContent(48);
            $promo[3] = BlockModel::getBlockContent(49);
            $promo[4] = BlockModel::getBlockContent(50);
            $promo[5] = BlockModel::getBlockContent(51);
            $promo[6] = BlockModel::getBlockContent(52);
            $promo[7] = BlockModel::getBlockContent(53);
            $promo[8] = BlockModel::getBlockContent(54);
            $promo[9] = BlockModel::getBlockContent(55);
            $promo[10] = BlockModel::getBlockContent(56);
            //Debug::displayArray($promo);exit;
            
		/*Debug::displayArray(Helper::dateTimeDisplaySQL($_POST['DateFrom']));
		exit;*/
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form' || $_POST['Trigger']=='')
		{
			if ($_POST['Trigger']=='search_form'){
			// Reset Query Variable
			$_SESSION['transaction_'.__FUNCTION__] = "";

			//Helper::dateTimeDisplaySQL(
			$query_condition .= $crud->queryCondition("t.TypeID",$_POST['TypeID'],"=",1);
			$query_condition .= $crud->queryCondition("t.MemberID",$_POST['MemberID'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Description",$_POST['Description'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Promotion",$_POST['Promotion'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.BankSlip",$_POST['BankSlip'],"LIKE");
			$query_condition .= $crud->queryCondition("t.RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("t.Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Credit",$_POST['Out'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Status",$_POST['Status'],"LIKE");

			$_SESSION['transaction_'.__FUNCTION__]['param']['t.TypeID'] = $_POST['TypeID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Description'] = $_POST['Description'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Promotion'] = $_POST['Promotion'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.BankSlip'] = $_POST['BankSlip'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.MemberID'] = $_POST['MemberID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateTo'] = $_POST['DateTo'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Debit'] = $_POST['Debit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Credit'] = $_POST['Credit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['transaction_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['transaction_'.__FUNCTION__]['query_title'] = "Search Results";

		}
		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['transaction_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['transaction_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." AND m.Reseller = '".$param."'";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/transaction/reseller/'.$param;
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



		//$sql = "SELECT * FROM transaction WHERE MemberID = '".$_SESSION['member']['ID']."' ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." ORDER BY `Date` DESC LIMIT $start, $limit";

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

			//$sql = "SELECT * FROM transaction WHERE MemberID = '".$result[$i]['ID']."'";
			//ORDER BY m.ProfileID ASC, m.Name
			 $sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.BankSlip AS t_BankSlip, t.Promotion AS t_Promotion, t.RejectedRemark AS t_RejectedRemark, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Bonus as t_Bonus, t.Commission as t_Commission, t.Status as t_Status, t.StaffID as t_StaffID, t.StaffIDUpdated as t_StaffIDUpdated, t.ModifiedDate as t_ModifiedDate, t.UpdatedDate as t_UpdatedDate, t.ProductID as t_ProductID FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." AND m.Reseller = '".$param."' Order By t.Date DESC, t.ID DESC LIMIT $start, $limit";


			/*echo $sql;
			exit;*/
			$transaction = array();
			//$transaction['count'] = $result['count'];
			$i = 0;

			foreach ($this->dbconnect->query($sql) as $row)
			{
                            
                            if($row['t_ModifiedDate']=='0000-00-00 00:00:00')
                        {
                            $ModifiedDate = '0000-00-00 00:00:00';
                        }  
                        else
                        {
                            $ModifiedDate = date("d-m-Y | h.i", strtotime(Helper::dateTimeSQLToDisplay($row['t_ModifiedDate'])));
                        } 
                        
                        if($row['t_UpdatedDate']=='0000-00-00 00:00:00')
                        {
                            $UpdatedDate = '0000-00-00 00:00:00';
                        }  
                        else
                        {
                            $UpdatedDate = date("d-m-Y | h.i", strtotime(Helper::dateTimeSQLToDisplay($row['t_UpdatedDate'])));
                        }
                            

				$transaction[$i] = array(
				'ID' => $row['t_ID'],
				'TypeID' => TransactionTypeModel::getTransactionType($row['t_TypeID']),
				//'Report' => ResellerModel::getResellerReport($param, $filename),
				'UnformattedMemberID' => $row['t_MemberID'],
				'MemberID' => MemberModel::getMemberName($row['t_MemberID']),
                'MemberUsername' => MemberModel::getMemberUsername($row['t_MemberID']),
				'Description' => $row['t_Description'],
                                'Promotion' => $row['t_Promotion'], 
                                'BankSlip' => $row['t_BankSlip'], 
                                'GameUsername' => WalletModel::getWalletUsername($row['t_MemberID'], $row['t_ProductID']), 
                                'MainWallet' =>  WalletModel::getAdminWalletTotal(30, $row['t_MemberID']),  
				'RejectedRemark' => $row['t_RejectedRemark'],
				'Date' => date("d-m-Y | h.i", strtotime(Helper::dateTimeSQLToDisplay($row['t_Date']))),
				'TransferTo' => $row['t_TransferTo'],
				'TransferFrom' => $row['t_TransferFrom'],
				'DepositBonus' => $row['t_DepositBonus'],
				'DepositChannel' => $row['t_DepositChannel'],
				'ReferenceCode' => $row['t_ReferenceCode'],
	            'Bank' => $row['t_Bank'],
				'In' => Helper::displayCurrency($row['t_Debit']),
				'Out' => Helper::displayCurrency($row['t_Credit']),
				'Amount' => Helper::displayCurrency($row['t_Amount']),
                'Bonus' => Helper::displayCurrency($row['t_Bonus']),
                'Commission' => Helper::displayCurrency($row['t_Commission']),
                                'StaffID' => ($row['t_StaffID']=='0')?'0':StaffModel::getStaffDetails($row['t_StaffID']),
            'StaffIDUpdated' => StaffModel::getStaffDetails($row['t_StaffIDUpdated']),
			'ModifiedDate' => $ModifiedDate,
            'UpdatedDate' => $UpdatedDate,    
				'Status' => TransactionStatusModel::getTransactionStatus($row['t_Status']));

				$i += 1;


			}

			$transaction['count'] = $i;

			}
                        
                        if(isset($_SESSION['transaction_'.__FUNCTION__]['param']['t.Promotion']))
                        {    
                            for ($index = 0; $index < 10; $index++) {

                                    if($promo[$index]==$_SESSION['transaction_'.__FUNCTION__]['param']['t.Promotion']){
                                        $promotionspecial = $index;
                                    }

                            }
                        }
                        //echo $_SESSION['transaction_'.__FUNCTION__]['param']['t.Promotion'];
                        //echo $promotionspecial;
                        //exit;
                            
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
		'page' => array('title' => "View Report By Reseller", 'template' => 'admin.transaction.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/reseller.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
        'membertotal' =>  $membertotal,
		'breadcrumb' => HTML::getBreadcrumb($this->reseller_module_name,$this->module_default_admin_url,"admin",$this->config,"View Report By Reseller"),
		'content' => $transaction,
                'promo' => $promo,
                'promotionspecial' => $promotionspecial,
		'report' => $report,
		'ID' => $param,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberListByReseller($param), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'reseller_list' => ResellerModel::getResellerList()),
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
			$_SESSION['transaction_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=",1);
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']): Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Out'],"LIKE");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['transaction_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['DateFrom'] = $_POST['DateFrom'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['DateTo'] = $_POST['DateTo'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['transaction_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['transaction_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['transaction_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['transaction_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM transaction WHERE MemberID = '".$_SESSION['member']['ID']."' ".$_SESSION['transaction_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/member/transaction/index';
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

		$sql = "SELECT * FROM transaction WHERE MemberID = '".$_SESSION['member']['ID']."' ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." ORDER BY `Date` DESC, `ID` DESC LIMIT $start, $limit";

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
			'Bonus' => $row['Bonus'],
            'Commission' => $row['Commission'],
            'Bank' => $row['Bank'],
			'In' => Helper::displayCurrency($row['Debit']),
			'Out' => Helper::displayCurrency($row['Credit']),
			'Amount' => Helper::displayCurrency($row['Amount']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;
		}

                if($_SESSION['language']=='en')
                {
                   $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }
                elseif($_SESSION['language']=='ms')
                {
                    $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }
                elseif($_SESSION['language']=='zh_CN')
                {
                    $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => Helper::translate("My Transactions", "member-history-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/index.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		//unset($_SESSION['admin']['transaction_delete']);

		return $this->output;
	}
        
        
        public function AdminHistory($param)
	{


		$sql = "SELECT * FROM transaction WHERE MemberID = '".$param."' ORDER BY `Date` DESC, `ID` DESC LIMIT 0, 10";
                
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if($row['ModifiedDate']=='0000-00-00 00:00:00')
                        {
                            $ModifiedDate = '0000-00-00 00:00:00';
                        }  
                        else
                        {
                            $ModifiedDate = date("d-m-Y | h.i", strtotime(Helper::dateTimeSQLToDisplay($row['ModifiedDate'])));
                        } 
                        
                        if($row['UpdatedDate']=='0000-00-00 00:00:00')
                        {
                            $UpdatedDate = '0000-00-00 00:00:00';
                        }  
                        else
                        {
                            $UpdatedDate = date("d-m-Y | h.i", strtotime(Helper::dateTimeSQLToDisplay($row['UpdatedDate'])));
                        }
                        
                        $this->getTransactionCumulation($row['MemberID']);
                        //exit;
                        $reseller = MemberModel::getMemberResellerID($row['MemberID']);
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'MemberID' => MemberModel::getMemberName($row['MemberID']),
                        'RawMemberID' => $row['MemberID'],
                        'MemberUsername' => MemberModel::getMemberUsername($row['MemberID']),
                        'Reseller' => MemberModel::getMemberReseller($row['MemberID']),
                        'Colour' => ResellerModel::getReseller($reseller),    
			'Description' => $row['Description'],
                        'Promotion' => $row['Promotion'],
                        'BankSlip' => $row['BankSlip'],    
                        'GameUsername' => WalletModel::getWalletUsername($row['MemberID'], $row['ProductID']), 
                        'MainWallet' =>  Helper::displayCurrency(WalletModel::getMemberWalletTotal($row['MemberID'])),
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => date("d-m-Y | h.i", strtotime(Helper::dateTimeSQLToDisplay($row['Date']))),
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
			'DepositBonus' => $row['DepositBonus'],
			'DepositChannel' => $row['DepositChannel'],
			'ReferenceCode' => $row['ReferenceCode'],
			'Bonus' => $row['Bonus'],
			'Commission' => $row['Commission'],
			'In' => Helper::displayCurrency($row['Debit']),
			'Out' => Helper::displayCurrency($row['Credit']),
			'Amount' => Helper::displayCurrency($row['Amount']),
			'Bank' => $row['Bank'],
			'StaffID' => ($row['StaffID']=='0')?'0':StaffModel::getStaffDetails($row['StaffID']),
                        'StaffIDUpdated' => StaffModel::getStaffDetails($row['StaffIDUpdated']),
			'ModifiedDate' => $ModifiedDate,
                        'UpdatedDate' =>  $UpdatedDate,
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;
		}

                
                
                

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "My Transactions", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'off', 'custom_inc_loc' => $this->module_dir.'inc/member/index.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
                //'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		//'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,""),
		'content' => $result,
                'content_param' => array('count' => $i),   
		/*'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),*/
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		//unset($_SESSION['admin']['transaction_delete']);

		return $this->output;
	}


	public function ResellerIndex($param)

	{
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form' || $_POST['Trigger']=='')
		{
			if ($_POST['Trigger']=='search_form'){
			// Reset Query Variable
			$_SESSION['transaction_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("t.TypeID",$_POST['TypeID'],"=",1);
			$query_condition .= $crud->queryCondition("t.MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("t.Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("t.RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("t.Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Credit",$_POST['Out'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Status",$_POST['Status'],"LIKE");

			$_SESSION['transaction_'.__FUNCTION__]['param']['t.TypeID'] = $_POST['TypeID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Description'] = $_POST['Description'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.MemberID'] = $_POST['MemberID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateTo'] = $_POST['DateTo'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Debit'] = $_POST['Debit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Credit'] = $_POST['Credit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['transaction_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['transaction_'.__FUNCTION__]['query_title'] = "Search Results";

		}
		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['transaction_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['transaction_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." AND m.Reseller = '".$_SESSION['reseller']['ID']."'";
		#echo $query_count;
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/reseller/transaction/index';
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

		 $sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.RejectedRemark AS t_RejectedRemark, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bonus as t_Bonus, t.Commission as t_Commission, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." AND m.Reseller = '".$_SESSION['reseller']['ID']."' Order By t.Date DESC LIMIT $start, $limit";


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
				#'Report' => ResellerModel::getResellerReport($_SESSION['reseller']['ID'], $filename),
				'MemberID' => MemberModel::getMemberName($row['t_MemberID']),
                'MemberUsername' => MemberModel::getMemberUsername($row['t_MemberID']),
				'Description' => $row['t_Description'],
				'RejectedRemark' => $row['t_RejectedRemark'],
				'Date' => Helper::dateTimeSQLToDisplay($row['t_Date']),
				'TransferTo' => $row['t_TransferTo'],
				'TransferFrom' => $row['t_TransferFrom'],
				/*'Bonus' => $row['t_Bonus'],
				'Commission' => $row['t_Commission'],*/
				'DepositBonus' => $row['t_DepositBonus'],
				'DepositChannel' => $row['t_DepositChannel'],
				'ReferenceCode' => $row['t_ReferenceCode'],
				'Bonus' => $row['t_Bonus'],
				'Commission' => $row['t_Commission'],
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
			$report = ResellerModel::getResellerReport($_SESSION['reseller']['ID'], $filename);

		$param = $_SESSION['reseller']['ID'];
		ResellerModel::getResellerCredit($_SESSION['reseller']['ID']);
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Reseller's Member Transactions", 'template' => 'reseller.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/reseller/index.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
        'block' => array('side_nav' => $this->reseller_module_dir.'inc/reseller/side_nav.reseller.inc.php', 'common' => "false"),
        'membertotal' =>  $membertotal,
		'breadcrumb' => HTML::getBreadcrumb($this->reseller_module_name,$this->module_default_reseller_url,"",$this->config,"Reseller's Member Transactions"),
		'content' => $transaction,
		'report'=>$report,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberListByReseller($param), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		/*Debug::displayArray($this->output);
		exit;*/

		return $this->output;
	}


	public function MemberDeposit()
	{
         
        $form_token = $_SESSION['member']['ID'].'-'.time();  
        $_SESSION['form_token'] = $form_token;
        
        
                
        //$stack = array("orange", "banana");
        //        
        //Debug::displayArray($_SESSION['member']);
        
         
        
        //exit;
        /*if($_SESSION['member']['form_token'] == $_SESSION['form_token'])
        {
            
        } */   
        
        //$sql = "UPDATE form_token SET Deposit = '".$form_token."' WHERE ID = 1";
        
             
        //$count = $this->dbconnect->exec($sql);                    
                  
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

                if($_SESSION['language']=='en')
                {
                   $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }
                elseif($_SESSION['language']=='ms')
                {
                    $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }
                elseif($_SESSION['language']=='zh_CN')
                {
                    $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }
                
                $nonmainwalletproduct = ProductModel::getNonMainWalletProduct();
                
        

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => Helper::translate("Deposit", "member-deposit-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/deposit.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("Deposit", "member-deposit-title")),
		'content' => $result,
                'form_token' => $form_token,
                'nonmainwallet' => $nonmainwalletproduct,    
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_slip' => BankinSlipModel::getPublicBankinSlipList(), 'bank_info' => BankInfoModel::getResellerBankInfoList($_SESSION['member']['ID'])),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_add']);

		return $this->output;
	}

	public function MemberDepositProcess()
	{
           
             /*Debug::displayArray($_POST);
             exit;*/
             /*$selecttoken = "SELECT Deposit FROM form_token WHERE ID = 1";

             
             foreach ($this->dbconnect->query($selecttoken) as $row)
             {
                $result = $row['Deposit'];
                     
             }*/
            
            if(is_array($_SESSION['member']['token'])===FALSE)
            {    
               $_SESSION['member']['token'] = array();
            }
            
            if (in_array($_POST['form_token'], $_SESSION['member']['token'])===FALSE) {
                
                array_push($_SESSION['member']['token'], $_POST['form_token']);

                 /*Debug::displayArray($_SESSION['member']);
                 exit;*/
            /*if($_POST['form_token']==$_SESSION['form_token'])
            {*/
                
                      
            $_SESSION['form_token'] = $_SESSION['member']['ID'].'-'.time();
            //$sqltoken = "UPDATE form_token SET Deposit = '".$form_token."' WHERE ID = 1";

            //$counttoken = $this->dbconnect->exec($sqltoken);
            
            

		$date_deposit = "Date of Deposit: ".$_POST['DateDeposit'];
        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$key = "(MemberID, TypeID, Description, Promotion, Date, DepositChannel, BankSlip, ReferenceCode, Bank, Debit, StaffID, ModifiedDate, Status)";
		$value = "('".$_SESSION['member']['ID']."', '2', '".$date_deposit." | ".$_POST['PromoSpecial']."', '".$_POST['PromoSpecial']."', '".$date_posted."', '".$_POST['DepositChannel']."', '".$_POST['BankSlip']."', '".$_POST['ReferenceCode']."', '".$_POST['bank']."', '".$_POST['DepositAmount']."', '', '', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count_deposit = $this->dbconnect->exec($sql);
		$newID_deposit = $this->dbconnect->lastInsertId();

        $member = MemberModel::getMember($_SESSION['member']['ID']);
        $reseller = ResellerModel::getReseller($member[0]['Reseller']);
        $reseller_email = $reseller[0]['Email'];

		$message_deposit = "<br /><br />Reseller:\t".$reseller[0]['Name']."<br />";
        $message_deposit .= "Description:\t".$date_deposit."<br />";
        $message_deposit .= "Date Posted:\t".$date_posted_display."<br />";
        $message_deposit .= "Deposit Channel:\t".$_POST['DepositChannel']."<br />";
        $message_deposit .= "Reference Code:\t".$_POST['ReferenceCode']."<br />";
        $message_deposit .= "Bank:\t".$_POST['bank']."<br />";
        $message_deposit .= "In (MYR):\t".$_POST['DepositAmount']."<br /><br />";
        $message_deposit .= "Promo:\t".$_POST['PromoSpecial']."<br />";

		// Set Status
        $ok_deposit = ($count_deposit==1) ? 1 : "";
        
        //Transfer
        if($_POST['TransferAmount']!='')
        {    
        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$transferFrom = WalletModel::getWalletByProductID('30');

		//if ($_POST['Amount']>$transferFrom) {
			//$valid = '0';
		//}elseif($_POST['Amount']<=$transferFrom){
                /*echo $_POST['TransferTo'];
                exit;*/
                        
			$key = "(MemberID, TypeID, Description, ProductID, Date, TransferTo, TransferFrom, Amount, StaffID, ModifiedDate,Status)";
			$value = "('".$_SESSION['member']['ID']."', '1', '".$_POST['description']."', '".$_POST['TransferTo']."', '".$date_posted."', '".ProductModel::IDToProductName($_POST['TransferTo'])."', '".ProductModel::IDToProductName('30')."', '".$_POST['TransferAmount']."', '', '', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count_transfer = $this->dbconnect->exec($sql);
		$newID_transfer = $this->dbconnect->lastInsertId();
		//}

        $member = MemberModel::getMember($_SESSION['member']['ID']);
        $reseller = ResellerModel::getReseller($member[0]['Reseller']);
        $reseller_email = $reseller[0]['Email'];

        $message_transfer = "<br /><br />Reseller:\t".$reseller[0]['Name']."<br />";
        $message_transfer .= "Date Posted:\t".$date_posted_display."<br />";
        $message_transfer .= "Transfer From:\t".ProductModel::IDToProductName('30')."<br />";
        $message_transfer .= "Transfer To:\t".ProductModel::IDToProductName($_POST['TransferTo'])."<br />";
        $message_transfer .= "Transfer Amount (MYR):\t".$_POST['TransferAmount']."<br />";

		// Set Status
        $ok_transfer = ($count_transfer==1) ? 1 : "";
        
        }
        
            }
            /*}*/
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Deposit...", 'template' => 'common.tpl.php'),
		'content_param_deposit' => array('count_deposit' => $count_deposit, 'newID_deposit' => $newID_deposit, 'reseller_email' => $reseller_email),
                'content_param_transfer' =>  array('count_transfer' => $count_transfer, 'newID_transfer' => $newID_transfer, 'reseller_email' => $reseller_email),   
		'message_deposit' => $message_deposit,
                'message_transfer' => $message_transfer,
		'status_deposit' => array('ok_deposit' => $ok_deposit, 'error_deposit' => $error_deposit),
                'status_transfer' => array('ok_transfer' => $ok_transfer, 'error_transfer' => $error_transfer),    
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MemberTransfer()
	{
            
                $form_token = $_SESSION['member']['ID'].'-'.time();
                $_SESSION['form_token'] = $form_token;
                

                //$sql = "UPDATE form_token SET Transfer = '".$form_token."' WHERE ID = 1"; 

                //$count = $this->dbconnect->exec($sql); 
            
		/*$productType = ProductTypeModel::getProductTypeList();*/

		$product = ProductModel::getProductListWithWallet();

		$result = WalletModel::getWalletList();

		$nonmainwalletproduct = ProductModel::getNonMainWalletProduct();

		$mainwalletproduct = ProductModel::getMainWalletProduct();

        /*$product_list['casino'] = ProductModel::getProductListByType('1');

        $product_list['soccer'] = ProductModel::getProductListByType('2');

        $product_list['horse'] = ProductModel::getProductListByType('3');

        $product_list['poker'] = ProductModel::getProductListByType('6');

        $product_list['games'] = ProductModel::getProductListByType('7');

        $product_list['fourd'] = ProductModel::getProductListByType('8');

        $product_list['main'] = ProductModel::getProductListByType('5');*/

		#$total = WalletModel::getWalletTotal();

		//$product = ProductModel::getProductByType($productType[$i]['ID']);
                if($_SESSION['language']=='en')
                {
                   $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }
                elseif($_SESSION['language']=='ms')
                {
                    $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }
                elseif($_SESSION['language']=='zh_CN')
                {
                    $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => Helper::translate("Transfer", "member-transfer-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/transfer.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("Transfer", "member-transfer-title")),
		'content' => $result,
		'ProductType' =>$productType,
		'Product' =>$product,
		'WalletTotal' => $total,
		'content2' => $product_list,
                'form_token' => $form_token,
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
            
            if($_POST['TransferFrom']=='30')
            {
                 
            }
            else
            {
                $ProductID = $_POST['TransferFrom']; 
            }
            
            if($_POST['TransferTo']=='30')
            {
                 
            }
            else
            {
                $ProductID = $_POST['TransferTo']; 
            }
            
            
            
             /*$selecttoken = "SELECT Transfer FROM form_token WHERE ID = 1";

             
             foreach ($this->dbconnect->query($selecttoken) as $row)
             {
                $result = $row['Transfer'];
                     
             }*/
         
        if(is_array($_SESSION['member']['token'])===FALSE)
            {    
               $_SESSION['member']['token'] = array();
            }
            
            if (in_array($_POST['form_token'], $_SESSION['member']['token'])===FALSE) {
                
                array_push($_SESSION['member']['token'], $_POST['form_token']);
                
                      
            $_SESSION['form_token'] = $_SESSION['member']['ID'].'-'.time();
            
            
        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$transferFrom = WalletModel::getWalletByProductID($_POST['TransferFrom']);

		//if ($_POST['Amount']>$transferFrom) {
			//$valid = '0';
		//}elseif($_POST['Amount']<=$transferFrom){
			$key = "(MemberID, TypeID, ProductID, Description, Date, TransferTo, TransferFrom, Amount, StaffID, ModifiedDate, Status)";
			$value = "('".$_SESSION['member']['ID']."', '1', '".$ProductID."', '".$_POST['description']."', '".$date_posted."', '".ProductModel::IDToProductName($_POST['TransferTo'])."', '".ProductModel::IDToProductName($_POST['TransferFrom'])."', '".$_POST['Amount']."', '', '', '1')";

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
        
        }

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
                $form_token = $_SESSION['member']['ID'].'-'.time(); 
                
                $_SESSION['form_token'] = $form_token;
                
                //$sql = "UPDATE form_token SET Withdrawal = '".$form_token."' WHERE ID = 1";  

                //$count = $this->dbconnect->exec($sql);
            
		$result = MemberModel::getMember($_SESSION['member']['ID']);
        $result['MainWallet'] = WalletModel::getMainWalletTotal();

                if($_SESSION['language']=='en')
                {
                   $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }
                elseif($_SESSION['language']=='ms')
                {
                    $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }
                elseif($_SESSION['language']=='zh_CN')
                {
                    $this->module_name = Helper::translate("Transactions", "member-breadcrumb-transaction");
                }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => Helper::translate("Withdrawal", "member-withdrawal-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/withdrawal.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("Withdrawal", "member-withdrawal-title")),
		'content' => $result,
                'form_token' => $form_token,    
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_add']);

		return $this->output;
	}

	public function MemberWithdrawalProcess()
	{
            
         
        if(is_array($_SESSION['member']['token'])===FALSE)
            {    
               $_SESSION['member']['token'] = array();
            }
            
            if (in_array($_POST['form_token'], $_SESSION['member']['token'])===FALSE) {
                
                array_push($_SESSION['member']['token'], $_POST['form_token']);
                
                      
            $_SESSION['form_token'] = $_SESSION['member']['ID'].'-'.time();
            
            
        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$BankDetails = MemberModel::getMember($_SESSION['member']['ID']);

        $description = "Bank: ".$_POST['Bank']." | Bank Account No: ".$_POST['BankAccountNo']." | Secondary Bank: ".$_POST['SecondaryBank']." | Secondary Bank Account No: ".$_POST['SecondaryBankAccountNo'];

		$key = "(MemberID, TypeID, Description, `Date`, Bank, Credit, StaffID, ModifiedDate, Status)";
		$value = "('".$_SESSION['member']['ID']."', '3', '".$description."', '".$date_posted."', '".$_POST['Bank']."', '".$_POST['Amount']."', '', '', '1')";

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
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Deposit...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID, 'reseller_email' => $reseller_email),
        'message' => $message,
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getTransactionReport()
	{

			// Initialise query conditions
			$query_condition = "";

			$crud = new CRUD();

			if ($_POST['Trigger']=='search_form')
			{
				// Reset Query Variable
				$_SESSION['transaction_summary'] = "";

				$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=", 1);
				$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
				$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
				$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
	            $query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']) : Helper::dateDisplaySQL($_POST['DateTo']),"<=");
				$query_condition .= $crud->queryCondition("Debit",$_POST['Debit'],"LIKE");
				$query_condition .= $crud->queryCondition("Credit",$_POST['Credit'],"LIKE");
				//$query_condition .= $crud->queryCondition("Status",'2',"LIKE");
                $query_condition .= $crud->queryCondition("DepositBonus",$_POST['DepositBonus'],"LIKE");
                $query_condition .= $crud->queryCondition("DepositChannel",$_POST['DepositChannel'],"LIKE");
                $query_condition .= $crud->queryCondition("ReferenceCode",$_POST['ReferenceCode'],"LIKE");
                $query_condition .= $crud->queryCondition("Bank",$_POST['Bank'],"LIKE");
                $query_condition .= $crud->queryCondition("TransferFrom",$_POST['TransferFrom'],"LIKE");
                $query_condition .= $crud->queryCondition("TransferTo",$_POST['TransferTo'],"LIKE");
                $query_condition .= $crud->queryCondition("Amount",$_POST['Amount'],"LIKE");

				$_SESSION['transaction_summary']['param']['MemberID'] = $_POST['MemberID'];
				$_SESSION['transaction_summary']['param']['Description'] = $_POST['Description'];
				$_SESSION['transaction_summary']['param']['RejectedRemark'] = $_POST['RejectedRemark'];
				$_SESSION['transaction_summary']['param']['DateFrom'] = $_POST['DateFrom'];
				$_SESSION['transaction_summary']['param']['DateTo'] = $_POST['DateTo'];
				$_SESSION['transaction_summary']['param']['Debit'] = $_POST['Debit'];
				$_SESSION['transaction_summary']['param']['Credit'] = $_POST['Credit'];
				//$_SESSION['transaction_summary']['param']['Status'] = '2';
                $_SESSION['transaction_summary']['param']['DepositBonus'] = $_POST['DepositBonus'];
                $_SESSION['transaction_summary']['param']['DepositChannel'] = $_POST['DepositChannel'];
                $_SESSION['transaction_summary']['param']['ReferenceCode'] = $_POST['ReferenceCode'];
                $_SESSION['transaction_summary']['param']['Bank'] = $_POST['Bank'];
                $_SESSION['transaction_summary']['param']['TransferFrom'] = $_POST['TransferFrom'];
                $_SESSION['transaction_summary']['param']['TransferTo'] = $_POST['TransferTo'];
                $_SESSION['transaction_summary']['param']['Amount'] = $_POST['Amount'];

				// Set Query Variable
				$_SESSION['transaction_summary']['query_condition'] = $query_condition;
				$_SESSION['transaction_summary']['query_title'] = "Search Results";
			}

			// Reset query conditions
			if ($_GET['page']=="all")
			{
				$_GET['page'] = "";
				unset($_SESSION['transaction_summary']);
			}

			if(isset($_POST)){

			   $sql = "SELECT * FROM transaction WHERE Status = '2' ".$_SESSION['transaction_summary']['query_condition'];

			}else{

			   $sql = "SELECT * FROM transaction WHERE Status = '2'";
			}

			$result = array();
			//$transaction['count'] = $result['count'];
			//$i = 0;


			$i = 0;
			foreach ($this->dbconnect->query($sql) as $row)
			{
				$In += $row['Debit'];
				$Out += $row['Credit'];
				$Bonus += $row['Bonus'];
				$Commission += $row['Commission'];

				$i += 1;
			}



			$profit = $In - $Out - $Commission - $Bonus;

			$result = array('In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out), 'Bonus'=> Helper::displayCurrency($Bonus), 'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit));
			/*Debug::displayArray($result);
			exit;*/


		/*unset($profit);
		unset($In);
		unset($Out);
		unset($Total);
		unset($Percentage);*/

		return $result;
	}
        
        public function getTransactionCumulation($param)
	{
            
                $sql = "SELECT * FROM transaction WHERE Status = '2' AND MemberID = '".$param."'";
                //echo $sql;

                foreach ($this->dbconnect->query($sql) as $row)
                {
                        $In += $row['Debit'];
                        $Out += $row['Credit'];
                        
                                                                        
                }
                
                $sql2 = "SELECT * FROM transaction WHERE Status = '2' AND MemberID = '".$param."' AND TypeID = '1'";

                foreach ($this->dbconnect->query($sql2) as $row2)
                {                       
                        
                        $TransferTo = ProductModel::getProductByName($row2['TransferTo']);
                        if($TransferTo == '30')
                        {
                            $TransferToAmount += $row2['Amount'];
                        }
                                                                           
                }
                
                $sql3 = "SELECT * FROM transaction WHERE Status = '2' AND MemberID = '".$param."' AND TypeID = '1'";
                //echo $sql3;
                //$TransferFromAmount = 0;
                foreach ($this->dbconnect->query($sql3) as $row3)
                {
                        $TransferFrom = ProductModel::getProductByName($row3['TransferFrom']);
                        /*echo $TransferFrom;
                        exit;*/
                        if($TransferFrom == '30')
                        {
                            $TransferFromAmount -= $row3['Amount'];
                        }    
                                                                           
                }
                 /*echo $TransferFromAmount;
                 exit;*/

                $total1 = $In - $Out;
                /*echo $total1;
                exit;*/
                $total2 = $TransferToAmount + $TransferFromAmount;
                $MainWallet = $total1 + $total2;
                
                
                $ok = WalletModel::getWalletUpdate($MainWallet, $param);
               	/*echo $total1.'<br />';
                echo $total2;
                exit;*/
                if($ok === 1)
                {
                   return TRUE;   
                }    
		else
                {
                    return FALSE;
                }    
	}

	public function getTransaction($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM transaction WHERE ID = '".$param."'";

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

    public function getTransactionFull($param)
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM transaction WHERE ID = '".$param."'";

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

		$sql = "SELECT * FROM transaction ORDER BY Date DESC";

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


		$sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.$param]['query_condition']." AND m.Reseller = '".$ID."' Order By t.Date DESC";


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
		//$sql = "SELECT * FROM transaction ".$_SESSION['transaction_'.$param]['query_condition']." ORDER BY `Date` DESC";
		$Resname = array();
		//$MemName = array();
		$Resname = ResellerModel::getReseller($ID);
		$MemName = MemberModel::getMemberName($_SESSION['transaction_'.$param]['param']['t.MemberID']);
		$result = array();
		$Report  = array();
		$result['content'] = '';
		$result['filename'] = $this->config['SITE_NAME']."_Transaction";
		//$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			//$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateTo']
		$Report = ResellerModel::getResellerReport($ID, $param);
		$result['header'] = $this->config['SITE_NAME']." | Transaction (" . date('Y-m-d H:i:s') . ")<br /><br />";
		$result['header'] .= "\"Search filter\",";
		$result['header'] .= "\"Reseller\":,";
		$result['header'] .= "\"".$Resname[0]['Name']."\",";
		if($_SESSION['transaction_'.$param]['param']['t.DateFrom'] != ''){
		$result['header'] .= "\"Date From\":,";
		$result['header'] .= "\"".Helper::dateSQLToDisplay($_SESSION['transaction_'.$param]['param']['t.DateFrom'])."\",";
		}
		if($_SESSION['transaction_'.$param]['param']['t.DateTo'] != ''){
		$result['header'] .= "\"Date To\":,";
		$result['header'] .= "\"".Helper::dateSQLToDisplay($_SESSION['transaction_'.$param]['param']['t.DateTo'])."\",";
		}
		if($_SESSION['transaction_'.$param]['param']['t.MemberID'] != ''){
		$result['header'] .= "\"Member\":,";
		$result['header'] .= "\"".$MemName."\",";
		}
        if($_SESSION['transaction_'.$param]['param']['t.TypeID'] != ''){
		$result['header'] .= "\"Type\":,";
		$result['header'] .= "\"".TransactionTypeModel::getTransactionType($_SESSION['transaction_'.$param]['param']['t.TypeID'])."\",";
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
			$result['content'] .= "\"".TransactionStatusModel::getTransactionStatus($row['t_Status'])."\"\n";

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
		$sql = "SELECT * FROM transaction ".$_SESSION['transaction_'.$param]['query_condition']." ORDER BY `Date` DESC";
		/*echo $sql;
		exit;*/
		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Transaction";
		$result['header'] = $this->config['SITE_NAME']." | Transaction (" . date('Y-m-d H:i:s') . ")<br /><br />Date Posted, Type, Member, Username, Description, Transfer From, Transfer To, Deposit Channel, Reference Code, Bank, In (MYR), Out (MYR), Transfer (MYR), Staff, Modified Date, Status";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
            $result['content'] .= "\"".Helper::dateTimeSQLToDisplay($row['Date'])."\",";
			$result['content'] .= "\"".TransactionTypeModel::getTransactionType($row['TypeID'])."\",";
			$result['content'] .= "\"".MemberModel::getMemberName($row['MemberID'])."\",";
            $result['content'] .= "\"".MemberModel::getMemberUsername($row['MemberID'])."\",";
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
			$result['content'] .= "\"".TransactionStatusModel::getTransactionStatus($row['Status'])."\"\n";

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