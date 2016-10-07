<?php
// Require required models
Core::requireModel('module');
Core::requireModel('language');

class ModuleTranslationModel extends BaseModel
{
	private $output = array();
    private $module = array();
    
   
    private $module_name = "Module Translation";
	private $module_dir = "modules/moduletranslation/";
    private $module_default_url = "/main/moduletranslation/index";
    private $module_default_admin_url = "/admin/moduletranslation/index";
    private $module_default_member_url = "/member/moduletranslation/index";

    private $member_module_name = "Member";
    private $member_module_dir = "modules/member/";

	private $reseller_module_name = "Reseller";
    private $reseller_module_dir = "modules/reseller/";
	private $module_default_reseller_url = "/reseller/reseller/index";

	public function __construct()
	{
		parent::__construct();

        $this->module['moduletranslation'] = array(
        'name' => "Module Translation",
        'dir' => "modules/moduletranslation/",
        'default_url' => "/main/moduletranslation/index",
        'admin_url' => "/admin/moduletranslation/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM module_translation WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/moduletranslation/index';
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
		
		$sql = "SELECT * FROM module_translation WHERE Enabled = 1 ORDER BY ID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'LanguageID' => $row['LanguageID'],
			'RowID' => $row['RowID'],
			'Content' => $row['Content']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['moduletranslation']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Module Translations", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['moduletranslation']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['moduletranslation']['dir'].'meta/main/index.inc.php'));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM module_translation WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'LanguageID' => $row['LanguageID'],
			'RowID' => $row['RowID'],
			'Content' => $row['Content']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['moduletranslation']['name'], "Link" => $this->module['moduletranslation']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['moduletranslation']['dir'].'meta/main/view.inc.php'));
					
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
			$_SESSION['moduletranslation_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ModuleID",$_POST['ModuleID'],"=");
			$query_condition .= $crud->queryCondition("LanguageID",$_POST['LanguageID'],"=");
			$query_condition .= $crud->queryCondition("RowID",$_POST['RowID'],"=");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
			
			$_SESSION['moduletranslation_'.__FUNCTION__]['param']['ModuleID'] = $_POST['ModuleID'];
			$_SESSION['moduletranslation_'.__FUNCTION__]['param']['LanguageID'] = $_POST['LanguageID'];
			$_SESSION['moduletranslation_'.__FUNCTION__]['param']['RowID'] = $_POST['RowID'];
			$_SESSION['moduletranslation_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
			
			// Set Query Variable
			$_SESSION['moduletranslation_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['moduletranslation_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['moduletranslation_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['moduletranslation_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM module_translation ".$_SESSION['moduletranslation_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/moduletranslation/index';
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
		
		$sql = "SELECT * FROM module_translation ".$_SESSION['moduletranslation_'.__FUNCTION__]['query_condition']." ORDER BY ID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => ModuleModel::getModule($row['ModuleID'], "Name"),
			'LanguageID' => LanguageModel::getLanguage($row['LanguageID'], "Name"),
			'RowID' => $row['RowID'],
			'Content' => $row['Content']);
			
			$i += 1;
		}

        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['moduletranslation']['name'], "Link" => "")
        );*/
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Module Translations", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['moduletranslation']['dir'].'inc/admin/index.inc.php', 'moduletranslation_delete' => $_SESSION['admin']['moduletranslation_delete']),
		'block' => array('side_nav' => $this->module['moduletranslation']['dir'].'inc/admin/side_nav.moduletranslation_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'module_list' => ModuleModel::getModuleList(), 'language_list' => LanguageModel::getLanguageList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['moduletranslation_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['moduletranslation']['name'], "Link" => $this->module['moduletranslation']['admin_url']),
            array("Title" => "Create Module Translation", "Link" => "")
        );*/
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Module Translation", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['moduletranslation']['dir'].'inc/admin/add.inc.php', 'moduletranslation_add' => $_SESSION['admin']['moduletranslation_add']),
		'block' => array('side_nav' => $this->module['moduletranslation']['dir'].'inc/admin/side_nav.moduletranslation_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Add Module Translation"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'module_list' => ModuleModel::getModuleList(), 'language_list' => LanguageModel::getLanguageList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['moduletranslation_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(ModuleID, LanguageID, RowID, Content)";
		$value = "('".$_POST['ModuleID']."', '".$_POST['LanguageID']."', '".$_POST['RowID']."', '".$_POST['Content']."')";

		$sql = "INSERT INTO module_translation ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Module Translation...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
        
        public function AdminAjaxTranslateAction($param)
	{  
            
           
            switch ($_GET['lang']) {
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
            
            
            $ModuleID = ModuleModel::getModuleID($param);
            
            
            if($_GET['lang'] != $_SESSION['admin']['DEFAULT_LANGUAGE'])
            {    
                    
                
                                  
                    $sql2 = "SELECT COUNT(*) AS mt_num FROM module_translation WHERE RowID = '".$_GET['contentID']."' AND LanguageID = '".$LanguageID."' AND ModuleID = '".$ModuleID."'";
                    
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                        $count = $row2['mt_num'];
                    }
                    
                if($count == '1')
                {    
                    
                    $sql = "SELECT * FROM module_translation WHERE RowID = '".$_GET['contentID']."' AND LanguageID = '".$LanguageID."' AND ModuleID = '".$ModuleID."'";
            
                    
                    
                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                         
                        
                            
                            $result = json_decode($row['Content'], TRUE);
                            
                            

                            $result[0]['Label'] = ($result['Label']!='') ? base64_decode($result['Label']): $this->getColumnTranslation($param, $_GET['contentID'], "Label");
                            
   
                       
                    }
                    
                    
                    
                    
                    
                    
                }
                elseif($count == '0')
                {
                    
                            $result[0]['Label'] = $this->getColumnTranslation($param, $_GET['contentID'], "Label");
                            
                    
                    
                }    
                    
                    
            }
            elseif($_GET['lang'] == $_SESSION['admin']['DEFAULT_LANGUAGE'])
            {
                   
                    $sql = "SELECT * FROM ".$param." WHERE ID = '".$_GET['contentID']."'";
                    
                                        
                    $result = array();
                    $i = 0;
                    
                    
                        
                        foreach ($this->dbconnect->query($sql) as $row)
                        {
                           
                            $result[$i] = array(
                            'Label' =>  $row['Label']);

                            $i += 1;
                        }
               
            }
            
				                                     	
		$this->output = array( 
		'config' => $this->config,
		//'page' => array('title' => "Creating Module Translation...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
                'content' => json_encode($result),  
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
        
        
        

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM module_translation WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'LanguageID' => $row['LanguageID'],
			'RowID' => $row['RowID'],
			'Content' => $row['Content']);
			
			$i += 1;
		}
                
                
                
                
                

        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['moduletranslation']['name'], "Link" => $this->module['moduletranslation']['admin_url']),
            array("Title" => "Edit Module Translation", "Link" => "")
        );*/

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Module Translation", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['moduletranslation']['dir'].'inc/admin/edit.inc.php', 'moduletranslation_add' => $_SESSION['admin']['moduletranslation_add'], 'moduletranslation_edit' => $_SESSION['admin']['moduletranslation_edit']),
		'block' => array('side_nav' => $this->module['moduletranslation']['dir'].'inc/admin/side_nav.moduletranslation_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Module Translation"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'module_list' => ModuleModel::getModuleList(), 'language_list' => LanguageModel::getLanguageList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['moduletranslation_add']);
		unset($_SESSION['admin']['moduletranslation_edit']);
					
		return $this->output;
	}
        
        public function AdminAjaxEditProcess($param) 
	{
		$sql = "UPDATE module_translation SET ModuleID='".$_POST['ModuleID']."', LanguageID='".$_POST['LanguageID']."', RowID='".$_POST['RowID']."', Content='".$_POST['Content']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Module Translation...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
        
        

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE module_translation SET ModuleID='".$_POST['ModuleID']."', LanguageID='".$_POST['LanguageID']."', RowID='".$_POST['RowID']."', Content='".$_POST['Content']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Module Translation...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM module_translation WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Module Translation...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function getModuleTranslation($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM module_translation WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'LanguageID' => $row['LanguageID'],
			'RowID' => $row['RowID'],
			'Content' => $row['Content']);
			
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
        
        public function getColumnTranslation($table, $param, $column = "") 
	{
                if($table == 'bankinslip')
                {
                   $table = 'bankin_slip';     
                }
                elseif($table == 'producttype')
                {
                    $table = 'product_type';
                }    
            

		$sql = "SELECT ".$column." FROM ".$table." WHERE ID = '".$param."'";
		
		/*echo $sql;
                exit;*/
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			
			$result = $row[$column];
			
			
		}
		
	
		return $result;
	}
        
        
        public function getTranslated($ID) 
	{   
            switch ($_SESSION['language']) {
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
            
            if($_SESSION['language']!='en')
            {
                
                
                $sql = "SELECT * FROM module_translation WHERE RowID = '".$ID."' AND LanguageID = '".$LanguageID."' AND ModuleID = '58'";
            //echo $sql;
            //exit;
            $result = array();
            $i = 0;
            
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result = json_decode($row['Content'], TRUE);
                            
                $result[$i]['Label'] =  base64_decode($result['Label']);
                                
                $i++;
                            
            }
                
            }    
            
                //Debug::displayArray($result);
                //exit;
		return $result[0]['Label'];
	}
        
        public function getBankinSlipTranslated($param) 
	{   
            switch ($_SESSION['language']) {
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
            
            if($_SESSION['language']!='en')
            {
                
                
                $sql = "SELECT * FROM module_translation WHERE RowID = '".$param."' AND LanguageID = '".$LanguageID."' AND ModuleID = '77'";
            //echo $sql;
            //exit;
            $result = array();
            $i = 0;
            
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result = json_decode($row['Content'], TRUE);
                            
                $result[$i]['Label'] =  base64_decode($result['Label']);
                                
                $i++;
                            
            }
                
            }    
            

		return $result[0]['Label'];
	}

	public function getModuleTranslationList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM module_translation ORDER BY ID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ModuleID' => $row['ModuleID'],
			'LanguageID' => $row['LanguageID'],
			'RowID' => $row['RowID'],
			'Content' => $row['Content']);
			
			$i += 1;
		}
		
		$result['count'] = $i;
		
		return $result;
	}

	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM module_translation ".$_SESSION['moduletranslation_'.$param]['query_condition']." ORDER BY ID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_Label']."_Module_Translation";
		$result['header'] = $this->config['SITE_Label']." | Module Translation (" . date('Y-m-d H:i:s') . ")\n\nID, Module, Language, Row, Content";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ModuleModel::getModule($row['ModuleID'], "Name")."\",";
			$result['content'] .= "\"".LanguageModel::getLanguage($row['LanguageID'], "Name")."\",";
			$result['content'] .= "\"".$row['RowID']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Content'])."\"\n";

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