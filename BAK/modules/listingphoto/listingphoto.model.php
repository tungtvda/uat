<?php
// Require required models
Core::requireModel('listing');


class ListingPhotoModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['listingphoto'] = array(
        'name' => "Listing Photo",
        'dir' => "modules/listingphoto/",
        'default_url' => "/main/listingphoto/index",
        'admin_url' => "/admin/listingphoto/index");

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
		$query_count = "SELECT COUNT(*) AS num FROM listing_photo WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/listingphoto/index';
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

		$sql = "SELECT * FROM listing_photo WHERE Enabled = 1 ORDER BY ListingID ASC LIMIT $start, $limit";

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
			'ListingID' => $row['ListingID'],
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Cover' => $row['Cover'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingphoto']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Listing Photos", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingphoto']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM listing_photo WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ListingID' => $row['ListingID'],
			'Description' => $row['Description'],
			'ImageURL' => $row['ImageURL'],
			'Cover' => $row['Cover'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingphoto']['name'], "Link" => $this->module['listingphoto']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingphoto']['dir'].'inc/main/view.inc.php'),
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
			$_SESSION['listingphoto_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Cover",$_POST['Cover'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['listingphoto_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
			$_SESSION['listingphoto_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['listingphoto_'.__FUNCTION__]['param']['Cover'] = $_POST['Cover'];
			$_SESSION['listingphoto_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['listingphoto_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['listingphoto_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['listingphoto_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['listingphoto_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM listing_photo ".$_SESSION['listingphoto_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/listingphoto/index';
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

		$sql = "SELECT * FROM listing_photo ".$_SESSION['listingphoto_'.__FUNCTION__]['query_condition']." ORDER BY ListingID ASC, Cover DESC, Position ASC LIMIT $start, $limit";

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
			'ListingID' => $row['ListingID'],
            'ListingID' => $listing['ID']." - ".$listing['Name'],
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Cover' => CRUD::isActive($row['Cover']),
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingphoto']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Listing Photos", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingphoto']['dir'].'inc/admin/index.inc.php', 'listingphoto_delete' => $_SESSION['admin']['listingphoto_delete']),
		'block' => array('side_nav' => $this->module['listingphoto']['dir'].'inc/admin/side_nav.listingphoto_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listingphoto_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingphoto']['name'], "Link" => $this->module['listingphoto']['admin_url']),
            array("Title" => "Create Listing Photo", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Listing Photo", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingphoto']['dir'].'inc/admin/add.inc.php', 'listingphoto_add' => $_SESSION['admin']['listingphoto_add']),
		'block' => array('side_nav' => $this->module['listingphoto']['dir'].'inc/admin/side_nav.listingphoto_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listingphoto_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listingphoto");

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
            $sql = "UPDATE listing_photo SET Cover='0' WHERE ListingID='".$_POST['ListingID']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(ListingID, Description, ImageURL, Cover, Position, Enabled)";
		$value = "('".$_POST['ListingID']."', '".$_POST['Description']."', '".$file_location['ImageURL']."', '".$_POST['Cover']."', '".$_POST['Position']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO listing_photo ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Listing Photo...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM listing_photo WHERE ID = '".$param."'";

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
			'Description' => $row['Description'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Cover' => $row['Cover'],
			'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingphoto']['name'], "Link" => $this->module['listingphoto']['admin_url']),
            array("Title" => "Edit Listing Photo", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Listing Photo",
					'template' => 'admin.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['listingphoto']['dir'].'inc/admin/edit.inc.php',
					'listingphoto_add' => $_SESSION['admin']['listingphoto_add'],
                    'listingphoto_edit' => $_SESSION['admin']['listingphoto_edit']),
		'block' => array('side_nav' => $this->module['listingphoto']['dir'].'inc/admin/side_nav.listingphoto_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listingphoto_add']);
		unset($_SESSION['admin']['listingphoto_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listingphoto");

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
            $sql = "UPDATE listing_photo SET Cover='0' WHERE ListingID='".$_POST['ListingID']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE listing_photo SET ListingID='".$_POST['ListingID']."', Description='".$_POST['Description']."', ImageURL='".$file_location['ImageURL']."', Cover='".$_POST['Cover']."', Position='".$_POST['Position']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Listing Photo...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM listing_photo WHERE ID = '".$param."'";

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
		$sql = "DELETE FROM listing_photo WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Listing Photo...", 'template' => 'admin.common.tpl.php'),
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
			$_SESSION['listingphoto_'.__FUNCTION__.'_'.$item['id']] = "";

			$query_condition .= $crud->queryCondition("Cover",$_POST['Cover'],"=",1);
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['listingphoto_'.__FUNCTION__]['param']['Cover'] = $_POST['Cover'];
			$_SESSION['listingphoto_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['listingphoto_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['listingphoto_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['listingphoto_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['listingphoto_'.__FUNCTION__.'_'.$item['id']]);
		}

		// Determine Title
		if (isset($_SESSION['listingphoto_'.__FUNCTION__.'_'.$item['id']]))
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
		$query_count = "SELECT COUNT(*) AS num FROM listing_photo WHERE ListingID = '".$item['id']."' ".$_SESSION['listingphoto_'.__FUNCTION__.'_'.$item['id']]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/listingphoto/listingindex/'.$item['id'];
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

		$sql = "SELECT * FROM listing_photo WHERE ListingID = '".$item['id']."' ".$_SESSION['listingphoto_'.__FUNCTION__.'_'.$item['id']]['query_condition']." ORDER BY ListingID ASC, Cover DESC, Position ASC LIMIT $start, $limit";

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
			'ListingID' => $row['ListingID'],
            'ListingID' => $listing['ID']." - ".$listing['Name'],
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Cover' => CRUD::isActive($row['Cover']),
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => $this->module['listingphoto']['name'], "Link" => "")
        );

		$this->output = array(
        'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Listing Photos", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingphoto']['dir'].'inc/admin/listingindex.inc.php', 'listingphoto_listingdelete' => $_SESSION['admin']['listingphoto_listingdelete']),
		'block' => array('side_nav' => $this->module['listingphoto']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listingphoto_listingdelete']);

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
            array("Title" => "Create Photo", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Create Listing Photo", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingphoto']['dir'].'inc/admin/listingadd.inc.php', 'listingphoto_listingadd' => $_SESSION['admin']['listingphoto_listingadd']),
		'block' => array('side_nav' => $this->module['listingphoto']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listingphoto_listingadd']);

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
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listingphoto");

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
            $sql = "UPDATE listing_photo SET Cover='0' WHERE ListingID='".$item['id']."'";
            $this->dbconnect->exec($sql);
        }

		$key = "(ListingID, Description, ImageURL, Cover, Position, Enabled)";
		$value = "('".$item['id']."', '".$_POST['Description']."', '".$file_location['ImageURL']."', '".$_POST['Cover']."', '".$_POST['Position']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO listing_photo ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Creating Listing Photo...", 'template' => 'admin.common.tpl.php'),
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
        
		$sql = "SELECT * FROM listing_photo WHERE ID = '".$item['child']."' AND ListingID = '".$item['id']."'";

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
			'Description' => $row['Description'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Cover' => $row['Cover'],
			'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listing']['name'], "Link" => $this->module['listing']['admin_url']),
            array("Title" => $item['title'], "Link" => $item['url']),
            array("Title" => "Edit Photo", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
        'parent' => $item,
		'page' => array(
					'title' => "Edit Listing Photo",
					'template' => 'admin.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module['listingphoto']['dir'].'inc/admin/listingedit.inc.php',
					'listingphoto_listingadd' => $_SESSION['admin']['listingphoto_listingadd'],
                    'listingphoto_listingedit' => $_SESSION['admin']['listingphoto_listingedit']),
		'block' => array('side_nav' => $this->module['listingphoto']['dir'].'inc/admin/side_nav.listing.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listingphoto_listingadd']);
		unset($_SESSION['admin']['listingphoto_listingedit']);

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
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"listingphoto");

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
            $sql = "UPDATE listing_photo SET Cover='0' WHERE ListingID='".$item['id']."'";
            $this->dbconnect->exec($sql);
        }

		$sql = "UPDATE listing_photo SET ImageURL='".$file_location['ImageURL']."', Description='".$_POST['Description']."', Cover='".$_POST['Cover']."', Position='".$_POST['Position']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$item['child']."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
        'config' => $this->config,
        'parent' => $item,
        'current' => array('id' => $item['child']),
		'page' => array('title' => "Editing Listing Photo...", 'template' => 'admin.common.tpl.php'),
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

        $sql = "SELECT * FROM listing_photo WHERE ID = '".$item['child']."'";

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
		$sql = "DELETE FROM listing_photo WHERE ID = '".$item['child']."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
        'config' => $this->config,
        'parent' => $item,
		'page' => array('title' => "Deleting Listing Photo...", 'template' => 'admin.common.tpl.php'),
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
            $sql = "UPDATE listing_photo SET Position='".$i."' WHERE ID='".$id."'";
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

        $sql = "SELECT * FROM listing_photo WHERE ID = '".$param."'";

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

	public function getListingPhotoCover($param, $size = 'cover')
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing_photo WHERE Cover = 1 AND Enabled = 1 AND ListingID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ImageURL' => Image::getImage($row['ImageURL'], $size));

			$i += 1;
		}

		$result = $result[0]['ImageURL'];

		if ($result=="")
		{
			$sql = "SELECT * FROM listing_photo WHERE ListingID = '".$param."' ORDER BY Position ASC LIMIT 0,1";

			$result = array();
			$i = 0;
			foreach ($this->dbconnect->query($sql) as $row)
			{
				$result[$i] = array(
				'ID' => $row['ID'],
				'ImageURL' => Image::getImage($row['ImageURL'], $size));

				$i += 1;
			}

			$result = $result[0]['ImageURL'];
		}

		return $result;
	}

	// Get all active listing images for a specific listing
	public function getListingPhotoGroup($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing_photo WHERE ListingID = ".$param." AND Enabled = 1 ORDER BY Cover DESC, Position ASC, ID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ImageURL' => $row['ImageURL'],
			'ImageURLThumb' => Image::getImage($row['ImageURL'],'thumb'),
            'ImageURLCover' => Image::getImage($row['ImageURL'],'cover'),
			'ImageURLMedium' => Image::getImage($row['ImageURL'],'medium'));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM listing_photo ".$_SESSION['listingphoto_'.$param]['query_condition']." ORDER BY ListingID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Listing_Photo";
		$result['header'] = $this->config['SITE_NAME']." | Listing Photo (" . date('Y-m-d H:i:s') . ")\n\nID, Listing, Description, ImageURL, Cover, Position, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ListingModel::getListing($row['ListingID'])."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Description'])."\",";
			$result['content'] .= "\"".$row['ImageURL']."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Cover'])."\",";
			$result['content'] .= "\"".$row['Position']."\",";
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

	public function getListingPhoto($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing_photo WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ListingID' => ListingModel::getListing($row['ListingID']),
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Cover' => CRUD::isActive($row['Cover']),
			'Position' => $row['Position'],
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
	
	public function getListingPhotoByListingID($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing_photo WHERE ListingID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			//$row['ImageURL'] = Image::getImage($row['ImageURL']);
			$result[$i] = array(
			
			'ImageURL' => $this->config['SITE_URL'].$row['ImageURL'],
			'Description' => $row['Description']
			);
			
			// Determine if get all fields or one specific field
	        
			

			$i += 1;
		}

		

		return $result;
	}

	public function getListingPhotoList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing_photo ORDER BY ListingID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ListingID' => ListingModel::getListing($row['ListingID']),
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Cover' => CRUD::isActive($row['Cover']),
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
}
?>