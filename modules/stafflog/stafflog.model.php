<?php
class StaffLogModel extends BaseModel
{
	private $output = array();
    private $module_name = "Staff Access Log";
	private $module_dir = "modules/stafflog/";
    private $module_default_url = "/main/stafflog/index";
    private $module_default_admin_url = "/admin/stafflog/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function AdminIndex($param) 
	{		
		// Initialise query conditions
		$query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['stafflog_'.__FUNCTION__] = "";

            $query_condition .= $crud->queryCondition("IP",$_POST['IP'],"LIKE");			
			$query_condition .= $crud->queryCondition("UserID",$_POST['UserID'],"=");
			$query_condition .= $crud->queryCondition("User",$_POST['User'],"LIKE");
			$query_condition .= $crud->queryCondition("DateLogged",Helper::dateDisplaySQL($_POST['DateLoggedFrom']),">=");
			$query_condition .= $crud->queryCondition("DateLogged",Helper::dateDisplaySQL($_POST['DateLoggedTo']),"<=");
            $query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			
            $_SESSION['stafflog_'.__FUNCTION__]['param']['IP'] = $_POST['IP'];			
			$_SESSION['stafflog_'.__FUNCTION__]['param']['UserID'] = $_POST['UserID'];
			$_SESSION['stafflog_'.__FUNCTION__]['param']['User'] = $_POST['User'];
			$_SESSION['stafflog_'.__FUNCTION__]['param']['DateLoggedFrom'] = $_POST['DateLoggedFrom'];
			$_SESSION['stafflog_'.__FUNCTION__]['param']['DateLoggedTo'] = $_POST['DateLoggedTo'];
            $_SESSION['stafflog_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			
			// Set Query Variable
			$_SESSION['stafflog_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['stafflog_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['stafflog_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['stafflog_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM staff_log ".$_SESSION['stafflog_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/stafflog/index';
		$limit = 200;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;	
		}	
		
		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
		
		$sql = "SELECT * FROM staff_log ".$_SESSION['stafflog_'.__FUNCTION__]['query_condition']." ORDER BY DateLogged DESC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'UserID' => $row['UserID'],
			'User' => $row['User'],
            'IP' => $row['IP'],
			'DateLogged' => $row['DateLogged'],
			'Description' => $row['Description']);
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Staff Access Log", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.stafflog_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function LogAccess($IP,$userID,$user,$description)
    {
        $key = "(DateLogged, IP, UserID, User, Description)";
        $value = "('".date('YmdHis')."', '".$IP."', '".$userID."', '".$user."', '".$description."')";

        $sql = "INSERT INTO staff_log ".$key." VALUES ". $value;

        $count = $this->dbconnect->exec($sql);
        
        $this->output = array( 
        'config' => $this->config,
        'page' => array('title' => "Creating Log..."),
        'content_param' => array('count' => $count),
        'meta' => array('active' => "on"));
                    
        return $this->output;
    }

    public function AdminExport($param) 
    {       
        $sql = "SELECT * FROM staff_log ".$_SESSION['stafflog_'.$param]['query_condition']." ORDER BY DateLogged DESC";
        
        $result = array();
        
        $result['filename'] = $this->config['SITE_NAME']."_Staff_Access_Log";
        $result['header'] = $this->config['SITE_NAME']." | Staff Access Log (" . date('Y-m-d H:i:s') . ")\n\nDate Logged, IP, UserID, User, Description";
        $result['content'] = '';
        
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result['content'] .= "\"".$row['DateLogged']."\",";
            $result['content'] .= "\"".$row['IP']."\",";
            $result['content'] .= "\"".$row['UserID']."\",";
            $result['content'] .= "\"".$row['User']."\",";
            $result['content'] .= "\"".$row['Description']."\"\n";

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