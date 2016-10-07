<?php
// Require required models
Core::requireModel('member');
Core::requireModel('transactiontype');
Core::requireModel('transactionstatus');
Core::requireModel('product');
Core::requireModel('wallet');
Core::requireModel('producttype');
Core::requireModel('staff');
Core::requireModel('bankinslip');
Core::requireModel('bankinfo');
Core::requireModel('rejectmessage');
Core::requireModel('agent');
Core::requireModel('agentblock');
Core::requireModel('agentpromotion');
Core::requireModel('operator');



class TransactionModel extends BaseModel
{
        private $output = array();
        private $module_name = "Transactions";
        private $module_dir = "modules/transaction/";
        private $module_default_url = "/main/transaction/index";
        private $module_default_admin_url = "/admin/transaction/index";
        private $module_default_member_url = "/member/transaction/index";
        private $module_default_agent_url = "/agent/transaction/index";
        private $module_default_agentaffiliatedreporting_url = "/agent/transaction/affiliatedreporting";
        private $module_default_adminaffiliatedreporting_url = "/admin/transaction/affiliatedreporting";
        private $module_default_agentgroup_url = "/agent/transaction/group";

        private $member_module_name = "Member";
        private $member_module_dir = "modules/member/";

        private $reseller_module_name = "Reseller";
        private $reseller_module_dir = "modules/reseller/";
        private $module_default_reseller_url = "/reseller/reseller/index";

        private $agent_module_name = "Agent";
        private $affiliate_report = "Affiliate Report";
        private $agent_module_dir = "modules/agent/";

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
                /*if(empty($_POST['submit'])===FALSE)
                {
                  Debug::displayArray($_POST);
                  exit;

                }*/

                /*$promo[1] = BlockModel::getBlockContent(47);
                $promo[2] = BlockModel::getBlockContent(48);
                $promo[3] = BlockModel::getBlockContent(49);
                $promo[4] = BlockModel::getBlockContent(50);
                $promo[5] = BlockModel::getBlockContent(51);
                $promo[6] = BlockModel::getBlockContent(52);
                $promo[7] = BlockModel::getBlockContent(53);
                $promo[8] = BlockModel::getBlockContent(54);
                $promo[9] = BlockModel::getBlockContent(55);
                $promo[10] = BlockModel::getBlockContent(56);*/

		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{

                    

			// Reset Query Variable
			$_SESSION['transaction_'.__FUNCTION__] = "";
                        
                        if($_POST['Member']=='')
                        {
                            $_POST['MemberID'] = '';
                        }

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
                        $_SESSION['transaction_'.__FUNCTION__]['param']['Member'] = $_POST['Member'];
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
			unset($_SESSION['transaction_summary']);
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
		//echo $sql;
		/*exit;*/
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
            'Agent' => MemberModel::getMemberResellerCompany($row['MemberID']),
                        'Colour' => AgentModel::getAgent($reseller),
			'Description' => $row['Description'],
                        'Promotion' => $row['Promotion'],
                        'BankSlip' => $row['BankSlip'],
                        'GameUsername' => WalletModel::getWalletUsername($row['MemberID'], $row['ProductID']),
                        'MainWallet' =>  Helper::displayCurrency(WalletModel::getMemberWalletTotal($row['MemberID'])),
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => date("d-m-Y | H.i.s a", strtotime(Helper::dateTimeSQLToDisplay($row['Date']))),
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
                        'OperatorID' => ($row['OperatorID']=='0')?'0': OperatorModel::getOperator($row['OperatorID']),
                        'OperatorIDUpdated' => OperatorModel::getOperator($row['OperatorIDUpdated']),    
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

                /*if($_SESSION['transaction_'.__FUNCTION__]['param']['Promotion']!="")
                        {
                            for ($index = 0; $index < 10; $index++) {

                                    if($promo[$index]==$_SESSION['transaction_'.__FUNCTION__]['param']['Promotion']){
                                        $promotionspecial = $index;
                                    }

                            }
                        }*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Transactions", 'template' => 'admin.transaction.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'transaction_delete' => $_SESSION['admin']['transaction_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
                /*'promo' => $promo,*/
                /*'promotionspecial' => $promotionspecial,*/
		'summary' => $this->getTransactionReport(),
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), /*'member_list' => MemberModel::getMemberList(),*/ 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'rejecte_message' => RejectMessageModel::getRejectMessageList(), 'bank_list' => BankModel::getBankList(), 'agentpromotion_list' => AgentPromotionModel::getEnabledAgentPromotionList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['transaction_delete']);
		/*Debug::displayArray($this->output['summary']);
		exit;*/
		return $this->output;
	}
        
        public function APISearch()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            
            // Get all request data
            $request_data = $restapi->getRequestData();
            $request_data['TypeID'] = urldecode($request_data['TypeID']);
            $request_data['Status'] = urldecode($request_data['Status']);
            $request_data['DateTo'] = urldecode($request_data['DateTo']);
            $request_data['DateFrom'] = urldecode($request_data['DateFrom']);
            
            if($request_data['TypeID']=='All Types')
            {
                $queryTypes = '';
                
            }
            else
            {
                $queryTypes = " AND TypeID = '".$request_data['TypeID']."'";
            }    
            
            if($request_data['Status']=='All Statuses')
            {
                $queryStatuses = '';
                
            } 
            else
            {
                $queryStatuses = " AND Status = '".$request_data['Status']."'";
            }    
                      
            
            if($request_data['DateTo']=='')
            {
                $queryDateTo = '';
                
            }
            else
            {
                $queryDateTo = " AND Date <= '".Helper::dateTimeDisplaySQL($request_data['DateTo'])."'";
            }    
            
            if($request_data['DateFrom']=='')
            {
                $queryDateFrom = '';
                
            }
            else            
            {
                $queryDateFrom = " AND Date >= '".Helper::dateTimeDisplaySQL($request_data['DateFrom'])."'";
                
            }

            
            
            
            
        
            // Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM transaction WHERE MemberID = '".$request_data['memberID']."'".$queryTypes.$queryStatuses.$queryDateFrom.$queryDateTo;
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();



		$sql = "SELECT * FROM transaction WHERE MemberID = '".$request_data['memberID']."'" .$queryTypes.$queryStatuses.$queryDateFrom.$queryDateTo." ORDER BY `Date` DESC, `ID` DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
                    
                        $timeLeft = $this->timeLeft(strtotime($row['Date']), $this->config['TIME_ELAPSE']);
                        if($timeLeft=='0')
                        {
                            $timeLeft = '0:00';
                        }
                        else
                        {
                            
                        }
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'MemberID' => MemberModel::getMemberName($row['MemberID']),
			'Description' => $row['Description'],
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
                        'TimeLeft' =>  $timeLeft,
                        'TimeConfig' =>  $this->config['TIME_ELAPSE'],  
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
                
                $output['count'] = $i;
                $output['content'] = $result;
                $output['transactiontype_list'] = TransactionTypeModel::getAPITransactionTypeList(); 
                $output['transactiontype_list_count'] = count($output['transactiontype_list']);
                $output['transactionstatus_list'] = TransactionStatusModel::getAPITransactionStatusList();
                $output['transactionstatus_list_count'] = count($output['transactionstatus_list']);
                $output['total'] = $total_pages;
                
                // Set output
            if ($output['count']>0)
            {
                $result = json_encode($output);
                $restapi->setResponse('200', 'OK', $result);
            }
            else
            {
                $restapi->setResponse('404', 'Resource Not Found');
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
                
    }
    
    public function APIHTMLHeaderBottom()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            
            // Get all request data
            $request_data = $restapi->getRequestData();
            
            $BackgroundColour = AgentModel::getAgent($request_data['Agent'], "BackgroundColour");
            $FontColour = AgentModel::getAgent($request_data['Agent'], "FontColour");
             
            
            
            $result = array();
		

			$dataSet = array(
			'pretext' => "<!DOCTYPE html>
                                    <head>
                                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                    <meta name='viewport' content='width=device-width, initial-scale=1' />
                                    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                    <style type='text/css'>
                                    body{
                                        background-color: ". $BackgroundColour ." !important;      
                                        color: ". $FontColour ." !important; 
                                     }
                                    </style>
                                    </head>
                                    <body>
                                   ",
			'posttext' => "</body></html>");
                        
                        array_push($result, $dataSet); 
			
	
            
            
            $output['content'] = $result;
            $output['count'] = count($output['content']);
                
                // Set output
            if ($output['count']>0)
            {
                $result = json_encode($output);
                $restapi->setResponse('200', 'OK', $result);
            }
            else
            {
                $restapi->setResponse('404', 'Resource Not Found');
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
                
    }

        public function APIDeposit()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();



            $output['nonmainwalletproduct'] = ProductModel::getAPINonMainWalletProduct($request_data);
            $output['nonmainwalletproduct_count'] = count($output['nonmainwalletproduct']);
            $output['agentblock'] = AgentBlockModel::getAPIAgentBlockByAgent($request_data['Agent'], "deposit");
            $output['promotion_list'] = AgentPromotionModel::getAPIAgentPromotionListByAgent($request_data['Agent'], $request_data['memberID']);
            $output['promotion_list_count'] = count($output['promotion_list']);
            $output['bank_info'] = BankInfoModel::getAPIAgentBankInfoList($request_data['Agent']);
            $output['bank_info_count'] = count($output['bank_info']);
            $output['bank_slip'] = BankinSlipModel::getAPIPublicBankinSlipList();
            $output['bank_slip_count'] = count($output['bank_slip']);
            $output['deposit_channel'] = array("Please select one", "Internet Banking", "ATM Deposit", "CTM Cash Deposit Machine");
            $output['deposit_channel_count'] = count($output['deposit_channel']);
            
            
            
            

            $output['count'] = count($output);

            // Set output
            if ($output['count']>0)
            {
                $result = json_encode($output);
                $restapi->setResponse('200', 'OK', $result);
            }
            else
            {
                $restapi->setResponse('404', 'Resource Not Found');
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }


    public function APIDepositProcess(){

    // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
            // Get all request data
            $request_data = $restapi->getRequestData();
            $status = array();

    $date_deposit = "Date of Deposit: ".$request_data['DateDeposit'];
        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$key = "(MemberID, TypeID, Description, Promotion, Date, DepositChannel, BankSlip, ReferenceCode, Bank, Debit, StaffID, ModifiedDate, Status)";
		$value = "('".$request_data['memberID']."', '2', '".$date_deposit." | ".$request_data['PromoSpecial']."', '".$request_data['PromoSpecial']."', '".$date_posted."', '".$request_data['DepositChannel']."', '".$request_data['BankSlip']."', '".$request_data['ReferenceCode']."', '".$request_data['bank']."', '".$request_data['DepositAmount']."', '', '', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count_deposit = $this->dbconnect->exec($sql);
		$newID_deposit = $this->dbconnect->lastInsertId();

        $member = MemberModel::getMember($request_data['memberID']);
        $agent = AgentModel::getAgent($member[0]['Agent']);
        $agent_email = $agent['Email'];

		$message_deposit = "<br /><br />Agent:\t".$agent['Name']."<br />";
        $message_deposit .= "Description:\t".$date_deposit."<br />";
        $message_deposit .= "Date Posted:\t".$date_posted_display."<br />";
        $message_deposit .= "Deposit Channel:\t".$request_data['DepositChannel']."<br />";
        $message_deposit .= "Reference Code:\t".$request_data['ReferenceCode']."<br />";
        $message_deposit .= "Bank:\t".$request_data['bank']."<br />";
        $message_deposit .= "In (MYR):\t".$request_data['DepositAmount']."<br /><br />";
        $message_deposit .= "Promo:\t".$request_data['PromoSpecial']."<br />";

		// Set Status
        $ok_deposit = ($count_deposit==1) ? 1 : "";

        //Transfer
        if($request_data['TransferAmount']!='')
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
			$value = "('".$request_data['memberID']."', '1', '".$request_data['description']."', '".$request_data['TransferTo']."', '".$date_posted."', '".ProductModel::IDToProductName($request_data['TransferTo'])."', '".ProductModel::IDToProductName('30')."', '".$request_data['TransferAmount']."', '', '', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count_transfer = $this->dbconnect->exec($sql);
		$newID_transfer = $this->dbconnect->lastInsertId();
		//}

        $member = MemberModel::getMember($request_data['memberID']);
        $agent = AgentModel::getAgent($member[0]['Agent']);
        $agent_email = $agent['Email'];

        //Debug::displayArray($agent);
        if($agent['ParentID']!='0')
        {

            AgentModel::getloopAgentParent($agent['ParentID']);

        }




        $message_transfer = "<br /><br />Agent:\t".$agent['Name']."<br />";
        $message_transfer .= "Date Posted:\t".$date_posted_display."<br />";
        $message_transfer .= "Transfer From:\t".ProductModel::IDToProductName('30')."<br />";
        $message_transfer .= "Transfer To:\t".ProductModel::IDToProductName($request_data['TransferTo'])."<br />";
        $message_transfer .= "Transfer Amount (MYR):\t".$_POST['TransferAmount']."<br />";

		// Set Status
        $ok_transfer = ($count_transfer==1) ? 1 : "";

        }


            /*}*/

                $agent_type = AgentModel::getAgent($request_data['Agent'], "TypeID");

                if($agent_type == '2')
                {

                    $agentParent = AgentModel::getAgent($_SESSION['platform_agent']);
                    unset($_SESSION['platform_agent']);
                }



                $ok_sum = $ok_transfer + $ok_deposit;
                
                
                
                
                
                
                
                
                
                
                $Logo = AgentModel::getAgent($request_data['Agent'], "Logo");
                $Name = AgentModel::getAgent($request_data['Agent'], "Name");
                $Username = AgentModel::getAgent($request_data['Agent'],"Username");
                $Company = AgentModel::getAgent($request_data['Agent'],"Company");           
                $agent_type = AgentModel::getAgent($request_data['Agent'], "TypeID");
                
                if($request_data['TransferAmount']!='')
        {        
        if ($ok_deposit=="1" && $ok_transfer=="1")
		{
            
            $message_deposit = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            $message_transfer = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            
            if($agent_type == '1')
            {    
            
                $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';

                $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';
            
            }
            elseif($agent_type == '2')
            {
                $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';

                $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';
            }    
                        
            
            $message_deposit .= "A new deposit has been requested. (Member: ".$Name." - ".$Username.")".$message_deposit.$message_deposit_account;
            $message_transfer .= "A new transfer has been requested. (Member: ".$Name." - ".$Username.")".$message_transfer.$message_transfer_account;
            
            $param['agent_type'] = $agent_type;
            $param['agent'] = AgentModel::getAgent($request_data['Agent']);
            $param['agent_parent'] = $agentParent;
            $param['config'] = $this->config;
            
            $this->TransactionSendMail($message_deposit, $param);
            $this->TransactionSendMail($message_transfer, $param);

			$status['status_deposit']['ok_deposit']="successd";
                        $status['status_transfer']['ok_transfer']="successt";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit'].'&paramtransfer='.$param['status_transfer']['ok_transfer']);
                            
            
            
		}
                
                if($ok_deposit=="1" && $ok_transfer!="1")
                {
                    
                    $message_deposit = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            $message_transfer = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            
            if($agent_type == '1')
            {    
            
                $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';

                $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';
            
            }
            elseif($agent_type == '2')
            {
                $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';

                $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';
            }
                    
                    $message_deposit .= "A new deposit has been requested. (Member: ".$Name." - ".$Username.")".$message_deposit.$message_deposit_account;
                    
            $param['agent_type'] = $agent_type;
            $param['agent'] = AgentModel::getAgent($request_data['Agent']);
            $param['agent_parent'] = $agentParent;
            $param['config'] = $this->config;
            
            $this->TransactionSendMail($message_deposit, $param);
            

			$status['status_deposit']['ok_deposit']="successd";
                        $status['status_transfer']['ok_transfer']="failure";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit'].'&paramtransfer='.$param['status_transfer']['ok_transfer']);
                    
                }
                
                if($ok_deposit!="1" && $ok_transfer=="1")
                {
                 
                    $message_deposit = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            $message_transfer = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            
            if($agent_type == '1')
            {    
            
                $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';

                $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';
            
            }
            elseif($agent_type == '2')
            {
                $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';

                $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';
            }
                    
                    
            $message_transfer .= "A new transfer has been requested. (Member: ".$Name." - ".$Username.")".$message_transfer.$message_transfer_account;
            $param['agent_type'] = $agent_type;
            $param['agent'] = AgentModel::getAgent($request_data['Agent']);
            $param['agent_parent'] = $agentParent;
            $param['config'] = $this->config;
            $this->TransactionSendMail($message_transfer, $param);

			$status['status_deposit']['ok_deposit']="failure";
                        $status['status_transfer']['ok_transfer']="successt";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit'].'&paramtransfer='.$param['status_transfer']['ok_transfer']);
                } 
                
		if($ok_deposit!="1" && $ok_transfer!="1")
		{
			$status['status_deposit']['ok_deposit']="failure";
                        $status['status_transfer']['ok_transfer']="failure";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit'].'&paramtransfer='.$param['status_transfer']['ok_transfer']);
		}
        }
        
        
        if($request_data['TransferAmount']=='')
        {
            if ($ok_deposit=="1")
		{
                
                $message_deposit = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            $message_transfer = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            
            if($agent_type == '1')
            {    
            
                $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';

                $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';
            
            }
            elseif($agent_type == '2')
            {
                $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';

                $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';
            }
                
                
            $message_deposit .= "A new deposit has been requested. (Member: ".$Name." - ".$Username.")".$message_deposit.$message_deposit_account;
            $param['agent_type'] = $agent_type;
            $param['agent'] = AgentModel::getAgent($request_data['Agent']);
            $param['agent_parent'] = $agentParent;
            $param['config'] = $this->config;
            $this->TransactionSendMail($message_deposit, $param);

			$status['status_deposit']['ok_deposit']="successd";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit']);
		}
		else
		{
			$status['status_deposit']['ok_deposit']="failure";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit']);
		}
        }
        
                $dataStatus = array();
        
                if($request_data['TransferAmount']!='')
                {
        
                    if($status['status_deposit']['ok_deposit']=='successd'){

                        array_push($dataStatus, 'member-history-credited');

                    }
                    elseif($status['status_deposit']['ok_deposit']=='failure')
                    {                   
                        array_push($dataStatus, 'member-history-error');
                    }
                    
                    if($status['status_transfer']['ok_transfer']=='successt'){

                        array_push($dataStatus, 'member-history-transfer');

                    }
                    elseif($status['status_transfer']['ok_transfer']=='failure')
                    {                   
                        array_push($dataStatus, 'member-history-error');
                    }
                }
                else
                {
                    if($status['status_deposit']['ok_deposit']=='successd'){

                        array_push($dataStatus, 'member-history-credited');

                    }
                    elseif($status['status_deposit']['ok_deposit']=='failure')
                    {                   
                        array_push($dataStatus, 'member-history-error');
                    }
                } 
        
                                                     
                               

             // Set output
                if ($ok_sum >= 1)
                {
                    $result = json_encode(array('Status' => $dataStatus));
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    $restapi->setResponse('401', 'Not Authorized');
                }

            }

            }
            else
            {
                $restapi->setResponse('405', 'HTTP Method Not Accepted');
            }
        }

        public function APITransferProcess(){

    // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
            $status = array();    
            // Get all request data
            $request_data = $restapi->getRequestData();

    if($request_data['TransferFrom']=='30')
            {

            }
            else
            {
                $ProductID = $request_data['TransferFrom'];
            }

            if($request_data['TransferTo']=='30')
            {

            }
            else
            {
                $ProductID = $request_data['TransferTo'];
            }








        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$transferFrom = WalletModel::getWalletByProductID($request_data['TransferFrom']);

		//if ($_POST['Amount']>$transferFrom) {
			//$valid = '0';
		//}elseif($_POST['Amount']<=$transferFrom){
			$key = "(MemberID, TypeID, ProductID, Description, Date, TransferTo, TransferFrom, Amount, StaffID, ModifiedDate, Status)";
			$value = "('".$request_data['memberID']."', '1', '".$ProductID."', '".$request_data['description']."', '".$date_posted."', '".ProductModel::IDToProductName($request_data['TransferTo'])."', '".ProductModel::IDToProductName($request_data['TransferFrom'])."', '".$request_data['TransferAmount']."', '', '', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		//}

        $member = MemberModel::getMember($request_data['memberID']);
        $agent = AgentModel::getAgent($member[0]['Agent']);

        $agent_email = $agent['Email'];

        if($agent['ParentID']!='0')
        {
            AgentModel::getloopAgentParent($agent['ParentID']);
        }

        $message = "<br /><br />Agent:\t".$agent['Name']."<br />";
        $message .= "Date Posted:\t".$date_posted_display."<br />";
        $message .= "Transfer From:\t".ProductModel::IDToProductName($request_data['TransferFrom'])."<br />";
        $message .= "Transfer To:\t".ProductModel::IDToProductName($request_data['TransferTo'])."<br />";
        $message .= "Transfer Amount (MYR):\t".$request_data['TransferAmount']."<br />";

		// Set Status
        $ok = ($count==1) ? 1 : "";



                $agent_type = AgentModel::getAgent($request_data['Agent'], "TypeID");

                if($agent_type == '2')
                {

                    $agentParent = AgentModel::getAgent($_SESSION['platform_agent']);
                    unset($_SESSION['platform_agent']);

                }
                
                
                $Logo = AgentModel::getAgent($request_data['Agent'], "Logo");
                $Name = AgentModel::getAgent($request_data['Agent'], "Name");
                $Username = AgentModel::getAgent($request_data['Agent'],"Username");
                $Company = AgentModel::getAgent($request_data['Agent'],"Company");           
                $agent_type = AgentModel::getAgent($request_data['Agent'], "TypeID");
                
                
                if ($ok=="1")
        {
            $message = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            
            if($agent_type == '1')
            {    
            
                $message_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';

            
            }
            elseif($agent_type == '2')
            {
                $message_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';

            }    
            
	        $message .= "A new transfer has been requested. (Member: ".$Name." - ".$Username.")".$message.$message_account;
                $param['agent_type'] = $agent_type;
                $param['agent'] = AgentModel::getAgent($request_data['Agent']);
                $param['agent_parent'] = $agentParent;
                $param['config'] = $this->config;
		    $this->TransactionSendMail($message, $param);

			$status['status_transfer']['ok_transfer']="successt";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramtransfer=".$param['status']['ok']);
		}
		else
		{
			$status['status_transfer']['ok_transfer']="failure";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramtransfer=".$param['status']['ok']);
		}
                
                    
                                 
                    if($status['status_transfer']['ok_transfer']=='successt'){

                        $dataStatus = 'member-history-transfer';

                    }
                    elseif($status['status_transfer']['ok_transfer']=='failure')
                    {                   
                        $dataStatus = 'member-history-error';
                    }
                   



             // Set output
                if ($ok=="1")
                {
                    $result = json_encode(array('Status' => $dataStatus));
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    $restapi->setResponse('401', 'Not Authorized');
                }

            }

            }
            else
            {
                $restapi->setResponse('405', 'HTTP Method Not Accepted');
            }
        }

         public function APIWithdrawalProcess(){

    // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            $status = array();
            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
            // Get all request data
            $request_data = $restapi->getRequestData();


        $date_posted = date('YmdHis');
        $date_posted_display = date('d-m-Y H:i:s');

		$BankDetails = MemberModel::getMember($request_data['memberID']);

        $description = "Bank: ".$request_data['Bank']." | Bank Account No: ".$request_data['BankAccountNo'];

		$key = "(MemberID, TypeID, Description, `Date`, Bank, Credit, StaffID, ModifiedDate, Status)";
		$value = "('".$request_data['memberID']."', '3', '".$description."', '".$date_posted."', '".$request_data['Bank']."', '".$request_data['Amount']."', '', '', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		$sql = "UPDATE member SET Bank = '".$request_data['Bank']."', BankAccountNo = '".$request_data['BankAccountNo']."' WHERE ID = '".$BankDetails['content'][0]['ID']."'";

		$this->dbconnect->exec($sql);

        $member = MemberModel::getMember($request_data['memberID']);
        $agent = AgentModel::getAgent($member[0]['Agent']);
        $agent_email = $agent[0]['Email'];

        if($agent['ParentID']!='0')
        {
            AgentModel::getloopAgentParent($agent['ParentID']);
        }

        $message = "<br /><br />Agent:\t".$agent['Name']."<br />";
        $message .= "Description:\t".$description."<br />";
        $message .= "Date Posted:\t".$date_posted_display."<br />";
        $message .= "Bank:\t".$request_data['Bank']."<br />";
        $message .= "Out (MYR):\t".$request_data['Amount']."<br />";

        $member = MemberModel::getMember($request_data['memberID']);
        $agent = AgentModel::getAgent($member[0]['Agent']);
        $agent_email = $agent['Email'];

        $ok = ($count==1) ? 1 : "";



                $agent_type = AgentModel::getAgent($request_data['Agent'], "TypeID");

                if($agent_type == '2')
                {

                    $agentParent = AgentModel::getAgent($_SESSION['platform_agent']);
                    unset($_SESSION['platform_agent']);

                }
                
                $Logo = AgentModel::getAgent($request_data['Agent'], "Logo");
                $Name = AgentModel::getAgent($request_data['Agent'], "Name");
                $Username = AgentModel::getAgent($request_data['Agent'],"Username");
                $Company = AgentModel::getAgent($request_data['Agent'],"Company");           
                $agent_type = AgentModel::getAgent($request_data['Agent'], "TypeID");
                
                if ($ok=="1")
		{
            
            $message = '<tr><td align="left"><img src="'.$this->config['SITE_URL'].$Logo.'" /></td></tr>';
            
            if($agent_type == '1')
            {    
            
                $message_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$Company.'">'.$Company.'</a>.</td></tr>';

            
            }
            elseif($agent_type == '2')
            {
                $message_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$agentParent['Company'].'">'.$agentParent['Company'].'</a>.</td></tr>';

            }
            
            $message .= "A new withdrawal has been requested. (Member: ".$Name." - ".$Username.")".$message.$message_account;
            
            $param['agent_type'] = $agent_type;
            $param['agent'] = AgentModel::getAgent($request_data['Agent']);
            $param['agent_parent'] = $agentParent;
            $param['config'] = $this->config;
            
            $this->TransactionSendMail($message, $param);

			$status['status']['ok']="successw";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?param=".$param['status']['ok']);
		}
		else
		{
			$status['status']['ok']="failure";
			//Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?param=".$param['status']['ok']);
		}
                
                
                                 
                if($status['status']['ok']=='successw'){

                     $dataStatus = 'member-history-bankin';

                }
                elseif($status['status']['ok']=='failure')
                {                   
                    $dataStatus = 'member-history-error';
                }

             // Set output
                if ($ok=="1")
                {
                    $result = json_encode(array('Status' => $dataStatus));
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    $restapi->setResponse('401', 'Not Authorized');
                }

            }

            }
            else
            {
                $restapi->setResponse('405', 'HTTP Method Not Accepted');
            }
        }

        public function APIWithdrawal()
        {
            // Initiate REST API class
                $restapi = new RestAPI();

                // Get method
                $method = $restapi->getMethod();

                if ($method=="GET")
                {
                    // Get all request data
                    $request_data = $restapi->getRequestData();

                    $output['content'] = MemberModel::getAPIMember($request_data['memberID']);
                    $output['MainWallet'] = WalletModel::getAPIMainWalletTotal($request_data);
                    $output['agentblock'] = AgentBlockModel::getAPIAgentBlockByAgent($request_data['Agent'], "withdrawal");



                    $output['Count'] = count($output);


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
                else
                {
                    $restapi->setResponse('405', 'HTTP Method Not Accepted');
                }

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

		/*// Initialise query conditions
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
		$query_count = "SELECT COUNT(*) AS num FROM transaction WHERE MemberID = '".$request_data['memberID']."' ".$_SESSION['transaction_'.__FUNCTION__]['query_condition'];
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
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);*/

		$sql = "SELECT * FROM transaction WHERE MemberID = '".$request_data['memberID']."' ORDER BY `Date` DESC, `ID` DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
                        $timeLeft = $this->timeLeft(strtotime($row['Date']), $this->config['TIME_ELAPSE']);
                        if($timeLeft=='0')
                        {
                            $timeLeft = '0:00';
                        }
                        else
                        {
                            
                        }
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'MemberID' => MemberModel::getMemberName($row['MemberID']),
			'Description' => $row['Description'],
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
			'TransferTo' => $row['TransferTo'],
			'TransferFrom' => $row['TransferFrom'],
                        'TimeLeft' => $timeLeft,
                        'TimeConfig' =>  $this->config['TIME_ELAPSE'],    
			'DepositBonus' => $row['DepositBonus'],
			'DepositChannel' => $row['DepositChannel'],
			'ReferenceCode' => (empty($row['ReferenceCode'])===TRUE) ? 'N/A': $row['ReferenceCode'],
			'Bonus' => $row['Bonus'],
                        'Commission' => $row['Commission'],
                        'Bank' => $row['Bank'],
			'In' => Helper::displayCurrency($row['Debit']),
			'Out' => Helper::displayCurrency($row['Credit']),
			'Amount' => Helper::displayCurrency($row['Amount']),
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;
		}

                $output['Count'] = $i;
                $output['Content'] = $result;
                $output['transactiontype_list'] = TransactionTypeModel::getAPITransactionTypeList(); 
                $output['transactiontype_list_count'] = count($output['transactiontype_list']);
                $output['transactionstatus_list'] = TransactionStatusModel::getAPITransactionStatusList();
                $output['transactionstatus_list_count'] = count($output['transactionstatus_list']);

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
            else
            {
                $restapi->setResponse('405', 'HTTP Method Not Accepted');
            }
	}

        public function APITransfer()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();


            //$output['mainwalletproduct'] = ProductModel::getAPIProductListWithWallet($request_data);
            //$output['mainwalletproduct_count'] = count($output['mainwalletproduct']);
            $output['product'] = ProductModel::getAPIProductListWithWallet($request_data);
            $output['product_count'] = count($output['product']);
            $output['mainwalletproduct'] = ProductModel::getAPIMainWalletProduct();
            $output['nonmainwalletproduct'] = ProductModel::getAPINonMainWalletProduct($request_data);
            $output['nonmainwalletproduct_count'] = count($output['nonmainwalletproduct']);
            $output['agentblock'] = AgentBlockModel::getAPIAgentBlockByAgent($request_data['Agent'], "transfer");

            $output['count'] = count($output);

            // Set output
            if ($output['count']>0)
            {
                $result = json_encode($output);
                $restapi->setResponse('200', 'OK', $result);
            }
            else
            {
                $restapi->setResponse('404', 'Resource Not Found');
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
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
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList(), 'agentpromotion_list' => AgentPromotionModel::getEnabledAgentPromotionList()),
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
		$value = "('".$_POST['TypeID']."', '".$_POST['MemberID']."', '".$_POST['Description']."', '".$_POST['Promotion']."', '".$_POST['ProductID']."', '".$_POST['BankSlip']."', '".$_POST['RejectedRemark']."', '".Helper::dateTimeDisplaySQL($_POST['Date'])."', '".$_POST['TransferTo']."', '".$_POST['TransferFrom']."', '".$_POST['Debit']."', '".$_POST['Credit']."', '".$_POST['Bonus']."', '".$_POST['Commission']."', '".$_POST['Amount']."', '".$_POST['DepositBonus']."', '".$_POST['DepositChannel']."', '".$_POST['ReferenceCode']."', '".$_POST['Bank']."', '', '', '".$_POST['Status']."')";

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
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList(), 'agentpromotion_list' => AgentPromotionModel::getEnabledAgentPromotionList()),
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



            $sql = "UPDATE transaction SET TypeID='".$_POST['TypeID']."', MemberID='".$_POST['MemberID']."', Description='".$_POST['Description']."', Promotion='".$_POST['Promotion']."', ProductID='".$_POST['ProductID']."', BankSlip='".$_POST['BankSlip']."', RejectedRemark='".$_POST['RejectedRemark']."', Date='".Helper::dateTimeDisplaySQL($_POST['Date'])."', TransferTo='".$_POST['TransferTo']."', TransferFrom='".$_POST['TransferFrom']."', Debit='".$_POST['Debit']."', Credit='".$_POST['Credit']."', Amount='".$_POST['Amount']."', DepositBonus='".$_POST['DepositBonus']."', Bonus='".$_POST['Bonus']."', Commission='".$_POST['Commission']."', ReferenceCode='".$_POST['ReferenceCode']."', Bank='".$_POST['Bank']."', Status='".$_POST['Status']."', StaffID = '".$staff_id."', StaffIDUpdated = '".$StaffIDUpdated."', ModifiedDate = '".$modified_date."', UpdatedDate = '".$UpdatedDate."' WHERE ID='".$param."'";

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


        public function AgentAdd()
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

                if($_GET['apc'] == 'apcg')
                {
                    $breadcrumb = $this->module_default_agentgroup_url;
                    $member_list = MemberModel::getMemberListByAgentAgent($_SESSION['agent']['ID']);
                }
                elseif($_GET['apc'] == 'apci')
                {
                    $breadcrumb = $this->module_default_agent_url;
                    $member_list = MemberModel::getMemberListByReseller($_SESSION['agent']['ID']);
                }
                else
                {
                    $breadcrumb = $this->module_default_agent_url;
                }

		$this->output = array(
		'config' => $this->config,
                'agent' => $result2,
		'page' => array('title' => "Create Transaction", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/add.inc.php', 'transaction_add' => $_SESSION['agent']['transaction_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.transaction_common.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$breadcrumb,"",$this->config,"Create Transaction"),
                'nonmainwallet' => $nonmainwalletproduct,
                'back' => $_SESSION['agent']['redirect'],
                'apc' => $_GET['apc'],   
                'content' => $result,
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => $member_list, 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


                unset($_SESSION['agent']['redirect']);
		unset($_SESSION['agent']['transaction_add']);

		return $this->output;
	}

	public function AgentAddProcess()
	{
            /*if($_POST['TypeID']=='1')
            {

            }*/


		$key = "(TypeID, MemberID, Description, Promotion, ProductID, BankSlip, RejectedRemark, Date, TransferTo, TransferFrom, Debit, Credit, Bonus, Commission, Amount, DepositBonus, DepositChannel, ReferenceCode, Bank, StaffID, OperatorID, ModifiedDate, Status)";
		$value = "('".$_POST['TypeID']."', '".$_POST['MemberID']."', '".$_POST['Description']."', '".$_POST['PromoSpecial']."', '".$_POST['ProductID']."', '".$_POST['BankSlip']."', '".$_POST['RejectedRemark']."', '".Helper::dateTimeDisplaySQL($_POST['Date'])."', '".$_POST['TransferTo']."', '".$_POST['TransferFrom']."', '".$_POST['Debit']."', '".$_POST['Credit']."', '".$_POST['Bonus']."', '".$_POST['Commission']."', '".$_POST['Amount']."', '".$_POST['DepositBonus']."', '".$_POST['DepositChannel']."', '".$_POST['ReferenceCode']."', '".$_POST['Bank']."', '', '', '', '".$_POST['Status']."')";

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
                'apc' => $_POST['apc'],    
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentEdit($param)
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
                        'AgentID' => $row['AgentID'],
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

                $nonmainwalletproduct = ProductModel::getNonMainWalletProduct();
                
                if(isset($_GET['apc'])===true && $_GET['apc']=='apcg')
                {
                    $member_list = MemberModel::getMemberListByAgentAgent($_SESSION['agent']['ID']);
                    $breadcrumb = $this->module_default_agentgroup_url;
                }
                else
                {
                    $member_list = MemberModel::getMemberListByReseller($_SESSION['agent']['ID']);
                    $breadcrumb = $this->module_default_agent_url;
                } 
                
                

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Transaction", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php', 'transaction_add' => $_SESSION['agent']['transaction_add'], 'transaction_edit' => $_SESSION['agent']['transaction_edit']),
                'agent' => $result2,
                'apc' => $_GET['apc'],  
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$breadcrumb,"",$this->config,"Edit Transaction"),
                'nonmainwallet' => $nonmainwalletproduct,
		'content' => $result,
                'back' => $_SESSION['agent']['redirect'],
                'promotion' => $promotion,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => $member_list, 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

                unset($_SESSION['agent']['redirect']);
		unset($_SESSION['agent']['transaction_add']);
		unset($_SESSION['agent']['transaction_edit']);

		return $this->output;
	}

	public function AgentEditProcess($param)
	{

            //if(isset($_SESSION['agent']['operator']['ProfileID'])===TRUE && empty($_SESSION['agent']['operator']['ProfileID'])===FALSE){
                $ModifierDetails = TransactionModel::getTransactionFull($param);

                if($ModifierDetails['OperatorID']=='0' || is_null($ModifierDetails['OperatorID'])===TRUE)
                {
                    $staff_id = $_SESSION['agent']['operator']['RowID'];
                     $modified_date = date("YmdHis");
                    $StaffIDUpdated = $_SESSION['agent']['operator']['RowID'];
                    $UpdatedDate = date("YmdHis");

                }
                else
                {
                    $staff_id = $ModifierDetails['OperatorID'];
                     $modified_date = $ModifierDetails['ModifiedDate'];
                     $StaffIDUpdated = $_SESSION['agent']['operator']['RowID'];
                     $UpdatedDate = date("YmdHis");

                }
       
            //}



            $sql = "UPDATE transaction SET TypeID='".$_POST['TypeID']."', MemberID='".$_POST['MemberID']."', Description='".$_POST['Description']."', Promotion='".$_POST['PromoSpecial']."', ProductID='".$_POST['ProductID']."', BankSlip='".$_POST['BankSlip']."', RejectedRemark='".$_POST['RejectedRemark']."', Date='".Helper::dateTimeDisplaySQL($_POST['Date'])."', TransferTo='".$_POST['TransferTo']."', TransferFrom='".$_POST['TransferFrom']."', Debit='".$_POST['Debit']."', Credit='".$_POST['Credit']."', Amount='".$_POST['Amount']."', DepositBonus='".$_POST['DepositBonus']."', Bonus='".$_POST['Bonus']."', Commission='".$_POST['Commission']."', ReferenceCode='".$_POST['ReferenceCode']."', Bank='".$_POST['Bank']."', Status='".$_POST['Status']."', OperatorID = '".$staff_id."', OperatorIDUpdated = '".$StaffIDUpdated."', ModifiedDate = '".$modified_date."', UpdatedDate = '".$UpdatedDate."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";



		$this->getTransactionCumulation($ModifierDetails['MemberID']);

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Transaction...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
                'apc' => $_POST['apc'],  
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

        public function AgentDelete($param)
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
                'pagination' => $_GET['pagination'],
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
         //$param = (int)$param;
         //$page = $param / 10;
         //$page = ceil($page);
        /*echo '1'.$_POST['RejectedRemarkSelect'].'<br />';
        echo '2'.$_POST['RejectedComment'].'<br />';
        echo '3'.$_POST['RejectedRemarkManual'];
        exit;*/
        if($_POST['RejectedRemarkSelect']!='Others' && isset($_POST['RejectedRemarkSelect'])===TRUE)
        {
            $_POST['RejectedRemark'] = $_POST['RejectedRemarkSelect'];
            $_POST['RejectedRemarkManual'] = '';
        }
        elseif($_POST['RejectedRemarkSelect']=='Others')
        {
            $_POST['RejectedRemark'] = $_POST['RejectedComment'];
        }

        if($_POST['RejectedRemarkManual']!='' && empty($_POST['RejectedRemarkManual'])===FALSE)
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
                'pagination' => ($_POST['pagination']=='')? 1: $_POST['pagination'],
		'meta' => array('active' => "on"));

		return $this->output;
	}

        public function AgentQuickEdit($param)
	{

		$sql = "SELECT * FROM transaction WHERE ID = '".$param."'";
                //echo $sql;
                //exit;
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
		'page' => array('title' => "Edit Transaction", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'off', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add'], 'transaction_edit' => $_SESSION['admin']['transaction_edit']),
                'content' => $result,
                'ID' => $param,
                'pagination' => $_GET['pagination'],
                'pagetype' => $_GET['page'],
		/*'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Transaction"),

                'promotion' => $promotion,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList()),*/
                'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'reject_message' => RejectMessageModel::getRejectMessageList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}

        public function AgentQuickEditProcess($param)
	{
         //$param = (int)$param;
         //$page = $param / 10;
         //$page = ceil($page);
        /*echo '1'.$_POST['RejectedRemarkSelect'].'<br />';
        echo '2'.$_POST['RejectedComment'].'<br />';
        echo '3'.$_POST['RejectedRemarkManual'];
        exit;*/
        if($_POST['RejectedRemarkSelect']!='Others' && isset($_POST['RejectedRemarkSelect'])===TRUE)
        {
            $_POST['RejectedRemark'] = $_POST['RejectedRemarkSelect'];
            $_POST['RejectedRemarkManual'] = '';
        }
        elseif($_POST['RejectedRemarkSelect']=='Others')
        {
            $_POST['RejectedRemark'] = $_POST['RejectedComment'];
        }

        if($_POST['RejectedRemarkManual']!='' && empty($_POST['RejectedRemarkManual'])===FALSE)
        {
            $_POST['RejectedRemark'] = $_POST['RejectedRemarkManual'];
        }

       $ModifierDetails = TransactionModel::getTransactionFull($param);
       /*Debug::displayArray($ModifierDetails);
       exit;*/

       if($ModifierDetails['OperatorID']=='0' || is_null($ModifierDetails['OperatorID'])===TRUE)
       {
           $staff_id = $_SESSION['agent']['operator']['RowID'];
            $modified_date = date("YmdHis");
           $StaffIDUpdated = $_SESSION['agent']['operator']['RowID'];
           $UpdatedDate = date("YmdHis");

       }
       else
       {
           $staff_id = $ModifierDetails['OperatorID'];
            $modified_date = $ModifierDetails['ModifiedDate'];
            $StaffIDUpdated = $_SESSION['agent']['operator']['RowID'];
            $UpdatedDate = date("YmdHis");

       }



            $sql = "UPDATE transaction SET RejectedRemark='".$_POST['RejectedRemark']."', Bonus='".$_POST['Bonus']."', Commission='".$_POST['Commission']."', OperatorID = '".$staff_id."', OperatorIDUpdated = '".$StaffIDUpdated."', ModifiedDate = '".$modified_date."', UpdatedDate = '".$UpdatedDate."', Status='".$_POST['Status']."' WHERE ID='".$param."'";
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
                 //echo 'hi';
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Transaction...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
                'pagetype' => $_POST['page'],
		'status' => array('ok' => $ok, 'error' => $error),
                'pagination' => ($_POST['pagination']=='')? 1: $_POST['pagination'],
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

	public function AdminAgent($param)
	{

            /*$promo[1] = BlockModel::getBlockContent(47);
            $promo[2] = BlockModel::getBlockContent(48);
            $promo[3] = BlockModel::getBlockContent(49);
            $promo[4] = BlockModel::getBlockContent(50);
            $promo[5] = BlockModel::getBlockContent(51);
            $promo[6] = BlockModel::getBlockContent(52);
            $promo[7] = BlockModel::getBlockContent(53);
            $promo[8] = BlockModel::getBlockContent(54);
            $promo[9] = BlockModel::getBlockContent(55);
            $promo[10] = BlockModel::getBlockContent(56);*/
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
			$query_condition .= $crud->queryCondition("t.MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("t.Description",$_POST['Description'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Promotion",$_POST['Promotion'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.BankSlip",$_POST['BankSlip'],"LIKE");
			$query_condition .= $crud->queryCondition("t.RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			/*$query_condition .= $crud->queryCondition("t.Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Credit",$_POST['Out'],"LIKE");*/
			$query_condition .= $crud->queryCondition("t.Status",$_POST['Status'],"=");

			$_SESSION['transaction_'.__FUNCTION__]['param']['t.TypeID'] = $_POST['TypeID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Description'] = $_POST['Description'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Promotion'] = $_POST['Promotion'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.BankSlip'] = $_POST['BankSlip'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.MemberID'] = $_POST['MemberID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateTo'] = $_POST['DateTo'];
			/*$_SESSION['transaction_'.__FUNCTION__]['param']['t.Debit'] = $_POST['Debit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Credit'] = $_POST['Credit'];*/
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

                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_GET['id']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_GET['id']);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_GET['id']);
                }


                $child = implode(',', $_SESSION['agentchild']);

                unset($_SESSION['agentchild']);

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." AND m.Agent = '".$param."'";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/transaction/agent/'.$param;
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
			 $sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.BankSlip AS t_BankSlip, t.Promotion AS t_Promotion, t.RejectedRemark AS t_RejectedRemark, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Bonus as t_Bonus, t.Commission as t_Commission, t.Status as t_Status, t.StaffID as t_StaffID, t.StaffIDUpdated as t_StaffIDUpdated, t.ModifiedDate as t_ModifiedDate, t.UpdatedDate as t_UpdatedDate, t.ProductID as t_ProductID FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." AND m.Agent = '".$param."' Order By t.Date DESC, t.ID DESC LIMIT $start, $limit";


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


                        //$IDarray = explode(",", $child);
                        //$IDarray['count'] = count($IDarray);


                        if(empty($_GET['id'])===false && isset($_GET['id'])===TRUE)
                        {

                             $data = array();
                             $data = AgentModel::getAgentGroupReport($child, $filename);



                             $report = array();
                             $report['In'] = $data['In'];
                             $report['Out'] = $data['Out'];
                             $report['Commission'] = $data['Commission'];
                             $report['Bonus'] = $data['Bonus'];
                             $report['Profit'] = $data['Profit'];
                             /*$report['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                             $report['Percentage'] = Helper::displayCurrency($Percentage);*/



                             unset($profit);
                             unset($In);
                             unset($Out);
                             unset($Commission);
                             unset($Bonus);
                             unset($Total);
                             unset($Percentage);

                        }



		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "View Report By Agent", 'template' => 'admin.transaction.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/agent.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.transaction_common.inc.php'),
        'membertotal' =>  $membertotal,
		'breadcrumb' => HTML::getBreadcrumb($this->reseller_module_name,$this->module_default_admin_url,"admin",$this->config,"View Report By Reseller"),
		'content' => $transaction,
                /*'promo' => $promo,
                'promotionspecial' => $promotionspecial,*/
		'report' => $report,
		'ID' => $param,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberListByReseller($param), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'agent_list' => AgentModel::getAgentList(), 'agentpromotion_list' => AgentPromotionModel::getEnabledAgentPromotionListByAgentID($_GET['id'])),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		//unset($_SESSION['admin']['transaction_delete']);
		/*Debug::displayArray($this->output);
		exit;*/

		return $this->output;
	}

        public function AgentAgent($param)
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
			$query_condition .= $crud->queryCondition("t.MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("t.Description",$_POST['Description'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Promotion",$_POST['Promotion'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.BankSlip",$_POST['BankSlip'],"LIKE");
			$query_condition .= $crud->queryCondition("t.RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			/*$query_condition .= $crud->queryCondition("t.Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Credit",$_POST['Out'],"LIKE");*/
			$query_condition .= $crud->queryCondition("t.Status",$_POST['Status'],"=");

			$_SESSION['transaction_'.__FUNCTION__]['param']['t.TypeID'] = $_POST['TypeID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Description'] = $_POST['Description'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Promotion'] = $_POST['Promotion'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.BankSlip'] = $_POST['BankSlip'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.MemberID'] = $_POST['MemberID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateTo'] = $_POST['DateTo'];
			/*$_SESSION['transaction_'.__FUNCTION__]['param']['t.Debit'] = $_POST['Debit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Credit'] = $_POST['Credit'];*/
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
                
                if(empty($_GET['id'])===TRUE || isset($_GET['id'])===FALSE)
                {
                    $_GET['id'] = $_SESSION['agent']['ID'];
                }
                

                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_GET['id']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_GET['id']);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_GET['id']);
                }


                $child = implode(',', $_SESSION['agentchild']);

                unset($_SESSION['agentchild']);

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." AND m.Agent IN (".$child.")";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/agent/transaction/agent/'.$_GET['id'];
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
			 $sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.BankSlip AS t_BankSlip, t.Promotion AS t_Promotion, t.RejectedRemark AS t_RejectedRemark, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Bonus as t_Bonus, t.Commission as t_Commission, t.Status as t_Status, t.StaffID as t_StaffID, t.StaffIDUpdated as t_StaffIDUpdated, t.ModifiedDate as t_ModifiedDate, t.UpdatedDate as t_UpdatedDate, t.ProductID as t_ProductID FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." AND m.Agent IN (".$child.") Order By t.Date DESC, t.ID DESC LIMIT $start, $limit";


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
                                'Agent' => AgentModel::getAgent(MemberModel::getMemberResellerID($row['t_MemberID']), "Name"),    
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


			//$report = array();
			//$report = AgentModel::getAgentReport($_GET['id'], $filename);

                        //$IDarray = explode(",", $child);
                        //$IDarray['count'] = count($IDarray);


                        if(empty($_GET['id'])===false && isset($_GET['id'])===TRUE)
                        {

                             $data = array();
                             $data = AgentModel::getAgentGroupReport($child, $filename);



                             $report = array();
                             $report['In'] = $data['In'];
                             $report['Out'] = $data['Out'];
                             $report['Commission'] = $data['Commission'];
                             $report['Bonus'] = $data['Bonus'];
                             $report['Profit'] = $data['Profit'];
                             /*$report['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                             $report['Percentage'] = Helper::displayCurrency($Percentage);*/



                             unset($profit);
                             unset($In);
                             unset($Out);
                             unset($Commission);
                             unset($Bonus);
                             unset($Total);
                             unset($Percentage);

                        }

                        /*if(isset($_POST['Agent'])===FALSE)
                        {

                             for ($c = 0; $c < $IDarray['count']; $c++) {
                                 $report[$c] = AgentModel::getAgentGroupReport($IDarray[$c], $filename);
                             }

                             $report['count'] = count($report);
                             for ($r = 0; $r < $report['count']; $r++) {

                                 $In += $report[$r]['In'];
                                 $Out += $report[$r]['Out'];
                                 $Commission += $report[$r]['Commission'];
                                 $Bonus += $report[$r]['Bonus'];
                                 $Profit += $report[$r]['Profit'];
                                 $Profitsharing += $report[$r]['Profitsharing'];
                                 $Percentage += $report[$r]['Percentage'];

                             }

                             unset($report);

                             $report = array();
                             $report['In'] = Helper::displayCurrency($In);
                             $report['Out'] = Helper::displayCurrency($Out);
                             $report['Commission'] = Helper::displayCurrency($Commission);
                             $report['Bonus'] = Helper::displayCurrency($Bonus);
                             $report['Profit'] = Helper::displayCurrency($Profit);
                             $report['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                             $report['Percentage'] = Helper::displayCurrency($Percentage);



                             unset($profit);
                             unset($In);
                             unset($Out);
                             unset($Commission);
                             unset($Bonus);
                             unset($Total);
                             unset($Percentage);


                        }*/


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



                    /*$option = '<option value="/agent/transaction/agent/'. $result2[0]['ID'].'?page=all"';

                    if ($result2[0]['ID']==$_GET['id']) {
                        $option.= 'selected="selected"';

                    }

                    $option.='>';

                    $option.= $result2[0]['Name'].' ('. $result2[0]['Company'].')</option>';*/




		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "View Report By Agent", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/index.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
                'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
                'membertotal' =>  $membertotal,
		'breadcrumb' => HTML::getBreadcrumb($this->agent_module_name,$this->module_default_agent_url,"",$this->config,"View Report By Agent"),
                'agent' =>  $result2,
		'content' => $transaction,
                'promo' => $promo,
                'promotionspecial' => $promotionspecial,
		'report' => $report,
		'ID' => $param,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberListByReseller($_SESSION['agent']['ID']), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'agentpromotion_list' => AgentPromotionModel::getEnabledAgentPromotionListByAgentID($_GET['id'])),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		//unset($_SESSION['admin']['transaction_delete']);
		/*Debug::displayArray($this->output);
		exit;*/

		return $this->output;
	}

        public function AgentAffiliatedReporting($param)
	{

            if(isset($_POST['Trigger'])===TRUE && $_POST['Trigger']=='search_form')
            {
                $_SESSION[__FUNCTION__]['DateFrom'] = $_POST['DateFrom'];
                $_SESSION[__FUNCTION__]['DateTo'] = $_POST['DateTo'];

            }

            if($_GET['page']=='all')
            {
                unset($_SESSION[__FUNCTION__]['DateFrom']);
                unset($_SESSION[__FUNCTION__]['DateTo']);
            }



            if(empty($param)===true)
            {
                $param = $_SESSION['agent']['ID'];
            }
            else
            {

            }


                $count = AgentModel::getAgentChildExist($param);
                $report = array();
                $result = array();
                $total = array();

                $profitSharing = AgentModel::getAgent($param, "Profitsharing");

                if($count>'0')
                {
                    $firstChildren = AgentModel::getAgentFirstChildren($param);




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

                    for ($i = 0; $i < $firstChildren['count']; $i++) {


                        $result[$i] = AgentModel::getAgentAffiliatedReporting($firstChildren[$i]['ID'], $profitSharing, __FUNCTION__);

                        $In += $result[$i]['First']['In'];
                        $Out += $result[$i]['First']['Out'];
                        $Bonus += $result[$i]['First']['Bonus'];
                        $winLose += $result[$i]['First']['winLose'];
                        $Profit += $result[$i]['First']['Profit'];

                        $SecIn += $result[$i]['Sec']['In'];
                        $SecBonus += $result[$i]['Sec']['Bonus'];
                        $SecProfit += $result[$i]['Sec']['Profit'];

                        $ThirdIn += $result[$i]['Third']['In'];
                        $ThirdBonus += $result[$i]['Third']['Bonus'];
                        $ThirdProfit += $result[$i]['Third']['Profit'];

                        $FourthIn += $result[$i]['Fourth']['In'];
                        $FourthBonus += $result[$i]['Fourth']['Bonus'];
                        $FourthProfit += $result[$i]['Fourth']['Profit'];
                         //Debug::displayArray($data[$i]);
                    }

                    $total['Total']['In'] = $In;
                    $total['Total']['Out'] = $Out;
                    $total['Total']['Bonus'] = $Bonus;
                    $total['Total']['winLose'] = $winLose;

                    $total['Total']['Profit'] = $Profit;

                    $total['Total']['SecIn'] = $SecIn;
                    $total['Total']['SecBonus'] = $SecBonus;
                    $total['Total']['SecProfit'] = $SecProfit;


                    $total['Total']['ThirdIn'] = $ThirdIn;
                    $total['Total']['ThirdBonus'] = $ThirdBonus;
                    $total['Total']['ThirdProfit'] = $ThirdProfit;
                    //$_SESSION['yourself'] = $ThirdProfit;


                    $total['Total']['FourthIn'] = $FourthIn;
                    $total['Total']['FourthBonus'] = $FourthBonus;
                    $total['Total']['FourthProfit'] = $FourthProfit;




                    $result['count'] = count($result);


                }

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


                $sql2 = "SELECT * FROM agent WHERE ID = '".$param."' AND Enabled = '1'";

                $currentAgent = array();
                foreach ($this->dbconnect->query($sql2) as $row2)
                {
                        $currentAgent[0] = array(
                        'ID' => $row2['ID'],
                        'Name' => $row2['Name'],
                        'Profitsharing' => $row2['Profitsharing']);
                }

                        //$currentAgent[0] = AgentModel::getAgentAffiliatedReporting($currentAgent[0]['ID'], $profitSharing);

                        $currentAgent[0] = AgentModel::getSelfAgentAffiliatedReporting($currentAgent[0]['ID'], $profitSharing, __FUNCTION__);
                        //exit;

                        $In += $currentAgent[0]['First']['In'];
                        $Out += $currentAgent[0]['First']['Out'];
                        $Bonus += $currentAgent[0]['First']['Bonus'];
                        $winLose += $currentAgent[0]['First']['winLose'];
                        $Profit += $currentAgent[0]['First']['Profit'];

                        $SecIn += $currentAgent[0]['Sec']['In'];
                        $SecBonus += $currentAgent[0]['Sec']['Bonus'];
                        $SecProfit += $currentAgent[0]['Sec']['Profit'];

                        $ThirdIn += $currentAgent[0]['Third']['In'];
                        $ThirdBonus += $currentAgent[0]['Third']['Bonus'];
                        $ThirdProfit += $currentAgent[0]['Third']['Profit'];

                        $FourthIn += $currentAgent[0]['Fourth']['In'];
                        $FourthBonus += $currentAgent[0]['Fourth']['Bonus'];
                        $FourthProfit += $currentAgent[0]['Fourth']['Profit'];


                        if(isset($total)===TRUE && empty($total)===FALSE)
                        {

                            $total['Total']['In'] += $In;
                            $total['Total']['Out'] += $Out;
                            $total['Total']['Bonus'] += $Bonus;
                            $total['Total']['winLose'] += $winLose;
                            $total['Total']['Profit'] += $Profit;

                            $total['Total']['SecIn'] += $SecIn;
                            $total['Total']['SecBonus'] += $SecBonus;
                            $total['Total']['SecProfit'] += $SecProfit;


                            $total['Total']['ThirdIn'] += $ThirdIn;
                            $total['Total']['ThirdBonus'] += $ThirdBonus;
                            $total['Total']['ThirdProfit'] += $ThirdProfit;


                            $total['Total']['FourthIn'] += $FourthIn;
                            $total['Total']['FourthBonus'] += $FourthBonus;
                            $total['Total']['FourthProfit'] += $FourthProfit;

                        }

                       $currentAgent['count'] = count($currentAgent);






                $parentID = AgentModel::getAgent($param, "ParentID");

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "View Affiliate Report", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/affiliatedreporting.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
                'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
                'membertotal' =>  $membertotal,
		'breadcrumb' => HTML::getBreadcrumb($this->affiliate_report,$this->module_default_agentaffiliatedreporting_url,"",$this->config,"View Affiliate Report"),
		'content' => $result,
                'param' => $param,
                'parentID' => $parentID,
                'currentAgent' => $currentAgent,
                'profitSharing' => $profitSharing,
                'profitSharingDiff' => 100 - $profitSharing,
                'total' => $total,
		'content_param' => array('count' => $count, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


		return $this->output;
	}

        public function AdminAffiliatedReporting($param)
	{

            if(isset($_POST['Trigger'])===TRUE && $_POST['Trigger']=='search_form')
            {
                $_SESSION[__FUNCTION__]['DateFrom'] = $_POST['DateFrom'];
                $_SESSION[__FUNCTION__]['DateTo'] = $_POST['DateTo'];

            }

            if($_GET['page']=='all')
            {
                unset($_SESSION[__FUNCTION__]['DateFrom']);
                unset($_SESSION[__FUNCTION__]['DateTo']);
            }



            if(empty($param)===TRUE)
            {

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


                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ParentID = '0'";

                $currentAgent = array();
                $total = array();
                $i = 0;
                foreach ($this->dbconnect->query($sql2) as $row2)
                {
                        $currentAgent[$i] = array(
                        'ID' => $row2['ID'],
                        'Name' => $row2['Name'],
                        'Profitsharing' => $row2['Profitsharing']);

                        $i+=1;
                }



                for ($z = 0; $z < count($currentAgent); $z++) {

                        $profitSharing = AgentModel::getAgent($currentAgent[$z]['ID'], "Profitsharing");

                        $currentAgent[$z] = AgentModel::getTopSelfAgentAffiliatedReporting($currentAgent[$z]['ID'], $profitSharing, __FUNCTION__);

                        $In += $currentAgent[$z]['First']['In'];
                        $Out += $currentAgent[$z]['First']['Out'];
                        $Bonus += $currentAgent[$z]['First']['Bonus'];
                        $winLose += $currentAgent[$z]['First']['winLose'];
                        $Profit += $currentAgent[$z]['First']['Profit'];

                        $SecIn += $currentAgent[$z]['Sec']['In'];
                        $SecBonus += $currentAgent[$z]['Sec']['Bonus'];
                        $SecProfit += $currentAgent[$z]['Sec']['Profit'];

                        $ThirdIn += $currentAgent[$z]['Third']['In'];
                        $ThirdBonus += $currentAgent[$z]['Third']['Bonus'];
                        $ThirdProfit += $currentAgent[$z]['Third']['Profit'];

                        $FourthIn += $currentAgent[$z]['Fourth']['In'];
                        $FourthBonus += $currentAgent[$z]['Fourth']['Bonus'];
                        $FourthProfit += $currentAgent[$z]['Fourth']['Profit'];


                }

                    $total['Total']['In'] = $In;
                    $total['Total']['Out'] = $Out;
                    $total['Total']['Bonus'] = $Bonus;
                    $total['Total']['winLose'] = $winLose;
                    $total['Total']['Profit'] = $Profit;

                    $total['Total']['SecIn'] = $SecIn;
                    $total['Total']['SecBonus'] = $SecBonus;
                    $total['Total']['SecProfit'] = $SecProfit;


                    $total['Total']['ThirdIn'] = $ThirdIn;
                    $total['Total']['ThirdBonus'] = $ThirdBonus;
                    $total['Total']['ThirdProfit'] = $ThirdProfit;


                    $total['Total']['FourthIn'] = $FourthIn;
                    $total['Total']['FourthBonus'] = $FourthBonus;
                    $total['Total']['FourthProfit'] = $FourthProfit;



                    $currentAgent['count'] = count($currentAgent);




            }

            if(empty($param)===FALSE)
            {
                //$decision = TRUE;

                $count = AgentModel::getAgentChildExist($param);
                $report = array();
                $result = array();
                $total = array();

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

                $profitSharing = AgentModel::getAgent($param, "Profitsharing");
                if($count>'0')
                {

                    $firstChildren = AgentModel::getAgentFirstChildren($param);






                    for ($i = 0; $i < $firstChildren['count']; $i++) {


                        $result[$i] = AgentModel::getAgentAffiliatedReporting($firstChildren[$i]['ID'], $profitSharing, __FUNCTION__);

                        $In += $result[$i]['First']['In'];
                        $Out += $result[$i]['First']['Out'];
                        $Bonus += $result[$i]['First']['Bonus'];
                        $winLose += $result[$i]['First']['winLose'];
                        $Profit += $result[$i]['First']['Profit'];

                        $SecIn += $result[$i]['Sec']['In'];
                        $SecBonus += $result[$i]['Sec']['Bonus'];
                        $SecProfit += $result[$i]['Sec']['Profit'];

                        $ThirdIn += $result[$i]['Third']['In'];
                        $ThirdBonus += $result[$i]['Third']['Bonus'];
                        $ThirdProfit += $result[$i]['Third']['Profit'];

                        $FourthIn += $result[$i]['Fourth']['In'];
                        $FourthBonus += $result[$i]['Fourth']['Bonus'];
                        $FourthProfit += $result[$i]['Fourth']['Profit'];
                         //Debug::displayArray($data[$i]);
                    }





                    /*$total['Total']['In'] = $In;
                    $total['Total']['Out'] = $Out;
                    $total['Total']['Bonus'] = $Bonus;
                    $total['Total']['winLose'] = $winLose;
                    $total['Total']['Profit'] = $Profit;

                    $total['Total']['SecIn'] = $SecIn;
                    $total['Total']['SecBonus'] = $SecBonus;
                    $total['Total']['SecProfit'] = $SecProfit;


                    $total['Total']['ThirdIn'] = $ThirdIn;
                    $total['Total']['ThirdBonus'] = $ThirdBonus;
                    $total['Total']['ThirdProfit'] = $ThirdProfit;


                    $total['Total']['FourthIn'] = $FourthIn;
                    $total['Total']['FourthBonus'] = $FourthBonus;
                    $total['Total']['FourthProfit'] = $FourthProfit;*/




                    $result['count'] = count($result);
                }





                $sql2 = "SELECT * FROM agent WHERE ID = '".$param."' AND Enabled = '1'";

                $currentAgent = array();
                foreach ($this->dbconnect->query($sql2) as $row2)
                {
                        $currentAgent[0] = array(
                        'ID' => $row2['ID'],
                        'Name' => $row2['Name'],
                        'Profitsharing' => $row2['Profitsharing']);
                }

                        $currentAgent[0] = AgentModel::getSelfAgentAffiliatedReporting($currentAgent[0]['ID'], $profitSharing, __FUNCTION__);

                        $In += $currentAgent[0]['First']['In'];
                        $Out += $currentAgent[0]['First']['Out'];
                        $Bonus += $currentAgent[0]['First']['Bonus'];
                        $winLose += $currentAgent[0]['First']['winLose'];
                        $Profit += $currentAgent[0]['First']['Profit'];

                        $SecIn += $currentAgent[0]['Sec']['In'];
                        $SecBonus += $currentAgent[0]['Sec']['Bonus'];
                        $SecProfit += $currentAgent[0]['Sec']['Profit'];

                        $ThirdIn += $currentAgent[0]['Third']['In'];
                        $ThirdBonus += $currentAgent[0]['Third']['Bonus'];
                        $ThirdProfit += $currentAgent[0]['Third']['Profit'];

                        $FourthIn += $currentAgent[0]['Fourth']['In'];
                        $FourthBonus += $currentAgent[0]['Fourth']['Bonus'];
                        $FourthProfit += $currentAgent[0]['Fourth']['Profit'];


                        //if(isset($total)===TRUE && empty($total)===FALSE)
                        //{

                            $total['Total']['In'] = $In;
                            $total['Total']['Out'] = $Out;
                            $total['Total']['Bonus'] = $Bonus;
                            $total['Total']['winLose'] = $winLose;
                            $total['Total']['Profit'] = $Profit;

                            $total['Total']['SecIn'] = $SecIn;
                            $total['Total']['SecBonus'] = $SecBonus;
                            $total['Total']['SecProfit'] = $SecProfit;


                            $total['Total']['ThirdIn'] = $ThirdIn;
                            $total['Total']['ThirdBonus'] = $ThirdBonus;
                            $total['Total']['ThirdProfit'] = $ThirdProfit;


                            $total['Total']['FourthIn'] = $FourthIn;
                            $total['Total']['FourthBonus'] = $FourthBonus;
                            $total['Total']['FourthProfit'] = $FourthProfit;

                        //}

                       $currentAgent['count'] = count($currentAgent);



            }






                //$url = $this->config['SITE_DIR'].'/admin/transaction/affiliatedreporting/'.$param;



                //echo $parameter;
                //exit;








                $parentID = AgentModel::getAgent($param, "ParentID");
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "View Affiliate Report", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/affiliatedreporting.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
                'block' => array('side_nav' => $this->agent_module_dir.'inc/admin/side_nav.agent.inc.php', 'common' => "false"),
                'membertotal' =>  $membertotal,
		'breadcrumb' => HTML::getBreadcrumb($this->affiliate_report,$this->module_default_adminaffiliatedreporting_url,"admin",$this->config,"View Affiliate Report"),
		'content' => $result,
                //'DateFrom' => $_POST['DateFrom'],
                //'DateTo' => $_POST['DateTo'],
                //'url' => $url,
                'param' => $param,
                'total' => $total,
                'parentID' => $parentID,
                'currentAgent' => $currentAgent,
                'profitSharing' => $profitSharing,
                'profitSharingDiff' => 100 - $profitSharing,
                'decision' => empty($param),
		'content_param' => array('count' => $count, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


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
			$query_title = Helper::translate("All Results", "member-history-search-title");
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
                        'TimeLeft' =>  $this->timeLeft(strtotime($row['Date']), $this->config['TIME_ELAPSE']),
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
		'page' => array('title' => Helper::translate("My Transactions", "member-history-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/index.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/member/index.bottom.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
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
                        $type = TransactionTypeModel::getTransactionType($row['TypeID']);
                        $currentStatus = TransactionStatusModel::getTransactionStatus($row['Status']);

                        //echo '<pre>';
                        //var_dump($row['Amount']);
                        /*var_dump($type);
                        var_dump($currentStatus);
                        var_dump($row['Amount']);
                        var_dump($row['TransferFrom']);*/
                        //echo '</pre>';
                        //Debug::displayArray($row['Debit']);
                        //Debug::displayArray($row['Credit']);

                        //exit;
                        $reseller = MemberModel::getMemberResellerID($row['MemberID']);
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'MemberID' => MemberModel::getMemberName($row['MemberID']),
                        'RawMemberID' => $row['MemberID'],
                        'MemberUsername' => MemberModel::getMemberUsername($row['MemberID']),
                        'Reseller' => MemberModel::getMemberReseller($row['MemberID']),
                        'Colour' => AgentModel::getAgent($reseller),
			'Description' => $row['Description'],
                        'Promotion' => $row['Promotion'],
                        'BankSlip' => $row['BankSlip'],
                        'GameUsername' => WalletModel::getWalletUsername($row['MemberID'], $row['ProductID']),
                        'MainWallet' =>  Helper::displayCurrency(WalletModel::getMemberWalletTotal($row['MemberID'])),
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => date("d-m-Y | h.i.s a", strtotime(Helper::dateTimeSQLToDisplay($row['Date']))),
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
                        'Balance' => Helper::displayCurrency($this->getProgress($row['ID'], $row['Debit'], $row['Credit'], $row['MemberID'], $currentStatus, $type, $row['Amount'], $row['TransferFrom'])),
			'Bank' => $row['Bank'],
			'StaffID' => ($row['StaffID']=='0')?'0':StaffModel::getStaffDetails($row['StaffID']),
                        'StaffIDUpdated' => StaffModel::getStaffDetails($row['StaffIDUpdated']),
			'ModifiedDate' => $ModifiedDate,
                        'UpdatedDate' =>  $UpdatedDate,
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;
		}

                //Debug::displayArray($result);
                //exit;





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

        public function AgentHistory($param)
	{


		$sql = "SELECT * FROM transaction WHERE MemberID = '".$param."' ORDER BY `Date` DESC, `ID` DESC LIMIT 0, 10";
                //echo $sql;
                //exit;
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
                        $type = TransactionTypeModel::getTransactionType($row['TypeID']);
                        $currentStatus = TransactionStatusModel::getTransactionStatus($row['Status']);

                        //echo '<pre>';
                        //var_dump($row['Amount']);
                        /*var_dump($type);
                        var_dump($currentStatus);
                        var_dump($row['Amount']);
                        var_dump($row['TransferFrom']);*/
                        //echo '</pre>';
                        //Debug::displayArray($row['Debit']);
                        //Debug::displayArray($row['Credit']);

                        //exit;
                        $reseller = MemberModel::getMemberResellerID($row['MemberID']);
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
			'MemberID' => MemberModel::getMemberName($row['MemberID']),
                        'RawMemberID' => $row['MemberID'],
                        'MemberUsername' => MemberModel::getMemberUsername($row['MemberID']),
                        'Reseller' => MemberModel::getMemberReseller($row['MemberID']),
                        'Colour' => AgentModel::getAgent($reseller),
			'Description' => $row['Description'],
                        'Promotion' => $row['Promotion'],
                        'BankSlip' => $row['BankSlip'],
                        'GameUsername' => WalletModel::getWalletUsername($row['MemberID'], $row['ProductID']),
                        'MainWallet' =>  Helper::displayCurrency(WalletModel::getMemberWalletTotal($row['MemberID'])),
			'RejectedRemark' => $row['RejectedRemark'],
			'Date' => date("d-m-Y | h.i.s a", strtotime(Helper::dateTimeSQLToDisplay($row['Date']))),
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
                        'Balance' => Helper::displayCurrency($this->getProgress($row['ID'], $row['Debit'], $row['Credit'], $row['MemberID'], $currentStatus, $type, $row['Amount'], $row['TransferFrom'])),
			'Bank' => $row['Bank'],
			'StaffID' => ($row['StaffID']=='0')?'0':StaffModel::getStaffDetails($row['StaffID']),
                        'StaffIDUpdated' => StaffModel::getStaffDetails($row['StaffIDUpdated']),
			'ModifiedDate' => $ModifiedDate,
                        'UpdatedDate' =>  $UpdatedDate,
			'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

			$i += 1;
		}

                //Debug::displayArray($result);
                //exit;





		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "My Transactions", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'off', 'custom_inc_loc' => $this->module_dir.'inc/member/index.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
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


	public function AgentIndex($param)

	{
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form' )
		{

			// Reset Query Variable
			$_SESSION['transaction_'.__FUNCTION__] = "";
                        
                        if($_POST['Member']=='')
                        {
                            $_POST['MemberID'] = '';
                        }

			/*$query_condition .= $crud->queryCondition("t.TypeID",$_POST['TypeID'],"=",1);
			$query_condition .= $crud->queryCondition("t.MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("t.Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("t.RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			
			$query_condition .= $crud->queryCondition("t.Status",$_POST['Status'],"=");

			$_SESSION['transaction_'.__FUNCTION__]['param']['t.TypeID'] = $_POST['TypeID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Description'] = $_POST['Description'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.MemberID'] = $_POST['MemberID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateTo'] = $_POST['DateTo'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Debit'] = $_POST['Debit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Credit'] = $_POST['Credit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Status'] = $_POST['Status'];*/
                        
                        //if(empty($_POST['MemberID'])===TRUE){
                                
                        //}
                        //echo $_POST['MemberID'];
                             //exit;
                                                
                        
                        $query_condition .= $crud->queryCondition("t.TypeID",$_POST['TypeID'],"=", 1);
                        
                            $query_condition .= $crud->queryCondition("t.MemberID",$_POST['MemberID'],"=");
                        
			$query_condition .= $crud->queryCondition("t.Description",$_POST['Description'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Promotion",$_POST['Promotion'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.BankSlip",$_POST['BankSlip'],"LIKE");
			$query_condition .= $crud->queryCondition("t.RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
                        $query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("t.Debit",$_POST['Debit'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Credit",$_POST['Credit'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Status",$_POST['Status'],"=");
                        $query_condition .= $crud->queryCondition("t.DepositBonus",$_POST['DepositBonus'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.DepositChannel",$_POST['DepositChannel'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.ReferenceCode",$_POST['ReferenceCode'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Bank",$_POST['Bank'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.TransferFrom",$_POST['TransferFrom'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.TransferTo",$_POST['TransferTo'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Amount",$_POST['Amount'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Bonus",$_POST['Bonus'],">=");
                        $query_condition .= $crud->queryCondition("t.Commission",$_POST['Commission'],">=");



			$_SESSION['transaction_'.__FUNCTION__]['param']['t.TypeID'] = $_POST['TypeID'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.MemberID'] = $_POST['MemberID'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['Member'] = $_POST['Member'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Description'] = $_POST['Description'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Promotion'] = $_POST['Promotion'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.BankSlip'] = $_POST['BankSlip'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateTo'] = $_POST['DateTo'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Debit'] = $_POST['Debit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Credit'] = $_POST['Credit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Status'] = $_POST['Status'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.DepositBonus'] = $_POST['DepositBonus'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.DepositChannel'] = $_POST['DepositChannel'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.ReferenceCode'] = $_POST['ReferenceCode'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Bank'] = $_POST['Bank'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.TransferFrom'] = $_POST['TransferFrom'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.TransferTo'] = $_POST['TransferTo'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Amount'] = $_POST['Amount'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Bonus'] = $_POST['Bonus'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Commission'] = $_POST['Commission'];
                                                                      

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
		$query_count = "SELECT COUNT(*) FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Agent = '".$_SESSION['agent']['ID']."' ".$_SESSION['transaction_'.__FUNCTION__]['query_condition'];
		#echo $query_count;
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/agent/transaction/index';
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);//AND m.Agent = '".$_SESSION['agent']['ID']."'

		 $sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.ProductID AS t_ProductID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.RejectedRemark AS t_RejectedRemark, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.BankSlip as t_BankSlip, t.ReferenceCode as t_ReferenceCode, t.Bonus as t_Bonus, t.Commission as t_Commission, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.StaffID as t_StaffID, t.OperatorID as t_OperatorID, t.OperatorIDUpdated as t_OperatorIDUpdated, t.StaffIDUpdated as t_StaffIDUpdated, t.ModifiedDate as t_ModifiedDate, t.UpdatedDate as t_UpdatedDate, t.Status as t_Status FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Agent = '".$_SESSION['agent']['ID']."' ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." ORDER BY t.Date DESC, t.ID DESC LIMIT $start, $limit";
                 


			//echo $sql;
			//exit;
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
				#'Report' => ResellerModel::getResellerReport($_SESSION['reseller']['ID'], $filename),                       
                                'Agent' => MemberModel::getMemberResellerCompany($row['t_MemberID']),
                                'AgentTypeID' => MemberModel::getMemberResellerCompanyType($row['t_MemberID']),
                                'MainWallet' =>  Helper::displayCurrency(WalletModel::getMemberWalletTotal($row['t_MemberID'])),
				'MemberID' => MemberModel::getMemberName($row['t_MemberID']),
                                'RawMemberID' => $row['t_MemberID'],
                                'GameUsername' => WalletModel::getWalletUsername($row['t_MemberID'], $row['t_ProductID']),
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
                                'BankSlip' => $row['t_BankSlip'],
                                'Bank' => $row['t_Bank'],
				'In' => Helper::displayCurrency($row['t_Debit']),
				'Out' => Helper::displayCurrency($row['t_Credit']),
				'Amount' => Helper::displayCurrency($row['t_Amount']),
                                'OperatorID' => ($row['t_OperatorID']=='0')?'0': OperatorModel::getOperator($row['t_OperatorID']),
                                'OperatorIDUpdated' => OperatorModel::getOperator($row['t_OperatorIDUpdated']),
                                'ModifiedDate' => $ModifiedDate,
                                'UpdatedDate' =>  $UpdatedDate,    
				'Status' => TransactionStatusModel::getTransactionStatus($row['t_Status']));

				$i += 1;


			}

			$transaction['count'] = $i;



			$report = array();
			$report = AgentModel::getAgentReport($_SESSION['agent']['ID'], $filename);

		$param = $_SESSION['agent']['ID'];
		AgentModel::getAgentCredit($_SESSION['agent']['ID']);

                $_SESSION['agent']['redirect'] = __FUNCTION__;

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent's Member Transactions", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/index.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
        'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
        'membertotal' =>  $membertotal,
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Agent's Member Transactions"),
		'content' => $transaction,
		'report'=>$report,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberListByReseller($param), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList(), 'agentpromotion_list' => AgentPromotionModel::getEnabledAgentPromotionList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		/*Debug::displayArray($this->output);
		exit;*/

		return $this->output;
	}

        public function AgentGroup($param)
	{
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			//if ($_POST['Trigger']=='search_form'){
			// Reset Query Variable
			$_SESSION['transaction_'.__FUNCTION__] = "";
                        
                        if($_POST['Member']=='')
                        {
                            $_POST['MemberID'] = '';
                        }
                                              
                        
                        $query_condition .= $crud->queryCondition("t.TypeID",$_POST['TypeID'],"=", 1);
                        $query_condition .= $crud->queryCondition("m.Agent",$_POST['Agent'],"=");
                        
                            $query_condition .= $crud->queryCondition("t.MemberID",$_POST['MemberID'],"=");
                        
			$query_condition .= $crud->queryCondition("t.Description",$_POST['Description'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Promotion",$_POST['Promotion'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.BankSlip",$_POST['BankSlip'],"LIKE");
			$query_condition .= $crud->queryCondition("t.RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
                        $query_condition .= $crud->queryCondition("t.Date",Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("t.Debit",$_POST['Debit'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Credit",$_POST['Credit'],"LIKE");
			$query_condition .= $crud->queryCondition("t.Status",$_POST['Status'],"=");
                        $query_condition .= $crud->queryCondition("t.DepositBonus",$_POST['DepositBonus'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.DepositChannel",$_POST['DepositChannel'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.ReferenceCode",$_POST['ReferenceCode'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Bank",$_POST['Bank'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.TransferFrom",$_POST['TransferFrom'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.TransferTo",$_POST['TransferTo'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Amount",$_POST['Amount'],"LIKE");
                        $query_condition .= $crud->queryCondition("t.Bonus",$_POST['Bonus'],">=");
                        $query_condition .= $crud->queryCondition("t.Commission",$_POST['Commission'],">=");



			$_SESSION['transaction_'.__FUNCTION__]['param']['t.TypeID'] = $_POST['TypeID'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['m.Agent'] = $_POST['Agent'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.MemberID'] = $_POST['MemberID'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['Member'] = $_POST['Member'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Description'] = $_POST['Description'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Promotion'] = $_POST['Promotion'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.BankSlip'] = $_POST['BankSlip'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateFrom'] = $_POST['DateFrom'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.DateTo'] = $_POST['DateTo'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Debit'] = $_POST['Debit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Credit'] = $_POST['Credit'];
			$_SESSION['transaction_'.__FUNCTION__]['param']['t.Status'] = $_POST['Status'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.DepositBonus'] = $_POST['DepositBonus'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.DepositChannel'] = $_POST['DepositChannel'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.ReferenceCode'] = $_POST['ReferenceCode'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Bank'] = $_POST['Bank'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.TransferFrom'] = $_POST['TransferFrom'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.TransferTo'] = $_POST['TransferTo'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Amount'] = $_POST['Amount'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Bonus'] = $_POST['Bonus'];
                        $_SESSION['transaction_'.__FUNCTION__]['param']['t.Commission'] = $_POST['Commission'];


			// Set Query Variable
			$_SESSION['transaction_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['transaction_'.__FUNCTION__]['query_title'] = "Search Results";
                }
		//}
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


                    if(isset($_SESSION['transaction_'.__FUNCTION__]['param']['m.Agent'])===true && empty($_SESSION['transaction_'.__FUNCTION__]['param']['m.Agent'])===false)
                    {
                        $query_part = "";
                    }
                    else
                    {
                        $query_part = "AND m.Agent IN (".$child.")";
                    }

                    //echo 'hi';
                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$query_part." ".$_SESSION['transaction_'.__FUNCTION__]['query_condition'];
                    //echo $query_count;
                    //echo $query_count;
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                    $targetpage = $data['config']['SITE_DIR'].'/agent/transaction/group';
                    $limit = 10;
                    $stages = 3;
                    $page = mysql_escape_string($_GET['page']);
                    if ($page) {
                            $start = ($page - 1) * $limit;
                    } else {
                            $start = 0;
                    }

                    //echo 'hi';
                    // Initialize Pagination
                    $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);




                     $sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.ProductID AS t_ProductID, t.BankSlip AS t_BankSlip, t.MemberID AS t_MemberID, t.Description AS t_Description, t.RejectedRemark AS t_RejectedRemark, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bonus as t_Bonus, t.Commission as t_Commission, t.Bank as t_Bank, t.Debit as t_Debit, t.StaffID as t_StaffID, t.StaffIDUpdated as t_StaffIDUpdated, t.OperatorID as t_OperatorID, t.OperatorIDUpdated as t_OperatorIDUpdated, t.ModifiedDate as t_ModifiedDate, t.UpdatedDate as t_UpdatedDate, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status, m.Agent AS m_Agent FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$query_part." ".$_SESSION['transaction_'.__FUNCTION__]['query_condition']." ORDER BY t.Date DESC, t.ID DESC LIMIT $start, $limit";




			//echo $sql;
			//exit;
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
                                'GameUsername' => WalletModel::getWalletUsername($row['t_MemberID'], $row['t_ProductID']),  
                                'Sub' => AgentModel::getAgentParentdExist(MemberModel::getMemberResellerID($row['t_MemberID'])),    
                                'Agent' => $row['m_Agent'],
                                'AgentTypeID' => MemberModel::getMemberResellerCompanyType($row['t_MemberID']),
                                'AgentDetails' => MemberModel::getMemberResellerCompany($row['t_MemberID']),
                                'MainWallet' =>  Helper::displayCurrency(WalletModel::getMemberWalletTotal($row['t_MemberID'])),   
				'TypeID' => TransactionTypeModel::getTransactionType($row['t_TypeID']),
				#'Report' => ResellerModel::getResellerReport($_SESSION['reseller']['ID'], $filename),
				'MemberID' => MemberModel::getMemberName($row['t_MemberID']),
                                'RawMemberID' => $row['t_MemberID'],
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
                                'BankSlip' => $row['t_BankSlip'],    
				'In' => Helper::displayCurrency($row['t_Debit']),
				'Out' => Helper::displayCurrency($row['t_Credit']),
				'Amount' => Helper::displayCurrency($row['t_Amount']),
                                'OperatorID' => ($row['t_OperatorID']=='0')?'0': OperatorModel::getOperator($row['t_OperatorID']),
                                'OperatorIDUpdated' => OperatorModel::getOperator($row['t_OperatorIDUpdated']),
                                'ModifiedDate' => $ModifiedDate,
                                'UpdatedDate' =>  $UpdatedDate,     
				'Status' => TransactionStatusModel::getTransactionStatus($row['t_Status']));

				$i += 1;


			}

			$transaction['count'] = $i;

			//}


                        /*$IDarray = explode(",", $child);
                        $IDarray['count'] = count($IDarray);*/
                        //echo

                        /*$report = array();
                             for ($c = 0; $c < $IDarray['count']; $c++) {
                                 $report[$c] = AgentModel::getAgentGroupReport($IDarray[$c], $filename);
                             }
                            //Debug::displayArray($report);
                             $report['count'] = count($report);
                             $In = 0;
                             $Out = 0;
                             $Commission = 0;
                             $Bonus = 0;
                             $Profit = 0;
                             $Profitsharing = 0;
                             $Percentage = 0;
                             for ($r = 0; $r < $report['count']; $r++) {

                                 $In += $report[$r]['In'];
                                 $Out += $report[$r]['Out'];
                                 $Commission += $report[$r]['Commission'];
                                 $Bonus += $report[$r]['Bonus'];
                                 $Profit += $report[$r]['Profit'];
                                 $Profitsharing += $report[$r]['Profitsharing'];
                                 $Percentage += $report[$r]['Percentage'];

                             }

                             unset($report);*/
                             $data = array();
                             $data = AgentModel::getAgentGroupReport($child, $filename);

                             $report = array();
                             $report['In'] = $data['In'];
                             $report['Out'] = $data['Out'];
                             $report['Commission'] = $data['Commission'];
                             $report['Bonus'] = $data['Bonus'];
                             $report['Profit'] = $data['Profit'];
                             $report['Profitsharing'] = $data['Profitsharing'];
                             $report['Percentage'] = $data['Percentage'];



                             /*unset($profit);
                             unset($In);
                             unset($Out);
                             unset($Commission);
                             unset($Bonus);
                             unset($Total);
                             unset($Percentage);*/

                             //Debug::displayArray($report);


                        $param = $_SESSION['agent']['ID'];
                        AgentModel::getAgentCredit($_SESSION['agent']['ID']);

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

                $_SESSION['agent']['redirect'] = __FUNCTION__;
                
                   
                
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent's Group Member Transactions", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/group.inc.php'), //'transaction_delete' => $_SESSION['admin']['transaction_delete']),
        'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
        'membertotal' =>  $membertotal,
                'agent' => $result2,    
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentgroup_url,"",$this->config,"Agent's Group Member Transactions"),
		'content' => $transaction,
		'report'=>$report,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberListByAgentAgent($param), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'agent_list' => AgentModel::getAgentListByParent($_SESSION['agent']['ID']), 'bank_list' => BankModel::getBankList(), 'agentpromotion_list' => AgentPromotionModel::getEnabledAgentPromotionList()),
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

        $count = $this->getTransactionByMemberID($_SESSION['member']['ID']);

        if($count > '0')
        {
            $result[6] = BlockModel::getBlockContent(53);
            $result[7] = BlockModel::getBlockContent(54);
            $result[8] = BlockModel::getBlockContent(55);
            $result[9] = BlockModel::getBlockContent(56);
        }
        else
        {
            $result[6] = BlockModel::getBlockContent(52);
            $result[7] = BlockModel::getBlockContent(53);
            $result[8] = BlockModel::getBlockContent(54);
            $result[9] = BlockModel::getBlockContent(55);
            $result[10] = BlockModel::getBlockContent(56);
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

                $nonmainwalletproduct = ProductModel::getNonMainWalletProduct();



		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => Helper::translate("Deposit", "member-deposit-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/deposit.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/member/deposit.bottom.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("Deposit", "member-deposit-title")),
		'content' => $result,
                'agentblock' => AgentBlockModel::getAgentBlockByAgent($_SESSION['reseller_code'], "deposit"),
                'form_token' => $form_token,
                'nonmainwallet' => $nonmainwalletproduct,
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'transactiontype_list' => TransactionTypeModel::getTransactionTypeList(), 'transactionstatus_list' => TransactionStatusModel::getTransactionStatusList(), 'bank_slip' => BankinSlipModel::getPublicBankinSlipList(), 'bank_info' => BankInfoModel::getAgentBankInfoList($_SESSION['member']['ID']), 'promotion_list' => AgentPromotionModel::getAgentPromotionListByAgent($_SESSION['reseller_code'], $_SESSION['member']['ID'])),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

                //Debug::displayArray($this->output);
                //exit;

		unset($_SESSION['admin']['transaction_add']);

		return $this->output;
	}

	public function MemberDepositProcess()
	{



             //Debug::displayArray($_POST);
             //exit;
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
        $agent = AgentModel::getAgent($member[0]['Agent']);
        $agent_email = $agent['Email'];

		$message_deposit = "<br /><br />Agent:\t".$agent['Name']."<br />";
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
        $agent = AgentModel::getAgent($member[0]['Agent']);
        $agent_email = $agent['Email'];

        //Debug::displayArray($agent);
        if($agent['ParentID']!='0')
        {

            AgentModel::getloopAgentParent($agent['ParentID']);

        }




        $message_transfer = "<br /><br />Agent:\t".$agent['Name']."<br />";
        $message_transfer .= "Date Posted:\t".$date_posted_display."<br />";
        $message_transfer .= "Transfer From:\t".ProductModel::IDToProductName('30')."<br />";
        $message_transfer .= "Transfer To:\t".ProductModel::IDToProductName($_POST['TransferTo'])."<br />";
        $message_transfer .= "Transfer Amount (MYR):\t".$_POST['TransferAmount']."<br />";

		// Set Status
        $ok_transfer = ($count_transfer==1) ? 1 : "";

        }

            }
            /*}*/

                $agent_type = AgentModel::getAgent($_SESSION['reseller_code'], "TypeID");

                if($agent_type == '2')
                {

                    $agentParent = AgentModel::getAgent($_SESSION['platform_agent']);
                    unset($_SESSION['platform_agent']);
                }

                

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Deposit...", 'template' => 'common.tpl.php'),
		'content_param_deposit' => array('count_deposit' => $count_deposit, 'newID_deposit' => $newID_deposit, 'agent_email' => $agent_email),
                'content_param_transfer' =>  array('count_transfer' => $count_transfer, 'newID_transfer' => $newID_transfer, 'agent_email' => $agent_email),
		'message_deposit' => $message_deposit,
                'agent_type' => AgentModel::getAgent($_SESSION['reseller_code'], "TypeID"),
                'agent' => AgentModel::getAgent($_SESSION['reseller_code']),
                'agent_parent' => $agentParent,
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
		#$result = WalletModel::getWalletList();
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
		'page' => array('title' => Helper::translate("Transfer", "member-transfer-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/transfer.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/member/transfer.bottom.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("Transfer", "member-transfer-title")),
		'content' => $result,
		'ProductType' =>$productType,
		'Product' =>$product,
		'WalletTotal' => $total,
		'content2' => $product_list,
                'agentblock' => AgentBlockModel::getAgentBlockByAgent($_SESSION['reseller_code'], "transfer"),
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

         if($ok!="0")
         {
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
        $agent = AgentModel::getAgent($member[0]['Agent']);

        $agent_email = $agent['Email'];

        if($agent['ParentID']!='0')
        {
            AgentModel::getloopAgentParent($agent['ParentID']);
        }

        $message = "<br /><br />Agent:\t".$agent['Name']."<br />";
        $message .= "Date Posted:\t".$date_posted_display."<br />";
        $message .= "Transfer From:\t".ProductModel::IDToProductName($_POST['TransferFrom'])."<br />";
        $message .= "Transfer To:\t".ProductModel::IDToProductName($_POST['TransferTo'])."<br />";
        $message .= "Transfer Amount (MYR):\t".$_POST['Amount']."<br />";

		// Set Status
        $ok = ($count==1) ? 1 : "";
        
        $agent_type = AgentModel::getAgent($_SESSION['reseller_code'], "TypeID");

                if($agent_type == '2')
                {

                    $agentParent = AgentModel::getAgent($_SESSION['platform_agent']);
                    unset($_SESSION['platform_agent']);

                }
            }

        }

                

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Transfer...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID, 'agent_email' => $agent_email),
        'message' => $message,
                'agent_type' => AgentModel::getAgent($_SESSION['reseller_code'], "TypeID"),
                'agent' => AgentModel::getAgent($_SESSION['reseller_code']),
                'agent_parent' => $agentParent,
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
		'page' => array('title' => Helper::translate("Withdrawal", "member-withdrawal-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/withdrawal.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/member/withdrawal.bottom.inc.php', 'transaction_add' => $_SESSION['admin']['transaction_add']),
        'block' => array('side_nav' => $this->member_module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("Withdrawal", "member-withdrawal-title")),
		'content' => $result,
                'form_token' => $form_token,
                'agentblock' => AgentBlockModel::getAgentBlockByAgent($_SESSION['reseller_code'], "withdrawal"),
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

        $description = "Bank: ".$_POST['Bank']." | Bank Account No: ".$_POST['BankAccountNo'];

		$key = "(MemberID, TypeID, Description, `Date`, Bank, Credit, StaffID, ModifiedDate, Status)";
		$value = "('".$_SESSION['member']['ID']."', '3', '".$description."', '".$date_posted."', '".$_POST['Bank']."', '".$_POST['Amount']."', '', '', '1')";

		$sql = "INSERT INTO transaction ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		$sql = "UPDATE member SET Bank = '".$_POST['Bank']."', BankAccountNo = '".$_POST['BankAccountNo']."' WHERE ID = '".$BankDetails['content'][0]['ID']."'";

		$this->dbconnect->exec($sql);

        $member = MemberModel::getMember($_SESSION['member']['ID']);
        $agent = AgentModel::getAgent($member[0]['Agent']);
        $agent_email = $agent[0]['Email'];

        if($agent['ParentID']!='0')
        {
            AgentModel::getloopAgentParent($agent['ParentID']);
        }

        $message = "<br /><br />Agent:\t".$agent['Name']."<br />";
        $message .= "Description:\t".$description."<br />";
        $message .= "Date Posted:\t".$date_posted_display."<br />";
        $message .= "Bank:\t".$_POST['Bank']."<br />";
        $message .= "Out (MYR):\t".$_POST['Amount']."<br />";

        $member = MemberModel::getMember($_SESSION['member']['ID']);
        $agent = AgentModel::getAgent($member[0]['Agent']);
        $agent_email = $agent['Email'];

        $ok = ($count==1) ? 1 : "";
        }

            $agent_type = AgentModel::getAgent($_SESSION['reseller_code'], "TypeID");

                if($agent_type == '2')
                {

                    $agentParent = AgentModel::getAgent($_SESSION['platform_agent']);
                    unset($_SESSION['platform_agent']);

                }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Deposit...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID, 'agent_email' => $agent_email),
        'message' => $message,
                'agent_type' => AgentModel::getAgent($_SESSION['reseller_code'], "TypeID"),
                'agent' => AgentModel::getAgent($_SESSION['reseller_code']),
                'agent_parent' => $agentParent,
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
                                
                                    
                                
                                $query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=", 1);
				$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");
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

                                $_SESSION['transaction_summary']['param']['TypeID'] = $_POST['TypeID'];
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

        public function getTransactionByMemberID($param)
	{

		$sql = "SELECT COUNT(*) AS depositCount FROM transaction WHERE MemberID = '".$param."' AND TypeID = '2' AND Status IN ('3', '2')";
                //echo $sql;
                //exit;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['depositCount'];
		}


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
            'OperatorID' => $row['OperatorID'],
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

        public function getProgress($ID, $Debit, $Credit, $MemberID, $currentStatus, $Type, $Amount, $transferFrom)
	{


                //settype($Amount, "integer");
		$currentTotal = WalletModel::getMemberWalletTotal($ID);
                $MainWallet = WalletModel::getMemberWalletTotal($row['MemberID']);

                //settype($MainWallet, "float");
                //echo $MainWallet.'<br>';
                //echo
                /*if($Amount == '')
                {
                    $Amount = 0;
                }*/

                if($MainWallet===FALSE)
                {
                    $MainWallet = 0.00;
                }

                //var_dump($MainWallet);
                //echo 'Amount is '.$Amount.'<br>';


                if($currentStatus == 'Completed')
                {
                    //echo '<pre>';
                    //var_dump($MainWallet);
                    /*var_dump($Amount);
                    var_dump($MainWallet);
                    echo '</pre>';*/

                    if($Type == 'Transfer')
                    {
                        if($transferFrom == 'Main Wallet')
                        {
                            $total = $MainWallet + $Amount;
                        }
                        else
                        {
                            $total = $MainWallet - $Amount;
                        }

                        //echo $total.'<br>';

                    }

                    if($Type == 'Withdrawal')
                    {
                        //echo $Amount.'<br>';
                        //echo $MainWallet.'<br>';
                        $total = $MainWallet + $Credit;
                        /*echo 'Main Wallet '.$MainWallet.'<br>';
                        echo 'Amount '.$Amount.'<br>';
                        echo 'Total '.$total.'<br>';*/
                    }

                    if($Type == 'Deposit')
                    {

                        $total = $MainWallet - $Debit;
                        //echo $Amount.'<br>';
                        //echo $currentTotal.'<br>';
                        //echo $total.'<br>';

                    }


                }
                //$test = Helper::displayCurrency(6.5);
                //echo $test;
                //exit;
                //Debug::displayArray($total);
               //exit;
		return $total;
	}

        public function timeLeft($date, $timeElapse)
        {
                $endTime = $date + $timeElapse;
                $currentTimestamp = time();

                $counter = $endTime - $currentTimestamp;

                //echo $endTime.'<br>';
                //echo $currentTimestamp.'<br>';
                //echo $counter.'<br/>';
                /*echo $counter;
                exit;*/
                $counter = ($counter<0)? 0: $counter;
                return $counter;
        }
        
        
        
        public function TransactionSendMail($message, $param)
    {
        //Debug::displayArray($param);
        //exit;
        
        if($param['agent_type'] == '2')
        {
            
            //Debug::displayArray($param);
            
            //exit;
            $mailer = new BaseMailer();
            $mailer->From = $param['agent']['Email'];
            $mailer->AddReplyTo($param['config']['MEMBER_EMAIL_FROM'], $param['agent']['Name']);
            $mailer->FromName = $param['agent']['Name'];

            $mailer->Subject = 'Transaction Request '.date('d-m-Y H:i:s');
            
            //platform operator            
            $mailer->AddAddress($param['agent_parent']['Email'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail1'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail2'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail3'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail4'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail5'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail6'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail7'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail8'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail9'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail10'], '');
            
            //normal operator
            $mailer->AddAddress($param['agent']['Email'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail1'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail2'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail3'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail4'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail5'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail6'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail7'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail8'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail9'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail10'], '');

            
            $mailer->IsHTML(true);
            $mailer->Body = $message;
            $mailer->AltBody = $message;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();
            
                                             
            
            
        }
        elseif($param['agent_type'] == '1')
        {    
    
            $mailer = new BaseMailer();
            $mailer->From = $param['agent']['Email'];
            $mailer->AddReplyTo($param['config']['MEMBER_EMAIL_FROM'], $param['agent']['Name']);
            $mailer->FromName = $param['agent']['Name'];

            $mailer->Subject = 'Transaction Request '.date('d-m-Y H:i:s');

            $mailer->AddAddress($param['agent']['Email'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail1'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail2'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail3'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail4'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail5'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail6'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail7'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail8'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail9'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail10'], '');
            
            $mailer->IsHTML(true);
            $mailer->Body = $message;
            $mailer->AltBody = $message;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();
        
        }
        
            /*$mailer = new BaseMailer();

            $mailer->From = $param['config']['EMAIL_SENDER'];
            $mailer->AddReplyTo($param['config']['TRX_EMAIL_TO'], $param['config']['COMPANY_NAME']);
            $mailer->FromName = $param['config']['COMPANY_NAME'];

            $mailer->Subject = '['.$param['config']['SITE_NAME'].'] Transaction Request '.date('d-m-Y H:i:s');

            $mailer->AddAddress($param['config']['TRX_EMAIL_TO'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC1'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC2'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC3'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC4'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC5'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC6'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC7'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC8'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC9'], '');
            $mailer->AddAddress($param['config']['TRX_EMAIL_CC10'], '');
            

            if ($param['content_param']['agent_email']!="") {
                $mailer->AddAddress($param['content_param']['agent_email'], '');
            }


            $mailer->IsHTML(true);
            $mailer->Body = $message;
            $mailer->AltBody = $message;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();*/
        
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