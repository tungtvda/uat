<?php
class RejectMessageModel extends BaseModel
{
    
    
	private $output = array();
    private $module = array();
    
    private $module_name = "Reject Message";
	private $module_dir = "modules/rejectmessage/";
    private $module_default_url = "/main/rejectmessage/index";
    private $module_default_admin_url = "/admin/rejectmessage/index";
    private $module_default_member_url = "/member/rejectmessage/index";

    private $member_module_name = "Member";
    private $member_module_dir = "modules/member/";

	private $reseller_module_name = "Reseller";
    private $reseller_module_dir = "modules/reseller/";
	private $module_default_reseller_url = "/reseller/reseller/index";

	public function __construct()
	{
		parent::__construct();

        $this->module['rejectmessage'] = array(
        'name' => "Reject Message",
        'dir' => "modules/rejectmessage/",
        'default_url' => "/main/rejectmessage/index",
        'admin_url' => "/admin/rejectmessage/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM reject_message WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/main/rejectmessage/index';
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
		
		$sql = "SELECT * FROM reject_message WHERE Enabled = 1 ORDER BY ID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['rejectmessage']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Reject Messages", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['rejectmessage']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM reject_message WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['rejectmessage']['name'], "Link" => $this->module['rejectmessage']['default_url']),
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

	public function AdminIndex($param) 
	{		
		// Initialise query conditions
		$query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['rejectmessage_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ID",$_POST['ID'],"=");
			$query_condition .= $crud->queryCondition("Label",$_POST['Label'],"LIKE");
			
			$_SESSION['rejectmessage_'.__FUNCTION__]['param']['ID'] = $_POST['ID'];
			$_SESSION['rejectmessage_'.__FUNCTION__]['param']['Label'] = $_POST['Label'];
			
			// Set Query Variable
			$_SESSION['rejectmessage_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['rejectmessage_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['rejectmessage_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['rejectmessage_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM reject_message ".$_SESSION['rejectmessage_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/admin/rejectmessage/index';
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
		
		$sql = "SELECT * FROM reject_message ".$_SESSION['rejectmessage_'.__FUNCTION__]['query_condition']." ORDER BY ID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
			$i += 1;
		}

        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['rejectmessage']['name'], "Link" => "")
        );*/
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Reject Messages", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['rejectmessage']['dir'].'inc/admin/index.inc.php', 'rejectmessage_delete' => $_SESSION['admin']['rejectmessage_delete']),
		'block' => array('side_nav' => $this->module['rejectmessage']['dir'].'inc/admin/side_nav.rejectmessage_common.inc.php'),
        //'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['rejectmessage_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['rejectmessage']['name'], "Link" => $this->module['rejectmessage']['admin_url']),
            array("Title" => "Create Reject Message", "Link" => "")
        );*/
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Reject Message", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['rejectmessage']['dir'].'inc/admin/add.inc.php', 'rejectmessage_add' => $_SESSION['admin']['rejectmessage_add']),
		'block' => array('side_nav' => $this->module['rejectmessage']['dir'].'inc/admin/side_nav.rejectmessage_common.inc.php'),
                //'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Reject Message"),    
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['rejectmessage_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(Label)";
		$value = "('".$_POST['Label']."')";

		$sql = "INSERT INTO reject_message ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Reject Message...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM reject_message WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
			$i += 1;
		}

        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['rejectmessage']['name'], "Link" => $this->module['rejectmessage']['admin_url']),
            array("Title" => "Edit Reject Message", "Link" => "")
        );*/

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Reject Message", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['rejectmessage']['dir'].'inc/admin/edit.inc.php', 'rejectmessage_add' => $_SESSION['admin']['rejectmessage_add'], 'rejectmessage_edit' => $_SESSION['admin']['rejectmessage_edit']),
		'block' => array('side_nav' => $this->module['rejectmessage']['dir'].'inc/admin/side_nav.rejectmessage_common.inc.php'),
                //'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Reject Message"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['rejectmessage_add']);
		unset($_SESSION['admin']['rejectmessage_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE reject_message SET Label='".$_POST['Label']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Reject Message...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM reject_message WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Reject Message...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function getRejectMessage($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM reject_message WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
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

	public function getRejectMessageList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM reject_message ORDER BY ID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
			$i += 1;
		}
		
		$result['count'] = $i;
		
		return $result;
	}

	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM reject_message ".$_SESSION['rejectmessage_'.$param]['query_condition']." ORDER BY ID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_Label']."_Reject_Message";
		$result['header'] = $this->config['SITE_Label']." | Reject Message (" . date('Y-m-d H:i:s') . ")\n\nID, Label";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['Label']."\"\n";

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