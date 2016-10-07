<?php
// Require required models
Core::requireModel('region');
Core::requireModel('generator');

class TaxModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['tax'] = array(
        'name' => "Tax",
        'dir' => "modules/tax/",
        'default_url' => "/main/tax/index",
        'admin_url' => "/admin/tax/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM tax";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_URL'].'/main/tax/index';
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
		
		$sql = "SELECT * FROM tax ORDER BY Name DESC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{			
			$result[$i] = array(
			'ID' => $row['ID'],
			'RegionID' => $row['RegionID'],
			'Name' => $row['Name'],
			'Amount' => $row['Amount'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['tax']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Taxes", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['tax']['dir'].'inc/main/index.inc.php'),
        'block' => array('side_nav' => $this->module['tax']['dir'].'inc/main/side_nav.tax.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{        
		$sql = "SELECT * FROM tax WHERE ID = '".$param."'".$query_condition;
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'RegionID' => $row['RegionID'],
			'Name' => $row['Name'],
			'Amount' => $row['Amount'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['tax']['name'], "Link" => $this->module['tax']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Name'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['tax']['dir'].'inc/main/view.inc.php'),
        'block' => array('side_nav' => $this->module['tax']['dir'].'inc/main/side_nav.tax.inc.php', 'common' => "false"),
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
			$_SESSION['tax_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("RegionID",$_POST['RegionID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Amount",$_POST['Amount'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['tax_'.__FUNCTION__]['param']['RegionID'] = $_POST['RegionID'];
			$_SESSION['tax_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['tax_'.__FUNCTION__]['param']['Amount'] = $_POST['Amount'];
			$_SESSION['tax_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['tax_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['tax_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['tax_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['tax_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM tax ".$_SESSION['tax_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/admin/tax/index';
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
		
		$sql = "SELECT * FROM tax ".$_SESSION['tax_'.__FUNCTION__]['query_condition']." ORDER BY Name DESC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'RegionID' => RegionModel::getRegion($row['RegionID'], "Name"),
			'Name' => $row['Name'],
			'Amount' => $row['Amount'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['tax']['name'], "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Taxes", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['tax']['dir'].'inc/admin/index.inc.php', 'tax_delete' => $_SESSION['admin']['tax_delete']),
		'block' => array('side_nav' => $this->module['tax']['dir'].'inc/admin/side_nav.tax_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['tax_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['tax']['name'], "Link" => $this->module['tax']['admin_url']),
            array("Title" => "Create Tax", "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Tax", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['tax']['dir'].'inc/admin/add.inc.php', 'tax_add' => $_SESSION['admin']['tax_add']),
		'block' => array('side_nav' => $this->module['tax']['dir'].'inc/admin/side_nav.tax_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['tax_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(RegionID, Name, Amount, Enabled)";
		$value = "('".$_POST['RegionID']."', '".$_POST['Name']."', '".$_POST['Amount']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO tax ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
        // Generate .htaccess
        GeneratorModel::Generate();
            		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Tax...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM tax WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'RegionID' => $row['RegionID'],
			'Name' => $row['Name'],
			'Amount' => $row['Amount'],
			'Enabled' => $row['Enabled']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['tax']['name'], "Link" => $this->module['tax']['admin_url']),
            array("Title" => "Edit Tax", "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Tax", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['tax']['dir'].'inc/admin/edit.inc.php', 'tax_add' => $_SESSION['admin']['tax_add'], 'tax_edit' => $_SESSION['admin']['tax_edit']),
		'block' => array('side_nav' => $this->module['tax']['dir'].'inc/admin/side_nav.tax.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['tax_add']);
		unset($_SESSION['admin']['tax_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{		
		$sql = "UPDATE tax SET RegionID='".$_POST['RegionID']."', Name='".$_POST['Name']."', Amount='".$_POST['Amount']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
        // Generate .htaccess
        GeneratorModel::Generate();
            
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Tax...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM tax WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Tax...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function getTax($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM tax WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'RegionID' => $row['RegionID'],
			'Name' => $row['Name'],
			'Amount' => $row['Amount'],
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

	public function getTaxList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM tax ORDER BY Name DESC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'RegionID' => $row['RegionID'],
			'Name' => $row['Name'],
			'Amount' => $row['Amount'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$result['count'] = $i;
		
		return $result;
	}
	
	public function BlockIndex($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM tax";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_URL'].'/main/tax/index';
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
		
		$sql = "SELECT * FROM tax ORDER BY Name DESC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{			
			$result[$i] = array(
			'ID' => $row['ID'],
			'RegionID' => $row['RegionID'],
			'Name' => $row['Name'],
			'Amount' => $row['Amount'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Taxs", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['tax']['dir'].'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM tax ".$_SESSION['tax_'.$param]['query_condition']." ORDER BY Name DESC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Taxes";
		$result['header'] = $this->config['SITE_NAME']." | Taxes (" . date('Y-m-d H:i:s') . ")\n\nID, Region, Name, Amount, Enabled";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".RegionModel::getRegion($row['RegionID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['Amount']."\",";
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
}
?>