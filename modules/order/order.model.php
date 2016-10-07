<?php
// Require required models
Core::requireModel('product');
Core::requireModel('orderstatus');
Core::requireModel('memberaddress');
Core::requireModel('region');
Core::requireModel('voucher');
Core::requireModel('deliverymethod');
Core::requireModel('carrier');
Core::requireModel('carrierweightrange');
Core::requireModel('carrierpricerange');
Core::requireModel('paymentmethod');

Core::requireModel('merchant');

Core::requireModel('commission');

Core::requireModel('commissionstatus');


class OrderModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['order'] = array(
        'name' => "Order",
        'dir' => "modules/order/",
        'default_url' => "/main/order/index",
        'member_url' => "/member/order/index",
        'cart_url' => "/cart/order/index",
        'admin_url' => "/admin/order/index");

        $this->module['member'] = array(
        'name' => "Member",
        'dir' => "modules/member/",
        'default_url' => "/main/member/index",
        'member_url' => "/cart/member/index",
        'admin_url' => "/admin/member/index");

		 $this->module['merchant'] = array(
        'name' => "Merchant",
        'dir' => "modules/merchant/",
        'default_url' => "/main/merchant/index",
        'merchant_url' => "/merchant/merchant/index",
        'admin_url' => "/admin/merchant/index");

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
		$query_count = "SELECT COUNT(*) AS num FROM `order` WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/order/index';
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

		$sql = "SELECT * FROM `order` WHERE Enabled = 1 ORDER BY OrderDate ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Subtotal' => $row['Subtotal'],
			'Discounts' => $row['Discounts'],
			'Charges' => $row['Charges'],
			'Shipping' => $row['Shipping'],
			'Tax' => $row['Tax'],
			'Total' => $row['Total'],
			'OrderDate' => Helper::dateSQLToLongDisplay($row['OrderDate']),
			'DeliveryMethod' => $row['DeliveryMethod'],
			'Remarks' => $row['Remarks'],
			'PaymentMethod' => $row['PaymentMethod'],
			'Status' => $row['Status']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['order']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "What's New", 'template' => 'common.tpl.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM `order` WHERE ID = '".$param."' ORDER BY OrderDate ASC LIMIT 0, 5";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Subtotal' => $row['Subtotal'],
			'Discounts' => $row['Discounts'],
			'Charges' => $row['Charges'],
			'Shipping' => $row['Shipping'],
			'Tax' => $row['Tax'],
			'Total' => $row['Total'],
			'OrderDate' => Helper::dateSQLToLongDisplay($row['OrderDate']),
			'DeliveryMethod' => $row['DeliveryMethod'],
			'Remarks' => $row['Remarks'],
			'PaymentMethod' => $row['PaymentMethod'],
			'Status' => $row['Status']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['order']['name'], "Link" => $this->module['order']['default_url']),
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

	public function MemberIndex($param)
    {
        $crud = new CRUD();

        // Prepare Pagination
        $query_count = "SELECT COUNT(*) AS num FROM `order` WHERE 1 = 1";
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

        $targetpage = $data['config']['SITE_URL'].'/main/order/index';
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

        $sql = "SELECT * FROM `order` WHERE 1 = 1 ORDER BY OrderDate ASC LIMIT $start, $limit";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Subtotal' => $row['Subtotal'],
            'Discounts' => $row['Discounts'],
            'Charges' => $row['Charges'],
            'Shipping' => $row['Shipping'],
            'Tax' => $row['Tax'],
            'Total' => $row['Total'],
            'OrderDate' => Helper::dateSQLToLongDisplay($row['OrderDate']),
            'DeliveryMethod' => $row['DeliveryMethod'],
            'Remarks' => $row['Remarks'],
            'PaymentMethod' => $row['PaymentMethod'],
            'Status' => $row['Status']);

            $i += 1;
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "What's New", 'template' => 'common.tpl.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'meta' => array('active' => "on"));

        return $this->output;
    }

	public function MerchantIndex($param) {
		
		unset($_SESSION['YearSelected']);
		
		unset($_SESSION['PaymentType']);
		
		$crud = new CRUD();

		// Prepare Pagination

		$query_count = "SELECT COUNT(*) AS num FROM `order` WHERE MerchantID = '" . $_SESSION['merchant']['ID'] . "'";

		$total_pages = $this -> dbconnect -> query($query_count) -> fetchColumn();

		$targetpage = $data['config']['SITE_URL'] . '/merchant/order/index';

		$limit = 10;

		$stages = 3;

		$page = mysql_escape_string($_GET['page']);

		if ($page) {

			$start = ($page - 1) * $limit;

		} else {

			$start = 0;

		}

		// Initialize Pagination

		$paginate = $crud -> paginate($targetpage, $total_pages, $limit, $stages, $page);

		$sql = "SELECT * FROM `order` WHERE MerchantID = '" . $_SESSION['merchant']['ID'] . "' ORDER BY ID DESC LIMIT $start, $limit";

		$result = array();

		$i = 0;

		foreach ($this->dbconnect->query($sql) as $row) {

			$result[$i] = array('ID' => $row['ID'], 'MerchantID' => $row['MerchantID'], 'Item' => $row['Item'], 'Description' => $row['Description'], 'Subtotal' => $row['Subtotal'], 'Discounts' => $row['Discounts'], 'Charges' => $row['Charges'], 'Shipping' => $row['Shipping'], 'Tax' => $row['Tax'], 'Total' => Helper::displayCurrency($row['Total']), 'OrderDate' => Helper::dateTimeSQLToLongDisplay($row['OrderDate']), 'DeliveryMethod' => DeliveryMethodModel::getDeliveryMethod($row['DeliveryMethod']), 'Remarks' => $row['Remarks'], 'PaymentMethod' => PaymentMethodModel::getPaymentMethod($row['PaymentMethod']), 'Status' => OrderStatusModel::getOrderStatus($row['Status']));

			$i += 1;

		}

		$this -> output = array('config' => $this -> config, 'page' => array('title' => "Order History", 'template' => 'common-2-column.tpl.php', 'custom_inc' => 'off', 'custom_inc_loc' => $this -> module_dir . 'inc/merchant/index.inc.php'), 'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"), 'breadcrumb' => HTML::getBreadcrumb($this -> module_member_name, $this -> module_default_member_url, "merchant", $this -> config, "My Orders"), 'content' => $result, 'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'enabled_list' => CRUD::getActiveList()), 'secure' => TRUE, 'meta' => array('active' => "on"));

		return $this -> output;

	}

	public function DealerIndex() {
		unset($_SESSION['YearSelected']);
		
		unset($_SESSION['PaymentType']);
		
		$crud = new CRUD();

		// Prepare Pagination

		$query_count = "SELECT COUNT(*) AS num FROM `order` AS o, merchant AS m WHERE m.ID = o.MerchantID AND m.DealerID = '".$_SESSION['dealer']['ID']."'";

		$total_pages = $this -> dbconnect -> query($query_count) -> fetchColumn();

		$targetpage = $data['config']['SITE_URL'] . '/dealer/order/index';

		$limit = 10;

		$stages = 3;

		$page = mysql_escape_string($_GET['page']);

		if ($page) {

			$start = ($page - 1) * $limit;

		} else {

			$start = 0;

		}

		// Initialize Pagination

		$paginate = $crud -> paginate($targetpage, $total_pages, $limit, $stages, $page);

		$sql = "SELECT o.ID AS o_ID, o.MerchantID AS o_MerchantID, o.Item AS o_Item, o.Description AS o_Description, o.Total AS o_Total, o.DealerTotal AS o_DealerTotal, o.DealerDiscount AS o_DealerDiscount, o.Status AS o_Status, o.PaymentMethod AS o_PaymentMethod, o.OrderDate AS o_OrderDate FROM `order` AS o, merchant AS m WHERE m.ID = o.MerchantID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ORDER BY o.OrderDate DESC LIMIT $start, $limit";

		$result = array();

		$i = 0;

		foreach ($this->dbconnect->query($sql) as $row) {

			$result[$i] = array('ID' => $row['o_ID'], 'MerchantID' => MerchantModel::getMerchant($row['o_MerchantID'], $column = "Name"), 'Item' => $row['o_Item'], 'Description' => $row['o_Description'], 'Subtotal' => $row['Subtotal'], 'Discounts' => $row['Discounts'], 'DealerTotal' => $row['o_DealerTotal'], 'DealerDiscount' => $row['o_DealerDiscount'], 'Charges' => $row['Charges'], 'Shipping' => $row['Shipping'], 'Tax' => $row['Tax'], 'Total' => Helper::displayCurrency($row['o_Total']), 'OrderDate' => Helper::dateTimeSQLToLongDisplay($row['o_OrderDate']), 'DeliveryMethod' => DeliveryMethodModel::getDeliveryMethod($row['DeliveryMethod']), 'Remarks' => $row['Remarks'], 'PaymentMethod' => PaymentMethodModel::getPaymentMethod($row['o_PaymentMethod']), 'Status' => OrderStatusModel::getOrderStatus($row['o_Status']));

			$i += 1;

		}

		$this -> output = array('config' => $this -> config, 'page' => array('title' => "Order History", 'template' => 'common-2-column.tpl.php', 'custom_inc' => 'off', 'custom_inc_loc' => $this -> module_dir . 'inc/merchant/index.inc.php'), 'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"), 'breadcrumb' => HTML::getBreadcrumb($this -> module_member_name, $this -> module_default_member_url, "merchant", $this -> config, "My Orders"), 'content' => $result, 'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'enabled_list' => CRUD::getActiveList()), 'secure' => TRUE, 'meta' => array('active' => "on"));

		return $this -> output;

	}

    public function CartConfirm($param) {


		//$_SESSION['post_data'] = $_POST;

    	if($param != ''){

		$result = MerchantModel::getMerchant($param);

			if(empty($_POST)){
					
			    //$_SESSION['DealerMerchant'] = $_SESSION['post_data'];
			}else{

			    $_SESSION['DealerMerchant'] = $_POST;
			}


		$_SESSION['DealerMerchant']['ID'] = $result['ID'];
		$_SESSION['DealerMerchant']['Name'] = $result['Name'];
		$_SESSION['DealerMerchant']['Email'] = $result['Email'];
		}else{
			//echo 'hi';

		//MerchantModel::getMerchant

    		if (empty($_POST))
    		{
    			/*Debug::displayArray($_SESSION);
				exit;*/
    			#echo 'hi';
    			#exit;
    			//$_SESSION['cart'] = $_SESSION['post_data'];
            }
            else
            {
    			$_SESSION['cart'] = $_POST;
    		}
        }

		/*if(isset($_POST['OrderDesc1'])){

		   $_SESSION['cart']['OrderDesc'] = $_POST['OrderDesc1'];

		}elseif(isset($_POST['OrderDesc'])){

			 $_SESSION['cart']['OrderDesc'] = $_POST['OrderDesc'];

		}

		if(isset($_POST['OrderAmount1'])){

		   $_SESSION['cart']['OrderAmount'] = $_POST['OrderAmount1'];

		}elseif(isset($_POST['OrderAmount'])){

			 $_SESSION['cart']['OrderAmount'] = $_POST['OrderAmount'];

		}*/
		/*Debug::displayArray($_SESSION['DealerMerchant']);
		exit;*/



		if($param ==''){

		$_SESSION['cart']['OrderAmount'] = number_format($_SESSION['cart']['OrderAmount'], 2, ".", "");
		$_SESSION['cart']['OrderAmount1'] = number_format($_SESSION['cart']['OrderAmount1'], 2, ".", "");
		//$discount = $_SESSION['cart']['OrderAmount'] * ($this->config['DEALER_DISCOUNT']/100);
		//$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount'] - $discount;
		//$discount = $_SESSION['cart']['OrderAmount1'] * ($this->config['DEALER_DISCOUNT']/100);
		//$_SESSION['cart']['OrderAmount1'] = $_SESSION['cart']['OrderAmount1'] - $discount;
		}else{
		$_SESSION['DealerMerchant']['OrderAmount'] = number_format($_SESSION['DealerMerchant']['OrderAmount'], 2, ".", "");
		$_SESSION['DealerMerchant']['OrderAmount1'] = number_format($_SESSION['DealerMerchant']['OrderAmount1'], 2, ".", "");

		}



		if ($_SESSION['cart']['OrderQuantity'] != "") {

			$_SESSION['cart']['OrderDesc'] = $_SESSION['cart']['OrderQuantity'] . " x " . $_SESSION['cart']['OrderDesc'];

		}

		if ($_SESSION['cart']['OrderDonateAddress'] != "") {

			$_SESSION['cart']['OrderDesc'] = $_SESSION['cart']['OrderDesc'] . "<br /><br /><u>Receipt Requested</u><br />" . $_SESSION['cart']['OrderDonateName'] . "<br />" . $_SESSION['cart']['OrderDonateIC'] . "<br />" . $_SESSION['cart']['OrderDonateAddress'] . "";

		}

		$user = ($_SESSION['merchant']['ID']!="") ? 'merchant' :' dealer';

		$this -> output = array('config' => $this -> config, 'page' => array('title' => "Confirm Order", 'template' => 'common-2-column.tpl.php'),
		'block' => array(/*'side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php',*/ 'common' => "false"),
		 /*'breadcrumb' => HTML::getBreadcrumb($this -> module_name, "", "", $this -> config, "Confirm Order"),*/
		 'content' => $result, 'content_param' => array('count' => $i),
		 'meta' => array('active' => "on"),
		 'back_link' => $user,
		 'param' => $param);

		return $this -> output;

	}

	public function CartRequest($param) {

		/*Debug::displayArray($_SESSION['DealerMerchant']['ID']);
		exit;*/
		if(!isset($_SESSION['DealerMerchant'])){
		$_SESSION['cart']['OrderKey'] = uniqid();

		if($_SESSION['PostYear']=='1'){
			/*echo $_SESSION['cart']['SubYear'];
			exit;*/
			$_SESSION['cart']['SubYear'] = '1';
			$_SESSION['cart']['OrderDesc'] = $_SESSION['cart']['OrderDesc'];
			$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount'];

		}elseif($_SESSION['PostYear']=='2'){
			$_SESSION['cart']['SubYear'] = '2';
			$_SESSION['cart']['OrderDesc'] = $_SESSION['cart']['OrderDesc2'];
			$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount2'];

		}
		}else{
			if($_SESSION['PostYear']=='1'){
			$_SESSION['DealerMerchant']['SubYear'] = '1';
			$_SESSION['DealerMerchant']['OrderDesc'] = $_SESSION['DealerMerchant']['OrderDesc'];
			$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['DealerMerchant']['OrderAmount'];
			$discount = $_SESSION['DealerMerchant']['OrderAmount'] * ($this->config['DEALER_DISCOUNT']/100);
			$_SESSION['DealerMerchant']['OrderTotal'] = $_SESSION['DealerMerchant']['OrderAmount'] - $discount;


		}elseif($_SESSION['PostYear']=='2'){
			$_SESSION['DealerMerchant']['SubYear'] = '2';
			$_SESSION['DealerMerchant']['OrderDesc'] = $_SESSION['DealerMerchant']['OrderDesc2'];
			$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['DealerMerchant']['OrderAmount2'];
			$discount = $_SESSION['DealerMerchant']['OrderAmount'] * ($this->config['DEALER_DISCOUNT']/100);
			$_SESSION['DealerMerchant']['OrderTotal'] = $_SESSION['DealerMerchant']['OrderAmount'] - $discount;

		}
		}

		/*Debug::displayArray($_SESSION);
		exit;*/

		/*if(isset($_SESSION['cart']['OrderAmount'])){

			$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount'];

		}elseif($_SESSION['cart']['OrderAmount2']){

			$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount2'];

		}*/

		if(!isset($_SESSION['DealerMerchant'])){



		if ($_SESSION['merchant']['ID'] != "") {

			$merchant_id = $_SESSION['merchant']['ID'];

		} else {

			$merchant_id = '0';

		}

		}else{

			$merchant_id = $_SESSION['DealerMerchant']['ID'];

		}

		// Insert New Order


		if(!isset($_SESSION['DealerMerchant'])){
		$key = "(MerchantID, Item, Description, Total, OrderDate, PaymentMethod, DeliveryMethod, Status)";
		$value = "('" . $merchant_id . "', '" . $_SESSION['cart']['OrderItem'] . "', '" . $_SESSION['cart']['OrderDesc'] . "', '" . $_SESSION['cart']['OrderAmount'] . "', '" . date('YmdHis') . "', '1', '" . $_SESSION['cart']['OrderDelivery'] . "', '1')";
		}else{
		$key = "(MerchantID, Item, Description, Total, DealerTotal, DealerDiscount, OrderDate, PaymentMethod, DeliveryMethod, Status)";
		$value = "('" . $merchant_id . "', '" . $_SESSION['DealerMerchant']['OrderItem'] . "', '" . $_SESSION['DealerMerchant']['OrderDesc'] . "', '" . $_SESSION['DealerMerchant']['OrderAmount'] . "', '" . $_SESSION['DealerMerchant']['OrderTotal'] . "', '" . $this->config['DEALER_DISCOUNT'] . "', '" . date('YmdHis') . "', '1', '" . $_SESSION['DealerMerchant']['OrderDelivery'] . "', '1')";
		}

		$sql = "INSERT INTO `order` " . $key . " VALUES " . $value;

		$count = $this -> dbconnect -> exec($sql);

		$newID = $this -> dbconnect -> lastInsertId();
		if(!isset($_SESSION['DealerMerchant'])){
			$_SESSION['cart']['OrderNo'] = $newID;
		}else{
			$_SESSION['DealerMerchant']['OrderNo'] = $newID;
		}



		$this -> output = array('config' => $this -> config,
		'page' => array('title' => "Connecting to Payment Gateway", 'template' => 'common-2-column.tpl.php'),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"), /*'breadcrumb' => HTML::getBreadcrumb($this -> module_name, "", "", $this -> config, "Payment"),*/ 'content' => $result, 'content_param' => array('count' => $i), 'meta' => array('active' => "on"));

		return $this -> output;

	}


	public function CartPaymentCheck($param) {
		/*Debug::displayArray($_SESSION);
		exit;*/		
			
		$_SESSION['YearSelected'] = $_POST['year'];
		$_SESSION['PaymentType'] = $_POST['payment'];
		if($_POST['payment'] == 'Online'){

			$payment = "1";
			$_SESSION['PostYear'] = $_POST['year'];

		}elseif($_POST['payment'] == 'BankIn'){

			$payment = "2";

			if(!isset($_SESSION['DealerMerchant'])){
			$_SESSION['cart']['OrderKey'] = uniqid();

				if($_POST['year']=='1'){
					//echo $_POST['year'];
					$_SESSION['cart']['SubYear'] = '1';
					$_SESSION['cart']['OrderDesc'] = $_SESSION['cart']['OrderDesc'];
					$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount'];
					$_SESSION['cart']['SelectedAmount'] = $_SESSION['cart']['OrderAmount'];
	
				}elseif($_POST['year']=='2'){
					$_SESSION['cart']['SubYear'] = '2';
					$_SESSION['cart']['OrderDesc2'] = $_SESSION['cart']['OrderDesc2'];
					$_SESSION['cart']['OrderAmount2'] = $_SESSION['cart']['OrderAmount2'];
					$_SESSION['cart']['SelectedAmount'] = $_SESSION['cart']['OrderAmount2'];
	
				}
			}else{
				if($_POST['year']=='1'){
				$_SESSION['DealerMerchant']['SubYear'] = '1';
				$_SESSION['DealerMerchant']['OrderDesc'] = $_SESSION['DealerMerchant']['OrderDesc'];
				$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['DealerMerchant']['OrderAmount'];
				$_SESSION['DealerMerchant']['SelectedAmount'] = $_SESSION['DealerMerchant']['OrderAmount'];
				$discount = $_SESSION['DealerMerchant']['OrderAmount'] * ($this->config['DEALER_DISCOUNT']/100);
				$_SESSION['DealerMerchant']['OrderTotal'] = $_SESSION['DealerMerchant']['OrderAmount'] - $discount;


				}elseif($_POST['year']=='2'){
					$_SESSION['DealerMerchant']['SubYear'] = '2';
					$_SESSION['DealerMerchant']['OrderDesc2'] = $_SESSION['DealerMerchant']['OrderDesc2'];
					$_SESSION['DealerMerchant']['OrderAmount2'] = $_SESSION['DealerMerchant']['OrderAmount2'];
					$_SESSION['DealerMerchant']['SelectedAmount'] = $_SESSION['DealerMerchant']['OrderAmount2'];
					$discount = $_SESSION['DealerMerchant']['OrderAmount2'] * ($this->config['DEALER_DISCOUNT']/100);
					$_SESSION['DealerMerchant']['OrderTotal'] = $_SESSION['DealerMerchant']['OrderAmount2'] - $discount;
	
				}
			}


		}elseif ($_POST['payment'] == 'Cheque') {

			$payment = "3";

			if(!isset($_SESSION['DealerMerchant'])){
					$_SESSION['cart']['OrderKey'] = uniqid();

					if($_POST['year']=='1'){
						$_SESSION['cart']['SubYear'] = '1';
						$_SESSION['cart']['OrderDesc'] = $_SESSION['cart']['OrderDesc'];
						$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount'];
						$_SESSION['cart']['SelectedAmount'] = $_SESSION['cart']['OrderAmount'];
					}elseif($_POST['year']=='2'){
						$_SESSION['cart']['SubYear'] = '2';
						$_SESSION['cart']['OrderDesc2'] = $_SESSION['cart']['OrderDesc2'];
						$_SESSION['cart']['OrderAmount2'] = $_SESSION['cart']['OrderAmount2'];
						
						$_SESSION['cart']['SelectedAmount'] = $_SESSION['cart']['OrderAmount2'];

					}
			}else{
					if($_POST['year']=='1'){
						$_SESSION['DealerMerchant']['SubYear'] = '1';
						$_SESSION['DealerMerchant']['OrderDesc'] = $_SESSION['DealerMerchant']['OrderDesc'];
						$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['DealerMerchant']['OrderAmount'];
						$_SESSION['DealerMerchant']['SelectedAmount'] = $_SESSION['DealerMerchant']['OrderAmount'];
						$discount = $_SESSION['DealerMerchant']['OrderAmount'] * ($this->config['DEALER_DISCOUNT']/100);
						$_SESSION['DealerMerchant']['OrderTotal'] = $_SESSION['DealerMerchant']['OrderAmount'] - $discount;


					}elseif($_POST['year']=='2'){
						$_SESSION['DealerMerchant']['SubYear'] = '2';
						$_SESSION['DealerMerchant']['OrderDesc2'] = $_SESSION['DealerMerchant']['OrderDesc2'];
						$_SESSION['DealerMerchant']['OrderAmount2'] = $_SESSION['DealerMerchant']['OrderAmount2'];
						$_SESSION['DealerMerchant']['SelectedAmount'] = $_SESSION['DealerMerchant']['OrderAmount2'];
						$discount = $_SESSION['DealerMerchant']['OrderAmount2'] * ($this->config['DEALER_DISCOUNT']/100);
						$_SESSION['DealerMerchant']['OrderTotal'] = $_SESSION['DealerMerchant']['OrderAmount2'] - $discount;

					}
			}

		}
        /*Debug::displayArray($_SESSION);
		exit;*/

		//echo 'hi ';
		//echo $payment;

		$this -> output = array('config' => $this -> config,
		'page' => array('title' => "Connecting to Payment Gateway", 'template' => 'common-2-column.tpl.php'),
		//'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
		 /*'breadcrumb' => HTML::getBreadcrumb($this -> module_name, "", "", $this -> config, "Payment"),*/
		'content' => $result,
		'payment_type' => $payment,
		'content_param' => array('count' => $i), 'meta' => array('active' => "on"));

		return $this -> output;

	}


	public function CartResponse() {

		$response = $_POST;

		$orderID = $_POST['custom0'];

		$trxID = $_POST['tid'];

		if(!isset($_SESSION['DealerMerchant'])){

		$clientID = $_SESSION['merchant']['ID'];

		}else{

		$clientID = $_SESSION['DealerMerchant']['ID'];

		}

		$gateway = $_POST['m'];

		if ($gateway == 4) {

			// PayPal / Credit Card

			$gateway = 2;

		} else if ($gateway == 2) {

			// Online Banking

			$gateway = 3;

		} else if ($gateway == 3) {

			// Webcash

			$gateway = 4;

		} else {

			// None

			$gateway = 1;

		}

		if ($response['status'] == 1) {

			// Successful Order

			$sql = "UPDATE `order` SET `Status` = '2', PaymentMethod = '" . $gateway . "',  Remarks = 'Transaction ID: " . $trxID . "' WHERE ID = '" . $orderID . "' AND MerchantID = '" . $clientID . "'";

			$this -> dbconnect -> query($sql);

			// Get Delivery Method

			$sql = "SELECT * FROM `order` WHERE ID = '" . $orderID . "' AND MerchantID = '" . $clientID . "'";

			$result = array();

			$i = 0;

			foreach ($this->dbconnect->query($sql) as $row) {

				$result[$i] = array('ID' => $row['ID'], 'OrderDate' => $row['OrderDate'], 'Item' => $row['Item'], 'Description' => $row['Description'], 'Total' => $row['Total'], 'DeliveryMethod' => $row['DeliveryMethod']);

				$i += 1;

			}

			// Handle Order Updates

			if ($result[0]['DeliveryMethod'] == "standard-membership-upgrade") {

				$typeid = "2";
				// Member
				if(!isset($_SESSION['DealerMerchant'])){
				$expiry = date('Ymd', strtotime("+{$_SESSION['cart']['SubYear']} year", time())); // Add One Year From Today
				/*echo $_SESSION['cart']['SubYear'].' ';
				echo $expiry;
				exit;*/
				$sql = "UPDATE merchant SET TypeID='" . $typeid . "', Expiry='" . $expiry . "' WHERE ID='" . $clientID . "'";

				$count = $this -> dbconnect -> exec($sql);

				// Set session data

				$_SESSION['merchant']['Type'] = "2";

				$_SESSION['merchant']['Expiry'] = $expiry;

				$_SESSION['merchant']['ExpiryText'] = Helper::dateSQLToDisplay($expiry);

				$order_type = 'Standard Membership';

				}else{
				$expiry = date('Ymd', strtotime("+{$_SESSION['DealerMerchant']['SubYear']} year", time())); // Add One Year From Today
				//echo $expiry;
				//exit;
				$sql = "UPDATE merchant SET TypeID='" . $typeid . "', Expiry='" . $expiry . "' WHERE ID='" . $clientID . "'";

				$count = $this -> dbconnect -> exec($sql);

				// Set session data

				$_SESSION['DealerMerchant']['Type'] = "2";

				$_SESSION['DealerMerchant']['Expiry'] = $expiry;

				$_SESSION['DealerMerchant']['ExpiryText'] = Helper::dateSQLToDisplay($expiry);

				$order_type = 'Standard Membership';



				}

				/*$total_tier_one = $result[0]['Total'] * (($this -> config['TIER_ONE_COMMISSION']) / 100);

				$total_tier_two = $result[0]['Total'] * (($this -> config['TIER_TWO_COMMISSION']) / 100);

				$member_tier_one = MemberModel::getParent($clientID);

				$member_tier_two = MemberModel::getParent($member_tier_one);

				CommissionModel::addCommission($member_tier_one, $orderID, $total_tier_one, $order_type);

				CommissionModel::addCommission($member_tier_two, $orderID, $total_tier_two, $order_type);*/

			} else if ($result[0]['DeliveryMethod'] == "standard-membership-renew") {

				// Get Current Expiry Date

				$sql_m = "SELECT * FROM `merchant` WHERE ID = '" . $clientID . "'";

				$result_m = array();

				$i_m = 0;

				foreach ($this->dbconnect->query($sql_m) as $row_m) {

					$result_m[$i_m] = array('ID' => $row_m['ID'], 'Expiry' => $row_m['Expiry']);

					$i += 1;

				}


				if (date('Y-m-d') > $result_m[0]['Expiry']) {

					// Renew after expiry
					if(!isset($_SESSION['DealerMerchant'])){
					$expiry = date('Ymd', strtotime("+{$_SESSION['cart']['SubYear']} year"));
					}else{
					$expiry = date('Ymd', strtotime("+{$_SESSION['DealerMerchant']['SubYear']} year"));
					}
					// Add One Year From Current Date

				} else {

					// Renew before expiry

					if(!isset($_SESSION['DealerMerchant'])){
					$expiry = date('Ymd', strtotime("+{$_SESSION['cart']['SubYear']} year", strtotime($result_m[0]['Expiry'])));
					}else{
					$expiry = date('Ymd', strtotime("+{$_SESSION['DealerMerchant']['SubYear']} year", strtotime($result_m[0]['Expiry'])));
					}


					// Add One Year From Expiry Date

				}

				$sql = "UPDATE merchant SET Expiry='" . $expiry . "' WHERE ID='" . $clientID . "'";

				$count = $this -> dbconnect -> exec($sql);

				// Set session data
				$_SESSION['merchant']['Type'] = "1";
				$_SESSION['merchant']['Expiry'] = $expiry;

				$_SESSION['merchant']['ExpiryText'] = Helper::dateSQLToDisplay($expiry);

				$order_type = 'Standard Renew';

				/*$total_tier_one = $result[0]['Total'] * (($this -> config['TIER_ONE_COMMISSION'] / 100));

				$total_tier_two = $result[0]['Total'] * (($this -> config['TIER_TWO_COMMISSION']) / 100);

				$member_tier_one = MemberModel::getParent($clientID);

				$member_tier_two = MemberModel::getParent($member_tier_one);

				CommissionModel::addCommission($member_tier_one, $orderID, $total_tier_one, $order_type);

				CommissionModel::addCommission($member_tier_two, $orderID, $total_tier_two, $order_type);*/

			}

			if ($result[0]['DeliveryMethod'] == "premier-membership-upgrade") {

				if(!isset($_SESSION['DealerMerchant'])){
				$typeid = "3";
				// Member

				$expiry = date('Ymd', strtotime("+{$_SESSION['cart']['SubYear']} year", time())); ;// Add One Year From Today

				$sql = "UPDATE merchant SET TypeID='" . $typeid . "', Expiry='" . $expiry . "' WHERE ID='" . $clientID . "'";

				$count = $this -> dbconnect -> exec($sql);

				// Set session data

				$_SESSION['merchant']['Type'] = "3";

				$_SESSION['merchant']['Expiry'] = $expiry;

				$_SESSION['merchant']['ExpiryText'] = Helper::dateSQLToDisplay($expiry);

				$order_type = 'Premier Membership';
			    }else{

				$typeid = "3";
				// Member

				$expiry = date('Ymd', strtotime("+{$_SESSION['DealerMerchant']['SubYear']} year", time())); ;// Add One Year From Today

				$sql = "UPDATE merchant SET TypeID='" . $typeid . "', Expiry='" . $expiry . "' WHERE ID='" . $clientID . "'";

				$count = $this -> dbconnect -> exec($sql);

				// Set session data

				$_SESSION['DealerMerchant']['Type'] = "3";

				$_SESSION['DealerMerchant']['Expiry'] = $expiry;

				$_SESSION['DealerMerchant']['ExpiryText'] = Helper::dateSQLToDisplay($expiry);

				$order_type = 'Premier Membership';


			    }

				/*$total_tier_one = $result[0]['Total'] * (($this -> config['TIER_ONE_COMMISSION']) / 100);

				$total_tier_two = $result[0]['Total'] * (($this -> config['TIER_TWO_COMMISSION']) / 100);

				$member_tier_one = MemberModel::getParent($clientID);

				$member_tier_two = MemberModel::getParent($member_tier_one);

				CommissionModel::addCommission($member_tier_one, $orderID, $total_tier_one, $order_type);

				CommissionModel::addCommission($member_tier_two, $orderID, $total_tier_two, $order_type);*/

			} else if ($result[0]['DeliveryMethod'] == "premier-membership-renew") {

				// Get Current Expiry Date

				$sql_m = "SELECT * FROM `merchant` WHERE ID = '" . $clientID . "'";

				$result_m = array();

				$i_m = 0;

				foreach ($this->dbconnect->query($sql_m) as $row_m) {

					$result_m[$i_m] = array('ID' => $row_m['ID'], 'Expiry' => $row_m['Expiry']);

					$i += 1;

				}


				if (date('Y-m-d') > $result_m[0]['Expiry']) {

					// Renew after expiry
					if(!isset($_SESSION['DealerMerchant'])){
					$expiry = date('Ymd', strtotime("+{$_SESSION['cart']['SubYear']} year"));
					}else{
					$expiry = date('Ymd', strtotime("+{$_SESSION['DealerMerchant']['SubYear']} year"));
					}
					// Add One Year From Current Date

				} else {

					// Renew before expiry
					if(!isset($_SESSION['DealerMerchant'])){
					$expiry = date('Ymd', strtotime("+{$_SESSION['cart']['SubYear']} year", strtotime($result_m[0]['Expiry'])));
					}else{
					$expiry = date('Ymd', strtotime("+{$_SESSION['DealerMerchant']['SubYear']} year", strtotime($result_m[0]['Expiry'])));
					}
					// Add One Year From Expiry Date

				}

				$sql = "UPDATE merchant SET Expiry='" . $expiry . "' WHERE ID='" . $clientID . "'";

				$count = $this -> dbconnect -> exec($sql);

				// Set session data
				if(!isset($_SESSION['DealerMerchant'])){
				$_SESSION['merchant']['Type'] = "3";
				$_SESSION['merchant']['Expiry'] = $expiry;

				$_SESSION['merchant']['ExpiryText'] = Helper::dateSQLToDisplay($expiry);

				$order_type = 'Premier Renew';
				}else{
				$_SESSION['DealerMerchant']['Type'] = "3";
				$_SESSION['DealerMerchant']['Expiry'] = $expiry;

				$_SESSION['DealerMerchant']['ExpiryText'] = Helper::dateSQLToDisplay($expiry);

				$order_type = 'Premier Renew';
				}

				/*$total_tier_one = $result[0]['Total'] * (($this -> config['TIER_ONE_COMMISSION'] / 100));

				$total_tier_two = $result[0]['Total'] * (($this -> config['TIER_TWO_COMMISSION']) / 100);

				$member_tier_one = MemberModel::getParent($clientID);

				$member_tier_two = MemberModel::getParent($member_tier_one);

				CommissionModel::addCommission($member_tier_one, $orderID, $total_tier_one, $order_type);

				CommissionModel::addCommission($member_tier_two, $orderID, $total_tier_two, $order_type);*/

			}

			if(!isset($_SESSION['DealerMerchant'])){
			if ($_SESSION['merchant']['ID'] != "") {

				// Send Mail

				$mailer = new BaseMailer();

				$mailer -> From = "no-reply@aseanfnb.valse.com.my";

				$mailer -> AddReplyTo = "admin@baseanfnb.valse.com.my";

				$mailer -> FromName = "aseanF&B";

				$mailer -> Subject = "[aseanF&B] Order Confirmation #" . $orderID;

				$mailer -> AddAddress($_SESSION['merchant']['Email'], '');

				$mailer -> AddBCC('decweng.chan@valse.com.my', '');

				$mailer -> IsHTML(true);

				$mailer -> Body = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


                  <title>Order Confirmation #' . $orderID . '</title>





                  <div style="width: 550px; border:1px solid #ddd; padding:10px; margin:10px">


                  <table style="font-family:Arial,sans-serif; font-size:12px;


                    color:#333; width: 550px;">


                    <tbody>


                      <tr>


                        <td align="left" style="font-size:16px; font-weight:bold; text-transform:uppercase"><img src="http://bitdstrategy.com/themes/valse/img/logo_mail.png" /></td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="left">Hello <strong style="color:#FB7D00;">' . $_SESSION['merchant']['Name'] . '</strong>,<br /><br />Thank you for your payment. Your order has been processed. ' . $backorder_remarks . '<br />&nbsp;</td>


                      </tr>


                      <tr>


                        <td style="background-color:#333; color:#FFF; font-size:


                          12px; font-weight:bold; padding: 0.5em


                          1em;" align="left">Order details</td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="left" colspan="2" style="color:#333; padding:0.6em 0.8em;"> Order: <strong><span


                              style="color:#FB7D00;">#' . $orderID . '</span></strong> placed on <strong>' . $result[0]['OrderDate'] . '</strong>


                        </td>


                      </tr>


                      <tr>


                        <td align="left">


                          <table style="width:100%; font-family:Arial,sans-serif; font-size:12px; color:#374953;">


                           <tbody>


                              <tr>


                                <td colspan="2" style="background-color:#efefef; color:#333; padding:0.6em 0.8em;"><strong>' . $result[0]['Item'] . '</strong><br />


                                    ' . $result[0]['Description'] . '


                                </td>


                              </tr>


                              <tr style="text-align:right; font-weight:bold;">


                                <td style="width:80%; background-color:#333; color:#FFFFFF; padding:0.6em 0.8em;">Total paid</td>


                                <td style="background-color:#333; color:#fff; padding:0.6em 0.8em;">RM' . $result[0]['Total'] . '</td>


                              </tr>


                            </tbody>


                          </table>


                        </td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="center">You can review your orders in the <a moz-do-not-send="true"


                            href="'.$this->config['SITE_URL'].'/merchant/order/index"


                            style="color:#FB7D00; font-weight:bold;


                            text-decoration:none;">"Order History"</a> page</td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>

						<td>'.$this->config['ANDROID_APP'].'</td>
						<td>'.$this->config['iOS_APP'].'</td>	
                        <td style="border-top: 1px solid #ddd;" align="center"> <a moz-do-not-send="true" href="" style="color:#FB7D00; font-weight:bold; text-decoration:none;">aseanF&B</a>


                        </td>


                      </tr>


                    </tbody>


                  </table>


                  </div>';

				$mailer -> Send();

			//}

		} else {

			// Failed / Cancelled Order

			$sql = "UPDATE `order` SET `Status` = '3', PaymentMethod = '" . $gateway . "',  Remarks = 'Transaction ID: " . $trxID . "' WHERE ID = '$orderID' AND MerchantID = '" . $clientID . "'";

			$this -> dbconnect -> query($sql);

		}
		}else{














		if ($_SESSION['DealerMerchant']['ID'] != "") {

				// Send Mail

				$mailer = new BaseMailer();

				$mailer -> From = "no-reply@aseanfnb.valse.com.my";

				$mailer -> AddReplyTo = "admin@baseanfnb.valse.com.my";

				$mailer -> FromName = "aseanF&B";

				$mailer -> Subject = "[aseanF&B] Order Confirmation #" . $orderID;

				$mailer -> AddAddress($_SESSION['DealerMerchant']['Email'], '');

				$mailer -> AddBCC('decweng.chan@valse.com.my', '');

				$mailer -> IsHTML(true);

				$mailer -> Body = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


                  <title>Order Confirmation #' . $orderID . '</title>





                  <div style="width: 550px; border:1px solid #ddd; padding:10px; margin:10px">


                  <table style="font-family:Arial,sans-serif; font-size:12px;


                    color:#333; width: 550px;">


                    <tbody>


                      <tr>


                        <td align="left" style="font-size:16px; font-weight:bold; text-transform:uppercase"><img src="http://bitdstrategy.com/themes/valse/img/logo_mail.png" /></td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="left">Hello <strong style="color:#FB7D00;">' . $_SESSION['DealerMerchant']['Name'] . '</strong>,<br /><br />Thank you for your payment. Your order has been processed. ' . $backorder_remarks . '<br />&nbsp;</td>


                      </tr>


                      <tr>


                        <td style="background-color:#333; color:#FFF; font-size:


                          12px; font-weight:bold; padding: 0.5em


                          1em;" align="left">Order details</td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="left" colspan="2" style="color:#333; padding:0.6em 0.8em;"> Order: <strong><span


                              style="color:#FB7D00;">#' . $orderID . '</span></strong> placed on <strong>' . $result[0]['OrderDate'] . '</strong>


                        </td>


                      </tr>


                      <tr>


                        <td align="left">


                          <table style="width:100%; font-family:Arial,sans-serif; font-size:12px; color:#374953;">


                           <tbody>


                              <tr>


                                <td colspan="2" style="background-color:#efefef; color:#333; padding:0.6em 0.8em;"><strong>' . $result[0]['Item'] . '</strong><br />


                                    ' . $result[0]['Description'] . '


                                </td>


                              </tr>


                              <tr style="text-align:right; font-weight:bold;">


                                <td style="width:80%; background-color:#333; color:#FFFFFF; padding:0.6em 0.8em;">Total paid</td>


                                <td style="background-color:#333; color:#fff; padding:0.6em 0.8em;">RM' . $result[0]['Total'] . '</td>


                              </tr>


                            </tbody>


                          </table>


                        </td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="center">You can review your orders in the <a moz-do-not-send="true"


                            href="'.$this->config['SITE_URL'].'/merchant/order/index"


                            style="color:#FB7D00; font-weight:bold;


                            text-decoration:none;">"Order History"</a> page</td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>

						<td>'.$this->config['ANDROID_APP'].'</td>
						<td>'.$this->config['iOS_APP'].'</td>
                        <td style="border-top: 1px solid #ddd;" align="center"> <a moz-do-not-send="true" href="" style="color:#FB7D00; font-weight:bold; text-decoration:none;">aseanF&B</a>


                        </td>


                      </tr>


                    </tbody>


                  </table>


                  </div>';

				$mailer -> Send();

			    MerchantModel::MerchantChanged();

		} else {

			// Failed / Cancelled Order

			$sql = "UPDATE `order` SET `Status` = '3', PaymentMethod = '" . $gateway . "',  Remarks = 'Transaction ID: " . $trxID . "' WHERE ID = '$orderID' AND MerchantID = '" . $clientID . "'";

			$this -> dbconnect -> query($sql);

		}
		}
		}

		// Clear Cart Sessions

		unset($_SESSION['cart']);

		$this -> output = array('config' => $this -> config, 'page' => array('title' => $title, 'template' => 'common-2-column.tpl.php'), 'status' => $response['status'], 'delivery_method' => $result[0]['DeliveryMethod'], 'meta' => array('active' => "on"), 'updated' => $status);

		return $this -> output;

	}

	public function CartManualBankIn($param) {
		/*echo $param;
		exit;*/
    	if($param != ""){

			$result = MerchantModel::getMerchant($param);

			$_SESSION['manualbankin']['ID'] = $result['ID'];
			$_SESSION['manualbankin']['Name'] = $result['Name'];
			$_SESSION['manualbankin']['AccountNo'] = $result['AccountNo'];
			$_SESSION['manualbankin']['Bank'] = $result['Bank'];


    	}else{

			$result = MerchantModel::getMerchant($_SESSION['merchant']['ID']);

			//$_SESSION['manualbankin']['ID'] = $result['ID'];
			$_SESSION['manualbankin']['Name'] = $result['Name'];
			$_SESSION['manualbankin']['AccountNo'] = $result['AccountNo'];
			$_SESSION['manualbankin']['Bank'] = $result['Bank'];

    	}

		$this -> output = array('config' => $this -> config,
		'page' => array('title' => "Confirm Order", 'template' => 'common-2-column.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['order']['dir'] . 'inc/cart/manualbankin.inc.php'),
		'block' => array(/*'side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', */'common' => "false"), /*'breadcrumb' => HTML::getBreadcrumb($this -> module_name, "", "", $this -> config, "Confirm Order"),*/
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this -> output;

	}

	public function CartManualCheque($param) {
    	if($param != ""){

			$result = MerchantModel::getMerchant($param);

			$_SESSION['manualcheque']['ID'] = $result['ID'];
			$_SESSION['manualcheque']['Name'] = $result['Name'];
			$_SESSION['manualcheque']['AccountNo'] = $result['AccountNo'];
			$_SESSION['manualcheque']['Bank'] = $result['Bank'];


    	}else{


			$result = MerchantModel::getMerchant($_SESSION['merchant']['ID']);

			//$_SESSION['manualcheque']['ID'] = $result['ID'];
			$_SESSION['manualcheque']['Name'] = $result['Name'];
			$_SESSION['manualcheque']['AccountNo'] = $result['AccountNo'];
			$_SESSION['manualcheque']['Bank'] = $result['Bank'];
    	}

		$this -> output = array('config' => $this -> config,
		'page' => array('title' => "Confirm Order", 'template' => 'common-2-column.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['order']['dir'] . 'inc/cart/manualcheque.inc.php'),
		'block' => array(/*'side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', */'common' => "false"), /*'breadcrumb' => HTML::getBreadcrumb($this -> module_name, "", "", $this -> config, "Confirm Order"),*/
		'content' => $result, 'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this -> output;

	}

	public function CartPaymentBankIn($param) {
		
		
		/*Debug::displayArray($_SESSION);
		exit;
			

		if($_SESSION['DealerMerchant']['OrderAmount']!=""){
    	
    	$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['DealerMerchant']['OrderAmount'];
		}	
		
		if($_SESSION['DealerMerchant']['OrderAmount2']!=""){
			
		$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['DealerMerchant']['OrderAmount2'];
		}		

		if($_SESSION['cart']['OrderAmount']!=""){
    	
    	$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount'];
		}	
		
		if($_SESSION['cart']['OrderAmount2']!=""){
			
		$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount2'];
		}*/

        if($_SESSION['manualbankin']['ID']!=""){
        	
		$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['cart']['SelectedAmount'];
		
        $discount_amount = $_SESSION['DealerMerchant']['OrderAmount'] * ($this->config['DEALER_DISCOUNT']/100);

		$discount = $_SESSION['DealerMerchant']['OrderAmount'] - $discount_amount;

		$key = "(MerchantID, Item, Description, Total, DealerTotal, DealerDiscount, OrderDate, PaymentMethod, Remarks, DeliveryMethod, Status)";
		$value = "('" . $_SESSION['manualbankin']['ID'] . "', 'Manual', 'Manual ".$_SESSION['DealerMerchant']['OrderItem']." Bank In', '".$_SESSION['DealerMerchant']['OrderAmount']."', '".$discount."', '".$this->config['DEALER_DISCOUNT']."', '" . date('YmdHis') . "', '2', '".$_SESSION['DealerMerchant']['OrderItem']."-".$_SESSION['DealerMerchant']['SubYear']."', 'No-Delivery-Method', '3')";

		$orderDate = date('YmdHis');
		$sql = "INSERT INTO `order` " . $key . " VALUES " . $value;
		/*echo $sql;
		exit;*/
		$count = $this -> dbconnect -> exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		$ismerchant = "0";

		//$send = OrderModel::checkOrderStatus($_SESSION['DealerMerchant']['SubYear']);
		$MerchantDetail = MerchantModel::getMerchant($_SESSION['manualbankin']['ID']);
		OrderModel::orderMail($MerchantDetail, $newID);

        }else{
        	
		$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['SelectedAmount'];	

		$key = "(MerchantID, Item, Description, Total, DealerTotal, DealerDiscount, OrderDate, PaymentMethod, Remarks, DeliveryMethod, Status)";
		$value = "('" . $_SESSION['merchant']['ID'] . "', 'Manual', 'Manual ".$_SESSION['cart']['OrderItem']." Bank In', '".$_SESSION['cart']['OrderAmount']."', '', '', '" . date('YmdHis') . "', '2', '".$_SESSION['cart']['OrderItem']."-".$_SESSION['cart']['SubYear']."', 'No-Delivery-Method', '3')";

		$orderDate = date('YmdHis');
		$sql = "INSERT INTO `order` " . $key . " VALUES " . $value;
		/*echo $sql;
		exit;*/
		$count = $this -> dbconnect -> exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		$ismerchant = "1";

		$MerchantDetail = MerchantModel::getMerchant($_SESSION['merchant']['ID']);
		OrderModel::orderMail($MerchantDetail, $newID);

        }

        $Ismerchant = $ismerchant;

        $this->output = array(
            'config' => $this->config,
            'page' => array('title' => "Manual Bank-In Payment", 'template' => 'common-2-column.tpl.php'),
            'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
            'content' => $result,
            'ismerchant' => $Ismerchant,
            'content_param' => array('count' => $count),
            'meta' => array('active' => "on"));

        return $this->output;
    }

    public function CartPaymentCheque($param) {
    	/*Debug::displayArray($_SESSION);
    	exit;*/
    	/*if($_SESSION['DealerMerchant']['OrderAmount']!=""){
    	
    	$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['DealerMerchant']['OrderAmount'];
		}	
		
		if($_SESSION['DealerMerchant']['OrderAmount2']!=""){
			
		$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['DealerMerchant']['OrderAmount2'];
		}
		
		if($_SESSION['cart']['OrderAmount']!=""){
    	
    	$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount'];
		}	
		
		if($_SESSION['cart']['OrderAmount2']!=""){
			
		$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['OrderAmount2'];
		}*/

        if($_SESSION['manualcheque']['ID'] != ""){
        	
		$_SESSION['DealerMerchant']['OrderAmount'] = $_SESSION['cart']['SelectedAmount'];	

		$discount_amount = $_SESSION['DealerMerchant']['OrderAmount'] * ($this->config['DEALER_DISCOUNT']/100);

		$discount = $_SESSION['DealerMerchant']['OrderAmount'] - $discount_amount;

		$key = "(MerchantID, Item, Description, Total, DealerTotal, DealerDiscount, OrderDate, PaymentMethod, Remarks, DeliveryMethod, Status)";
		$value = "('" . $_SESSION['manualcheque']['ID'] . "', 'Manual', 'Manual ".$_SESSION['DealerMerchant']['OrderItem']." Cheque', '".$_SESSION['DealerMerchant']['OrderAmount']."', '".$discount."', '".$this->config['DEALER_DISCOUNT']."', '" . date('YmdHis') . "', '2', '".$_SESSION['DealerMerchant']['OrderItem']."-".$_SESSION['DealerMerchant']['SubYear']."', 'No-Delivery-Method', '3')";

		$orderDate = date('YmdHis');
		$sql = "INSERT INTO `order` " . $key . " VALUES " . $value;

		$count = $this -> dbconnect -> exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		$MerchantDetail = MerchantModel::getMerchant($_SESSION['manualcheque']['ID']);
		OrderModel::orderMail($MerchantDetail, $newID);
		$ismerchant = "0";

        }else{
        	
		$_SESSION['cart']['OrderAmount'] = $_SESSION['cart']['SelectedAmount'];	

		$key = "(MerchantID, Item, Description, Total, DealerTotal, DealerDiscount, OrderDate, PaymentMethod, Remarks, DeliveryMethod, Status)";
		$value = "('" . $_SESSION['merchant']['ID'] . "', 'Manual', 'Manual ".$_SESSION['cart']['OrderItem']." Cheque', '".$_SESSION['cart']['OrderAmount']."', '', '', '" . date('YmdHis') . "', '2', '".$_SESSION['cart']['OrderItem']."-".$_SESSION['cart']['SubYear']."', 'No-Delivery-Method', '3')";

		$orderDate = date('YmdHis');
		$sql = "INSERT INTO `order` " . $key . " VALUES " . $value;
		/*echo $sql;
		exit;*/

		$count = $this -> dbconnect -> exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		$MerchantDetail = MerchantModel::getMerchant($_SESSION['merchant']['ID']);
		OrderModel::orderMail($MerchantDetail, $newID);

		$ismerchant = "1";



        }

        $Ismerchant = $ismerchant;


        $this->output = array(
            'config' => $this->config,
            'page' => array('title' => "Cheque Payment", 'template' => 'common-2-column.tpl.php'),
            'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
            'content' => $result,
            'ismerchant' => $Ismerchant,
            'content_param' => array('count' => $count),
            'meta' => array('active' => "on"));

        return $this->output;
    }

	public function CartComplete($param) {

		$status = $_GET['sid'];

		$method = $_GET['mid'];

		// Set Page Content Based on Status

		//if(isset($_SESSION['DealerMerchant'])){

			//$dealer = "1";

		//}

		if ($status == '1') {

			$title = "Order Successful";



			if(isset($_SESSION['DealerMerchant'])){

			$dealer = "1";

		    }


		} else {

			$title = "Order Not Successful";

		}

		if ($_SESSION['merchant']['ID'] != "") {

			$block = array('side_nav' => $this->module['merchant']['dir'] . 'inc/merchant/side_nav.merchant.inc.php', 'common' => "false");

		} else {

			$block = array('side_nav' => $this->module['merchant']['dir'] . 'inc/merchant/side_nav.merchant_out.inc.php', 'common' => "false");

		}

		$this -> output = array('config' => $this -> config, 'page' => array('title' => $title, 'template' => 'common-2-column.tpl.php'), 'block' => $block, /*'breadcrumb' => HTML::getBreadcrumb($this -> module_name, "", "", $this -> config, $title),*/ 'content' => $dealer, 'content_param' => array('count' => $i, 'status' => $status, 'method' => $method), 'meta' => array('active' => "on"));

		return $this -> output;

	}

    public function calculateCartQuantity()
    {
        // Get number of items in the cart
        $product_item_count = count($_SESSION['cart']['item']);

        $quantity = 0;
        for ($i=0; $i<$product_item_count; $i++)
        {
            $quantity += $_SESSION['cart']['item'][$i]['Quantity'];
        }

        $_SESSION['cart']['quantity'] = $quantity;
    }

    public function calculateCartSubTotal($param)
    {
        // Get number of items in the cart
        $product_item_count = count($_SESSION['cart']['item']);

        $subtotal = 0;
        for ($i=0; $i<$product_item_count; $i++)
        {
            $subtotal += $_SESSION['cart']['item'][$i]['Price'];
        }

        $_SESSION['cart']['subtotal'] = $subtotal;
    }

    public function calculateCartWeight()
    {
        // Get number of items in the cart
        $product_item_count = count($_SESSION['cart']['item']);

        $weight = 0;
        for ($i=0; $i<$product_item_count; $i++)
        {
            $weight += $_SESSION['cart']['item'][$i]['Weight'];
        }

        $_SESSION['cart']['weight'] = $weight;
    }

    public function calculateCartVoucher($param)
    {
        // Get number of items in the cart
        $product_item_count = count($_SESSION['cart']['item']);

        $subtotal = 0;
        for ($i=0; $i<$product_item_count; $i++)
        {
            $subtotal += $_SESSION['cart']['item'][$i]['Price'];
        }

        $_SESSION['cart']['subtotal'] = $subtotal;
    }

    public function calculateCartShipping()
    {
        // Get number of items in the cart
        $product_item_count = count($_SESSION['cart']['item']);

        $subtotal = 0;
        for ($i=0; $i<$product_item_count; $i++)
        {
            $subtotal += $_SESSION['cart']['item'][$i]['Price'];
        }

        $_SESSION['cart']['subtotal'] = $subtotal;
    }

    public function calculateCartTax($param)
    {
        // Get number of items in the cart
        $product_item_count = count($_SESSION['cart']['item']);

        $subtotal = 0;
        for ($i=0; $i<$product_item_count; $i++)
        {
            $subtotal += $_SESSION['cart']['item'][$i]['Price'];
        }

        $_SESSION['cart']['subtotal'] = $subtotal;
    }

    public function calculateCartTotal($param)
    {
        // Get number of items in the cart
        $product_item_count = count($_SESSION['cart']['item']);

        $subtotal = 0;
        for ($i=0; $i<$product_item_count; $i++)
        {
            $subtotal += $_SESSION['cart']['item'][$i]['Price'];
        }

        $_SESSION['cart']['subtotal'] = $subtotal;
    }

    public function CartUpdateAddress($param)
    {

        unset($_SESSION['merchantcart'][$param]['carrier_options']);

        $billing = $_POST['billing'];

        $delivery = $_POST['delivery'];

        $_SESSION['merchantcart'][$param]['billing'] = memberaddressModel::getMemberAddressDetails($billing);

        $_SESSION['merchantcart'][$param]['shipping'] = memberaddressModel::getMemberAddressDetails($delivery);
        //Debug::displayArray($_SESSION['cart']['totalweight']);

        // Debug::displayArray($_SESSION['merchantcart'][$param]['shipping']);
        // exit;

        $regionList = RegionModel::getRegionListDetails();

        //Debug::displayArray($regionList);

        $carrierList = CarrierModel::getCarrierList();

        $carrierweightList = CarrierModel::getCarrierList();

        // Debug::displayArray($regionList);
        // exit;
        for ($i=0; $i <$regionList['count'] ; $i++) {
            $regionList[$i]['UnformattedState'];
            $state = explode(",", $regionList[$i]['UnformattedState']);
            $state['count'] = count($state);

            for ($j=0; $j <$state['count'] ; $j++) {

                if ($state[$j] == $_SESSION['merchantcart'][$param]['shipping'][0]['UnformattedState']) {
                    //echo 'hi';
                    $id .= "'".$regionList[$i]['ID']."'".',';

                }

            }


        }



        $id = rtrim($id, ',');

        // Debug::displayArray($id);
        // exit;
        //Debug::displayArray($_SESSION['cart']['totalweight']);
        $comma = ',';

        $value = strpos($id, $comma);

        if(!empty($id) && $value !== false){


                $sql = "SELECT * FROM `carrier` WHERE RegionID IN (".$id.")";
                 //echo $sql;
                 // exit;

                $carrier = array();

                $i = 0;

                foreach ($this->dbconnect->query($sql) as $row)
                {
                    $carrier[$i] = array(
                    'ID' => $row['ID'],
                    'Name' => $row['Name'],
                    'TypeID' => CarrierTypeModel::getCarrierType($row['TypeID']),
                    'RegionID' => RegionModel::getRegion($row['RegionID']),
                    'ImageURL' => $cover_image,
                    'Free' => CRUD::isActive($row['Free']),
                    'TrackingURL' => $row['TrackingURL'],
                    'Position' => $row['Position'],
                    'Enabled' => CRUD::isActive($row['Enabled']));

                    $i += 1;
                }

                $carrier['count'] = $i;

                $carrierweightrangelist = CarrierWeightRangeModel::getCarrierWeightRangeListDetails();


                for ($i=0; $i <$carrier['count'] ; $i++) {

                    $sql = "SELECT * FROM carrier_weight_range WHERE CarrierID = '".$carrier[$i]['ID']."'";
                    //echo $sql.'  ';



                    $result = array();

                    //$j = 0;
                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                        $weightfrom = $row['WeightFrom'];
                        $weightto   = $row['WeightTo'];



                        if(($_SESSION['merchantcart'][$param]['totalweight'] >= $weightfrom) && ($_SESSION['merchantcart'][$param]['totalweight'] <= $weightto)){


                            $result = array(
                            'ID' => $row['ID'],
                            'CarrierID' => $row['CarrierID'],
                            'CarrierName' => CarrierModel::getCarrier($row['CarrierID']),
                            'RegionID' => $row['RegionID'],
                            'WeightFrom' => $row['WeightFrom'],
                            'WeightTo' => $row['WeightTo'],
                            'Cost' => $row['Cost']);

                            //$j+=1;


                        }

                        if(!empty($result)){

                            $_SESSION['merchantcart'][$param]['carrier_options'][$i] = $result;
                            $_SESSION['merchantcart'][$param]['carrier_options'] = array_values($_SESSION['merchantcart'][$param]['carrier_options']);
                        }


                    }

                    //$_SESSION['carrier_options'][$j] = $result;

                    // Debug::displayArray($_SESSION['merchantcart'][$param]['carrier_options']['count']);
                    // exit;

                }

                // Debug::displayArray($_SESSION['carrier_options']);
                // exit;
                if(empty($_SESSION['merchantcart'][$param]['carrier_options'])){
                        $_SESSION['merchantcart'][$param]['carrier_options'] = 'Carriers are not available';
                }else{
                    $_SESSION['merchantcart'][$param]['carrier_options']['count'] = count($_SESSION['merchantcart'][$param]['carrier_options']);
                }


        }elseif(empty($id)){

            $_SESSION['merchantcart'][$param]['carrier_options'] = 'All carriers are not qualify';

        }

        if ($value === false && !empty($id)) {

                $sql = "SELECT * FROM `carrier` WHERE RegionID = '".$id."'";

                $carrier = array();

                $i = 0;

                foreach ($this->dbconnect->query($sql) as $row)
                {
                    $carrier[$i] = array(
                    'ID' => $row['ID'],
                    'Name' => $row['Name'],
                    'TypeID' => CarrierTypeModel::getCarrierType($row['TypeID']),
                    'RegionID' => RegionModel::getRegion($row['RegionID']),
                    'ImageURL' => $cover_image,
                    'Free' => CRUD::isActive($row['Free']),
                    'TrackingURL' => $row['TrackingURL'],
                    'Position' => $row['Position'],
                    'Enabled' => CRUD::isActive($row['Enabled']));

                    $i += 1;
                }

                $carrier['count'] = $i;

                $carrierweightrangelist = CarrierWeightRangeModel::getCarrierWeightRangeListDetails();


                for ($i=0; $i <$carrier['count'] ; $i++) {

                    $sql = "SELECT * FROM carrier_weight_range WHERE CarrierID = '".$carrier[$i]['ID']."'";


                    $result = array();
                    //$j=0;

                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                        $weightfrom = $row['WeightFrom'];
                        $weightto   = $row['WeightTo'];



                        if(($_SESSION['merchantcart'][$param]['totalweight'] >= $weightfrom) && ($_SESSION['merchantcart'][$param]['totalweight'] <= $weightto)){


                            $result = array(
                            'ID' => $row['ID'],
                            'CarrierID' => $row['CarrierID'],
                            'CarrierName' => CarrierModel::getCarrier($row['CarrierID']),
                            'RegionID' => $row['RegionID'],
                            'WeightFrom' => $row['WeightFrom'],
                            'WeightTo' => $row['WeightTo'],
                            'Cost' => $row['Cost']);

                            // $j+=1;
//
                            // $_SESSION['carrier_options'] = $result;
                        }


                        if(!empty($result)){

                            $_SESSION['merchantcart'][$param]['carrier_options'][$i] = $result;
                            $_SESSION['merchantcart'][$param]['carrier_options'] = array_values($_SESSION['merchantcart'][$param]['carrier_options']);
                        }

                    }





                }

                if(empty($_SESSION['merchantcart'][$param]['carrier_options'])){
                        $_SESSION['merchantcart'][$param]['carrier_options'] = 'Carriers are not available';
                }else{

                        $_SESSION['merchantcart'][$param]['carrier_options']['count'] = count($_SESSION['merchantcart'][$param]['carrier_options']);

                }




        }

        // Debug::displayArray($_SESSION['carrier_options']);
        // exit;

        $ok = "1";


        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Updating Order...", 'template' => 'common.tpl.php'),
        'merchantID' => $param,
        'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;

    }

    public function CartUpdateQuantity($param)
    {


        $quantityID = $_POST['quantityID'];
        $updatequantity = $_POST['updatequantity'];
        $counter = $_POST['counter'];
        $merchantID = $_POST['merchantID'];
        if($_POST['delete']=='Delete'){
            // if (isset($_SESSION['cart']['originaltotal']) && $_SESSION['cart']['originaltotal']!='') {
                // $_SESSION['cart']['total'] = $_SESSION['cart']['originaltotal'];
            // }

            //$_SESSION['cart']['item'][$counter]['product'][$counter]['ID'];
              //for ($i=0; $i<$_SESSION['cart']['count']; $i++) {
                $_SESSION['merchantcart'][$merchantID]['total'] = $_SESSION['merchantcart'][$merchantID]['total']-$_SESSION['merchantcart']['item'][$merchantID][$counter]['subtotal'];
                $_SESSION['merchantcart'][$merchantID]['totalquantity'] = $_SESSION['merchantcart'][$merchantID]['totalquantity']-$_SESSION['merchantcart']['item'][$merchantID][$counter]['Quantity'];
                $_SESSION['merchantcart'][$merchantID]['totalweight'] = $_SESSION['merchantcart'][$merchantID]['totalweight'] - $_SESSION['merchantcart']['item'][$merchantID][$counter]['subweight'];
                unset($_SESSION['merchantcart']['item'][$merchantID][$counter]);
                //unset($_SESSION['cart']['item'][$counter]['product'][$counter]);

                $_SESSION['merchantcart'][$merchantID]['count'] = count($_SESSION['merchantcart']['item'][$merchantID]);

                $_SESSION['merchantcart'][$merchantID]['counter']-=1;


                //echo $_SESSION['cart']['item'][$i];

                // $i-1;
                // $_SESSION['cart']['item'][$i]-=1;
                // $_SESSION['cart']['item'][$i]['product'][$i]-=1;



                    $_SESSION['merchantcart'][$merchantID]['item'] = array_values($_SESSION['merchantcart']['item'][$merchantID]);



                // Debug::displayArray($_SESSION['merchantcart']['item']);
                // exit;

                //$_SESSION['cart']['item'][$i]['product'][$i] = array_values($_SESSION['cart']['item'][$i]['product'][$i]);
                //$_SESSION['cart']['item'][$i]['product'][$i] = array_values($_SESSION['cart']['item'][$i]['product'][$i]);
              //}
              //ProductModel::getProductInfo($productid = NULL,$quantityID = NULL, )

                 // for ($i=0; $i<$_SESSION['cart']['count']; $i++) {
                    // // if($i==$_SESSION['cart']['count']){
                        // // $_SESSION['cart']['item'][$i]['product'][$i]=$_SESSION['cart']['count'];
                    // // }
// //
                    // //$_SESSION['cart']['item'][$i]['product'][$i] = array_values($_SESSION['cart']['item'][$i]['product'][$i]);
                    // // echo $_SESSION['cart']['item'][$i]['product'];
                    // // echo $_SESSION['cart']['item'][$i]['product'][$i]['ProductImage'][0]['ImageURLThumb'];
                    // // echo $_SESSION['cart']['item'][$i]['product'][$i]['ShortDesc'];
                    // // // // $_SESSION['cart']['item'][$i]['product'][$i]['SKU'];
                    // // // // $_SESSION['cart']['item'][$i]['product'][$i]['Quantity'];
                    // // // // $_SESSION['cart']['item'][$i]['product'][$i]['Price'];
                    // // // // $_SESSION['cart']['item'][$i]['product'][$i]['Brand'];
                    // // // // $_SESSION['cart']['item'][$i]['product'][$i]['subtotal'];
                // }
// //
                // Debug::displayArray($_SESSION);
                // exit;
        }
//

        // Debug::displayArray($_SESSION['cart']['item']);
        // exit;
        for ($i=0; $i<$_SESSION['merchantcart'][$merchantID]['count']; $i++) {
            $_SESSION['merchantcart']['item'][$merchantID][$i]['ID'];
        //if($_POST['update']=='Update Quantity'){
            if($_SESSION['merchantcart']['item'][$merchantID][$i]['ID']==$quantityID){
                $_SESSION['merchantcart'][$merchantID]['totalquantity'] = $_SESSION['merchantcart'][$merchantID]['totalquantity'] - $_SESSION['merchantcart']['item'][$merchantID][$i]['Quantity'];
                $_SESSION['merchantcart'][$merchantID]['total'] = $_SESSION['merchantcart'][$merchantID]['total']-$_SESSION['merchantcart']['item'][$merchantID][$i]['subtotal'];
                //$_SESSION['cart']['totalquantity'] = $_SESSION['cart']['totalquantity']-$_SESSION['cart']['item'][$i]['product'][$i]['subtotal'];
                $_SESSION['merchantcart']['item'][$merchantID][$i]['Quantity'] = $updatequantity;
                $_SESSION['merchantcart']['item'][$merchantID][$i]['subtotal'] = $_SESSION['merchantcart']['item'][$merchantID][$i]['Quantity']*$_SESSION['merchantcart']['item'][$merchantID][$i]['Price'];
                $_SESSION['merchantcart'][$merchantID]['total'] = $_SESSION['merchantcart'][$merchantID]['total']+$_SESSION['merchantcart']['item'][$merchantID][$i]['subtotal'];
                $_SESSION['merchantcart'][$merchantID]['totalquantity'] = $_SESSION['merchantcart'][$merchantID]['totalquantity']+$_SESSION['merchantcart']['item'][$merchantID][$i]['Quantity'];
                //$_SESSION['cart']['totalquantity'] = $_SESSION['cart']['total']+=$_SESSION['cart']['item'][$i]['product'][$i]['subtotal'];
                $_SESSION['merchantcart'][$merchantID]['totalweight'] -= $_SESSION['merchantcart']['item'][$merchantID][$i]['subweight'];
                $_SESSION['merchantcart']['item'][$merchantID][$i]['subweight'] = $_SESSION['merchantcart']['item'][$merchantID][$i]['Quantity'] * $_SESSION['merchantcart']['item'][$merchantID][$i]['Weight'];
                $_SESSION['merchantcart'][$merchantID]['totalweight'] += $_SESSION['merchantcart']['item'][$merchantID][$i]['subweight'];



               }



        }

        //for ($i=0; $i < $_SESSION['cart']['count']; $i++) {

        //}

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "", 'template' => 'common-1-column.tpl.php'),
        'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function CartAddress($param)
    {
        $result = memberaddressModel::getMemberAddressByMemberID($_SESSION['member']['ID']);
        $crud = new CRUD();
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Address Information", 'template' => 'common-1-column.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['order']['dir'].'inc/cart/address.inc.php'),
        'result'=> $result,
        'content_param' => array('count' => $count, 'newID' => $newID),
        'merchantID' => $param,
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function CartShipping($param)
    {
        // $carrierweightrange = CarrierWeightRangeModel::getCarrierWeightRangeListDetails();
//
        // Debug::displayArray($carrierweightrange);
//
        // exit;


        if($this->config['shipping_type']=='2'){
            $carrierweightrange = CarrierWeightRangeModel::getCarrierWeightRangeListDetails();

            for ($i=0; $i<$carrierweightrange['count']; $i++) {
              if($_SESSION['merchantcart']['item'][$param]['totalweight']>=$carrierweightrange[$i]['WeightFrom'] && $_SESSION['merchantcart']['item'][$param]['totalweight']<=$carrierweightrange[$i]['WeightTo']){
                  //$carrierweightcost = $carrierweightrange[$i]['Cost'];
                 // Debug::displayArray($carrierpricecost);
              }

                // $_SESSION['merchantcart']['item'][$param]['weight_range_shipping_cost'] = $carrierweightcost;
                // $shipping_cost = $_SESSION['merchantcart']['item'][$param]['weight_range_shipping_cost'];

            }

        }elseif($this->config['shipping_type']=='1'){

            $carrierpricerange = CarrierPriceRangeModel::getCarrierPriceRangeList();

            for ($i=0; $i<$carrierpricerange['count']; $i++) {
              if($_SESSION['merchantcart']['item'][$param]['total']>=$carrierpricerange[$i]['PriceFrom'] && $_SESSION['merchantcart']['item'][$param]['total']<=$carrierpricerange[$i]['PriceTo']){
                  //$carrierpricecost = $carrierpricerange[$i]['Cost'];
                  //$mssg = "$i is hi";
                  //Debug::displayArray($carrierpricecost);
              }

                //$_SESSION['merchantcart']['item'][$param]['price_range_shipping_cost'] = $carrierpricecost;
                 //$shipping_cost = $_SESSION['merchantcart']['item'][$param]['price_range_shipping_cost'];
            }
        }
        // echo $carrierpricerange[3]['PriceTo'];
        // echo $carrierpricerange[3]['Cost'];
        // echo 'carrier price cost '.$carrierpricecost.'<br />'.$_SESSION['cart']['total'];
        // exit;
        // echo $mssg;
        // exit;
        // echo $_SESSION['cart']['total'];
        // Debug::displayArray($_SESSION);
        // exit;

        //exit;

        //$_SESSION['cart']['shipping'] = ;
        $result = CarrierModel::getCarrierList();
        $crud = new CRUD();
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Carrier Information", 'template' => 'common-1-column.tpl.php'/*, 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['order']['dir'].'inc/cart/shipping.inc.php'*/),
        'result'=> $result,
        'merchantID' => $param,
        'shipping_cost' => $shipping_cost,
        'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function CartShippingText($param)
    {
        $result = memberaddressModel::getMemberAddressDetails($param);
        $crud = new CRUD();
        //Debug::displayArray($result);
        $this->output = array(
        'config' => $this->config,
        //'page' => array('title' => "Shipping Information", 'template' => 'common-1-column.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['order']['dir'].'inc/cart/shipping.inc.php',),
        'content'=> $result,
        'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
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
			$_SESSION['order_'.__FUNCTION__] = "";
			
			
			$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=");
			$query_condition .= $crud->queryCondition("DeliveryMethod",$_POST['DeliveryMethod'],"LIKE");
			$query_condition .= $crud->queryCondition("Item",$_POST['Item'],"LIKE");
			$query_condition .= $crud->queryCondition("DealerTotal",$_POST['DealerTotal'],"LIKE");
			$query_condition .= $crud->queryCondition("DealerDiscount",$_POST['DealerDiscount'],"LIKE");
			$query_condition .= $crud->queryCondition("PaymentMethod",$_POST['PaymentMethod'],"LIKE");
			$query_condition .= $crud->queryCondition("OrderDate",Helper::dateDisplaySQL($_POST['OrderDateFrom']),">=");
			$query_condition .= $crud->queryCondition("OrderDate",Helper::dateDisplaySQL($_POST['OrderDateTo']),"<=");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"=");

			$_SESSION['order_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['order_'.__FUNCTION__]['param']['Item'] = $_POST['Item'];
			$_SESSION['order_'.__FUNCTION__]['param']['DealerTotal'] = $_POST['DealerTotal'];
			$_SESSION['order_'.__FUNCTION__]['param']['DealerDiscount'] = $_POST['DealerDiscount'];
			$_SESSION['order_'.__FUNCTION__]['param']['DeliveryMethod'] = $_POST['DeliveryMethod'];
			$_SESSION['order_'.__FUNCTION__]['param']['PaymentMethod'] = $_POST['PaymentMethod'];
			$_SESSION['order_'.__FUNCTION__]['param']['OrderDateFrom'] = $_POST['OrderDateFrom'];
			$_SESSION['order_'.__FUNCTION__]['param']['OrderDateTo'] = $_POST['OrderDateTo'];
			$_SESSION['order_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['order_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['order_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['order_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['order_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM `order` ".$_SESSION['order_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/order/index';
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

		$sql = "SELECT * FROM `order` ".$_SESSION['order_'.__FUNCTION__]['query_condition']." ORDER BY OrderDate ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantName' => MerchantModel::getMerchant($row['MerchantID'], "Name"),
			'Item' => $row['Item'],
			'DealerTotal' => $row['DealerTotal'],
			'DealerDiscount' => $row['DealerDiscount'],
			'Subtotal' => $row['Subtotal'],
			'Discounts' => $row['Discounts'],
			'Charges' => $row['Charges'],
			'Shipping' => $row['Shipping'],
			'Tax' => $row['Tax'],
			'Total' => $row['Total'],
			'OrderDate' => Helper::dateSQLToLongDisplay($row['OrderDate']),
			'DeliveryMethod' => DeliveryMethodModel::getDeliveryMethod($row['DeliveryMethod'], "Name"),
			'Remarks' => $row['Remarks'],
			'PaymentMethod' => PaymentMethodModel::getPaymentMethod($row['PaymentMethod'], "Name"),
			'Status' => OrderStatusModel::getOrderStatus($row['Status'], "Label"));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['order']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Orders", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['order']['dir'].'inc/admin/index.inc.php', 'order_delete' => $_SESSION['admin']['order_delete']),
		'block' => array('side_nav' => $this->module['order']['dir'].'inc/admin/side_nav.order_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'deliverymethod_list' => DeliveryMethodModel::getDeliveryMethodList(), 'paymentmethod_list' => PaymentMethodModel::getPaymentMethodList(), 'orderstatus_list' => OrderStatusModel::getOrderStatusList(), 'merchant_list' => MerchantModel::getMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['order_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['order']['name'], "Link" => $this->module['order']['admin_url']),
            array("Title" => "Create Order", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Order", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['order']['dir'].'inc/admin/add.inc.php', 'order_add' => $_SESSION['admin']['order_add']),
		'block' => array('side_nav' => $this->module['order']['dir'].'inc/admin/side_nav.order_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'deliverymethod_list' => DeliveryMethodModel::getDeliveryMethodList(), 'paymentmethod_list' => PaymentMethodModel::getPaymentMethodList(), 'orderstatus_list' => OrderStatusModel::getOrderStatusList(), 'merchant_list' => MerchantModel::getMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['order_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(Subtotal, Discounts, Charges, Shipping, Tax, Total, OrderDate, DeliveryMethod, Remarks, PaymentMethod, Status)";
		$value = "('".$_POST['Subtotal']."', '".$_POST['Discounts']."', '".$_POST['Charges']."', '".$_POST['Shipping']."', '".$_POST['Tax']."', '".$_POST['Total']."', '".Helper::dateDisplaySQL($_POST['OrderDate'])."', '".$_POST['DeliveryMethod']."', '".$_POST['Remarks']."', '".$_POST['PaymentMethod']."', '".$_POST['Status']."')";

		$sql = "INSERT INTO `order` ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Order...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM `order` WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Subtotal' => $row['Subtotal'],
			'Discounts' => $row['Discounts'],
			'DealerTotal' => $row['DealerTotal'],
			'DealerDiscount' => $row['DealerDiscount'],
			'Description' => $row['Description'],
			'Item' => $row['Item'],
			'Charges' => $row['Charges'],
			'Shipping' => $row['Shipping'],
			'Tax' => $row['Tax'],
			'Total' => $row['Total'],
			'OrderDate' => Helper::dateSQLToDisplay($row['OrderDate']),
			'DeliveryMethod' => $row['DeliveryMethod'],
			'Remarks' => $row['Remarks'],
			'PaymentMethod' => $row['PaymentMethod'],
			'Status' => $row['Status']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['order']['name'], "Link" => $this->module['order']['admin_url']),
            array("Title" => "Edit Order", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Order", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['order']['dir'].'inc/admin/edit.inc.php', 'order_add' => $_SESSION['admin']['order_add'], 'order_edit' => $_SESSION['admin']['order_edit']),
		'block' => array('side_nav' => $this->module['order']['dir'].'inc/admin/side_nav.order.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'deliverymethod_list' => DeliveryMethodModel::getDeliveryMethodList(), 'paymentmethod_list' => PaymentMethodModel::getPaymentMethodList(), 'orderstatus_list' => OrderStatusModel::getOrderStatusList(), 'merchant_list' => MerchantModel::getMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['order_add']);
		unset($_SESSION['admin']['order_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		//Debug::displayArray($param);
		//exit;
		//$MerchantID = OrderModel::getOrder($param, "MerchantID");
		
		//$MerchantID = MerchantModel::getMerchant($MerchantID);
		
		$sql = "UPDATE `order` SET Subtotal='".$_POST['Subtotal']."', Discounts='".$_POST['Discounts']."', Charges='".$_POST['Charges']."', Shipping='".$_POST['Shipping']."', Tax='".$_POST['Tax']."', Total='".$_POST['Total']."', OrderDate='".Helper::dateDisplaySQL($_POST['OrderDate'])."', DeliveryMethod='".$_POST['DeliveryMethod']."', Remarks='".$_POST['Remarks']."', PaymentMethod='".$_POST['PaymentMethod']."', Status='".$_POST['Status']."' WHERE ID='".$param."'";
		
		if($_POST['Status'] == 2){
		$MerchantID = OrderModel::getOrder($param, "MerchantID");
		MerchantModel::updateMerchant($MerchantID, $_POST['Remarks']);
		MerchantModel::MerchantManualChanged($MerchantID);
		/*$TypeID = MerchantModel::getMerchant($MerchantID, "TypeID");
		echo $TypeID;
		exit;*/
		}
		
		$status = OrderModel::checkOrderStatus($param);

		/*if($status[0]['Status'] != $_POST['Status']){
		
		
		}*/
		
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$MerchantID = OrderModel::getOrder($param, "MerchantID");
		
		$MerchantID = MerchantModel::getMerchant($MerchantID);
			
		//$param = OrderModel::getOrder($param);
		OrderModel::orderMail($MerchantID, $param);

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Order...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM `order` WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Order...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getOrder($param, $column = "")
	{
		/*echo  $param;
		exit;*/
		$crud = new CRUD();

		$sql = "SELECT * FROM `order` WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Item' => $row['Item'],
			'MerchantID' => $row['MerchantID'],
			'MerchantName' => MerchantModel::getMerchant($row['MerchantID'], "Name"),
			'Subtotal' => $row['Subtotal'],
			'Description' => $row['Description'],
			'Discounts' => $row['Discounts'],
			'Charges' => $row['Charges'],
			'Shipping' => $row['Shipping'],
			'Tax' => $row['Tax'],
			'Total' => $row['Total'],
			'OrderDate' => Helper::dateSQLToLongDisplay($row['OrderDate']),
			'DeliveryMethod' => $row['DeliveryMethod'],
			'Remarks' => $row['Remarks'],
			'DealerTotal' => $row['DealerTotal'],
			'DealerDiscount' => $row['DealerDiscount'],
			'PaymentMethod' => $row['PaymentMethod'],
			'PaymentMethodLabel' => PaymentMethodModel::getPaymentMethod($row['PaymentMethod'], "Name"),
			'Status' => $row['Status'],
			'StatusLabel' => OrderStatusModel::getOrderStatus($row['Status'], "Label"));

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

public function getOrderByUser($param, $column = "")
	{
		/*echo  $param;
		exit;*/
		$crud = new CRUD();

		$sql = "SELECT * FROM `order` WHERE MerchantID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Item' => $row['Item'],
			'MerchantID' => $row['MerchantID'],
			'MerchantName' => MerchantModel::getMerchant($row['MerchantID'], "Name"),
			'Subtotal' => $row['Subtotal'],
			'Description' => $row['Description'],
			'Discounts' => $row['Discounts'],
			'Charges' => $row['Charges'],
			'Shipping' => $row['Shipping'],
			'Tax' => $row['Tax'],
			'Total' => $row['Total'],
			'OrderDate' => Helper::dateSQLToLongDisplay($row['OrderDate']),
			'DeliveryMethod' => $row['DeliveryMethod'],
			'Remarks' => $row['Remarks'],
			'DealerTotal' => $row['DealerTotal'],
			'DealerDiscount' => $row['DealerDiscount'],
			'PaymentMethod' => $row['PaymentMethod'],
			'PaymentMethodLabel' => PaymentMethodModel::getPaymentMethod($row['PaymentMethod'], "Name"),
			'Status' => $row['Status'],
			'StatusLabel' => OrderStatusModel::getOrderStatus($row['Status'], "Label"));

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

	public function getOrderList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM `order` ORDER BY OrderDate ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Subtotal' => $row['Subtotal'],
			'Discounts' => $row['Discounts'],
			'Charges' => $row['Charges'],
			'Shipping' => $row['Shipping'],
			'Tax' => $row['Tax'],
			'Total' => $row['Total'],
			'OrderDate' => Helper::dateSQLToLongDisplay($row['OrderDate']),
			'DeliveryMethod' => $row['DeliveryMethod'],
			'Remarks' => $row['Remarks'],
			'PaymentMethod' => $row['PaymentMethod'],
			'Status' => $row['Status']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function checkOrderStatus($param){

		$sql = "SELECT Status FROM `order` WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{

			$result[$i] = array('Status' => $row['Status']);

			$i += 1;


		}

		/*if($param == $result[0]['Status']){

			$result = '1';

		}else{

			$result = '0';

		}*/

		return $result;



	}

	public function orderMail($param, $orderID){

		        $order = OrderModel::getOrder($orderID);


		        $mailer = new BaseMailer();

				$mailer -> From = "no-reply@aseanfnb.valse.com.my";

				$mailer -> AddReplyTo = "admin@baseanfnb.valse.com.my";

				$mailer -> FromName = "aseanF&B";

				$mailer -> Subject = "[aseanF&B] Order Confirmation #" . $orderID;

				$mailer -> AddAddress($param['Email'], '');

				$mailer -> AddBCC('decweng.chan@valse.com.my', '');

				$mailer -> IsHTML(true);

				$mailer -> Body = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


                  <title>Order Confirmation #' . $orderID . '</title>





                  <div style="width: 550px; border:1px solid #ddd; padding:10px; margin:10px">


                  <table style="font-family:Arial,sans-serif; font-size:12px;


                    color:#333; width: 550px;">


                    <tbody>


                      <tr>


                        <td align="left" style="font-size:16px; font-weight:bold; text-transform:uppercase"><img src="http://bitdstrategy.com/themes/valse/img/logo_mail.png" /></td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="left">Hello <strong style="color:#FB7D00;">' . $param['Name'] . '</strong>,<br /><br />Thank you for your payment. Your order has been processed. ' . $backorder_remarks . '<br />&nbsp;</td>


                      </tr>


                      <tr>


                        <td style="background-color:#333; color:#FFF; font-size:


                          12px; font-weight:bold; padding: 0.5em


                          1em;" align="left">Order details</td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="left" colspan="2" style="color:#333; padding:0.6em 0.8em;"> Order: <strong><span


                              style="color:#FB7D00;">#' . $orderID . '</span></strong> placed on <strong>' . $order['OrderDate'] . '</strong>


                        </td>
						<td align="left" colspan="2" style="color:#333; padding:0.6em 0.8em;"> Order Status: ' . OrderStatusModel::getOrderStatus($order['Status'], "Label") . '


                        </td>

                      </tr>


                      <tr>


                        <td align="left">


                          <table style="width:100%; font-family:Arial,sans-serif; font-size:12px; color:#374953;">


                           <tbody>


                              <tr>


                                <td colspan="2" style="background-color:#efefef; color:#333; padding:0.6em 0.8em;"><strong>' . $order['Item'] . '</strong><br />


                                    ' . $order['Description'] . '


                                </td>


                              </tr>


                              <tr style="text-align:right; font-weight:bold;">


                                <td style="width:80%; background-color:#333; color:#FFFFFF; padding:0.6em 0.8em;">Total paid</td>


                                <td style="background-color:#333; color:#fff; padding:0.6em 0.8em;">RM' . $order['Total'] . '</td>


                              </tr>


                            </tbody>


                          </table>


                        </td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="center">You can review your orders in the <a moz-do-not-send="true"


                            href="'.$this->config['SITE_URL'].'/merchant/order/index"


                            style="color:#FB7D00; font-weight:bold;


                            text-decoration:none;">"Order History"</a> page</td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>

						<td>'.$this->config['ANDROID_APP'].'</td>
						<td>'.$this->config['iOS_APP'].'</td>
                        <td style="border-top: 1px solid #ddd;" align="center"> <a moz-do-not-send="true" href="" style="color:#FB7D00; font-weight:bold; text-decoration:none;">aseanF&B</a>


                        </td>


                      </tr>


                    </tbody>


                  </table>


                  </div>';

				$mailer -> Send();






	}



	public function PdfGenerator($param, $user)
	{

		require_once('lib/fpdf/fpdf.php');

		$result = OrderModel::getOrder($param);
		/*Debug::displayArray($result);*/

		$fpdf = new FPDF();

		$fpdf->SetMargins(15, 15, 15);

		$fpdf->SetAutoPageBreak(true, 0);

		$fpdf->AliasNbPages();



		$fpdf->AddPage();


		$fpdf->SetFontSize(10);

		$fpdf->SetFont('Helvetica', '');

		if($user == "merchant"){

			$fpdf->Cell(30, 6, 'Order ID', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['ID'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Merchant', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['MerchantName'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Description', 0, 0, 'L', FALSE);

			$fpdf->MultiCell(100, 6, $result['Description'], 0, 'L');

			$fpdf->Cell(30, 6, 'Order Item', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Item'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Subtotal', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Subtotal'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Discounts', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Discounts'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Charges', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Charges'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Shipping', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Shipping'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Tax', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Tax'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Total', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Total'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Order Date', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['OrderDate'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Delivery Method', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['DeliveryMethod'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Remarks', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Remarks'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Payment Method', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['PaymentMethodLabel'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Status', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['StatusLabel'], 0, 1, 'L', FALSE);

			$fpdf->Output('Order.pdf', 'D');

		}elseif($user == "dealer"){
			/*echo 'hi';
			echo $result['ID'];
			exit;*/
			$fpdf->Cell(30, 6, 'Order ID', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['ID'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Merchant', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['MerchantName'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Description', 0, 0, 'L', FALSE);

			$fpdf->MultiCell(100, 6, $result['Description'], 0, 'L');

			$fpdf->Cell(30, 6, 'Order Item', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Item'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Subtotal', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Subtotal'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Discounts', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Discounts'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Charges', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Charges'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Shipping', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Shipping'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Tax', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Tax'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Total', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Total'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Dealer Total', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['DealerTotal'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Dealer Discount', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['DealerDiscount'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Order Date', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['OrderDate'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Delivery Method', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['DeliveryMethod'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Remarks', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['Remarks'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Payment Method', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['PaymentMethodLabel'], 0, 1, 'L', FALSE);

			$fpdf->Cell(30, 6, 'Status', 0, 0, 'L', FALSE);

			$fpdf->Cell(30, 6, $result['StatusLabel'], 0, 1, 'L', FALSE);

			$fpdf->Output('Order.pdf', 'D');
		}

		$fpdf->SetXY(190,290);
		$fpdf->Cell(30, 4, 'Page ' . $fpdf->PageNo(), 0, 1);





		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Exporting..."),
		'content' => $result,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MerchantExport($param)
	{
		OrderModel::PdfGenerator($param, $merchant = "merchant");

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Exporting..."),
		'content' => $result,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerExport($param)
	{
		OrderModel::PdfGenerator($param, $dealer = "dealer");

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
		$sql = "SELECT * FROM `order` ".$_SESSION['order_'.$param]['query_condition']." ORDER BY OrderDate ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Orders";
		$result['header'] = $this->config['SITE_NAME']." | Orders (" . date('Y-m-d H:i:s') . ")\n\nID, Subtotal, Discounts, Charges, Shipping, Tax, Total, Order Date, Delivery Method, Remarks, Payment Method, Status";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['Subtotal']."\",";
			$result['content'] .= "\"".$row['Discounts']."\",";
			$result['content'] .= "\"".$row['Charges']."\",";
			$result['content'] .= "\"".$row['Shipping']."\",";
			$result['content'] .= "\"".$row['Tax']."\",";
			$result['content'] .= "\"".$row['Total']."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['OrderDate'])."\",";
			$result['content'] .= "\"".DeliveryMethodModel::getDeliveryMethod($row['DeliveryMethod'])."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Remarks'])."\",";
			$result['content'] .= "\"".PaymentMethodModel::getPaymentMethod($row['PaymentMethod'])."\",";
			$result['content'] .= "\"".OrderStatusModel::getOrderStatus($row['Status'])."\"\n";

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