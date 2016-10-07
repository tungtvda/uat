<?php
// Require required models
Core::requireModel('messagestatus');

class MessageModel extends BaseModel
{
	private $output = array();
    private $module_name = "Message";
	private $module_dir = "modules/message/";
    private $module_default_url = "/main/message/index";
    private $module_default_admin_url = "/admin/message/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM message WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_DIR'].'/main/message/index';
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
		
		$sql = "SELECT * FROM message WHERE Enabled = 1 ORDER BY Name ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'ContactNo' => $row['ContactNo'],
			'Email' => $row['Email'],
			'Subject' => $row['Subject'],
			'Message' => $row['Message'],
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
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

	public function View($param) 
	{
		$sql = "SELECT * FROM message WHERE ID = '".$param."' ORDER BY Name ASC LIMIT 0, 5";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'ContactNo' => $row['ContactNo'],
			'Email' => $row['Email'],
			'Subject' => $row['Subject'],
			'Message' => $row['Message'],
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
			'Status' => $row['Status']);
			
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
			$_SESSION['message_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
			$query_condition .= $crud->queryCondition("ContactNo",$_POST['ContactNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
			$query_condition .= $crud->queryCondition("Subject",$_POST['Subject'],"LIKE");
			$query_condition .= $crud->queryCondition("Message",$_POST['Message'],"LIKE");
			$query_condition .= $crud->queryCondition("DatePosted",Helper::dateDisplaySQL($_POST['DatePostedFrom']),">=");
			$query_condition .= $crud->queryCondition("DatePosted",Helper::dateDisplaySQL($_POST['DatePostedTo']),"<=");
			$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");
			
			$_SESSION['message_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['message_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
			$_SESSION['message_'.__FUNCTION__]['param']['ContactNo'] = $_POST['ContactNo'];
			$_SESSION['message_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['message_'.__FUNCTION__]['param']['Subject'] = $_POST['Subject'];
			$_SESSION['message_'.__FUNCTION__]['param']['Message'] = $_POST['Message'];
			$_SESSION['message_'.__FUNCTION__]['param']['DatePostedFrom'] = $_POST['DatePostedFrom'];
			$_SESSION['message_'.__FUNCTION__]['param']['DatePostedTo'] = $_POST['DatePostedTo'];
			$_SESSION['message_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];
			
			// Set Query Variable
			$_SESSION['message_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['message_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['message_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['message_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM message ".$_SESSION['message_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/message/index';
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
		
		$sql = "SELECT * FROM message ".$_SESSION['message_'.__FUNCTION__]['query_condition']." ORDER BY DatePosted DESC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'ContactNo' => $row['ContactNo'],
			'Email' => $row['Email'],
			'Subject' => $row['Subject'],
			'Message' => Helper::truncate($row['Message'],100),
			'DatePosted' => Helper::dateTimeSQLToLongDisplay($row['DatePosted']),
			'Status' => MessageStatusModel::getMessageStatus($row['Status']));
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Messages", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'message_delete' => $_SESSION['admin']['message_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.message_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'messagestatus_list' => MessageStatusModel::getMessageStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['message_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Message", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'message_add' => $_SESSION['admin']['message_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.message_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Message"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'messagestatus_list' => MessageStatusModel::getMessageStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['message_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		$key = "(Name, Company, ContactNo, Email, Subject, Message, DatePosted, Status)";
		$value = "('".$_POST['Name']."', '".$_POST['Company']."', '".$_POST['ContactNo']."', '".$_POST['Email']."','".$_POST['Subject']."', '".$_POST['Message']."', '".Helper::dateTimeDisplaySQL($_POST['DatePosted'])."', '".$_POST['Status']."')";

		$sql = "INSERT INTO message ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Message...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM message WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'ContactNo' => $row['ContactNo'],
			'Email' => $row['Email'],
			'Subject' => $row['Subject'],
			'Message' => $row['Message'],
			'DatePosted' => Helper::dateTimeSQLToDisplay($row['DatePosted']),
			'Status' => $row['Status']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Message", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'message_add' => $_SESSION['admin']['message_add'], 'message_edit' => $_SESSION['admin']['message_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.message_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Message"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'messagestatus_list' => MessageStatusModel::getMessageStatusList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['message_add']);
		unset($_SESSION['admin']['message_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE message SET Name='".$_POST['Name']."', Company='".$_POST['Company']."', ContactNo='".$_POST['ContactNo']."', Email='".$_POST['Email']."', Subject='".$_POST['Subject']."', Message='".$_POST['Message']."', DatePosted='".Helper::dateTimeDisplaySQL($_POST['DatePosted'])."', Status='".$_POST['Status']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
	
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Message...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM message WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Message...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function getMessage($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM message WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'ContactNo' => $row['ContactNo'],
			'Email' => $row['Email'],
			'Subject' => $row['Subject'],
			'Message' => $row['Message'],
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
			'Status' => MessageStatusModel::getMessageStatus($row['Status']));
			
			$i += 1;
		}
		
		$result = $result[0]['Subject'];
		
		return $result;
	}

	public function getMessageList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM message ORDER BY DatePosted DESC, ID DESC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'ContactNo' => $row['ContactNo'],
			'Email' => $row['Email'],
			'Subject' => $row['Subject'],
			'Message' => $row['Message'],
			'DatePosted' => Helper::dateSQLToLongDisplay($row['DatePosted']),
			'Status' => MessageStatusModel::getMessageStatus($row['Status']));
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM message ".$_SESSION['message_'.$param]['query_condition']." ORDER BY Name ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Messages";
		$result['header'] = $this->config['SITE_NAME']." | Messages (" . date('Y-m-d H:i:s') . ")\n\nID, Name, Company, Contact No, Email, Subject, Message, Date Posted, Status";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['Company']."\",";
			$result['content'] .= "\"".$row['ContactNo']."\",";
			$result['content'] .= "\"".$row['Email']."\",";
			$result['content'] .= "\"".$row['Subject']."\",";
			$result['content'] .= "\"".$row['Message']."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DatePosted'])."\",";
			$result['content'] .= "\"".MessageStatusModel::getMessageStatus($row['Status'])."\"\n";

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