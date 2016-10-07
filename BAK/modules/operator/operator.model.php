<?php
// Require required models
Core::requireModel('agent');
Core::requireModel('profile');


class OperatorModel extends BaseModel
{
	private $output = array();
        private $module_name = "Operator";
        private $module_dir = "modules/operator/";
        private $module_default_url = "/main/operator/index";
        private $module_default_admin_url = "/admin/operator/index";
        private $module_default_member_url = "/member/operator/index";
        private $module_default_agentmember_url = "/agent/operator/index";

	public function __construct()
	{
		parent::__construct();
	}



	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM operator WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/operator/index';
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

		$sql = "SELECT * FROM operator WHERE Enabled = 1 ORDER BY ID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'ProfileID' => CRUD::isActive($row['ProfileID']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['operator']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Operators", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['operator']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM operator WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'ProfileID' => CRUD::isActive($row['ProfileID']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['operator']['name'], "Link" => $this->module['operator']['default_url']),
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

        public function getHash($param)
        {
            $sql = "SELECT Password FROM operator WHERE ID = '".$param."'";

            $result = array();
            $i = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i] = array(
                'ID' => $row['ID'],
                'Password' => $row['Password']);

                $i += 1;
            }

            return $result[0]['Password'];
        }

	public function AdminIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['operator_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=");
			$query_condition .= $crud->queryCondition("ProfileID",$_POST['ProfileID'],"=");
                        $query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['operator_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['operator_'.__FUNCTION__]['param']['ProfileID'] = $_POST['ProfileID'];
                        $_SESSION['operator_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			$_SESSION['operator_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['operator_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['operator_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['operator_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['operator_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM operator ".$_SESSION['operator_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/operator/index';
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

		$sql = "SELECT * FROM operator ".$_SESSION['operator_'.__FUNCTION__]['query_condition']." ORDER BY ID ASC LIMIT $start, $limit";
		//echo $sql;
                //exit;
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => AgentModel::getAgent($row['AgentID'], "Name"),
                        'Username' => $row['Username'],
			'ProfileID' => ProfileModel::getProfile($row['ProfileID'], "Profile"),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

                $result2 = AgentModel::getAdminAgentAllParentChild();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Operators &AMP; Analysts", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'operator_delete' => $_SESSION['admin']['operator_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.operator_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"",$this->config,"Index"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'profile_list' => ProfileModel::getOperatorProfileList(), 'agent_list1' => $result2['result2'], 'agent_list2' => $result2['result3']),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['operator_delete']);

		return $this->output;
	}

        public function AgentIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['operator_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=", 1);
			$query_condition .= $crud->queryCondition("ProfileID",$_POST['ProfileID'],"=");
                        $query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['operator_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['operator_'.__FUNCTION__]['param']['ProfileID'] = $_POST['ProfileID'];
                        $_SESSION['operator_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			$_SESSION['operator_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['operator_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['operator_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['operator_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['operator_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM operator WHERE AgentID IN (SELECT ID FROM agent WHERE ParentID = '".$_SESSION['agent']['ID']."' OR ID = '".$_SESSION['agent']['ID']."') ".$_SESSION['operator_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/agent/operator/index';
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

		$sql = "SELECT * FROM operator WHERE AgentID IN (SELECT ID FROM agent WHERE ParentID = '".$_SESSION['agent']['ID']."' OR ID = '".$_SESSION['agent']['ID']."') ".$_SESSION['operator_'.__FUNCTION__]['query_condition']." ORDER BY ID ASC LIMIT $start, $limit";
		//echo $sql;
                //exit;
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => AgentModel::getAgent($row['AgentID'], "Name"),
                        'Username' => $row['Username'],
			'ProfileID' => ProfileModel::getProfile($row['ProfileID'], "Profile"),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }

                        $result2['count'] = $z;


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Operators &AMP; Analysts", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/index.inc.php', 'operator_delete' => $_SESSION['agent']['operator_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.operator_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentmember_url,"",$this->config,"Index"),
		'content' => $result,
                'agent' => $result2,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'profile_list' => ProfileModel::getOperatorProfileList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['operator_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Operator &AMP; Analysts", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'operator_add' => $_SESSION['admin']['operator_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.operator_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"",$this->config,"Add"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'profile_list' => ProfileModel::getOperatorProfileList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['operator_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
            $sql = "SELECT COUNT(*) AS operatorNum FROM operator WHERE Username = '".$_POST['Username']."' AND Enabled = '1'";


            foreach ($this->dbconnect->query($sql) as $row)
            {
                   $operatorNum = $row['operatorNum']; 
            }
            
            if($operatorNum=='0')
            {    
            
            $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

		$key = "(AgentID, Username, Password, ProfileID, Enabled)";
		$value = "('".$_POST['AgentID']."', '".$_POST['Username']."', '".$hash."', '".$_POST['ProfileID']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO operator ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
                $ok = ($count==1) ? 1 : "";
            }
            else 
            {
                $error = array();
                $error['Username'] = "1";
                $error['count'] = 1;
                
            }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Operator...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM operator WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
                        'Username' => $row['Username'],
			'ProfileID' => $row['ProfileID'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Operator &AMP; Analysts", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'operator_add' => $_SESSION['admin']['operator_add'], 'operator_edit' => $_SESSION['admin']['operator_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.operator_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"",$this->config,"Edit"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'profile_list' => ProfileModel::getOperatorProfileList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['operator_add']);
		unset($_SESSION['admin']['operator_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
            // Check is username exists
            $sql = "SELECT COUNT(*) AS operatorNum FROM operator WHERE Username = '".$_POST['Username']."' AND ID != '".$param."' AND Enabled = '1'";


            foreach ($this->dbconnect->query($sql) as $row)
            {
                $operatorNum = $row['operatorNum'];
            }
            
            if($operatorNum=='0'){
            
            
                if ($_POST['NewPassword']==1)
                {
                    $bcrypt = new Bcrypt(9);
                    $hash = $bcrypt->hash($_POST['Password']);
                }
                else
                {
                    $hash = $this->getHash($param);
                }

                    $sql = "UPDATE operator SET AgentID='".$_POST['AgentID']."', Username='".$_POST['Username']."', Password='".$hash."', AgentID='".$_POST['AgentID']."', ProfileID='".$_POST['ProfileID']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

                    $count = $this->dbconnect->exec($sql);

                    // Set Status
                    $ok = ($count<=1) ? 1 : "";
            }
            else
            {
                $error = array();
                $error['Username'] = '1';
                $error['count'] = 1;
            }    

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Operator...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM operator WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Operator...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

        public function AgentAdd($param)
	{

            $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }

                        $result2['count'] = $z;



		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Operator &AMP; Analysts", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/add.inc.php', 'operator_add' => $_SESSION['agent']['operator_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.operator_common.inc.php'),
                'content' => $result2,
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentmember_url,"",$this->config,"Add"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'profile_list' => ProfileModel::getOperatorProfileList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['operator_add']);

		return $this->output;
	}

	public function AgentAddProcess($param)
	{
         $sql = "SELECT COUNT(*) AS operatorNum FROM operator WHERE Username = '".$_POST['Username']."' AND Enabled = '1'";


            foreach ($this->dbconnect->query($sql) as $row)
            {
                   $operatorNum = $row['operatorNum']; 
            }
            
            if($operatorNum=='0')
            {   
            
            
                $bcrypt = new Bcrypt(9);
                $hash = $bcrypt->hash($_POST['Password']);

                        $key = "(AgentID, Username, Password, ProfileID, Enabled)";
                        $value = "('".$_POST['AgentID']."', '".$_POST['Username']."', '".$hash."', '".$_POST['ProfileID']."', '".$_POST['Enabled']."')";

                        $sql = "INSERT INTO `operator` ".$key." VALUES ". $value;

                        $count = $this->dbconnect->exec($sql);
                        $newID = $this->dbconnect->lastInsertId();

                        // Set Status
                $ok = ($count==1) ? 1 : "";
        
            }
            else 
            {
            
                $error = array();
                $error['Username'] = "1";
                $error['count'] = 1;
            }    

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Operator...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentEdit($param)
	{
		$sql = "SELECT * FROM operator WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
                        'Username' => $row['Username'],
			'ProfileID' => $row['ProfileID'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";
                //echo $sql2;
                    $result2 = array();
                    $z = 0;
                    $tier = 1;
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                            $result2[$z] = array(
                                    'ID' => $row2['ID'],
                                    'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                    'Name' => $row2['Name'],
                                    'Company' => $row2['Company']);

                            $z += 1;
                    }
                    //Debug::displayArray($result2);
                    //exit;
                    $result2['count'] = $z;



		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Operator &AMP; Analysts", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php', 'operator_add' => $_SESSION['agent']['operator_add'], 'operator_edit' => $_SESSION['agent']['operator_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.operator_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentmember_url,"",$this->config,"Edit"),
		'content' => $result,
                'agent' => $result2,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'profile_list' => ProfileModel::getOperatorProfileList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['operator_add']);
		unset($_SESSION['agent']['operator_edit']);

		return $this->output;
	}

	public function AgentEditProcess($param)
	{
            // Check is username exists
            $sql = "SELECT COUNT(*) AS operatorNum FROM operator WHERE Username = '".$_POST['Username']."' AND ID != '".$param."' AND Enabled = '1'";


            foreach ($this->dbconnect->query($sql) as $row)
            {
                $operatorNum = $row['operatorNum'];
            }
            
            if($operatorNum=='0') {
            
            if ($_POST['NewPassword']==1)
            {
                $bcrypt = new Bcrypt(9);
                $hash = $bcrypt->hash($_POST['Password']);
            }
            else
            {
                $hash = $this->getHash($param);
            }

		$sql = "UPDATE operator SET AgentID='".$_POST['AgentID']."', Username='".$_POST['Username']."', Password='".$hash."', AgentID='".$_POST['AgentID']."', ProfileID='".$_POST['ProfileID']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
                $ok = ($count<=1) ? 1 : "";
            
            }
            else
            {
                $error = array();
                $error['Username'] = '1';
                $error['count'] = 1;
                
            }    

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Operator...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentDelete($param)
	{
		$sql = "DELETE FROM operator WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Operator...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getOperator($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM operator WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
                        'Username' => $row['Username'],
			'ProfileID' => CRUD::isActive($row['ProfileID']),
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

	public function getOperatorList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM operator ORDER BY ID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'ProfileID' => CRUD::isActive($row['ProfileID']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM operator ".$_SESSION['operator_'.$param]['query_condition']." ORDER BY ID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_Label']."_Operator";
		$result['header'] = $this->config['SITE_Label']." | Operator (" . date('Y-m-d H:i:s') . ")\n\nID, Agent, Profile, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".AgentModel::getAgent($row['AgentID'], "Name")."\",";
			$result['content'] .= "\"".CRUD::isActive($row['ProfileID'])."\",";
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