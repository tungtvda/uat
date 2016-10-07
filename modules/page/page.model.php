<?php
// Require required models
Core::requireModel('pagecategory');
Core::requireModel('pagestatus');
Core::requireModel('template');
Core::requireModel('generator');

class PageModel extends BaseModel
{
	private $output = array();
    private $module_name = "Page";
	private $module_dir = "modules/page/";
    private $module_default_url = "/main/page/index";
    private $module_default_admin_url = "/admin/page/index";

	public function __construct()
	{
		parent::__construct();
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM page WHERE Enabled = 1 AND Status = 2";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/page/index';
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

		$sql = "SELECT * FROM page WHERE Enabled = 1 AND Status = 2 ORDER BY DatePosted DESC, ID DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CategoryID' => $row['CategoryID'],
			'Title' => $row['Title'],
			'MetaKeyword' => $row['MetaKeyword'],
			'Heading'=> $row['Heading'],
			'FriendlyURL'=> $row['FriendlyURL'],
			'Description' => $row['Description'],
			'Content' => $row['Content'],
			'TemplateID' => TemplateModel::getTemplateFilename($row['TemplateID']),
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
			'Status' => $row['Status'],
			'Enabled' => CRUD::isActive($row['Enabled']),
			'LastUpdated' => Helper::dateSQLToLongDisplay($row['LastUpdated']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Page", 'template' => $result[0]['TemplateID'], 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/main/side_nav.page.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
        if ($_GET['preview']==1)
        {
            $query_condition ="";
        }
        else
        {
           $query_condition = " AND Status = 2 AND Enabled = 1";
        }

        $sql = "SELECT * FROM page WHERE ID = '".$param."'".$query_condition;

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CategoryID' => $row['CategoryID'],
			'Title' => $row['Title'],
			'MetaKeyword' => $row['MetaKeyword'],
			'Heading'=> $row['Heading'],
			'FriendlyURL'=> $row['FriendlyURL'],
			'Description' => $row['Description'],
			'Content' => $row['Content'],
			'TemplateID' => TemplateModel::getTemplateFilename($row['TemplateID']),
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
			'Status' => $row['Status'],
			'Enabled' => CRUD::isActive($row['Enabled']),
			'LastUpdated' => Helper::dateSQLToLongDisplay($row['LastUpdated']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => $result[0]['TemplateID'], 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/view.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/main/side_nav.page.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($result[0]['Title'],'',"",$this->config,''),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on", 'author' => $this->config['META_AUTHOR'], 'keywords' => $result[0]['MetaKeyword'], 'description' => $result[0]['Description'], 'robots' => $this->config['META_ROBOTS']));

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
			$_SESSION['page_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("CategoryID",$_POST['CategoryID'],"=");
			$query_condition .= $crud->queryCondition("Title",$_POST['Title'],"LIKE");
			$query_condition .= $crud->queryCondition("MetaKeyword",$_POST['MetaKeyword'],"LIKE");
			$query_condition .= $crud->queryCondition("Heading",$_POST['Heading'],"LIKE");
			$query_condition .= $crud->queryCondition("FriendlyURL",$_POST['FriendlyURL'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
			$query_condition .= $crud->queryCondition("TemplateID",$_POST['TemplateID'],"=");
			$query_condition .= $crud->queryCondition("DatePosted",Helper::dateDisplaySQL($_POST['DatePostedFrom']),">=");
			$query_condition .= $crud->queryCondition("DatePosted",Helper::dateDisplaySQL($_POST['DatePostedTo']),"<=");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			$query_condition .= $crud->queryCondition("LastUpdated",Helper::dateDisplaySQL($_POST['LastUpdatedFrom']),">=");
			$query_condition .= $crud->queryCondition("LastUpdated",Helper::dateDisplaySQL($_POST['LastUpdatedTo']),"<=");

			$_SESSION['page_'.__FUNCTION__]['param']['CategoryID'] = $_POST['CategoryID'];
			$_SESSION['page_'.__FUNCTION__]['param']['Title'] = $_POST['Title'];
			$_SESSION['page_'.__FUNCTION__]['param']['MetaKeyword'] = $_POST['MetaKeyword'];
			$_SESSION['page_'.__FUNCTION__]['param']['Heading'] = $_POST['Heading'];
			$_SESSION['page_'.__FUNCTION__]['param']['FriendlyURL'] = $_POST['FriendlyURL'];
			$_SESSION['page_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['page_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
			$_SESSION['page_'.__FUNCTION__]['param']['TemplateID'] = $_POST['TemplateID'];
			$_SESSION['page_'.__FUNCTION__]['param']['DatePostedFrom'] = $_POST['DatePostedFrom'];
			$_SESSION['page_'.__FUNCTION__]['param']['DatePostedTo'] = $_POST['DatePostedTo'];
			$_SESSION['page_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];
			$_SESSION['page_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			$_SESSION['page_'.__FUNCTION__]['param']['LastUpdatedFrom'] = $_POST['LastUpdatedFrom'];
			$_SESSION['page_'.__FUNCTION__]['param']['LastUpdatedTo'] = $_POST['LastUpdatedTo'];

			// Set Query Variable
			$_SESSION['page_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['page_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['page_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['page_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM page ".$_SESSION['page_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/page/index';
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

		$sql = "SELECT * FROM page ".$_SESSION['page_'.__FUNCTION__]['query_condition']." ORDER BY DatePosted DESC, ID DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CategoryID' => PageCategoryModel::getPageCategory($row['CategoryID']),
			'Title' => $row['Title'],
			'MetaKeyword' => $row['MetaKeyword'],
			'Heading'=> $row['Heading'],
			'FriendlyURL'=> $row['FriendlyURL'],
			'Description' => Helper::truncate($row['Description'],200),
			'Content' => $row['Content'],
			'TemplateID' => TemplateModel::getTemplate($row['TemplateID']),
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
			'Status' => PageStatusModel::getPageStatus($row['Status']),
			'Enabled' => CRUD::isActive($row['Enabled']),
			'LastUpdated' => Helper::dateTimeSQLToLongDisplay($row['LastUpdated']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Pages", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'page_delete' => $_SESSION['admin']['page_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.page_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'pagestatus_list' => PageStatusModel::getPageStatusList(), 'pagecategory_list' => PageCategoryModel::getPageCategoryList(), 'template_list' => TemplateModel::getTemplateList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['page_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Page", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'page_add' => $_SESSION['admin']['page_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.page_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Page"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'pagestatus_list' => PageStatusModel::getPageStatusList(), 'pagecategory_list' => PageCategoryModel::getPageCategoryList(), 'template_list' => TemplateModel::getTemplateList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['page_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
        // Rename by appending number if name exists
        $friendly_url = $_POST['FriendlyURL']; // This value is used in the iteration
        $friendly_url_ref = $_POST['FriendlyURL']; // This value never changes

        $counter = 0;
        while (CRUD::isUnique($this->dbconnect,'page','FriendlyURL',$friendly_url,"AND ID != '".$param."'")>0)
        {
            $friendly_url = $friendly_url_ref.'-'.($counter+1);
            $counter++;
        }

		$key = "(CategoryID, Title, MetaKeyword, Heading, FriendlyURL, Description, Content, TemplateID, DatePosted, Enabled, Status, LastUpdated)";
		$value = "('".$_POST['CategoryID']."', '".$_POST['Title']."','".$_POST['MetaKeyword']."', '".$_POST['Heading']."', '".$friendly_url."', '".$_POST['Description']."', '".$_POST['Content']."', '".$_POST['TemplateID']."', '".Helper::dateDisplaySQL($_POST['DatePosted'])."', '".$_POST['Enabled']."', '".$_POST['Status']."', '".date('YmdHis')."')";

		$sql = "INSERT INTO page ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		// Generate .htaccess
		GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Page...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM page WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CategoryID' => $row['CategoryID'],
			'Title' => $row['Title'],
			'MetaKeyword' => $row['MetaKeyword'],
			'Heading'=> $row['Heading'],
			'FriendlyURL'=> $row['FriendlyURL'],
			'Description' => $row['Description'],
			'Content' => $row['Content'],
			'TemplateID' => $row['TemplateID'],
			'DatePosted' => Helper::dateSQLToDisplay($row['DatePosted']),
			'Status' => $row['Status'],
			'Enabled' => $row['Enabled'],
			'LastUpdated' => Helper::dateSQLToDisplay($row['LastUpdated']));


			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Page", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'page_add' => $_SESSION['admin']['page_add'], 'page_edit' => $_SESSION['admin']['page_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.page_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Page"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'pagestatus_list' => PageStatusModel::getPageStatusList(), 'pagecategory_list' => PageCategoryModel::getPageCategoryList(), 'template_list' => TemplateModel::getTemplateList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['page_add']);
		unset($_SESSION['admin']['page_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
	    // Rename by appending number if name exists
	    $friendly_url = $_POST['FriendlyURL']; // This value is used in the iteration
        $friendly_url_ref = $_POST['FriendlyURL']; // This value never changes

        $counter = 0;
        while (CRUD::isUnique($this->dbconnect,'page','FriendlyURL',$friendly_url,"AND ID != '".$param."'")>0)
        {
            $friendly_url = $friendly_url_ref.'-'.($counter+1);
            $counter++;
        }

		$sql = "UPDATE page SET CategoryID='".$_POST['CategoryID']."', Title='".$_POST['Title']."', MetaKeyword='".$_POST['MetaKeyword']."', Heading='".$_POST['Heading']."', FriendlyURL='".$friendly_url."', Description='".$_POST['Description']."', Content='".$_POST['Content']."', TemplateID='".$_POST['TemplateID']."', DatePosted='".Helper::dateDisplaySQL($_POST['DatePosted'])."', Status='".$_POST['Status']."', Enabled='".$_POST['Enabled']."', LastUpdated='".date('YmdHis')."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Generate .htaccess
		GeneratorModel::Generate();

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Page...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM page WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Page...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getPage($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM page WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CategoryID' => PageCategoryModel::getPageCategory($row['CategoryID']),
			'Title' => $row['Title'],
			'MetaKeyword' => $row['MetaKeyword'],
			'Heading'=> $row['Heading'],
			'FriendlyURL'=> $row['FriendlyURL'],
			'Description' => Helper::truncate($row['Description'],200),
			'Content' => $row['Content'],
			'TemplateID' => TemplateModel::getTemplate($row['TemplateID']),
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
			'Status' => PageStatusModel::getPageStatus($row['Status']),
			'Enabled' => CRUD::isActive($row['Enabled']),
			'LastUpdated' => Helper::dateSQLToLongDisplay($row['LastUpdated']));

			$i += 1;
		}

		$result = $result[0]['Title'];

		return $result;
	}

	public function getPageList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM page ORDER BY DatePosted DESC, ID DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CategoryID' => PageCategoryModel::getPageCategory($row['CategoryID']),
			'Title' => $row['Title'],
			'MetaKeyword' => $row['MetaKeyword'],
			'Heading'=> $row['Heading'],
			'FriendlyURL'=> $row['FriendlyURL'],
			'Description' => Helper::truncate($row['Description'],200),
			'Content' => $row['Content'],
			'TemplateID' => TemplateModel::getTemplate($row['TemplateID']),
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
			'Status' => PageStatusModel::getPageStatus($row['Status']),
			'Enabled' => CRUD::isActive($row['Enabled']),
			'LastUpdated' => Helper::dateSQLToLongDisplay($row['LastUpdated']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function BlockIndex($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM page WHERE Enabled = 1 AND Status = 2";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/page/index';
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

		$sql = "SELECT * FROM page WHERE Enabled = 1 AND Status = 2 ORDER BY DatePosted DESC, ID DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CategoryID' => $row['CategoryID'],
			'Title' => $row['Title'],
			'MetaKeyword' => $row['MetaKeyword'],
			'Heading'=> $row['Heading'],
			'FriendlyURL'=> $row['FriendlyURL'],
			'Description' => $row['Description'],
			'Content' => $row['Content'],
			'TemplateID' => TemplateModel::getTemplateFilename($row['TemplateID']),
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
			'Status' => $row['Status'],
			'Enabled' => CRUD::isActive($row['Enabled']),
			'LastUpdated' => Helper::dateSQLToLongDisplay($row['LastUpdated']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Page", 'template' => $result[0]['TemplateID'], 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM page ".$_SESSION['page_'.$param]['query_condition']." ORDER BY DatePosted DESC, ID DESC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Pages";
		$result['header'] = $this->config['SITE_NAME']." | Pages (" . date('Y-m-d H:i:s') . ")\n\nID, Category, Title, Meta Keyword, Heading, Friendly URL, Description, Content, Template, Date Posted, Status, Enabled, Last Updated";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".PageCategoryModel::getPageCategory($row['CategoryID'])."\",";
			$result['content'] .= "\"".$row['Title']."\",";
			$result['content'] .= "\"".$row['MetaKeyword']."\",";
			$result['content'] .= "\"".$row['Heading']."\",";
			$result['content'] .= "\"".$row['FriendlyURL']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Description'])."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Content'])."\",";
			$result['content'] .= "\"".TemplateModel::getTemplate($row['TemplateID'])."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DatePosted'])."\",";
			$result['content'] .= "\"".PageStatusModel::getPageStatus($row['Status'])."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Enabled'])."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['LastUpdated'])."\"\n";

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