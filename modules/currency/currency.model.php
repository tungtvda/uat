<?php
// Require required models
Core::requireModel('country');

class CurrencyModel extends BaseModel
{
	private $output = array();
    private $module = array();
	
	public function __construct()
	{
		parent::__construct();

        $this->module['currency'] = array(
        'name' => "Currency",
        'dir' => "modules/currency/",
        'default_url' => "/main/currency/index",
        'admin_url' => "/admin/currency/index");
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM currency WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_URL'].'/main/currency/index';
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
		
		$sql = "SELECT * FROM currency WHERE Enabled = 1 ORDER BY CountryID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => $row['CountryID'],
			'Name' => $row['Name'],
			'ExchangeRate' => $row['ExchangeRate'],
			'Main' => $row['Main'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['currency']['name'], "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "What's New", 'template' => 'common.tpl.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM currency WHERE ID = '".$param."' ORDER BY CountryID ASC LIMIT 0, 5";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => $row['CountryID'],
			'Name' => $row['Name'],
			'ExchangeRate' => $row['ExchangeRate'],
			'Main' => $row['Main'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['currency']['name'], "Link" => $this->module['currency']['default_url']),
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
			$_SESSION['currency_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("CountryID",$_POST['CountryID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("ExchangeRate",$_POST['ExchangeRate'],"LIKE");
			$query_condition .= $crud->queryCondition("Main",$_POST['Main'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['currency_'.__FUNCTION__]['param']['CountryID'] = $_POST['CountryID'];
			$_SESSION['currency_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['currency_'.__FUNCTION__]['param']['ExchangeRate'] = $_POST['ExchangeRate'];
			$_SESSION['currency_'.__FUNCTION__]['param']['Main'] = $_POST['Main'];
			$_SESSION['currency_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['currency_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['currency_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['currency_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['currency_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM currency ".$_SESSION['currency_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_URL'].'/admin/currency/index';
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
		
		$sql = "SELECT * FROM currency ".$_SESSION['currency_'.__FUNCTION__]['query_condition']." ORDER BY CountryID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => CountryModel::getCountry($row['CountryID'], "Name"),
			'Name' => $row['Name'],
			'ExchangeRate' => $row['ExchangeRate'],
			'Main' => $row['Main'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['currency']['name'], "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Currencies", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['currency']['dir'].'inc/admin/index.inc.php', 'currency_delete' => $_SESSION['admin']['currency_delete']),
		'block' => array('side_nav' => $this->module['currency']['dir'].'inc/admin/side_nav.currency_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['currency_delete']);
					
		return $this->output;
	}

	public function AdminAdd($param) 
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['currency']['name'], "Link" => $this->module['currency']['admin_url']),
            array("Title" => "Create Currency", "Link" => "")
        );
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Currency", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['currency']['dir'].'inc/admin/add.inc.php', 'currency_add' => $_SESSION['admin']['currency_add']),
		'block' => array('side_nav' => $this->module['currency']['dir'].'inc/admin/side_nav.currency_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['currency_add']);
					
		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(CountryID, Name, ExchangeRate, Main, Enabled)";
		$value = "('".$_POST['CountryID']."', '".$_POST['Name']."', '".$_POST['ExchangeRate']."', '".$_POST['Main']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO currency ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Currency...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM currency WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => $row['CountryID'],
			'Name' => $row['Name'],
			'ExchangeRate' => $row['ExchangeRate'],
			'Main' => $row['Main'],
			'Enabled' => $row['Enabled']);
			
			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['currency']['name'], "Link" => $this->module['currency']['admin_url']),
            array("Title" => "Edit Currency", "Link" => "")
        );

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Currency", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['currency']['dir'].'inc/admin/edit.inc.php', 'currency_add' => $_SESSION['admin']['currency_add'], 'currency_edit' => $_SESSION['admin']['currency_edit']),
		'block' => array('side_nav' => $this->module['currency']['dir'].'inc/admin/side_nav.currency_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['currency_add']);
		unset($_SESSION['admin']['currency_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		$sql = "UPDATE currency SET CountryID='".$_POST['CountryID']."', Name='".$_POST['Name']."', ExchangeRate='".$_POST['ExchangeRate']."', Main='".$_POST['Main']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Currency...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		$sql = "DELETE FROM currency WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Currency...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function getCurrency($param, $column = "") 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM currency WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => CountryModel::getCountry($row['CountryID']),
			'Name' => $row['Name'],
			'ExchangeRate' => $row['ExchangeRate'],
			'Main' => $row['Main'],
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

	public function getCurrencyList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM currency ORDER BY ID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'CountryID' => CountryModel::getCountry($row['CountryID']),
			'Name' => $row['Name'],
			'ExchangeRate' => $row['ExchangeRate'],
			'Main' => $row['Main'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM currency ".$_SESSION['currency_'.$param]['query_condition']." ORDER BY CountryID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Currency";
		$result['header'] = $this->config['SITE_NAME']." | Currency (" . date('Y-m-d H:i:s') . ")\n\nID, Country, Name, Exchange Rate, Main, Enabled";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['CountryID']."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['ExchangeRate']."\",";
			$result['content'] .= "\"".$row['Main']."\",";
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