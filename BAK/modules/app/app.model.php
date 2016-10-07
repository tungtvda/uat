<?php
// Require required models
Core::requireModel('generator');

class AppModel extends BaseModel
{
	/*private $output = array();
        private $module = array();*/
        
        private $output = array();
        private $module_name = "App";
	private $module_dir = "modules/app/";
        private $module_default_url = "/main/app/index";
        private $module_default_admin_url = "/admin/app/index";
        private $module_default_agent_url = "/agent/app/index";

	public function __construct()
	{
		parent::__construct();

        $this->module['app'] = array(
        'name' => "App",
        'dir' => "modules/app/",
        'default_url' => "/main/app/index",
        'admin_url' => "/admin/app/index");
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM app WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/app/index';
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

		$sql = "SELECT * FROM app WHERE Enabled = 1 ORDER BY Name DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'PublicKey' => $row['PublicKey'],
			'SecretKey' => $row['SecretKey'],
			'IPAddress' => $row['IPAddress'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['app']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Apps", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['app']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM app WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'PublicKey' => $row['PublicKey'],
			'SecretKey' => $row['SecretKey'],
			'IPAddress' => $row['IPAddress'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['app']['name'], "Link" => $this->module['app']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['app']['dir'].'inc/main/view.inc.php'),
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
			$_SESSION['app_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("PublicKey",$_POST['PublicKey'],"LIKE");
			$query_condition .= $crud->queryCondition("SecretKey",$_POST['SecretKey'],"LIKE");
			$query_condition .= $crud->queryCondition("IPAddress",$_POST['IPAddress'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['app_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['app_'.__FUNCTION__]['param']['PublicKey'] = $_POST['PublicKey'];
			$_SESSION['app_'.__FUNCTION__]['param']['SecretKey'] = $_POST['SecretKey'];
			$_SESSION['app_'.__FUNCTION__]['param']['IPAddress'] = $_POST['IPAddress'];
			$_SESSION['app_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['app_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['app_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['app_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['app_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM app ".$_SESSION['app_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/app/index';
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

		$sql = "SELECT * FROM app ".$_SESSION['app_'.__FUNCTION__]['query_condition']." ORDER BY Name DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'PublicKey' => $row['PublicKey'],
			'SecretKey' => $row['SecretKey'],
			'IPAddress' => $row['IPAddress'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Apps", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['app']['dir'].'inc/admin/index.inc.php', 'app_delete' => $_SESSION['admin']['app_delete']),
		'block' => array('side_nav' => $this->module['app']['dir'].'inc/admin/side_nav.app_common.inc.php'),       
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Index"),    
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['app_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create App", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['app']['dir'].'inc/admin/add.inc.php', 'app_add' => $_SESSION['admin']['app_add']),
		'block' => array('side_nav' => $this->module['app']['dir'].'inc/admin/side_nav.app_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create App"),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['app_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
	    $bcrypt = new Bcrypt(9);
		$public_hash = hash('sha256', $_POST['Name'].date('YmdHis'));
		$secret_hash = $bcrypt->hash($public_hash);


		$key = "(Name, PublicKey, SecretKey, IPAddress, Enabled)";
		$value = "('".$_POST['Name']."', '".$public_hash."', '".$secret_hash."', '".$_POST['IPAddress']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO app ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating App...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM app WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
            $result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'PublicKey' => $row['PublicKey'],
			'SecretKey' => $row['SecretKey'],
			'IPAddress' => $row['IPAddress'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

                //$hash = hash_hmac('sha1', $result[0]['PublicKey'].'00:00:00', $result[0]['SecretKey']);
                    //echo $hash.'<br>';
                    //echo time();
                    //exit;

        

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit App", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['app']['dir'].'inc/admin/edit.inc.php', 'app_add' => $_SESSION['admin']['app_add'], 'app_edit' => $_SESSION['admin']['app_edit']),
        'block' => array('side_nav' => $this->module['app']['dir'].'inc/admin/side_nav.app_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit App"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['app_add']);
		unset($_SESSION['admin']['app_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
        if ($_POST['NewCredentials']==1)
        {
            $bcrypt = new Bcrypt(9);
            $public_hash = hash('sha256', $_POST['Name'].date('YmdHis'));
            $secret_hash = $bcrypt->hash($public_hash);
        }
        else
        {
            $hash = $this->getHash($param);

            $public_hash = $hash['PublicKey'];
            $secret_hash = $hash['SecretKey'];
        }

		$sql = "UPDATE app SET Name='".$_POST['Name']."', PublicKey='".$public_hash."', SecretKey='".$secret_hash."', IPAddress='".$_POST['IPAddress']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing App...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM app WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting App...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM app ".$_SESSION['app_'.$param]['query_condition']." ORDER BY Name DESC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_app";
		$result['header'] = $this->config['SITE_NAME']." | App (" . date('Y-m-d H:i:s') . ")\n\nID, Name, Public Key, Secret Key, IPAddress, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['PublicKey']."\",";
			$result['content'] .= "\"".$row['SecretKey']."\",";
			$result['content'] .= "\"".$row['IPAddress']."\",";
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

	public function getApp($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM app WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'PublicKey' => $row['PublicKey'],
			'SecretKey' => $row['SecretKey'],
			'IPAddress' => $row['IPAddress'],
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

	public function getAppList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM app ORDER BY Name DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'PublicKey' => $row['PublicKey'],
			'SecretKey' => $row['SecretKey'],
			'IPAddress' => $row['IPAddress'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

    public function verifyCredentials($request_data)
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM app WHERE PublicKey = '".$request_data['PublicKey']."' AND Enabled = 1";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'PublicKey' => $row['PublicKey'],
            'SecretKey' => $row['SecretKey'],
            'IPAddress' => $row['IPAddress']);

            $i += 1;
        }

        if ($i>0)
        {
            // If a registered IP address exists, check current IP address matches registered IP address
            if ($result[0]['IPAddress']!="")
            {
                $ip_address = $_SERVER['REMOTE_ADDR'];

                if ($result[0]['IPAddress']==$ip_address)
                {
                    // Verify hash provided from request
                    $hash = hash_hmac('sha1', $result[0]['PublicKey'].$request_data['Timestamp'], $result[0]['SecretKey']);

                    if ($hash==$request_data['Hash'])
                    {
                        $output['Status'] = "OK";
                    }
                    else
                    {
                        $output['Status'] = "INVALID_REQUEST";
                    }
                }
                else
                {
                    $output['Status'] = "INVALID_IP";
                }
            }
            else
            {
                // Verify hash provided from request
                $hash = hash_hmac('sha1', $result[0]['PublicKey'].$request_data['Timestamp'], $result[0]['SecretKey']);
                //echo
                if ($hash==$request_data['Hash'])
                {
                    $output['Status'] = "OK";
                }
                else
                {
                    $output['Status'] = "INVALID_REQUEST";
                }
            }
        }
        else
        {
            $output['Status'] = "INVALID_APP";
        }

        return $output;
    }

    public function getHash($param)
    {
        $sql = "SELECT PublicKey, SecretKey FROM app WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'PublicKey' => $row['PublicKey'],
            'SecretKey' => $row['SecretKey']);

            $i += 1;
        }

        return $result[0];
    }

    public function DNSLogin()
    {
        $restapi = new RestAPI();
        // Form Post
        $data_string = 'sub-auth-id=32&auth-password=12341234';

        $param = $restapi->makeRequest("https://api.cloudns.net/dns/available-name-servers.json", $data_string, "GET");

        Debug::displayArray(json_decode($param,1));
    }
}
?>