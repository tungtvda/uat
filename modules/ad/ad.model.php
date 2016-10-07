<?php
// Require required models
Core::requireModel('adtype');
Core::requireModel('merchant');
Core::requireModel('dealer');

class AdModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['ad'] = array(
        'name' => "Ad",
        'dir' => "modules/ad/",
        'default_url' => "/main/ad/index",
        'admin_url' => "/admin/ad/index",
		'merchant_url' => "/merchant/ad/index",
		'dealer_url' => "/dealer/ad/index");
		
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
		$query_count = "SELECT COUNT(*) AS num FROM ad WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/ad/index';
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

		$sql = "SELECT * FROM ad WHERE Enabled = 1 ORDER BY TypeID ASC LIMIT $start, $limit";

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
			'TypeID' => $row['TypeID'],
			'MerchantID' => $row['MerchantID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['ad']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Ads", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['ad']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM ad WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MerchantID' => $row['MerchantID'],
			'Name' => $row['Name'],
			'ImageURL' => $row['ImageURL'],
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['ad']['name'], "Link" => $this->module['ad']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['ad']['dir'].'inc/main/view.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
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

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['ad_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=");
			$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("AdLink",$_POST['AdLink'],"LIKE");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateTimeDisplaySQL($_POST['DateExpiryFrom']),">=");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateTimeDisplaySQL($_POST['DateExpiryTo']),"<=");

			$_SESSION['ad_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['ad_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['ad_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['ad_'.__FUNCTION__]['param']['AdLink'] = $_POST['AdLink'];
			$_SESSION['ad_'.__FUNCTION__]['param']['DateExpiryFrom'] = $_POST['DateExpiryFrom'];
			$_SESSION['ad_'.__FUNCTION__]['param']['DateExpiryTo'] = $_POST['DateExpiryTo'];

			// Set Query Variable
			$_SESSION['ad_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['ad_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['ad_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['ad_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM ad ".$_SESSION['ad_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/ad/index';
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

		$sql = "SELECT * FROM ad ".$_SESSION['ad_'.__FUNCTION__]['query_condition']." ORDER BY TypeID ASC LIMIT $start, $limit";

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

            $adtype = AdTypeModel::getAdType($row['TypeID']);

			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => AdTypeModel::getAdType($row['TypeID']),
            'TypeID' => $adtype['ID']." - ".$adtype['Label'],
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID']),
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'AdLink' => $row['AdLink'],
			'DateExpiry' => Helper::datetimeSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['ad']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Ads", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['ad']['dir'].'inc/admin/index.inc.php', 'ad_delete' => $_SESSION['admin']['ad_delete']),
		'block' => array('side_nav' => $this->module['ad']['dir'].'inc/admin/side_nav.ad_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'adtype_list' => AdTypeModel::getAdTypeList(), 'merchant_list' => MerchantModel::getMerchantList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['ad_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['ad']['name'], "Link" => $this->module['ad']['admin_url']),
            array("Title" => "Create Ad", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Ad", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['ad']['dir'].'inc/admin/add.inc.php', 'ad_add' => $_SESSION['admin']['ad_add']),
		'block' => array('side_nav' => $this->module['ad']['dir'].'inc/admin/side_nav.ad_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'adtype_list' => AdTypeModel::getAdTypeList(), 'merchant_list' => MerchantModel::getMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['ad_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"ad");

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
            $sql = "UPDATE ad SET Cover='0' WHERE TypeID='".$_POST['TypeID']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(TypeID, MerchantID, Name, ImageURL, AdLink, DateExpiry)";
		$value = "('".$_POST['TypeID']."', '".$_POST['MerchantID']."', '".$_POST['Name']."', '".$file_location['ImageURL']."', '".$_POST['AdLink']."', '".Helper::datetimeDisplaySQL($_POST['DateExpiry'])."')";

		$sql = "INSERT INTO ad ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Ad...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM ad WHERE ID = '".$param."'";

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
			'TypeID' => $row['TypeID'],
			'MerchantID' => $row['MerchantID'],
			'Name' => $row['Name'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'AdLink' => $row['AdLink'],
			'DateExpiry' => Helper::datetimeSQLToDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['ad']['name'], "Link" => $this->module['ad']['admin_url']),
            array("Title" => "Edit Ad", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Ad",
					'template' => 'admin.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['ad']['dir'].'inc/admin/edit.inc.php',
					'ad_add' => $_SESSION['admin']['ad_add'],
                    'ad_edit' => $_SESSION['admin']['ad_edit']),
		'block' => array('side_nav' => $this->module['ad']['dir'].'inc/admin/side_nav.ad_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'adtype_list' => AdTypeModel::getAdTypeList(), 'merchant_list' => MerchantModel::getMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['ad_add']);
		unset($_SESSION['admin']['ad_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"ad");

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
            $sql = "UPDATE ad SET Cover='0' WHERE TypeID='".$_POST['TypeID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE ad SET TypeID='".$_POST['TypeID']."', MerchantID='".$_POST['MerchantID']."', Name='".$_POST['Name']."', ImageURL='".$file_location['ImageURL']."', AdLink='".$_POST['AdLink']."', DateExpiry='".Helper::datetimeDisplaySQL($_POST['DateExpiry'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Ad...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM ad WHERE ID = '".$param."'";

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
		$sql = "DELETE FROM ad WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Ad...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM ad ".$_SESSION['ad_'.$param]['query_condition']." ORDER BY TypeID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Ad";
		$result['header'] = $this->config['SITE_NAME']." | Ad (" . date('Y-m-d H:i:s') . ")\n\nID, Type, Merchant, Name, ImageURL, Date Expiry";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".AdTypeModel::getAdType($row['TypeID'])."\",";
			$result['content'] .= "\"".MerchantModel::getMerchant($row['MerchantID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['ImageURL']."\",";
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

	public function MerchantIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['ad_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=");
			/*$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=");*/
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("AdLink",$_POST['AdLink'],"LIKE");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::datetimeDisplaySQL($_POST['DateExpiryFrom']),">=");
			$query_condition .= $crud->queryCondition("DateExpiry",Helper::datetimeDisplaySQL($_POST['DateExpiryTo']),"<=");

			$_SESSION['ad_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			/*$_SESSION['ad_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];*/
			$_SESSION['ad_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['ad_'.__FUNCTION__]['param']['AdLink'] = $_POST['AdLink'];
			$_SESSION['ad_'.__FUNCTION__]['param']['DateExpiryFrom'] = $_POST['DateExpiryFrom'];
			$_SESSION['ad_'.__FUNCTION__]['param']['DateExpiryTo'] = $_POST['DateExpiryTo'];

			// Set Query Variable
			$_SESSION['ad_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['ad_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['ad_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['ad_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM ad ".$_SESSION['ad_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/merchant/ad/index';
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

		$sql = "SELECT * FROM ad ".$_SESSION['ad_'.__FUNCTION__]['query_condition']." ORDER BY TypeID ASC LIMIT $start, $limit";
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

            $ad = AdTypeModel::getAdType($row['TypeID']);

			$result[$i] = array(
			'ID' => $row['ID'],
			//'TypeID' => AdTypeModel::getAdType($row['TypeID'], $column = "Label"),
            'TypeID' => $ad['ID']." - ".$ad['Label'],
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID'], $column = "Name"),
			'Name' => $row['Name'],
			'AdLink' => $row['AdLink'],
			'ImageURL' => $cover_image,
			'DateExpiry' => Helper::datetimeSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['merchant_url']),
            array("Title" => $this->module['ad']['name'], "Link" => ""),
            //array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Ad", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['ad']['dir'].'inc/merchant/index.inc.php', 'ad_delete' => $_SESSION['merchant']['ad_delete']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'ad_namelist' => AdModel::getAdNameList(), 'merchant_list' => MerchantModel::getMerchantList(), 'sort' => $sort, 'adtype_list'=>AdTypeModel::getAdTypeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['ad_delete']);

		return $this->output;
	}

	public function MerchantAdd()
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['merchant_url']),
            array("Title" => $this->module['ad']['name'], "Link" => $this->module['ad']['merchant_url']),
            array("Title" => "Add", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Ad", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['ad']['dir'].'inc/merchant/add.inc.php', 'ad_add' => $_SESSION['merchant']['ad_add']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'ad_list' => AdModel::getAdList(), 'merchant_list' => MerchantModel::getMerchantList(), 'adtype_list'=>AdTypeModel::getAdTypeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['ad_add']);

		return $this->output;
	}

	public function MerchantAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"ad");

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
            $sql = "UPDATE ad SET Cover='0' WHERE TypeID='".$_POST['TypeID']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(TypeID, MerchantID, Name, AdLink, ImageURL, DateExpiry)";
		$value = "('".$_POST['TypeID']."', '".$_SESSION['merchant']['ID']."', '".$_POST['Name']."', '".$_POST['AdLink']."', '".$file_location['ImageURL']."', '".Helper::datetimeDisplaySQL($_POST['DateExpiry'])."')";

		$sql = "INSERT INTO ad ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Ad Type...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MerchantEdit($param)
	{
		$sql = "SELECT * FROM ad WHERE ID = '".$param."' AND MerchantID = '".$_SESSION['merchant']['ID']."'";
		/*echo $sql;
		exit;*/
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
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'AdLink' => $row['AdLink'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'DateExpiry' => Helper::datetimeSQLToDisplay($row['DateExpiry']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['merchant_url']),
            array("Title" => $this->module['ad']['name'], "Link" => $this->module['ad']['merchant_url']),
            array("Title" => "Edit", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Ad",
					'template' => 'common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['ad']['dir'].'inc/merchant/edit.inc.php',
					'ad_add' => $_SESSION['merchant']['ad_add'],
                    'ad_edit' => $_SESSION['merchant']['ad_edit']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'ad_list' => AdModel::getAdList(), 'merchant_list' => MerchantModel::getMerchantList(), 'adtype_list'=>AdTypeModel::getAdTypeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['merchant']['ad_add']);
		unset($_SESSION['merchant']['ad_edit']);

		return $this->output;
	}

	public function MerchantEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"ad");

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
            $sql = "UPDATE ad SET Cover='0' WHERE TypeID='".$_POST['TypeID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE ad SET TypeID='".$_POST['TypeID']."', Name='".$_POST['Name']."', AdLink='".$_POST['AdLink']."', ImageURL='".$file_location['ImageURL']."', DateExpiry='".Helper::datetimeDisplaySQL($_POST['DateExpiry'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Ad Type...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MerchantDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM ad WHERE ID = '".$param."'";

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
		$sql = "DELETE FROM ad WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Ad Type...", 'template' => 'common.tpl.php'),
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
			$_SESSION['ad_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("ads.TypeID",$_POST['TypeID'],"=",1);
			$query_condition .= $crud->queryCondition("ads.MerchantID",$_POST['MerchantID'],"=");
			$query_condition .= $crud->queryCondition("ads.ID",$_POST['ID'],"=");
			$query_condition .= $crud->queryCondition("ads.Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("ads.AdLink",$_POST['AdLink'],"LIKE");
			$query_condition .= $crud->queryCondition("ads.DateExpiry",Helper::datetimeDisplaySQL($_POST['DateExpiryFrom']),">=");
			$query_condition .= $crud->queryCondition("ads.DateExpiry",Helper::datetimeDisplaySQL($_POST['DateExpiryTo']),"<=");

			$_SESSION['ad_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['ad_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
			$_SESSION['ad_'.__FUNCTION__]['param']['ID'] = $_POST['ID'];
			$_SESSION['ad_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['ad_'.__FUNCTION__]['param']['AdLink'] = $_POST['AdLink'];
			$_SESSION['ad_'.__FUNCTION__]['param']['DateExpiryFrom'] = $_POST['DateExpiryFrom'];
			$_SESSION['ad_'.__FUNCTION__]['param']['DateExpiryTo'] = $_POST['DateExpiryTo'];

			// Set Query Variable
			$_SESSION['ad_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['ad_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['ad_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['ad_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM ad AS ads, merchant AS m WHERE m.ID = ads.MerchantID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['ad_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/dealer/ad/index';
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

		$sql = "SELECT ads.ID, ads.TypeID, ads.MerchantID, ads.Name, ads.AdLink, ads.ImageURL, ads.DateExpiry FROM ad AS ads, merchant AS m WHERE m.ID = ads.MerchantID AND m.DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['ad_'.__FUNCTION__]['query_condition']." ORDER BY ads.TypeID ASC LIMIT $start, $limit";
		//echo $sql;
		
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

            $ad = AdTypeModel::getAdType($row['TypeID']);

			$result[$i] = array(
			'ID' => $row['ID'],
			//'TypeID' => AdTypeModel::getAdType($row['TypeID'], $column = "Label"),
            'TypeID' => $ad['ID']." - ".$ad['Label'],
			'MerchantID' => MerchantModel::getMerchant($row['MerchantID'], $column = "Name"),
			'Name' => $row['Name'],
			'AdLink' => $row['AdLink'],
			'ImageURL' => $cover_image,
			'DateExpiry' => Helper::datetimeSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}
		/*Debug::displayArray($result);
		exit;*/
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['ad']['name'], "Link" => "")
            //array("Title" => "Edit", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Ad", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['ad']['dir'].'inc/dealer/index.inc.php', 'ad_delete' => $_SESSION['dealer']['ad_delete']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'adtype_list' => AdTypeModel::getAdTypeList(), 'ad_list' => AdModel::getAdList(), 'merchant_list' => MerchantModel::getDealerMerchantList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['ad_delete']);

		return $this->output;
	}

	public function DealerAdd()
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['ad']['name'], "Link" => $this->module['ad']['dealer_url']),
            array("Title" => "Add", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Ad", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['ad']['dir'].'inc/dealer/add.inc.php', 'ad_add' => $_SESSION['dealer']['ad_add']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'ad_list' => AdModel::getAdList(), 'merchant_list' => MerchantModel::getDealerMerchantList(),'adtype_list' => AdTypeModel::getAdTypeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['ad_add']);

		return $this->output;
	}

	public function DealerAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"ad");

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
            $sql = "UPDATE ad SET Cover='0' WHERE TypeID='".$_POST['TypeID']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(TypeID, MerchantID, Name, AdLink, ImageURL, DateExpiry)";
		$value = "('".$_POST['TypeID']."', '".$_POST['MerchantID']."', '".$_POST['Name']."', '".$_POST['AdLink']."', '".$file_location['ImageURL']."', '".Helper::dateDisplaySQL($_POST['DateExpiry'])."')";

		$sql = "INSERT INTO ad ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Ad Type...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerEdit($param)
	{
		$sql = "SELECT * FROM ad WHERE ID = '".$param."'";

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
			'TypeID' => $row['TypeID'],
			'MerchantID' => $row['MerchantID'],
			'Name' => $row['Name'],
			'AdLink' => $row['AdLink'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'DateExpiry' => Helper::dateSQLToDisplay($row['DateExpiry']));

			$i += 1;
		}

         // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['ad']['name'], "Link" => $this->module['ad']['dealer_url']),
            array("Title" => "Edit", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Ad",
					'template' => 'common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['ad']['dir'].'inc/dealer/edit.inc.php',
					'ad_add' => $_SESSION['dealer']['ad_add'],
                    'ad_edit' => $_SESSION['dealer']['ad_edit']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'adtype_list' => AdTypeModel::getAdTypeList(), 'merchant_list' => MerchantModel::getDealerMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['ad_add']);
		unset($_SESSION['dealer']['ad_edit']);

		return $this->output;
	}

	public function DealerEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"ad");

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
            $sql = "UPDATE ad SET Cover='0' WHERE TypeID='".$_POST['TypeID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE ad SET TypeID='".$_POST['TypeID']."', MerchantID='".$_POST['MerchantID']."', Name='".$_POST['Name']."', AdLink='".$_POST['AdLink']."', ImageURL='".$file_location['ImageURL']."', DateExpiry='".Helper::dateDisplaySQL($_POST['DateExpiry'])."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Ad Type...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM ad WHERE ID = '".$param."'";

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
		$sql = "DELETE FROM ad WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Ad Type...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdControl()
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
				$query_condition = "";
		
				$crud = new CRUD();
		
				if ($_POST['Trigger']=='search_form')
				{
					// Reset Query Variable
					$_SESSION['ad_'.__FUNCTION__] = "";
		
					$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=");
					$query_condition .= $crud->queryCondition("MerchantID",$_POST['MerchantID'],"=");
					$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
					$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateDisplaySQL($_POST['DateExpiryFrom']),">=");
					$query_condition .= $crud->queryCondition("DateExpiry",Helper::dateDisplaySQL($_POST['DateExpiryTo']),"<=");
		
					$_SESSION['ad_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
					$_SESSION['ad_'.__FUNCTION__]['param']['MerchantID'] = $_POST['MerchantID'];
					$_SESSION['ad_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
					$_SESSION['ad_'.__FUNCTION__]['param']['DateExpiryFrom'] = $_POST['DateExpiryFrom'];
					$_SESSION['ad_'.__FUNCTION__]['param']['DateExpiryTo'] = $_POST['DateExpiryTo'];
		
					// Set Query Variable
					$_SESSION['ad_'.__FUNCTION__]['query_condition'] = $query_condition;
					$_SESSION['ad_'.__FUNCTION__]['query_title'] = "Search Results";
				}
		
				// Reset query conditions
				if ($_GET['page']=="all")
				{
					$_GET['page'] = "";
					unset($_SESSION['ad_'.__FUNCTION__]);
				}
		
				// Determine Title
				if (isset($_SESSION['ad_'.__FUNCTION__]))
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
				$query_count = "SELECT COUNT(*) AS num FROM ad ".$_SESSION['ad_'.__FUNCTION__]['query_condition'];
				$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
				$targetpage = $data['config']['SITE_URL'].'/merchant/ad/index';
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
		
				$sql = "SELECT * FROM ad ".$_SESSION['ad_'.__FUNCTION__]['query_condition']." ORDER BY TypeID ASC LIMIT $start, $limit";
		
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
		
		            $ad = AdTypeModel::getAdType($row['TypeID']);
		
					$result[$i] = array(
					'ID' => $row['ID'],
					//'TypeID' => AdTypeModel::getAdType($row['TypeID'], $column = "Label"),
		            'TypeID' => $ad['ID']." - ".$ad['Label'],
					'MerchantID' => MerchantModel::getMerchant($row['MerchantID'], $column = "Name"),
					'Name' => $row['Name'],
					'ImageURL' => $cover_image,
					'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));
		
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
                $sql = "SELECT * FROM ad WHERE ID = '".$param."'";

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
		
		            $ad = AdTypeModel::getAdType($row['TypeID']);
		
					$result[$i] = array(
					'ID' => $row['ID'],
					//'TypeID' => AdTypeModel::getAdType($row['TypeID'], $column = "Label"),
		            'TypeID' => $ad['ID']." - ".$ad['Label'],
					'MerchantID' => MerchantModel::getMerchant($row['MerchantID'], $column = "Name"),
					'Name' => $row['Name'],
					'ImageURL' => $cover_image,
					'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));
		
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

	public function APIHome($param)
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
               
				$result = AdModel::getSplashAd("1");
				
				if(empty($result)){
					
					$i = 0;
				}else{
					
					$i= 1;
				}

                //$result = array($result);
                //$output['Content'] = $result;

                // Set output
                if ($i>0)
                {
                    $result = json_encode($result);
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

	public function getAd($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM ad WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MerchantID' => $row['MerchantID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
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
	
	public function getAdLimit($param, $type)
	{
		$crud = new CRUD();

		$ad = $param / 4;
		
		$ad = floor($ad);
		/*echo $ad;
		exit;*/
		
		/*$sql = "SELECT MAX(ID) AS LastID FROM ad";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$count = $row['LastID'];
		}*/
		$result = array();
		$i = 0;
		
		$sql = "SELECT * FROM `ad` WHERE TypeID = '".$type."' ORDER BY RAND() LIMIT ".$ad;
		
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
			'TypeID' => $row['TypeID'],
			'MerchantID' => $row['MerchantID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'AdLink' => $row['AdLink'],
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

		/*Debug::displayArray($result);
		exit;*/	
		return $result;
	}

	public function getSplashAd($type)
	{
		$crud = new CRUD();
		
		/*$sql = "SELECT MAX(ID) AS LastID FROM ad";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$count = $row['LastID'];
		}*/
		$result = array();
		//$i = 0;
		
		$sql = "SELECT * FROM `ad` WHERE TypeID = '".$type."' ORDER BY RAND() LIMIT 1";
		
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
			
			$result = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MerchantID' => $row['MerchantID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'AdLink' => $row['AdLink'],
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));

			//$i += 1;
		}

		/*Debug::displayArray($result);
		exit;*/	
		return $result;
	}
	
	public function getAdNameList()
	{
		$crud = new CRUD();

		$sql = "SELECT Name FROM ad";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array('Name' => $row['Name']);

			$i += 1;
		}

		$result['count'] = $i; 
		return $result;
	}

	public function getAdList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM ad ORDER BY TypeID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'MerchantID' => $row['MerchantID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'DateExpiry' => Helper::dateSQLToLongDisplay($row['DateExpiry']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
}
?>