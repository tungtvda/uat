<?php
// Require required models
Core::requireModel('poitype');

class POIModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['poi'] = array(
        'name' => "POI",
        'dir' => "modules/poi/",
        'default_url' => "/main/poi/index",
        'admin_url' => "/admin/poi/index");
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM poi WHERE 1 = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/poi/index';
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

		$sql = "SELECT * FROM poi WHERE 1 = 1 ORDER BY TypeID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Address' => $row['Address'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['poi']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "POIs", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['poi']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM poi WHERE ID = '".$param."' AND 1 = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Address' => $row['Address'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['poi']['name'], "Link" => $this->module['poi']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['poi']['dir'].'inc/main/view.inc.php'),
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
			$_SESSION['poi_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Address",$_POST['Address'],"LIKE");
			$query_condition .= $crud->queryCondition("MapX",$_POST['MapX'],"LIKE");
			$query_condition .= $crud->queryCondition("MapY",$_POST['MapY'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['poi_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['poi_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['poi_'.__FUNCTION__]['param']['Address'] = $_POST['Address'];
			$_SESSION['poi_'.__FUNCTION__]['param']['MapX'] = $_POST['MapX'];
			$_SESSION['poi_'.__FUNCTION__]['param']['MapY'] = $_POST['MapY'];
			$_SESSION['poi_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['poi_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['poi_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['poi_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['poi_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM poi ".$_SESSION['poi_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/poi/index';
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

		$sql = "SELECT * FROM poi ".$_SESSION['poi_'.__FUNCTION__]['query_condition']." ORDER BY TypeID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => POITypeModel::getPOIType($row['TypeID'], "Label"),
			'Name' => $row['Name'],
			'Address' => $row['Address'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['poi']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "POIs", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['poi']['dir'].'inc/admin/index.inc.php', 'poi_delete' => $_SESSION['admin']['poi_delete']),
		'block' => array('side_nav' => $this->module['poi']['dir'].'inc/admin/side_nav.poi_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'poitype_list' => POITypeModel::getPOITypeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['poi_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['poi']['name'], "Link" => $this->module['poi']['admin_url']),
            array("Title" => "Create POI", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create POI", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['poi']['dir'].'inc/admin/add.inc.php', 'poi_add' => $_SESSION['admin']['poi_add']),
		'block' => array('side_nav' => $this->module['poi']['dir'].'inc/admin/side_nav.poi_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'poitype_list' => POITypeModel::getPOITypeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['poi_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(TypeID, Name, Address, MapX, MapY, Enabled)";
		$value = "('".$_POST['TypeID']."', '".$_POST['Name']."', '".$_POST['Address']."', '".$_POST['MapX']."', '".$_POST['MapY']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO poi ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating POI...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM poi WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Address' => $row['Address'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['poi']['name'], "Link" => $this->module['poi']['admin_url']),
            array("Title" => "Edit POI", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit POI", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['poi']['dir'].'inc/admin/edit.inc.php', 'poi_add' => $_SESSION['admin']['poi_add'], 'poi_edit' => $_SESSION['admin']['poi_edit']),
		'block' => array('side_nav' => $this->module['poi']['dir'].'inc/admin/side_nav.poi_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'poitype_list' => POITypeModel::getPOITypeList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['poi_add']);
		unset($_SESSION['admin']['poi_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		$sql = "UPDATE poi SET TypeID='".$_POST['TypeID']."',Name='".$_POST['Name']."', Address='".$_POST['Address']."', MapX='".$_POST['MapX']."',MapY='".$_POST['MapY']."',Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing POI...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM poi WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting POI...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getPOI($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM poi WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Address' => $row['Address'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
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

	public function getPOIList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM poi ORDER BY DatePosted DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Address' => $row['Address'],
			'MapX' => $row['MapX'],
			'MapY' => $row['MapY'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
	
	public function APIIndex($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                // Prepare Pagination
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
		
				$sql = "SELECT * FROM poi WHERE 1 = 1 ORDER BY TypeID ASC LIMIT $start, $limit";
		
				$result = array();
				$i = 0;
				foreach ($this->dbconnect->query($sql) as $row)
				{
					$result[$i] = array(
					'ID' => $row['ID'],
					'TypeID' => $row['TypeID'],
					'Name' => $row['Name'],
					'Address' => $row['Address'],
					'MapX' => $row['MapX'],
					'MapY' => $row['MapY'],
					'Enabled' => CRUD::isActive($row['Enabled']));
		
					$i += 1;
				}

                $output['Count'] = $i;
                $output['Content'] = $result;

                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode($output);
                    $restapi->setResponse('200', 'OK', $result);
                }
                else
                {
                    $restapi->setResponse('404', 'Resource Not Found');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }
    
  
    
	/*public function APISearchProcess($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
        
		     
		        //-33.8670522,151.1957362
		        $data_string = 'location='.$request_data['location'].'&radius='.$request_data['radius'].'&types='.$request_data['types'].'&key=AIzaSyA-QTgQc9s4wAj-M6yY0DkSYz2zmCo6zIA';
				//$data_string;
				//exit;
		        $param = $restapi->makeRequest("https://maps.googleapis.com/maps/api/place/nearbysearch/json", $data_string, "GET");
				
				//echo $param;
		    }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
		
        
    }*/
	

    public function APIView($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                $sql = "SELECT * FROM poi WHERE TypeID = '".$request_data['TypeID']."' AND Enabled = '1'";

				$result = array();
				$i = 0;
				foreach ($this->dbconnect->query($sql) as $row)
				{
					$result[$i] = array(
					'ID' => $row['ID'],
					'TypeID' => $row['TypeID'],
					'Name' => $row['Name'],
					'Address' => $row['Address'],
					'MapX' => $row['MapX'],
					'MapY' => $row['MapY'],
					'Enabled' => CRUD::isActive($row['Enabled']));
		
					$i += 1;
				}

                $output['Count'] = $i;
                $output['Content'] = $result;

                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode($output);
                    $restapi->setResponse('200', 'OK', $result);
                }
                else
                {
                    $restapi->setResponse('404', 'Resource Not Found');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM poi ".$_SESSION['poi_'.$param]['query_condition']." ORDER BY TypeID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_POI";
		$result['header'] = $this->config['SITE_NAME']." | POI (" . date('Y-m-d H:i:s') . ")\n\nID, Type, Name, Address, Map X, Map Y, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".POITypeModel::getPOIType($row['TypeID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Address'])."\",";
			$result['content'] .= "\"".$row['MapX']."\",";
			$result['content'] .= "\"".$row['MapY']."\",";
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