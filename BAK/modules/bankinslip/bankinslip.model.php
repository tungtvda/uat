<?php
// Require required models
Core::requireModel('module');
Core::requireModel('language');
Core::requireModel('moduletranslation');

class BankinSlipModel extends BaseModel
{
	private $output = array();
    private $module_name = "Bankin Slip";
	private $module_dir = "modules/bankinslip/";
    private $module_default_url = "/main/bankinslip/index";
    private $module_default_admin_url = "/admin/bankinslip/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM bankin_slip WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/bankinslip/index';
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
		
		$sql = "SELECT * FROM bankin_slip WHERE Enabled = 1 ORDER BY ID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Bankin Slips", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM bankin_slip WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
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
			$_SESSION['bankinslip_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ID",$_POST['ID'],"=");
			$query_condition .= $crud->queryCondition("Label",$_POST['Label'],"LIKE");
			
			$_SESSION['bankinslip_'.__FUNCTION__]['param']['ID'] = $_POST['ID'];
			$_SESSION['bankinslip_'.__FUNCTION__]['param']['Label'] = $_POST['Label'];
			
			// Set Query Variable
			$_SESSION['bankinslip_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['bankinslip_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['bankinslip_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['bankinslip_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM bankin_slip ".$_SESSION['bankinslip_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/bankinslip/index';
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
		
		$sql = "SELECT * FROM bankin_slip ".$_SESSION['bankinslip_'.__FUNCTION__]['query_condition']." ORDER BY ID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Bankin Slips", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'bankinslip_delete' => $_SESSION['admin']['bankinslip_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.bankinslip_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['bankinslip_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Bankin Slip", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'bankinslip_add' => $_SESSION['admin']['bankinslip_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.bankinslip_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Transaction Type"),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['bankinslip_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{                
            
		$key = "(Label)";
		$value = "('".$_POST['Label']."')";

		$sql = "INSERT INTO bankin_slip ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Bankin Slip...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM bankin_slip WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Bankin Slip", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'bankinslip_add' => $_SESSION['admin']['bankinslip_add'], 'bankinslip_edit' => $_SESSION['admin']['bankinslip_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.bankinslip_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Transaction Type"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['bankinslip_add']);
		unset($_SESSION['admin']['bankinslip_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param, $controller) 
	{
          
            
            switch ($_POST['Lang']) {
                case "zhCN":
                    $LanguageID = LanguageModel::getLanguageID("zh_CN");
                    break;
                case "en":
                    $LanguageID = LanguageModel::getLanguageID("en");
                    break;
                case "ms":
                    $LanguageID = LanguageModel::getLanguageID("ms");
                    break;                
                case "zh_CN":
                    $LanguageID = LanguageModel::getLanguageID("zh_CN");
                    break;
                
            }
            
            if($_POST['Lang']!='en')
            {    
            $ModuleID = ModuleModel::getModuleID($controller);
                
                    $con1 = array();
            $con1 = array('Label' => base64_encode($_POST['Label']));
                
            $con1 = json_encode($con1);
            
            $sql4 = "SELECT COUNT(*) AS num FROM module_translation  WHERE RowID = '".$param."' AND LanguageID = '".$LanguageID."' AND ModuleID = '".$ModuleID."'"; 
            
            foreach ($this->dbconnect->query($sql4) as $row4)
            {
                $numCount = $row4['num'];
                
            }
            
            
                if($numCount=='1'){


                    $sql2 = "UPDATE module_translation SET Content='".$con1."' WHERE RowID = '".$param."' AND LanguageID = '".$LanguageID."' AND ModuleID = '".$ModuleID."'"; 



                    $count = $this->dbconnect->exec($sql2);

                    // Set Status
                    $ok = ($count<=1) ? 1 : "";
                } 
                else 
                {
                    $key = "(ModuleID, LanguageID, RowID, Content)";
                    $value = "('".$ModuleID."', '".$LanguageID."', '".$param."', '".$con1."')";

                    $sql = "INSERT INTO module_translation ".$key." VALUES ". $value;

                    $count = $this->dbconnect->exec($sql);
                    $newID = $this->dbconnect->lastInsertId();
                    // Set Status
                    $ok = ($count<=1) ? 1 : "";

                }
            
            }
            elseif($_POST['Lang']=='en')
            {
                $sql = "UPDATE bankin_slip SET Label='".$_POST['Label']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
                $ok = ($count<=1) ? 1 : "";
            }    
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Bankin Slip...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM bankin_slip WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Bankin Slip...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function getBankinSlip($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM bankin_slip WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => $row['Label']);
			
			$i += 1;
		}
		
		$result = $result[0]['Label'];
		
		return $result;
	}

	public function getBankinSlipList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM bankin_slip ORDER BY ID ASC";
		
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
        
        public function getPublicBankinSlipList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM bankin_slip ORDER BY ID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Label' => ($_SESSION['language']=='en')? $row['Label'] : ModuleTranslationModel::getBankinSlipTranslated($row['ID']));
	
			$i += 1;
		}
		
		$result['count'] = $i;
		
		return $result;
	}
        
        public function getAPIPublicBankinSlipList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM bankin_slip ORDER BY ID ASC";
		
		$result = array();
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$dataSet = array(
			'ID' => $row['ID'],
			'Label' => ($_SESSION['language']=='en')? $row['Label'] : ModuleTranslationModel::getBankinSlipTranslated($row['ID']));
                        
                        array_push($result, $dataSet); 
			
		}
		
		
		
		return $result;
	}

	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM bankin_slip ".$_SESSION['bankinslip_'.$param]['query_condition']." ORDER BY ID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_Label']."_Bankin_Slip";
		$result['header'] = $this->config['SITE_Label']." | Bankin Slip (" . date('Y-m-d H:i:s') . ")\n\nID, Label";
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