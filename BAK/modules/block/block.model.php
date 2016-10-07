<?php
// Require required models
Core::requireModel('area');
Core::requireModel('blocktype');

class BlockModel extends BaseModel
{
	private $output = array();
    private $module_name = "Block";
	private $module_dir = "modules/block/";
    private $module_default_url = "/main/block/index";
    private $module_default_admin_url = "/admin/block/index";

	public function __construct()
	{
		parent::__construct();
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM block WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/block/index';
		$limit = 5;
		$stages = 3;
		$page = mysql_escape_string($param);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM block WHERE Enabled = 1 ORDER BY UserID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'UserID' => $row['UserID'],
			'AreaID' => AreaModel::getArea($row['AreaID']),
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

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

	public function View($param)
	{
		$sql = "SELECT * FROM block WHERE ID = '".$param."' ORDER BY UserID ASC LIMIT 0, 5";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'UserID' => $row['UserID'],
			'AreaID' => AreaModel::getArea($row['AreaID']),
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Position' => $row['Position'],
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

	public function AdminIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['block_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("UserID",$_POST['UserID'],"=");
			$query_condition .= $crud->queryCondition("AreaID",$_POST['AreaID'],"=");
			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['block_'.__FUNCTION__]['param']['UserID'] = $_POST['UserID'];
			$_SESSION['block_'.__FUNCTION__]['param']['AreaID'] = $_POST['AreaID'];
			$_SESSION['block_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['block_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['block_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
			$_SESSION['block_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['block_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['block_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['block_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['block_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM block ".$_SESSION['block_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/block/index';
		$limit = 100000;
		$stages = 3;
		$page = mysql_escape_string($param);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM block ".$_SESSION['block_'.__FUNCTION__]['query_condition']." ORDER BY UserID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'UserID' => $row['UserID'],
			'AreaID' => AreaModel::getArea($row['AreaID']),
			'TypeID' => BlockTypeModel::getBlockType($row['TypeID']),
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Blocks", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'block_delete' => $_SESSION['admin']['block_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.block_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'area_list' => AreaModel::getAreaList(), 'blocktype_list' => BlockTypeModel::getBlockTypeList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['block_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Block", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'block_add' => $_SESSION['admin']['block_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.block_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Block"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'area_list' => AreaModel::getAreaList(), 'blocktype_list' => BlockTypeModel::getBlockTypeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['block_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
		if ($_POST['TypeID']==1)
		{
			$_POST['Content'] = trim(strip_tags($_POST['Content']));
		}

		$key = "(UserID, AreaID, TypeID, Name, Content, Position, Enabled)";
		$value = "('".$_POST['UserID']."', '".$_POST['AreaID']."', '".$_POST['TypeID']."', '".$_POST['Name']."', '".$_POST['Content']."', '".$_POST['Position']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO block ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Block...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM block WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'UserID' => $row['UserID'],
			'AreaID' => $row['AreaID'],
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Block", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'block_add' => $_SESSION['admin']['block_add'], 'block_edit' => $_SESSION['admin']['block_edit']),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.block_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Block"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'area_list' => AreaModel::getAreaList(), 'blocktype_list' => BlockTypeModel::getBlockTypeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['block_add']);
		unset($_SESSION['admin']['block_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		if ($_POST['TypeID']==1)
		{
			$_POST['Content'] = trim(strip_tags($_POST['Content']));
		}

		$sql = "UPDATE block SET UserID='".$_POST['UserID']."', AreaID='".$_POST['AreaID']."', TypeID='".$_POST['TypeID']."', Name='".$_POST['Name']."', Content='".$_POST['Content']."', Position='".$_POST['Position']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Block...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM block WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Block...", 'template' => 'admin.common.tpl.php'),
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
            $sql = "UPDATE block SET Position='".$i."' WHERE ID='".$id."'";
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

        $sql = "SELECT * FROM block WHERE ID = '".$param."'";

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

	public function getBlockHookList($area)
	{
		$crud = new CRUD();

		if ($area!='')
		{
			$area_param = ' AND `AreaID` = ' . AreaModel::getAreaID($area);
		}

		$sql = "SELECT * FROM block WHERE Enabled = 1 ".$area_param." ORDER BY Position ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'][$i] = array(
			'ID' => $row['ID'],
			'UserID' => $row['UserID'],
			'AreaID' => AreaModel::getArea($row['AreaID']),
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM block ".$_SESSION['block_'.$param]['query_condition']." ORDER BY UserID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Blocks";
		$result['header'] = $this->config['SITE_NAME']." | Blocks (" . date('Y-m-d H:i:s') . ")\n\nID, User, Area, Type, Name, Content, Position, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['UserID']."\",";
			$result['content'] .= "\"".AreaModel::getArea($row['AreaID'])."\",";
			$result['content'] .= "\"".BlockTypeModel::getBlockType($row['TypeID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Content'])."\",";
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

	public function getBlock($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM block WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'UserID' => $row['UserID'],
			'AreaID' => AreaModel::getArea($row['AreaID']),
			'TypeID' => BlockTypeModel::getBlockType($row['TypeID']),
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result = $result[0]['UserID'];

		return $result;
	}

    public function getBlockContent($param)
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM block WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'UserID' => $row['UserID'],
            'AreaID' => AreaModel::getArea($row['AreaID']),
            'TypeID' => BlockTypeModel::getBlockType($row['TypeID']),
            'Name' => $row['Name'],
            'Content' => $row['Content'],
            'Position' => $row['Position'],
            'Enabled' => CRUD::isActive($row['Enabled']));

            $i += 1;
        }

        $result = $result[0]['Content'];

        return $result;
    }
    
    public function getAPIBlockContent($param)
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM block WHERE ID = '".$param."'";


        foreach ($this->dbconnect->query($sql) as $row)
        {
            $dataSet = array(
            'ID' => $row['ID'],
            'UserID' => $row['UserID'],
            'AreaID' => AreaModel::getArea($row['AreaID']),
            'TypeID' => BlockTypeModel::getBlockType($row['TypeID']),
            'Name' => $row['Name'],
            'Content' => $row['Content'],
            'Position' => $row['Position'],
            'Enabled' => CRUD::isActive($row['Enabled']));

            
        }

        $result = $dataSet['Content'];

        return $result;
    }

	public function getBlockList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM block ORDER BY UserID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'UserID' => $row['UserID'],
			'AreaID' => AreaModel::getArea($row['AreaID']),
			'TypeID' => BlockTypeModel::getBlockType($row['TypeID']),
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
}
?>