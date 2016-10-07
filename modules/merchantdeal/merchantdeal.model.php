<?php
// Require required models
Core::requireModel('ad');
Core::requireModel('listing');
Core::requireModel('merchant');
Core::requireModel('dealer');

class MerchantDealModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['merchantdeal'] = array(
        'name' => "Merchant Deal",
        'dir' => "modules/merchantdeal/",
        'default_url' => "/main/merchantdeal/index",
        'merchant_url' => "/merchant/merchantdeal/index",
        'admin_url' => "/admin/merchantdeal/index",
		"dealer_url" =>"/dealer/merchantdeal/index");
		
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
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM merchant_deal WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/merchantdeal/index';
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

		$sql = "SELECT * FROM merchant_deal WHERE Enabled = 1 ORDER BY ListingID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'cover');
			}

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'ListingID' => $row['ListingID'],
			'ImageURL' => $cover_image,
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantdeal']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Merchant Deals", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'ListingID' => $row['ListingID'],
			'ImageURL' => $row['ImageURL'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantdeal']['name'], "Link" => $this->module['merchantdeal']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/main/view.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i),
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
			$_SESSION['merchantdeal_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::datetimeDisplaySQL($_POST['DateExpiryFrom']),">=");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::datetimeDisplaySQL($_POST['DateExpiryTo']),"<=");

			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryFrom'] = $_POST['DateExpiryFrom'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryTo'] = $_POST['DateExpiryTo'];

			// Set Query Variable
			$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['merchantdeal_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['merchantdeal_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['merchantdeal_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM merchant_deal ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/merchant/merchantdeal/index';
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

		$sql = "SELECT * FROM merchant_deal ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition']." ORDER BY ID DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'thumb');
			}

            $listing = ListingModel::getListing($row['ListingID']);

			$result[$i] = array(
			'ID' => $row['ID'],
			//'ListingID' => $row['ListingID'],
            'ListingID' => $listing['ID']." - ".$listing['Name'],
			'ImageURL' => $cover_image,
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::datetimeSQLToLongDisplay($row['DateExpiry']),
			'Limit' => MerchantDealModel::getMerchantDealLimitStatus($_SESSION['merchant']['ID'])
			);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['merchantdeal']['name'], "Link" => ""),
            //array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Merchant Deals", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/merchant/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'listing_list' => ListingModel::getListingList(), 'merchantdeal_list' => MerchantDealModel::getMerchantDealList()),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MerchantView($param)
	{
		$sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ListingID' => $row['ListingID'],
			'ImageURL' => $row['ImageURL'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::datetimeSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['merchantdeal']['name'], "Link" => $this->module['merchantdeal']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/main/view.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MerchantAdd()
	{
        // Set breadcrumb
        
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['merchantdeal']['name'], "Link" => $this->module['merchantdeal']['merchant_url']),
            array("Title" => "Create Merchant Deal", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Merchant Deal", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/merchant/add.inc.php', 'merchantdeal_add' => $_SESSION['merchant']['merchantdeal_add']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantdeal_add']);

		return $this->output;
	}

	public function MerchantAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"merchantdeal");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            $file_location['ImageURL'] = "";
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],66,66,'thumb');
            Image::generateImage($file_location['ImageURL'],145,145,'cover');
            Image::generateImage($file_location['ImageURL'],300,300,'medium');
                    }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE merchant_deal SET Cover='0' WHERE ListingID='".$_POST['ListingID']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(MerchantID, ListingID, ImageURL, Name, Description, DateExpiry)";
		$value = "('".$_SESSION['merchant']['ID']."', '".$_POST['ListingID']."', '".$file_location['ImageURL']."', '".$_POST['Name']."', '".$_POST['Description']."', '".Helper::datetimeDisplaySQL($_POST['DateExpiry'])."')";

		$sql = "INSERT INTO merchant_deal ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Merchant Deal...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MerchantEdit($param)
	{
		$sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['ImageURL'],'thumb');
            }

			$result[$i] = array(
			'ID' => $row['ID'],
			'ListingID' => $row['ListingID'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::datetimeSQLToDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['merchantdeal']['name'], "Link" => $this->module['merchantdeal']['merchant_url']),
            array("Title" => "Edit Merchant Deal", "Link" => "")
        );
		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Merchant Deal",
					'template' => 'common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/merchant/edit.inc.php',
					'merchantdeal_add' => $_SESSION['merchant']['merchantdeal_add'],
                    'merchantdeal_edit' => $_SESSION['merchant']['merchantdeal_edit']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['merchantdeal_add']);
		unset($_SESSION['merchant']['merchantdeal_edit']);

		return $this->output;
	}

	public function MerchantEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"merchantdeal");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['ImageURLRemove']==1)
            {
                $file_location['ImageURL'] = "";
                Image::deleteImage($_POST['ImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['ImageURL'] = $_POST['ImageURLCurrent'];
            }
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],66,66,'thumb');
            Image::generateImage($file_location['ImageURL'],145,145,'cover');
            Image::generateImage($file_location['ImageURL'],300,300,'medium');
            Image::deleteImage($_POST['ImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE merchant_deal SET Cover='0' WHERE ListingID='".$_POST['ListingID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE merchant_deal SET MerchantID='".$_SESSION['merchant']['ID']."', ListingID='".$_POST['ListingID']."', ImageURL='".$file_location['ImageURL']."', Name='".$_POST['Name']."', Description='".$_POST['Description']."', DateExpiry='".Helper::datetimeDisplaySQL($_POST['DateExpiry'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Merchant Deal...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MerchantDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'ImageURL' => $row['ImageURL']);

            $i += 1;
        }

        Image::deleteImage($result[0]['ImageURL']);
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'thumb'));
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'cover'));
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'medium'));

		// Delete entry from table
		$sql = "DELETE FROM merchant_deal WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Merchant Deal...", 'template' => 'common.tpl.php'),
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
			$_SESSION['merchantdeal_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("md.ListingID",$_POST['ListingID'],"=",1);
			$query_condition .= $crud->queryCondition("md.MerchantID",$_POST['MerchantID'],"=");
			$query_condition .= $crud->queryCondition("md.Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("md.Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("md.DateExpiry",Helper::dateTimeDisplaySQL($_POST['DateExpiryFrom']),">=");
			$query_condition .= $crud->queryCondition("md.DateExpiry",Helper::dateTimeDisplaySQL($_POST['DateExpiryTo']),"<=");

			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryFrom'] = $_POST['DateExpiryFrom'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryTo'] = $_POST['DateExpiryTo'];

			// Set Query Variable
			$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['merchantdeal_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['merchantdeal_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['merchantdeal_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM merchant_deal AS md , merchant AS m WHERE m.ID = md.MerchantID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'];
		/*echo $query_count;
		exit;*/
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/dealer/merchantdeal/index';
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

		$sql = "SELECT m.ID AS m_ID, m.DealerID AS m_DealerID, md.ID AS md_ID, md.ListingID AS md_ListingID, md.MerchantID AS md_MerchantID, md.ImageURL AS md_ImageURL, md.Name AS md_Name, md.Description AS md_Description, md.DateExpiry AS md_DateExpiry FROM merchant_deal AS md, merchant AS m  WHERE m.ID = md.MerchantID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition']." ORDER BY md_ListingID ASC, md_ImageURL DESC LIMIT $start, $limit";
		/*echo $sql;
		exit;*/
		$result = array();
		$limit = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['md_ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['md_ImageURL'],'thumb');
			}

            $listing = ListingModel::getListing($row['md_ListingID']);

			$result[$i] = array(
			'ID' => $row['md_ID'],
			//'ListingID' => $row['md_ListingID'],
			'ListingID' => $listing['ID']." - ".$listing['Name'],
            'MerchantID' => MerchantModel::getMerchant($row['md_MerchantID'], $column = "Name"),
			'ImageURL' => $cover_image,
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateTimeSQLToLongDisplay($row['md_DateExpiry']));

			
			$i += 1;
		
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['merchantdeal']['name'], "Link" => ""),
            //array("Title" => $result[0]['Title'], "Link" => "")
        );

		//$limit = $this->getMerchantDealLimitStatus($param);

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Dealer Deals", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/dealer/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'listing_list' => ListingModel::getListingList(), 'merchant_list' => MerchantModel::getDealerMerchantList()),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerView($param)
	{
		$sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ListingID' => $row['ListingID'],
			'ImageURL' => $row['ImageURL'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateTimeSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['default_url']),
            array("Title" => $this->module['merchantdeal']['name'], "Link" => $this->module['merchantdeal']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/main/view.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.merchant.inc.php', 'common' => "false"),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerAdd()
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['merchantdeal']['name'], "Link" => $this->module['merchantdeal']['dealer_url']),
            array("Title" => "Add", "Link" => "")
        );
		
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Dealer Deal", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/dealer/add.inc.php', 'merchantdeal_add' => $_SESSION['dealer']['merchantdeal_add']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'merchant_list' => MerchantModel::getDealerMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['merchantdeal_add']);

		return $this->output;
	}

	public function DealerAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"merchantdeal");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            $file_location['ImageURL'] = "";
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],66,66,'thumb');
            Image::generateImage($file_location['ImageURL'],145,145,'cover');
            Image::generateImage($file_location['ImageURL'],300,300,'medium');
                    }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE merchant_deal SET Cover='0' WHERE ListingID='".$_POST['ListingID']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(MerchantID, ListingID, ImageURL, Name, Description, DateExpiry)";
		$value = "('".$_POST['MerchantID']."', '".$_POST['ListingID']."', '".$file_location['ImageURL']."', '".$_POST['Name']."', '".$_POST['Description']."', '".Helper::dateTimeDisplaySQL($_POST['DateExpiry'])."')";

		$sql = "INSERT INTO merchant_deal ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Dealer Deal...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerEdit($param)
	{
		$sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['ImageURL'],'thumb');
            }

			$result[$i] = array(
			'ID' => $row['ID'],
			'ListingID' => $row['ListingID'],
			'MerchantID' => $row['MerchantID'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateTimeSQLToDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['merchantdeal']['name'], "Link" => $this->module['merchantdeal']['dealer_url']),
            array("Title" => "Edit", "Link" => "")
        );
        
		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Dealer Deal",
					'template' => 'common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/dealer/edit.inc.php',
					'merchantdeal_add' => $_SESSION['dealer']['merchantdeal_add'],
                    'merchantdeal_edit' => $_SESSION['dealer']['merchantdeal_edit']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'merchant_list' => MerchantModel::getDealerMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['merchantdeal_add']);
		unset($_SESSION['dealer']['merchantdeal_edit']);

		return $this->output;
	}

	public function DealerEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"merchantdeal");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['ImageURLRemove']==1)
            {
                $file_location['ImageURL'] = "";
                Image::deleteImage($_POST['ImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['ImageURL'] = $_POST['ImageURLCurrent'];
            }
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],66,66,'thumb');
            Image::generateImage($file_location['ImageURL'],145,145,'cover');
            Image::generateImage($file_location['ImageURL'],300,300,'medium');
            Image::deleteImage($_POST['ImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE merchant_deal SET Cover='0' WHERE ListingID='".$_POST['ListingID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE merchant_deal SET MerchantID='".$_POST['MerchantID']."', ListingID='".$_POST['ListingID']."', ImageURL='".$file_location['ImageURL']."', Name='".$_POST['Name']."', Description='".$_POST['Description']."', DateExpiry='".Helper::dateTimeDisplaySQL($_POST['DateExpiry'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Dealer Deal...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."'";
		
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'ImageURL' => $row['ImageURL']);

            $i += 1;
        }

        Image::deleteImage($result[0]['ImageURL']);
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'thumb'));
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'cover'));
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'medium'));

		// Delete entry from table
		$sql = "DELETE FROM merchant_deal WHERE ID ='".$param."'";
		//echo $sql;
		
		$count = $this->dbconnect->exec($sql);
		//echo $count;
		//exit;
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Dealer Deal...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
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
			$_SESSION['merchantdeal_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=");
			$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateTimeDisplaySQL($_POST['DateExpiryFrom']),">=");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateTimeDisplaySQL($_POST['DateExpiryTo']),"<=");

			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryFrom'] = $_POST['DateExpiryFrom'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryTo'] = $_POST['DateExpiryTo'];

			// Set Query Variable
			$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['merchantdeal_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['merchantdeal_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['merchantdeal_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM merchant_deal ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/merchantdeal/index';
		$limit = 100000;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM merchant_deal ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition']." ORDER BY ListingID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'thumb');
			}

            $listing = ListingModel::getListing($row['ListingID']);

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'ListingID' => $row['ListingID'],
            'ListingID' => $listing['ID']." - ".$listing['Name'],
			'ImageURL' => $cover_image,
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateTimeSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantdeal']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Merchant Deals", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/admin/index.inc.php', 'merchantdeal_delete' => $_SESSION['admin']['merchantdeal_delete']),
		'block' => array('side_nav' => $this->module['merchantdeal']['dir'].'inc/admin/side_nav.merchantdeal_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'merchant_list' => MerchantModel::getMerchantList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantdeal_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantdeal']['name'], "Link" => $this->module['merchantdeal']['admin_url']),
            array("Title" => "Create Merchant Deal", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Merchant Deal", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/admin/add.inc.php', 'merchantdeal_add' => $_SESSION['admin']['merchantdeal_add']),
		'block' => array('side_nav' => $this->module['merchantdeal']['dir'].'inc/admin/side_nav.merchantdeal_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'merchant_list' => MerchantModel::getMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantdeal_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"merchantdeal");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            $file_location['ImageURL'] = "";
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],66,66,'thumb');
            Image::generateImage($file_location['ImageURL'],145,145,'cover');
            Image::generateImage($file_location['ImageURL'],300,300,'medium');
                    }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE merchant_deal SET Cover='0' WHERE ListingID='".$_POST['ListingID']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(MerchantID, ListingID, ImageURL, Name, Description, DateExpiry)";
		$value = "('".$_POST['MerchantID']."', '".$_POST['ListingID']."', '".$file_location['ImageURL']."', '".$_POST['Name']."', '".$_POST['Description']."', '".Helper::dateTimeDisplaySQL($_POST['DateExpiry'])."')";

		$sql = "INSERT INTO merchant_deal ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Merchant Deal...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['ImageURL'],'thumb');
            }

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'ListingID' => $row['ListingID'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateTimeSQLToDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchantdeal']['name'], "Link" => $this->module['merchantdeal']['admin_url']),
            array("Title" => "Edit Merchant Deal", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Merchant Deal",
					'template' => 'admin.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/admin/edit.inc.php',
					'merchantdeal_add' => $_SESSION['admin']['merchantdeal_add'],
                    'merchantdeal_edit' => $_SESSION['admin']['merchantdeal_edit']),
		'block' => array('side_nav' => $this->module['merchantdeal']['dir'].'inc/admin/side_nav.merchantdeal_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'merchant_list' => MerchantModel::getMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantdeal_add']);
		unset($_SESSION['admin']['merchantdeal_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"merchantdeal");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['ImageURLRemove']==1)
            {
                $file_location['ImageURL'] = "";
                Image::deleteImage($_POST['ImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['ImageURL'] = $_POST['ImageURLCurrent'];
            }
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],66,66,'thumb');
            Image::generateImage($file_location['ImageURL'],145,145,'cover');
            Image::generateImage($file_location['ImageURL'],300,300,'medium');
            Image::deleteImage($_POST['ImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE merchant_deal SET Cover='0' WHERE ListingID='".$_POST['ListingID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE merchant_deal SET MerchantID='".$_POST['MerchantID']."', ListingID='".$_POST['ListingID']."', ImageURL='".$file_location['ImageURL']."', DateExpiry='".Helper::dateTimeDisplaySQL($_POST['DateExpiry'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Merchant Deal...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'ImageURL' => $row['ImageURL']);

            $i += 1;
        }

        Image::deleteImage($result[0]['ImageURL']);
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'thumb'));
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'cover'));
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'medium'));

		// Delete entry from table
		$sql = "DELETE FROM merchant_deal WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Merchant Deal...", 'template' => 'admin.common.tpl.php'),
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
			$_SESSION['merchantdeal_'.__FUNCTION__.'_'.$item['id']] = "";

			$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=",1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateTimeDisplaySQL($_POST['DateExpiryFrom']),">=");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateTimeDisplaySQL($_POST['DateExpiryTo']),"<=");

			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryFrom'] = $_POST['DateExpiryFrom'];
			$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryTo'] = $_POST['DateExpiryTo'];

			// Set Query Variable
			$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['merchantdeal_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['merchantdeal_'.__FUNCTION__.'_'.$item['id']]);
		}

		// Determine Title
		if (isset($_SESSION['merchantdeal_'.__FUNCTION__.'_'.$item['id']]))
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
		$query_count = "SELECT COUNT(*) AS num FROM merchant_deal WHERE ListingID = '".$item['id']."' ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/merchantdeal/listingindex/'.$item['id'];
		$limit = 100000;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM merchant_deal WHERE ListingID = '".$item['id']."' ".$_SESSION['merchantdeal_'.__FUNCTION__.'_'.$item['id']]['query_condition']." ORDER BY ListingID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'thumb');
			}

            $listing = ListingModel::getListing($row['ListingID']);

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'ListingID' => $row['ListingID'],
            'ListingID' => $listing['ID']." - ".$listing['Name'],
			'ImageURL' => $cover_image,
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateTimeSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => $this->module['merchantdeal']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Merchant Deals", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/admin/listingindex.inc.php', 'merchantdeal_listingdelete' => $_SESSION['admin']['merchantdeal_listingdelete']),
		'block' => array('side_nav' => $this->module['merchantdeal']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'merchant_list' => MerchantModel::getMerchantList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantdeal_listingdelete']);

		return $this->output;
	}

	public function AdminListingAdd()
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
            array("Title" => "Create Merchant Deal", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Create Merchant Deal", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/admin/listingadd.inc.php', 'merchantdeal_listingadd' => $_SESSION['admin']['merchantdeal_listingadd']),
		'block' => array('side_nav' => $this->module['merchantdeal']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'merchant_list' => MerchantModel::getMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantdeal_listingadd']);

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
		
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"merchantdeal");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            $file_location['ImageURL'] = "";
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],66,66,'thumb');
            Image::generateImage($file_location['ImageURL'],145,145,'cover');
            Image::generateImage($file_location['ImageURL'],300,300,'medium');
                    }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE merchant_deal SET Cover='0' WHERE ListingID='".$item['id']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(MerchantID, ListingID, ImageURL, Name, Description, DateExpiry)";
		$value = "('".$_POST['MerchantID']."', '".$item['id']."', '".$file_location['ImageURL']."', '".$_POST['Name']."', '".$_POST['Description']."', '".Helper::dateTimeDisplaySQL($_POST['DateExpiry'])."')";

		$sql = "INSERT INTO merchant_deal ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Creating Merchant Deal...", 'template' => 'admin.common.tpl.php'),
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
        
		$sql = "SELECT * FROM merchant_deal WHERE ID = '".$item['child']."' AND ListingID = '".$item['id']."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['ImageURL'],'thumb');
            }

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'ListingID' => $row['ListingID'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateTimeSQLToDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => "Edit Merchant Deal", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array(
					'title' => "Edit Merchant Deal",
					'template' => 'admin.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['merchantdeal']['dir'].'inc/admin/listingedit.inc.php',
					'merchantdeal_listingadd' => $_SESSION['admin']['merchantdeal_listingadd'],
                    'merchantdeal_listingedit' => $_SESSION['admin']['merchantdeal_listingedit']),
		'block' => array('side_nav' => $this->module['merchantdeal']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'merchant_list' => MerchantModel::getMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchantdeal_listingadd']);
		unset($_SESSION['admin']['merchantdeal_listingedit']);

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
		
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"merchantdeal");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['ImageURLRemove']==1)
            {
                $file_location['ImageURL'] = "";
                Image::deleteImage($_POST['ImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['ImageURL'] = $_POST['ImageURLCurrent'];
            }
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],66,66,'thumb');
            Image::generateImage($file_location['ImageURL'],145,145,'cover');
            Image::generateImage($file_location['ImageURL'],300,300,'medium');
            Image::deleteImage($_POST['ImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE merchant_deal SET Cover='0' WHERE ListingID='".$item['id']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE merchant_deal SET MerchantID='".$_POST['MerchantID']."', ImageURL='".$file_location['ImageURL']."', DateExpiry='".Helper::dateTimeDisplaySQL($_POST['DateExpiry'])."' WHERE ID='".$item['child']."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
        'current' => array('id' => $item['child']),
		'page' => array('title' => "Editing Merchant Deal...", 'template' => 'admin.common.tpl.php'),
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
		
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM merchant_deal WHERE ID = '".$item['child']."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'ImageURL' => $row['ImageURL']);

            $i += 1;
        }

        Image::deleteImage($result[0]['ImageURL']);
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'thumb'));
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'cover'));
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'medium'));

		// Delete entry from table
		$sql = "DELETE FROM merchant_deal WHERE ID = '".$item['child']."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Merchant Deal...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminSort($param)
    {
        $param = explode(",",$_POST['param']);

        $i = 0;
        foreach($param as $id)
        {
            $sql = "UPDATE merchant_deal SET Position='".$i."' WHERE ID='".$id."'";
            $count = $this->dbconnect->exec($sql);

            $i++;
        }

        $result = $i;

        return $result;
    }

    public function AdminPosition($param)
    {
        $param = $_POST['param'];

        $crud = new CRUD();

        $sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Position' => $row['Position']);

            $i += 1;
        }

        $result = $result[0]['ID'].",".$result[0]['Position'];

        return $result;
    }

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM merchant_deal ".$_SESSION['merchantdeal_'.$param]['query_condition']." ORDER BY ListingID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Merchant_Deal";
		$result['header'] = $this->config['SITE_NAME']." | Merchant Deal (" . date('Y-m-d H:i:s') . ")\n\nID, Merchant, Listing, ImageURL, Name, Description, Date Expiry";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".MerchantModel::getMerchant($row['MerchantID'])."\",";
			$result['content'] .= "\"".ListingModel::getListing($row['ListingID'])."\",";
			$result['content'] .= "\"".$row['ImageURL']."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Description'])."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DateExpiry'])."\"\n";

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
                // Initialise query conditions
				$query_condition = "";
		
				$crud = new CRUD();
		
				if ($_POST['Trigger']=='search_form')
				{
					// Reset Query Variable
					$_SESSION['merchantdeal_'.__FUNCTION__] = "";
		
					$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=");
					$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");
					$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"=");
					$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"=");
					$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateDisplaySQL($_POST['DateExpiryFrom']),">=");
					$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateDisplaySQL($_POST['DateExpiryTo']),"<=");
		
					$_SESSION['merchantdeal_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
					$_SESSION['merchantdeal_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
					$_SESSION['merchantdeal_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
					$_SESSION['merchantdeal_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
					$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryFrom'] = $_POST['DateExpiryFrom'];
					$_SESSION['merchantdeal_'.__FUNCTION__]['param']['DateExpiryTo'] = $_POST['DateExpiryTo'];
		
					// Set Query Variable
					$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'] = $query_condition;
					$_SESSION['merchantdeal_'.__FUNCTION__]['query_title'] = "Search Results";
				}
		
				// Reset query conditions
				if ($_GET['page']=="all")
				{
					$_GET['page'] = "";
					unset($_SESSION['merchantdeal_'.__FUNCTION__]);
				}
		
				// Determine Title
				if (isset($_SESSION['merchantdeal_'.__FUNCTION__]))
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
				$query_count = "SELECT COUNT(*) AS num FROM merchant_deal ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition'];
				$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
				$targetpage = $data['config']['SITE_URL'].'/merchant/merchantdeal/index';
				$limit = 100000;
				$stages = 3;
				$page = mysql_escape_string($_GET['page']);
				if ($page) {
					$start = ($page - 1) * $limit;
				} else {
					$start = 0;
				}
		
				// Initialize Pagination
				$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
		
				$sql = "SELECT * FROM merchant_deal ".$_SESSION['merchantdeal_'.__FUNCTION__]['query_condition']." ORDER BY ListingID ASC, ImageURL DESC LIMIT $start, $limit";
		
				$result = array();
				$i = 0;
				foreach ($this->dbconnect->query($sql) as $row)
				{
					if ($row['ImageURL']=='')
					{
						$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
					}
					else
					{
						$cover_image = $row['ImageURL'];
					}
		
		            $listing = ListingModel::getListing($row['ListingID']);
					
					
            
		
					$cover_image = $this->config['SITE_URL'].$cover_image;
					//echo $cover_image;
					$result[$i] = array(
					'ID' => $row['ID'],
					//'ListingID' => $row['ListingID'],
					'MerchantID' => $row['MerchantID'],
		            'ListingID' => $row['ListingID'],
		            'Listing' => $listing['ID']." - ".$listing['Name'],
					'ImageURL' => $cover_image,
					'Name' => $row['Name'],
					'Description' => $row['Description'],
					'DateExpiry' => Helper::dateTimeSQLToLongDisplay($row['DateExpiry'])
					);
		
					$i += 1;
				}
				
				$result[$i]['Ad'] = AdModel::getAdLimit($i, "3");

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

	public function APIView($param)
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
                $sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."'";

				$result = array();
				$i = 0;
				foreach ($this->dbconnect->query($sql) as $row)
				{
					$result[$i] = array(
					'ID' => $row['ID'],
					'MerchantID' => $row['MerchantID'],
					'ListingID' => MerchantDealModel::getListingMerchantDeal($row['ListingID']),
					'ImageURL' => $row['ImageURL'],
					'Name' => $row['Name'],
					'Description' => $row['Description'],
					'DateExpiry' => Helper::dateTimeSQLToLongDisplay($row['DateExpiry']));
		
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

    public function MerchantDealControl()
	{
		$crud = new CRUD();
		
		$sql = "SELECT TypeID FROM merchanT WHERE ID = '".$_SESSION['merchant']['ID']."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['TypeID'];
		}
		
		return $result;
	}
	
	/*public function getMerchantDealByListingID($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM merchant_deal WHERE ListingID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'ListingID' => ListingModel::getListing($row['ListingID']),
			'ImageURL' => $cover_image,
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}


		return $result;
	}*/
	
	public function getMerchantDeal($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM merchant_deal WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['SITE_URL'].'/themes/valse/img/no_image.png';
			}
			else
			{
				$cover_image = $this->config['SITE_URL'].$row['ImageURL'];
			}		
				
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'ListingID' => ListingModel::getListing($row['ListingID']),
			'ImageURL' => $cover_image,
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));

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
	
	public function getListingMerchantDeal($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM merchant_deal WHERE ListingID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['SITE_URL'].'/themes/valse/img/no_image.png';
			}
			else
			{
				$cover_image = $this->config['SITE_URL'].$row['ImageURL'];
			}
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			//'ListingID' => $row['ListingID'],
			'ImageURL' => $cover_image,
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateTimeSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}

	public function getMerchantDealList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM merchant_deal ORDER BY ListingID ASC";

		$result = array();

		$i = 0;
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'ListingID' => ListingModel::getListing($row['ListingID']),
			'ImageURL' => $cover_image,
			'Name' => $row['Name'],
			'Description' => $row['Description'],
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']),
			'Limit' => MerchantDealModel::getMerchantDealLimitStatus($row['MerchantID'])
			);

		
			$i += 1;
			
			
		}

		$result['count'] = $i;

		return $result;
	}
	
	public function getMerchantDealLimitStatus($param)
	{
		$crud = new CRUD();
		$limit = array();
		$sql = "SELECT COUNT(MerchantID) AS Control FROM merchant_deal WHERE MerchantID = '".$param."'";		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$limit =  $row['Control'];
		}	
	

		return $limit;
	}
  }
?>