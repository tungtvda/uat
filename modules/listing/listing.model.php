<?php
// Require required models
Core::requireModel('ad');
Core::requireModel('merchant');
Core::requireModel('dealer');
Core::requireModel('listingtype');
Core::requireModel('listingfilter');
Core::requireModel('listingfiltertwo');
Core::requireModel('state');
Core::requireModel('country');
Core::requireModel('listingrating');
Core::requireModel('listingphoto');
Core::requireModel('memberfavorite');

class ListingModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['listing'] = array(
        'name' => "Listing",
        'dir' => "modules/listing/",
        'default_url' => "/main/listing/index",
        'merchant_url' => "/merchant/listing/index",
        'admin_url' => "/admin/listing/index",
		'dealer_url' =>"/dealer/listing/index");
		
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
		
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM listing WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/listing/index';
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

		$sql = "SELECT * FROM listing WHERE Enabled = 1 ORDER BY MerchantID ASC LIMIT $start, $limit";

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

			if ($row['BrandImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['BrandImageURL'],'cover');
			}

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'TypeID' => $row['TypeID'],
			'FilterID' => $row['FilterID'],
			'Filter2ID' => $row['Filter2ID'],
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $cover_image,
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => $row['State'],
			'Country' => $row['Country'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Listings", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM listing WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'TypeID' => $row['TypeID'],
			'FilterID' => $row['FilterID'],
			'Filter2ID' => $row['Filter2ID'],
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $row['BrandImageURL'],
			'Description' => $row['Description'],
			'ImageURL' => $row['ImageURL'],
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => $row['State'],
			'Country' => $row['Country'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/main/view.inc.php'),
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
			$_SESSION['listing_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=");
			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=");
			$query_condition .= $crud->queryCondition("FilterID",$_POST['FilterID'],"=");
			$query_condition .= $crud->queryCondition("Filter2ID",$_POST['Filter2ID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("BrandName",$_POST['BrandName'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Street1",$_POST['Street1'],"LIKE");
			$query_condition .= $crud->queryCondition("Street2",$_POST['Street2'],"LIKE");
			$query_condition .= $crud->queryCondition("City",$_POST['City'],"LIKE");
			$query_condition .= $crud->queryCondition("Postcode",$_POST['Postcode'],"LIKE");
			$query_condition .= $crud->queryCondition("State",$_POST['State'],"=");
			$query_condition .= $crud->queryCondition("Country",$_POST['Country'],"=");
			$query_condition .= $crud->queryCondition("MapX",$_POST['MapX'],"LIKE");
			$query_condition .= $crud->queryCondition("MapY",$_POST['MapY'],"LIKE");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['listing_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['FilterID'] = $_POST['FilterID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Filter2ID'] = $_POST['Filter2ID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['listing_'.__FUNCTION__]['param']['BrandName'] = $_POST['BrandName'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Street1'] = $_POST['Street1'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['listing_'.__FUNCTION__]['param']['City'] = $_POST['City'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['listing_'.__FUNCTION__]['param']['State'] = $_POST['State'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Country'] = $_POST['Country'];
			$_SESSION['listing_'.__FUNCTION__]['param']['MapX'] = $_POST['MapX'];
			$_SESSION['listing_'.__FUNCTION__]['param']['MapY'] = $_POST['MapY'];
			$_SESSION['listing_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['listing_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['listing_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['listing_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['listing_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM listing ".$_SESSION['listing_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/merchant/listing/index';
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
		

		$sql = "SELECT * FROM listing ".$_SESSION['listing_'.__FUNCTION__]['query_condition']." ORDER BY ID DESC LIMIT $start, $limit";
		/*echo $sql;
		exit;*/
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
			
			if ($row['BrandImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['BrandImageURL'],'thumb');
			}

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID']),
			'TypeID' => ListingTypeModel::getListingType($row['TypeID']),
			'FilterID' => ListingFilterModel::getListingFilter($row['FilterID']),
			'Filter2ID' => ListingFilterTwoModel::getListingFilterTwo($row['Filter2ID']),
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $cover_image,
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => StateModel::getState($row['State']),
			'Country' => CountryModel::getCountry($row['Country']),
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}
		
		

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['listing']['name'], "Link" => ""),
            //array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Listings", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/merchant/index.inc.php', 'listing_delete' => $_SESSION['merchant']['listing_delete']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'listingtype_list' => ListingTypeModel::getListingTypeList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'listingfilter_list' => ListingFilterModel::getListingFilterList(), 'listingfiltertwo_list' => ListingFilterTwoModel::getListingFilterTwoList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['listing_delete']);

		return $this->output;
	}
	
	
	public function MerchantView($param)
	{
		$sql = "SELECT * FROM listing WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'TypeID' => $row['TypeID'],
			'FilterID' => $row['FilterID'],
			'Filter2ID' => $row['Filter2ID'],
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $row['BrandImageURL'],
			'Description' => $row['Description'],
			'ImageURL' => $row['ImageURL'],
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => $row['State'],
			'Country' => $row['Country'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		// Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['listing']['name'], "Link" => "$this->module['listing']['default_url']"),
            array("Title" => $result[0]['Title'], "Link" => "")
        );
		
        /*// Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/merchant/view.inc.php'),
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
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['merchant_url']),
            array("Title" => "Add Directory Listing", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Listing", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/merchant/add.inc.php', 'listing_add' => $_SESSION['merchant']['listing_add']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'listingtype_list' => ListingTypeModel::getListingTypeList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'listingfilter_list' => ListingFilterModel::getListingFilterList(), 'listingfiltertwo_list' => ListingFilterTwoModel::getListingFilterTwoList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['listing_add']);

		return $this->output;
	}

	public function MerchantAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listing");

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
            $sql = "UPDATE listing SET Cover='0' WHERE MerchantID='".$_POST['MerchantID']."'";
            $this->dbconnect->exec($sql);
        }

		// Handle Image Upload
        $upload['BrandImageURL'] = File::uploadFile('BrandImageURL',1,2,"listing");

        if ($upload['BrandImageURL']['upload']['status']=="Empty")
        {
            $file_location['BrandImageURL'] = "";
        }
        else if ($upload['BrandImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],66,66,'thumb');
            Image::generateImage($file_location['ImageURL'],145,145,'cover');
            Image::generateImage($file_location['ImageURL'],300,300,'medium');
                    }
        else
        {
            $error['count'] += 1;
            $error['BrandImageURL'] = $upload['BrandImageURL']['error'];

            $file_location['BrandImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE listing SET Cover='0' WHERE MerchantID='".$_POST['MerchantID']."'";
            $this->dbconnect->exec($sql);
        }
		
		
		$key = "(MerchantID, TypeID, FilterID, Filter2ID, Name, BrandName, BrandImageURL, Description, ImageURL, Street1, Street2, City, Postcode, State, Country, MapX, MapY, PhoneNo, Enabled)";
		$value = "('".$_POST['MerchantID']."', '".$_POST['TypeID']."', '".$_POST['FilterID']."', '".$_POST['Filter2ID']."', '".$_POST['Name']."', '".$_POST['BrandName']."', '".$file_location['BrandImageURL']."', '".$_POST['Description']."', '".$file_location['ImageURL']."', '".$_POST['Street1']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['Postcode']."', '".$_POST['State']."', '".$_POST['Country']."', '".$_POST['MapX']."', '".$_POST['MapY']."', '".$_POST['PhoneNo']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO listing ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Listing...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	
	public function MerchantEdit($param)
	{
		$sql = "SELECT * FROM listing WHERE ID = '".$param."'";

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
			
			if ($row['BrandImageURL']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['BrandImageURL'],'thumb');
            }

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'TypeID' => $row['TypeID'],
			'FilterID' => $row['FilterID'],
			'Filter2ID' => $row['Filter2ID'],
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURLCover' => $cover_image,
			'BrandImageURL' => $row['BrandImageURL'],
			'Description' => $row['Description'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => $row['State'],
			'Country' => $row['Country'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['merchant_url']),
            array("Title" => "Edit Directory Listing", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Listing",
					'template' => 'common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['listing']['dir'].'inc/merchant/edit.inc.php',
					'listing_add' => $_SESSION['merchant']['listing_add'],
                    'listing_edit' => $_SESSION['merchant']['listing_edit']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'listingtype_list' => ListingTypeModel::getListingTypeList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'listingfilter_list' => ListingFilterModel::getListingFilterList(), 'listingfiltertwo_list' => ListingFilterTwoModel::getListingFilterTwoList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['listing_add']);
		unset($_SESSION['merchant']['listing_edit']);

		return $this->output;
	}

	public function MerchantEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listing");

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
            $sql = "UPDATE listing SET Cover='0' WHERE MerchantID='".$_POST['MerchantID']."'";
            $this->dbconnect->exec($sql);
        }
		
		// Handle Image Upload
        $upload['BrandImageURL'] = File::uploadFile('BrandImageURL',1,2,"listing");

        if ($upload['BrandImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['BrandImageURLRemove']==1)
            {
                $file_location['BrandImageURL'] = "";
                Image::deleteImage($_POST['BrandImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['BrandImageURL'] = $_POST['BrandImageURLCurrent'];
            }
        }
        else if ($upload['BrandImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['BrandImageURL'] = $upload['BrandImageURL']['upload']['destination'];
            Image::generateImage($file_location['BrandImageURL'],66,66,'thumb');
            Image::generateImage($file_location['BrandImageURL'],145,145,'cover');
            Image::generateImage($file_location['BrandImageURL'],300,300,'medium');
            Image::deleteImage($_POST['BrandImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['BrandImageURL'] = $upload['BrandImageURL']['error'];

            $file_location['BrandImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE listing SET Cover='0' WHERE MerchantID='".$_POST['MerchantID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE listing SET MerchantID='".$_POST['MerchantID']."', TypeID='".$_POST['TypeID']."', FilterID='".$_POST['FilterID']."', Filter2ID='".$_POST['Filter2ID']."', Name='".$_POST['Name']."', BrandName='".$_POST['BrandName']."', BrandImageURL='".$file_location['BrandImageURL']."', Description='".$_POST['Description']."', ImageURL='".$file_location['ImageURL']."', Street1='".$_POST['Street1']."', Street2='".$_POST['Street2']."', City='".$_POST['City']."', Postcode='".$_POST['Postcode']."', State='".$_POST['State']."', Country='".$_POST['Country']."', MapX='".$_POST['MapX']."', MapY='".$_POST['MapY']."', PhoneNo='".$_POST['PhoneNo']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Listing...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	public function MerchantDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM listing WHERE ID = '".$param."'";

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
		
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM listing WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'BrandImageURL' => $row['BrandImageURL']);

            $i += 1;
        }

        Image::deleteImage($result[0]['BrandImageURL']);
        Image::deleteImage(Image::getImage($result[0]['BrandImageURL'],'thumb'));
        Image::deleteImage(Image::getImage($result[0]['BrandImageURL'],'cover'));
        Image::deleteImage(Image::getImage($result[0]['BrandImageURL'],'medium'));

		// Delete entry from table
		$sql = "DELETE FROM listing WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Listing...", 'template' => 'common.tpl.php'),
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
			$_SESSION['listing_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("l.MerchantID",$_POST['MerchantID'],"=",1);
			$query_condition .= $crud->queryCondition("l.TypeID",$_POST['TypeID'],"=");
			$query_condition .= $crud->queryCondition("l.FilterID",$_POST['FilterID'],"=");
			$query_condition .= $crud->queryCondition("l.Filter2ID",$_POST['Filter2ID'],"=");
			$query_condition .= $crud->queryCondition("l.Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("l.BrandName",$_POST['BrandName'],"LIKE");
			$query_condition .= $crud->queryCondition("l.Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("l.Street1",$_POST['Street1'],"LIKE");
			$query_condition .= $crud->queryCondition("l.Street2",$_POST['Street2'],"LIKE");
			$query_condition .= $crud->queryCondition("l.City",$_POST['City'],"LIKE");
			$query_condition .= $crud->queryCondition("l.Postcode",$_POST['Postcode'],"LIKE");
			$query_condition .= $crud->queryCondition("l.State",$_POST['State'],"=");
			$query_condition .= $crud->queryCondition("l.Country",$_POST['Country'],"=");
			$query_condition .= $crud->queryCondition("l.MapX",$_POST['MapX'],"LIKE");
			$query_condition .= $crud->queryCondition("l.MapY",$_POST['MapY'],"LIKE");
			$query_condition .= $crud->queryCondition("l.PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("l.Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['listing_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['FilterID'] = $_POST['FilterID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Filter2ID'] = $_POST['Filter2ID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['listing_'.__FUNCTION__]['param']['BrandName'] = $_POST['BrandName'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Street1'] = $_POST['Street1'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['listing_'.__FUNCTION__]['param']['City'] = $_POST['City'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['listing_'.__FUNCTION__]['param']['State'] = $_POST['State'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Country'] = $_POST['Country'];
			$_SESSION['listing_'.__FUNCTION__]['param']['MapX'] = $_POST['MapX'];
			$_SESSION['listing_'.__FUNCTION__]['param']['MapY'] = $_POST['MapY'];
			$_SESSION['listing_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['listing_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['listing_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['listing_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['listing_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM listing AS l , merchant AS m  WHERE m.ID = l.MerchantID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['listing_'.__FUNCTION__]['query_condition'];
		/*echo $query_count;
		exit;*/
		
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/dealer/listing/index';
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

		/*SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Reseller = '".$resellers[$z]['ID']."*/


		$sql = "SELECT l.ID, l.TypeID, l.MerchantID, l.FilterID, l.Filter2ID, l.Name, l.BrandName, l.BrandImageURL, l.Description, l.Street1, l.Street2, l.ImageURL, l.City, l.Postcode, l.State, l.Country, l.MapX, l.MapY, l.PhoneNo, l.Enabled FROM listing AS l, merchant AS m  WHERE m.ID = l.MerchantID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['listing_'.__FUNCTION__]['query_condition']." ORDER BY ID DESC LIMIT $start, $limit";
		/*echo $sql;
		exit;*/
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

			$result[$i] = array(
			'ID' => $row['ID'],
			//'DealerID' => DealerModel::getDealer($row['DealerID']),
			'TypeID' => ListingTypeModel::getListingType($row['TypeID']),
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID'], $column = "Name"),
			'FilterID' => ListingFilterModel::getListingFilter($row['FilterID'], "Label"),
			'Filter2ID' => ListingFilterTwoModel::getListingFilterTwo($row['Filter2ID'], "Label"),
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $cover_image,
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => StateModel::getState($row['State']),
			'Country' => CountryModel::getCountry($row['Country']),
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['listing']['name'], "Link" => ""),
            //array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Listings", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/dealer/index.inc.php', 'listing_delete' => $_SESSION['dealer']['listing_delete']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'dealer_list' => DealerModel::getDealerList(), 'listingtype_list' => ListingTypeModel::getListingTypeList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'listingfilter_list' => ListingFilterModel::getListingFilterList(), 'listingfiltertwo_list' => ListingFilterTwoModel::getListingFilterTwoList(), 'sort' => $sort, 'merchant_list' => MerchantModel::getDealerMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['listing_delete']);

		return $this->output;
	}
	
	
	public function DealerView($param)
	{
		$sql = "SELECT * FROM listing WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
			'TypeID' => $row['TypeID'],
			'FilterID' => $row['FilterID'],
			'Filter2ID' => $row['Filter2ID'],
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $row['BrandImageURL'],
			'Description' => $row['Description'],
			'ImageURL' => $row['ImageURL'],
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => $row['State'],
			'Country' => $row['Country'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		// Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['default_url']),
            array("Title" => $this->module['listing']['name'], "Link" => "$this->module['listing']['default_url']"),
            array("Title" => $result[0]['Title'], "Link" => "")
        );
		
        /*// Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/dealer/view.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
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
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['dealer_url']),
            array("Title" => "Add", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Listing", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/dealer/add.inc.php', 'listing_add' => $_SESSION['dealer']['listing_add']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getDealerMerchantList(), 'listingtype_list' => ListingTypeModel::getListingTypeList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'listingfilter_list' => ListingFilterModel::getListingFilterList(), 'listingfiltertwo_list' => ListingFilterTwoModel::getListingFilterTwoList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['listing_add']);

		return $this->output;
	}

	public function DealerAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listing");

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
            $sql = "UPDATE listing SET Cover='0' WHERE ID='".$_POST['ID']."'";
            $this->dbconnect->exec($sql);
        }
		
		// Handle Image Upload
        $upload['BrandImageURL'] = File::uploadFile('BrandImageURL',1,2,"listing");

        if ($upload['BrandImageURL']['upload']['status']=="Empty")
        {
            $file_location['BrandImageURL'] = "";
        }
        else if ($upload['BrandImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['BrandImageURL'] = $upload['BrandImageURL']['upload']['destination'];
            Image::generateImage($file_location['BrandImageURL'],66,66,'thumb');
            Image::generateImage($file_location['BrandImageURL'],145,145,'cover');
            Image::generateImage($file_location['BrandImageURL'],300,300,'medium');
                    }
        else
        {
            $error['count'] += 1;
            $error['BrandImageURL'] = $upload['BrandImageURL']['error'];

            $file_location['BrandImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE listing SET Cover='0' WHERE ID='".$_POST['ID']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(MerchantID, TypeID, FilterID, Filter2ID, Name, BrandName, BrandImageURL, Description, ImageURL, Street1, Street2, City, Postcode, State, Country, MapX, MapY, PhoneNo, Enabled)";
		$value = "('".$_POST['MerchantID']."', '".$_POST['TypeID']."', '".$_POST['FilterID']."', '".$_POST['Filter2ID']."', '".$_POST['Name']."', '".$_POST['BrandName']."', '".$file_location['BrandImageURL']."', '".$_POST['Description']."', '".$file_location['ImageURL']."', '".$_POST['Street1']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['Postcode']."', '".$_POST['State']."', '".$_POST['Country']."', '".$_POST['MapX']."', '".$_POST['MapY']."', '".$_POST['PhoneNo']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO listing ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Listing...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	
	public function DealerEdit($param)
	{
		$sql = "SELECT * FROM listing WHERE ID = '".$param."'";

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
			
			if ($row['BrandImageURL']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['BrandImageURL'],'thumb');
            }

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'DealerID' => $row['DealerID'],
			'TypeID' => $row['TypeID'],
			'FilterID' => $row['FilterID'],
			'Filter2ID' => $row['Filter2ID'],
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURLCover' => $cover_image,
			'BrandImageURL' => $row['BrandImageURL'],
			'Description' => $row['Description'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => $row['State'],
			'Country' => $row['Country'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['dealer_url']),
            array("Title" => "Edit", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Listing",
					'template' => 'common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['listing']['dir'].'inc/dealer/edit.inc.php',
					'listing_add' => $_SESSION['dealer']['listing_add'],
                    'listing_edit' => $_SESSION['dealer']['listing_edit']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getDealerMerchantList(), 'listingtype_list' => ListingTypeModel::getListingTypeList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'listingfilter_list' => ListingFilterModel::getListingFilterList(), 'listingfiltertwo_list' => ListingFilterTwoModel::getListingFilterTwoList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['listing_add']);
		unset($_SESSION['dealer']['listing_edit']);

		return $this->output;
	}

	public function DealerEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listing");

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
            $sql = "UPDATE listing SET Cover='0' WHERE ID='".$_POST['ID']."'";
            $this->dbconnect->exec($sql);
        }

		// Handle Image Upload
        $upload['BrandImageURL'] = File::uploadFile('BrandImageURL',1,2,"listing");

        if ($upload['BrandBrandImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['BrandImageURLRemove']==1)
            {
                $file_location['BrandImageURL'] = "";
                Image::deleteImage($_POST['BrandImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['BrandImageURL'] = $_POST['BrandImageURLCurrent'];
            }
        }
        else if ($upload['BrandImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['BrandImageURL'] = $uplBrandoad['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['BrandImageURL'],66,66,'thumb');
            Image::generateImage($file_location['BrandImageURL'],145,145,'cover');
            Image::generateImage($file_location['BrandImageURL'],300,300,'medium');
            Image::deleteImage($_POST['BrandImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['BrandImageURL'] = $upload['BrandImageURL']['error'];

            $file_location['BrandImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE listing SET Cover='0' WHERE ID='".$_POST['ID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE listing SET TypeID='".$_POST['TypeID']."', MerchantID='".$_POST['MerchantID']."', FilterID='".$_POST['FilterID']."', Filter2ID='".$_POST['Filter2ID']."', Name='".$_POST['Name']."', BrandName='".$_POST['BrandName']."', BrandImageURL='".$file_location['BrandImageURL']."', Description='".$_POST['Description']."', ImageURL='".$file_location['ImageURL']."', Street1='".$_POST['Street1']."', Street2='".$_POST['Street2']."', City='".$_POST['City']."', Postcode='".$_POST['Postcode']."', State='".$_POST['State']."', Country='".$_POST['Country']."', MapX='".$_POST['MapX']."', MapY='".$_POST['MapY']."', PhoneNo='".$_POST['PhoneNo']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";
		/*echo $sql;
		exit;*/
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Listing...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	public function DealerDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM listing WHERE ID = '".$param."'";

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
		
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM listing WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'BrandImageURL' => $row['BrandImageURL']);

            $i += 1;
        }

        Image::deleteImage($result[0]['BrandImageURL']);
        Image::deleteImage(Image::getImage($result[0]['BrandImageURL'],'thumb'));
        Image::deleteImage(Image::getImage($result[0]['BrandImageURL'],'cover'));
        Image::deleteImage(Image::getImage($result[0]['BrandImageURL'],'medium'));

		// Delete entry from table
		$sql = "DELETE FROM listing WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Listing...", 'template' => 'common.tpl.php'),
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
			$_SESSION['listing_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=");
			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=");
			$query_condition .= $crud->queryCondition("FilterID",$_POST['FilterID'],"=");
			$query_condition .= $crud->queryCondition("Filter2ID",$_POST['Filter2ID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("BrandName",$_POST['BrandName'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Street1",$_POST['Street1'],"LIKE");
			$query_condition .= $crud->queryCondition("Street2",$_POST['Street2'],"LIKE");
			$query_condition .= $crud->queryCondition("City",$_POST['City'],"LIKE");
			$query_condition .= $crud->queryCondition("Postcode",$_POST['Postcode'],"LIKE");
			$query_condition .= $crud->queryCondition("State",$_POST['State'],"=");
			$query_condition .= $crud->queryCondition("Country",$_POST['Country'],"=");
			$query_condition .= $crud->queryCondition("MapX",$_POST['MapX'],"LIKE");
			$query_condition .= $crud->queryCondition("MapY",$_POST['TypeID'],"LIKE");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['TypeID'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['listing_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['FilterID'] = $_POST['FilterID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Filter2ID'] = $_POST['Filter2ID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['listing_'.__FUNCTION__]['param']['BrandName'] = $_POST['BrandName'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Street1'] = $_POST['Street1'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['listing_'.__FUNCTION__]['param']['City'] = $_POST['City'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['listing_'.__FUNCTION__]['param']['State'] = $_POST['State'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Country'] = $_POST['Country'];
			$_SESSION['listing_'.__FUNCTION__]['param']['MapX'] = $_POST['MapX'];
			$_SESSION['listing_'.__FUNCTION__]['param']['MapY'] = $_POST['MapY'];
			$_SESSION['listing_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['listing_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['listing_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['listing_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['listing_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM listing ".$_SESSION['listing_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/listing/index';
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

		$sql = "SELECT * FROM listing ".$_SESSION['listing_'.__FUNCTION__]['query_condition']." ORDER BY MerchantID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$ImageURL = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$ImageURL = Image::getImage($row['ImageURL'],'thumb');
			}
			
			if ($row['BrandImageURL']=='')
			{
				$BrandImageURL = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$BrandImageURL = Image::getImage($row['BrandImageURL'],'thumb');
			}

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID'], "Name"),
			'TypeID' => ListingTypeModel::getListingType($row['TypeID'], "Label"),
			'FilterID' => ListingFilterModel::getListingFilter($row['FilterID'], "Label"),
			'Filter2ID' => ListingFilterTwoModel::getListingFilterTwo($row['Filter2ID'], "Label"),
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $BrandImageURL,
			'Description' => $row['Description'],
			'ImageURL' => $ImageURL,
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => StateModel::getState($row['State'], "Name"),
			'Country' => CountryModel::getCountry($row['Country'], "Name"),
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Listings", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/admin/index.inc.php', 'listing_delete' => $_SESSION['admin']['listing_delete']),
		'block' => array('side_nav' => $this->module['listing']['dir'].'inc/admin/side_nav.listing_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'listingtype_list' => ListingTypeModel::getListingTypeList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'listingfilter_list' => ListingFilterModel::getListingFilterList(), 'listingfiltertwo_list' => ListingFilterTwoModel::getListingFilterTwoList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listing_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['admin_url']),
            array("Title" => "Create Listing", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Listing", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listing']['dir'].'inc/admin/add.inc.php', 'listing_add' => $_SESSION['admin']['listing_add']),
		'block' => array('side_nav' => $this->module['listing']['dir'].'inc/admin/side_nav.listing_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'listingtype_list' => ListingTypeModel::getListingTypeList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'listingfilter_list' => ListingFilterModel::getListingFilterList(), 'listingfiltertwo_list' => ListingFilterTwoModel::getListingFilterTwoList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listing_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listing");

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
            $sql = "UPDATE listing SET Cover='0' WHERE MerchantID='".$_POST['MerchantID']."'";
            $this->dbconnect->exec($sql);
        }

		// Handle Image Upload
        $upload['BrandImageURL'] = File::uploadFile('BrandImageURL',1,2,"listing");

        if ($upload['BrandImageURL']['upload']['status']=="Empty")
        {
            $file_location['BrandImageURL'] = "";
        }
        else if ($upload['BrandImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['BrandImageURL'] = $upload['BrandImageURL']['upload']['destination'];
            Image::generateImage($file_location['BrandImageURL'],66,66,'thumb');
            Image::generateImage($file_location['BrandImageURL'],145,145,'cover');
            Image::generateImage($file_location['BrandImageURL'],200,100,'medium');
                    }
        else
        {
            $error['count'] += 1;
            $error['BrandImageURL'] = $upload['BrandImageURL']['error'];

            $file_location['BrandImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE listing SET Cover='0' WHERE MerchantID='".$_POST['MerchantID']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(MerchantID, TypeID, FilterID, Filter2ID, Name, BrandName, BrandImageURL, Description, ImageURL, Street1, Street2, City, Postcode, State, Country, MapX, MapY, PhoneNo, Enabled)";
		$value = "('".$_POST['MerchantID']."', '".$_POST['TypeID']."', '".$_POST['FilterID']."', '".$_POST['Filter2ID']."', '".$_POST['Name']."', '".$_POST['BrandName']."', '".$file_location['BrandImageURL']."', '".$_POST['Description']."', '".$file_location['ImageURL']."', '".$_POST['Street1']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['Postcode']."', '".$_POST['State']."', '".$_POST['Country']."', '".$_POST['MapX']."', '".$_POST['MapY']."', '".$_POST['PhoneNo']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO listing ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Listing...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM listing WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
            {
                $ImageURL = '';
            }
            else
            {
                $ImageURL = Image::getImage($row['ImageURL'],'thumb');
            }
			
			if ($row['BrandImageURL']=='')
            {
                $BrandImageURL = '';
            }
            else
            {
                $BrandImageURL = Image::getImage($row['BrandImageURL'],'thumb');
            }

			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'TypeID' => $row['TypeID'],
			'FilterID' => $row['FilterID'],
			'Filter2ID' => $row['Filter2ID'],
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURLCover' => $BrandImageURL,
			'BrandImageURL' => $row['BrandImageURL'],
			'Description' => $row['Description'],
			'ImageURLCover' => $ImageURL,
			'ImageURL' => $row['ImageURL'],
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => $row['State'],
			'Country' => $row['Country'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['admin_url']),
            array("Title" => "Edit Listing", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array(
					'title' => "Edit Listing",
					'template' => 'admin.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['listing']['dir'].'inc/admin/edit.inc.php',
					'listing_add' => $_SESSION['admin']['listing_add'],
                    'listing_edit' => $_SESSION['admin']['listing_edit']),
		'block' => array('side_nav' => $this->module['listing']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'merchant_list' => MerchantModel::getMerchantList(), 'listingtype_list' => ListingTypeModel::getListingTypeList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'listingfilter_list' => ListingFilterModel::getListingFilterList(), 'listingfiltertwo_list' => ListingFilterTwoModel::getListingFilterTwoList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listing_add']);
		unset($_SESSION['admin']['listing_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listing");

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
            $sql = "UPDATE listing SET Cover='0' WHERE MerchantID='".$_POST['MerchantID']."'";
            $this->dbconnect->exec($sql);
        }
		
		// Handle Image Upload
        $upload['BrandImageURL'] = File::uploadFile('BrandImageURL',1,2,"listing");

        if ($upload['BrandImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['BrandImageURLRemove']==1)
            {
                $file_location['BrandImageURL'] = "";
                Image::deleteImage($_POST['BrandImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['BrandImageURL'] = $_POST['BrandImageURLCurrent'];
            }
        }
        else if ($upload['BrandImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['BrandImageURL'] = $upload['BrandImageURL']['upload']['destination'];
            Image::generateImage($file_location['BrandImageURL'],66,66,'thumb');
            Image::generateImage($file_location['BrandImageURL'],145,145,'cover');
            Image::generateImage($file_location['BrandImageURL'],200,100,'medium');
            Image::deleteImage($_POST['BrandImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['BrandImageURLCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['BrandImageURL'] = $upload['BrandImageURL']['error'];

            $file_location['BrandImageURL'] = "";
        }

        // Disable other photos as cover
        if ($_POST['Cover']==1)
        {
            $sql = "UPDATE listing SET Cover='0' WHERE MerchantID='".$_POST['MerchantID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE listing SET MerchantID='".$_POST['MerchantID']."', TypeID='".$_POST['TypeID']."', FilterID='".$_POST['FilterID']."', Filter2ID='".$_POST['Filter2ID']."', Name='".$_POST['Name']."', BrandName='".$_POST['BrandName']."', BrandImageURL='".$file_location['BrandImageURL']."', Description='".$_POST['Description']."', ImageURL='".$file_location['ImageURL']."', Street1='".$_POST['Street1']."', Street2='".$_POST['Street2']."', City='".$_POST['City']."', Postcode='".$_POST['Postcode']."', State='".$_POST['State']."', Country='".$_POST['Country']."', MapX='".$_POST['MapX']."', MapY='".$_POST['MapY']."', PhoneNo='".$_POST['PhoneNo']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Listing...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM listing WHERE ID = '".$param."'";

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
		
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM listing WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'BrandImageURL' => $row['BrandImageURL']);

            $i += 1;
        }

        Image::deleteImage($result[0]['BrandImageURL']);
        Image::deleteImage(Image::getImage($result[0]['BrandImageURL'],'thumb'));
        Image::deleteImage(Image::getImage($result[0]['BrandImageURL'],'cover'));
        Image::deleteImage(Image::getImage($result[0]['BrandImageURL'],'medium'));

		// Delete entry from table
		$sql = "DELETE FROM listing WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Listing...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM listing ".$_SESSION['listing_'.$param]['query_condition']." ORDER BY MerchantID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Listing";
		$result['header'] = $this->config['SITE_NAME']." | Listing (" . date('Y-m-d H:i:s') . ")\n\nID, Merchant, Type, Filter, Filter 2, Name, Brand Name, Brand Image URL, Description, Image URL, Street 1, Street 2, City, Postcode, State, Country, Map X, Map Y, Phone No, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".MerchantIDModel::getMerchantID($row['MerchantID'])."\",";
			$result['content'] .= "\"".ListingTypeModel::getListingType($row['TypeID'])."\",";
			$result['content'] .= "\"".ListingFilterModel::getListingFilter($row['FilterID'])."\",";
			$result['content'] .= "\"".ListingFilterTwoModel::getListingFilterTwo($row['Filter2ID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['BrandName']."\",";
			$result['content'] .= "\"".$row['BrandImageURL']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Description'])."\",";
			$result['content'] .= "\"".$row['ImageURL']."\",";
			$result['content'] .= "\"".$row['Street1']."\",";
			$result['content'] .= "\"".$row['Street2']."\",";
			$result['content'] .= "\"".$row['City']."\",";
			$result['content'] .= "\"".$row['Postcode']."\",";
			$result['content'] .= "\"".StateModel::getState($row['State'])."\",";
			$result['content'] .= "\"".CountryModel::getCountry($row['Country'])."\",";
			$result['content'] .= "\"".$row['MapX']."\",";
			$result['content'] .= "\"".$row['MapY']."\",";
			$result['content'] .= "\"".$row['PhoneNo']."\",";
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

	public function ListingControl()
	{
		$crud = new CRUD();
		
		$sql = "SELECT TypeID FROM merchanT WHERE ID = '".$_SESSION['merchant']['ID']."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['TypeID'];
		}
		
		return $result;
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
		//$query_condition = "";

		$crud = new CRUD();

		if ($_GET['search']=='1')
		{
			/*// Reset Query Variable
			$_SESSION['listing_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=", 1);
			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=");
			$query_condition .= $crud->queryCondition("FilterID",$_POST['FilterID'],"=");
			$query_condition .= $crud->queryCondition("Filter2ID",$_POST['Filter2ID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Street1",$_POST['Street1'],"LIKE");
			$query_condition .= $crud->queryCondition("Street2",$_POST['Street2'],"LIKE");
			$query_condition .= $crud->queryCondition("City",$_POST['City'],"LIKE");
			$query_condition .= $crud->queryCondition("Postcode",$_POST['Postcode'],"LIKE");
			$query_condition .= $crud->queryCondition("State",$_POST['State'],"=");
			$query_condition .= $crud->queryCondition("Country",$_POST['Country'],"=");
			$query_condition .= $crud->queryCondition("MapX",$_POST['MapX'],"LIKE");
			$query_condition .= $crud->queryCondition("MapY",$_POST['MapY'],"LIKE");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['listing_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['FilterID'] = $_POST['FilterID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Filter2ID'] = $_POST['Filter2ID'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Street1'] = $_POST['Street1'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Street2'] = $_POST['Street2'];
			$_SESSION['listing_'.__FUNCTION__]['param']['City'] = $_POST['City'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Postcode'] = $_POST['Postcode'];
			$_SESSION['listing_'.__FUNCTION__]['param']['State'] = $_POST['State'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Country'] = $_POST['Country'];
			$_SESSION['listing_'.__FUNCTION__]['param']['MapX'] = $_POST['MapX'];
			$_SESSION['listing_'.__FUNCTION__]['param']['MapY'] = $_POST['MapY'];
			$_SESSION['listing_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['listing_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['listing_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['listing_'.__FUNCTION__]['query_title'] = "Search Results";
		*/

		/*// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['listing_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['listing_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM listing WHERE TypeID = '".$param."' ".$_SESSION['listing_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/merchant/listing/index';
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

        $name = "AND Name LIKE '%".$request_data['Name']."%'";
		$filterID = "AND FilterID = '".$request_data['FilterID']."'";
		$filter2ID =  "AND Filter2ID = '".$request_data['Filter2ID']."'";
		$allfilter2ID =  "AND Filter2ID IN ('2', '4')"; 
		$allfilterID =  "AND FilterID IN ('3', '5', '6', '8')"; 
		   
		$Name = ($request_data['Name']!="")?$name:'';
		$filterID = ($request_data['FilterID']=="2") ? $allfilterID : $filterID;
		$filter2ID = ($request_data['Filter2ID']=="1") ? $allfilter2ID : $filter2ID;
		
		$sql = "SELECT * FROM listing WHERE TypeID = '".$param."' ".$Name." ".$filterID." ".$filter2ID;
		//echo $sql;		/*ORDER BY MerchantID ASC LIMIT $start, $limit*/
		/*echo $sql;
		exit;*/
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
			
			if ($row['BrandImageURL']=='')
			{
				$BrandImageURL = $this->config['SITE_URL'].'/themes/valse/img/no_image.png';
			}
			else
			{
				$BrandImageURL =  $this->config['SITE_URL'].$row['BrandImageURL'];
			}
			
			

			$result[$i] = array(
			
			'ID' => $row['ID'],
			'ListingRating' => ListingRatingModel::getListingRatingByListingID($row['ID'], "Rating"),
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID']),
			'ListingMemberFavorite' => MemberFavoriteModel::getMemberFavoriteByListingID($row['ID']),
			'TypeID' => ListingTypeModel::getListingType($row['TypeID'], "Label"),
			'FilterID' => ListingFilterModel::getListingFilter($row['FilterID'], "Label"),
			'Filter2ID' => ListingFilterTwoModel::getListingFilterTwo($row['Filter2ID'], "Label"),
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $BrandImageURL,
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => StateModel::getState($row['State']),
			'Country' => CountryModel::getCountry($row['Country']),
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}
		$result[$i]['Ad'] = AdModel::getAdLimit($i, "2");

		}elseif($_GET['search']=='0'){
			
			
		$sql = "SELECT * FROM listing WHERE TypeID = '".$param."'";
		//echo $sql;		/*ORDER BY MerchantID ASC LIMIT $start, $limit*/
		/*echo $sql;
		exit;*/
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
			
						
			if ($row['BrandImageURL']=='')
			{
				$BrandImageURL = $this->config['SITE_URL'].'/themes/valse/img/no_image.png';
			}
			else
			{
				$BrandImageURL = $this->config['SITE_URL'].$row['BrandImageURL'];
			}
			
			//$cover_image = $this->config['SITE_URL'].$cover_image;

			$result[$i] = array(
			
			'ID' => $row['ID'],
			'ListingRating' => ListingRatingModel::getListingRatingByListingID($row['ID'], "Rating"),
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID']),
			'ListingMemberFavorite' => MemberFavoriteModel::getMemberFavoriteByListingID($row['ID']),
			'TypeID' => ListingTypeModel::getListingType($row['TypeID'], "Label"),
			'FilterID' => ListingFilterModel::getListingFilter($row['FilterID'], "Label"),
			'Filter2ID' => ListingFilterTwoModel::getListingFilterTwo($row['Filter2ID'], "Label"),
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $BrandImageURL,
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => StateModel::getState($row['State']),
			'Country' => CountryModel::getCountry($row['Country']),
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}
		$result[$i]['Ad'] = AdModel::getAdLimit($i, "2");
			
			
			
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

	public function APIUpdateProcess($param)
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
            	
            	$count = ListingRatingModel::getListingRated($request_data['MemberID'], $request_data['ListingID']);
				
				if($count == 0){
					
	                $key = "(MemberID, ListingID)";
					$value = "('".$request_data['MemberID']."', '".$request_data['ListingID']."')";
			
					$sql = "INSERT INTO listing_rating ".$key." VALUES ". $value;
			
					$count = $this->dbconnect->exec($sql);
				
				}elseif($count > 0){
					
					
			
					$sql = "UPDATE listing_rating SET ListingID = '".$request_data['ListingID']."' WHERE MemberID = '".$request_data['MemberID']."'";
			
					$count = $this->dbconnect->exec($sql);
					
				}

                $output['Count'] = $count;
                //$output['Content'] = $result;
                
                $error_message = "Error ocurred";

                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode($output);
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

	public function APILikeUpdateProcess($param)
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
	            	
	            	$count = MemberFavoriteModel::getMemberFavoriteChecked($request_data['MemberID'], $request_data['ListingID']);
					
					if($count == 0){
						
		                $key = "(MemberID, ListingID)";
						$value = "('".$request_data['MemberID']."', '".$request_data['ListingID']."')";
				
						$sql = "INSERT INTO member_favorite ".$key." VALUES ". $value;
				
						$count = $this->dbconnect->exec($sql);
					
					}elseif($count > 0){
						
						
				
						$sql = "DELETE FROM member_favorite WHERE ListingID = '".$request_data['ListingID']."' AND MemberID = '".$request_data['MemberID']."'";
				
						$count = $this->dbconnect->exec($sql);
						
					}
	
	                $output['Count'] = $count;
	                //$output['Content'] = $result;
	                
	                $error_message = "Error ocurred";
	
	                // Set output
	                if ($output['Count']>0)
	                {
	                    $result = json_encode($output);
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
                $sql = "SELECT * FROM listing WHERE ID = '".$param."' AND Enabled = 1";

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
					
					$cover_image = $this->config['SITE_URL'].$cover_image;
					
					if ($row['BrandImageURL']=='')
					{
						$brand_image = $this->config['THEME_DIR'].'img/no_image.png';
					}
					else
					{
						$brand_image = Image::getImage($row['BrandImageURL'],'medium');
						 
					}
					
					$brand_image = $this->config['SITE_URL'].$brand_image;
					
					
					$result[$i] = array(
					'ID' => $row['ID'],
					//'ListingMerchantDeals' => MerchantDealModel::getListingMerchantDeal($row['ID']),
					'MemberFavorite' => MemberFavoriteModel::getViewMemberFavoriteChecked($request_data['memberID'], $row['ID']),
					'ListingRating' => ListingRatingModel::getListingRatingByListingID($row['ID'], "Rating"),
					'ListingMemberFavorite' => MemberFavoriteModel::getMemberFavoriteByListingID($row['ID']),
					'MerchantID' => array(MerchantModel::getMerchant($row['MerchantID'])),
					'TypeID' => ListingTypeModel::getListingType($row['TypeID'], "Label"),
					'FilterID' => ListingFilterModel::getListingFilter($row['FilterID'], "Label"),
					'Filter2ID' => ListingFilterTwoModel::getListingFilterTwo($row['Filter2ID'], "Label"),
					'ListingPhoto' => ListingPhotoModel::getListingPhotoByListingID($row['ID']),
					'Name' => $row['Name'],
					'ImageBannerURL' => $cover_image,
					'BrandName' => $row['BrandName'],
					'BrandImageURL' => $brand_image,
					'Description' => $row['Description'],
					'ImageURL' => $row['ImageURL'],
					'Street1' => $row['Street1'],
					'Street2' => $row['Street2'],
					'City' => $row['City'],
					'Postcode' => $row['Postcode'],
					'State' => StateModel::getState($row['State'], "Name"),
					'Country' => $row['Country'],
					'MapX' => $row['MapX'],
					'MapY' => $row['MapY'],
					'PhoneNo' => $row['PhoneNo'],
					'Enabled' => CRUD::isActive($row['Enabled']));
		
					$i += 1;
				}

				$deals = MerchantDealModel::getListingMerchantDeal($row['ID']);
				$deals = array($deals);

                $output['Count'] = $i;
                $output['Content'] = $result;
				$output['Deals'] = $deals;
				//$output['ListingPhoto'] = ListingPhotoModel::getListingPhotoByListingID($row['ID'], "ImageURL");

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


	public function getListing($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$cover_image = $this->config['SITE_URL'].$row['ImageURL'];
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'TypeID' => $row['TypeID'],
			'TypeLabel'=> ListingTypeModel::getListingType($row['TypeID'], "Label"),
			'FilterID' => $row['FilterID'],
			'Filter2ID' => $row['Filter2ID'],
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $cover_image,
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => $row['State'],
			'Country' => $row['Country'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
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

	public function getListingList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing ORDER BY ID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MerchantID' => $row['MerchantID'],
			'TypeID' => $row['TypeID'],
			'FilterID' => $row['FilterID'],
			'Filter2ID' => $row['Filter2ID'],
			'Name' => $row['Name'],
			'BrandName' => $row['BrandName'],
			'BrandImageURL' => $cover_image,
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Street1' => $row['Street1'],
			'Street2' => $row['Street2'],
			'City' => $row['City'],
			'Postcode' => $row['Postcode'],
			'State' => $row['State'],
			'Country' => $row['Country'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'PhoneNo' => $row['PhoneNo'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;
		/*Debug::displayArray($result);
		exit;*/
		return $result;
	}
}
?>