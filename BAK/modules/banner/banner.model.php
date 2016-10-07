<?php
class BannerModel extends BaseModel
{
	private $output = array();
    private $module_name = "Banner";
	private $module_dir = "modules/banner/";
    private $module_default_url = "/main/banner/index";
    private $module_default_admin_url = "/admin/banner/index";

	public function __construct()
	{
		parent::__construct();
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM banner WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/banner/index';
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

		$sql = "SELECT * FROM banner WHERE Enabled = 1 ORDER BY Position ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'ImageURL' => Image::getImage($row['ImageURL'],'banner'),
			'Link' => $row['Link'],
			'ALtTitle' => $row['AltTitle'],
			'Target' => $row['Target'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Banners", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM banner WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'ImageURL' => $row['ImageURL'],
			'Link' => $row['Link'],
			'ALtTitle' => $row['AltTitle'],
			'Target' => CRUD::isActive($row['Target']),
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

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

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['banner_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("AltTitle",$_POST['AltTitle'],"LIKE");
			$query_condition .= $crud->queryCondition("Target",$_POST['Target'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['banner_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['banner_'.__FUNCTION__]['param']['AltTitle'] = $_POST['AltTitle'];
			$_SESSION['banner_'.__FUNCTION__]['param']['Target'] = $_POST['Target'];
			$_SESSION['banner_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['banner_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['banner_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['banner_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['banner_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM banner ".$_SESSION['banner_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/banner/index';
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

		$sql = "SELECT * FROM banner ".$_SESSION['banner_'.__FUNCTION__]['query_condition']." ORDER BY Position ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'ImageURL' => Image::getImage($row['ImageURL'],'banner'),
			'Link' => $row['Link'],
			'ALtTitle' => $row['AltTitle'],
			'Target' => CRUD::isActive($row['Target']),
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Banners", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'banner_delete' => $_SESSION['admin']['banner_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.banner_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'target_list' => CRUD::getActiveList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['banner_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Banner", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'banner_add' => $_SESSION['admin']['banner_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.banner_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Banner"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'target_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['banner_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
        // Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"banner");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            $file_location['ImageURL'] = "";
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],980,295,'banner');
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

		$key = "(Name, ImageURL, Link, AltTitle, Target, Position, Enabled)";
		$value = "('".$_POST['Name']."', '".$file_location['ImageURL']."', '".$_POST['Link']."', '".$_POST['AltTitle']."', '".$_POST['Target']."', '".$_POST['Position']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO banner ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Banner...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM banner WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'ImageURLBanner' => Image::getImage($row['ImageURL'],'banner'),
            'ImageURL' => $row['ImageURL'],
			'Link' => $row['Link'],
			'AltTitle' => $row['AltTitle'],
			'Target' => $row['Target'],
			'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Banner", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'banner_add' => $_SESSION['admin']['banner_add'], 'banner_edit' => $_SESSION['admin']['banner_edit']),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.banner_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Banner"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'target_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['banner_add']);
		unset($_SESSION['admin']['banner_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
        // Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"banner");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['ImageURLRemove']==1)
            {
                $file_location['ImageURL'] = "";
                Image::deleteImage($_POST['ImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'banner'));
            }
            else
            {
                $file_location['ImageURL'] = $_POST['ImageURLCurrent'];
            }
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],980,295,'banner');
            Image::deleteImage($_POST['ImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'banner'));
        }
        else
        {
        	$error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

		$sql = "UPDATE banner SET Name='".$_POST['Name']."', ImageURL='".$file_location['ImageURL']."', Link='".$_POST['Link']."', AltTitle='".$_POST['AltTitle']."', Target='".$_POST['Target']."', Position='".$_POST['Position']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Banner...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
        // Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM banner WHERE ID = '".$param."'";

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
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'banner'));

        // Delete entry from table
		$sql = "DELETE FROM banner WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Banner...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminSort()
    {
        $param = explode(",",$_POST['param']);

        $i = 0;
        foreach($param as $id)
        {
            $sql = "UPDATE banner SET Position='".$i."' WHERE ID='".$id."'";
            $count = $this->dbconnect->exec($sql);

            $i++;
        }

        $result = $i;

        return $result;
    }

    public function AdminPosition()
    {
        $param = $_POST['param'];

        $crud = new CRUD();

        $sql = "SELECT * FROM banner WHERE ID = '".$param."'";

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

	public function getBanner($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM banner WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'ImageURL' => Image::getImage($row['ImageURL'],'banner'),
			'Link' => $row['Link'],
			'ALtTitle' => $row['AltTitle'],
			'Target' => CRUD::isActive($row['Target']),
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result = $result[0]['Name'];

		return $result;
	}

	public function getBannerList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM banner ORDER BY ID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'ImageURL' => Image::getImage($row['ImageURL'],'banner'),
			'Link' => $row['Link'],
			'ALtTitle' => $row['AltTitle'],
			'Target' => CRUD::isActive($row['Target']),
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM banner ".$_SESSION['banner_'.$param]['query_condition']." ORDER BY Name ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Banners";
		$result['header'] = $this->config['SITE_NAME']." | Banners (" . date('Y-m-d H:i:s') . ")\n\nID, Name, Image URL, Link, Alt Title, Target, Position, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['ImageURL']."\",";
			$result['content'] .= "\"".$row['Link']."\",";
			$result['content'] .= "\"".$row['Title2']."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Target'])."\",";
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

    public function BlockIndex()
    {
        $crud = new CRUD();

        // Prepare Pagination
        $query_count = "SELECT COUNT(*) AS num FROM banner WHERE Enabled = 1";
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

        $targetpage = $data['config']['SITE_DIR'].'/main/banner/index';
        $limit = 1000;
        $stages = 3;
        $page = mysql_escape_string($param);
        if ($page) {
            $start = ($page - 1) * $limit;
        } else {
            $start = 0;
        }

        // Initialize Pagination
        $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

        $sql = "SELECT * FROM banner WHERE Enabled = 1 ORDER BY Position ASC LIMIT $start, $limit";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'ImageURL' => Image::getImage($row['ImageURL'],'banner'),
            'Link' => $row['Link'],
            'ALtTitle' => $row['AltTitle'],
			'Target' => $row['Target'],
            'Position' => $row['Position'],
            'Enabled' => CRUD::isActive($row['Enabled']));

            $i += 1;
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Banners", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'meta' => array('active' => "on"));

        return $this->output;
    }

}
?>