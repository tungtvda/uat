<?php
// Require required models
Core::requireModel('agent');
Core::requireModel('generator');
Core::requireModel('transaction');

class AgentPromotionModel extends BaseModel
{

        private $output = array();

        private $module_name = "Agent Promotion";
	private $module_dir = "modules/agentpromotion/";
        private $module_default_url = "/main/agentpromotion/index";
        private $module_default_admin_url = "/admin/agentpromotion/index";
        private $module_default_agent_url = "/agent/agentpromotion/index";

	public function __construct()
	{
		parent::__construct();
	}


	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM agent_promotion";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/agentpromotion/index';
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

		$sql = "SELECT * FROM agent_promotion ORDER BY Title DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Title' => $row['Title'],
			'Position' => $row['Position'],
			'First' => $row['First'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['agentpromotion']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Promotions", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['agentpromotion']['dir'].'inc/main/index.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module['agentpromotion']['dir'].'inc/main/index.bottom.inc.php'),
        'block' => array('side_nav' => $this->module['agentpromotion']['dir'].'inc/main/side_nav.agentpromotion.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['agentpromotion']['dir'].'meta/main/index.inc.php'));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM agent_promotion WHERE ID = '".$param."'".$query_condition;

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Title' => $row['Title'],
			'Position' => $row['Position'],
			'First' => $row['First'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['agentpromotion']['name'], "Link" => $this->module['agentpromotion']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['agentpromotion']['dir'].'inc/main/view.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module['agentpromotion']['dir'].'inc/main/view.bottom.inc.php'),
        'block' => array('side_nav' => $this->module['agentpromotion']['dir'].'inc/main/side_nav.agentpromotion.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['agentpromotion']['dir'].'meta/main/view.inc.php'));

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
			$_SESSION['agentpromotion_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=");
                        $query_condition .= $crud->queryCondition("AgentID",$_POST['AgentUsernameID'],"=");
			$query_condition .= $crud->queryCondition("Title",$_POST['Title'],"LIKE");
			$query_condition .= $crud->queryCondition("First",$_POST['First'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
                        $_SESSION['agentpromotion_'.__FUNCTION__]['param']['AgentUsernameID'] = $_POST['AgentUsernameID'];
			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['Title'] = $_POST['Title'];
			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['First'] = $_POST['First'];
			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentpromotion_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentpromotion_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agentpromotion_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
			$sort = TRUE;
		}

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM agent_promotion ".$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/agentpromotion/index';
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

		$sql = "SELECT * FROM agent_promotion ".$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition']." ORDER BY Title DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => AgentModel::getAgent($row['AgentID'], "Name"),
                        'AgentUsername' => AgentModel::getAgent($row['AgentID'], "Username"),
			'Title' => $row['Title'],
			'Position' => $row['Position'],
			'First' => $row['First'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result2 = AgentModel::getAdminAgentAllParentChild();
                $result3 = AgentModel::getUsernameAdminAgentAllParentChild();
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Promotions", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/admin/index.bottom.inc.php', 'agentpromotion_delete' => $_SESSION['admin']['agentpromotion_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agentpromotion_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Index"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'sort' => $sort, 'agent_list1' => $result2['result2'], 'agent_list2' => $result2['result3'], 'agent_username1' => $result3['result2'], 'agent_username2' => $result3['result3']),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agentpromotion_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Agent Promotion", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/admin/add.bottom.inc.php', 'agentpromotion_add' => $_SESSION['admin']['agentpromotion_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agentpromotion_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"index"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agentpromotion_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(AgentID, Title, Position, First, Enabled)";
		$value = "('".$_POST['AgentID']."', '".$_POST['Title']."', '".$_POST['Position']."', '".$_POST['First']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO agent_promotion ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

        // Generate .htaccess
        GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Agent Promotion...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM agent_promotion WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Title' => $row['Title'],
			'Position' => $row['Position'],
			'First' => $row['First'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}



		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Agent Promotion", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/admin/edit.bottom.inc.php', 'agentpromotion_add' => $_SESSION['admin']['agentpromotion_add'], 'agentpromotion_edit' => $_SESSION['admin']['agentpromotion_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agentpromotion.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Agent Promotion"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agentpromotion_add']);
		unset($_SESSION['admin']['agentpromotion_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		$sql = "UPDATE agent_promotion SET AgentID='".$_POST['AgentID']."', Title='".$_POST['Title']."', Position='".$_POST['Position']."', First='".$_POST['First']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

        // Generate .htaccess
        GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Agent Promotion...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM agent_promotion WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Agent Promotion...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

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
			$_SESSION['agentpromotion_'.__FUNCTION__] = "";


                        $query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=", 1);


                        $query_condition .= $crud->queryCondition("AgentID",$_POST['AgentUsernameID'],"=");
			$query_condition .= $crud->queryCondition("Title",$_POST['Title'],"LIKE");
			$query_condition .= $crud->queryCondition("First",$_POST['First'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['AgentUsernameID'] = $_POST['AgentUsernameID'];
                        $_SESSION['agentpromotion_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['Title'] = $_POST['Title'];
			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['First'] = $_POST['First'];
			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentpromotion_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentpromotion_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agentpromotion_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
			$sort = TRUE;
		}

                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_SESSION['agent']['ID']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_SESSION['agent']['ID']);
                }


                $child = implode(',', $_SESSION['agentchild']);

                unset($_SESSION['agentchild']);

                if(isset($_SESSION['agentpromotion_'.__FUNCTION__]['param']['AgentID'])===true && empty($_SESSION['agentpromotion_'.__FUNCTION__]['param']['AgentID'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND AgentID IN (".$child.")";
                }



                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM agent_promotion WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition'];

                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                    $targetpage = $data['config']['SITE_DIR'].'/agent/agentpromotion/index';
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

                    $sql = "SELECT * FROM agent_promotion WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition']." ORDER BY Title DESC LIMIT $start, $limit";
                    //echo $sql;
                    //exit;


		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => AgentModel::getAgent($row['AgentID'], "Name"),
                        'AgentUsername' => AgentModel::getAgent($row['AgentID'], "Username"),
			'Title' => $row['Title'],
			'Position' => $row['Position'],
			'First' => $row['First'],
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
                                        'Username' => $row2['Username'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }

                        $result2['count'] = $z;


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Promotions", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/index.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/agent/index.bottom.inc.php', 'agentpromotion_delete' => $_SESSION['agent']['agentpromotion_delete']),
		'block' => array('side_nav' => $this->module['agentpromotion']['dir'].'inc/agent/side_nav.agentpromotion_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"index"),
		'content' => $result,
                'agent' => $result2,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['agentpromotion_delete']);

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
		'page' => array('title' => "Create Agent Promotion", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/add.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/agent/add.bottom.inc.php', 'agentpromotion_add' => $_SESSION['agent']['agentpromotion_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agentpromotion_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Add Agent Promotion"),
                'content' => $result2,
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['agentpromotion_add']);

		return $this->output;
	}

	public function AgentAddProcess($param)
	{
		$key = "(AgentID, Title, Position, First, Enabled)";
		$value = "('".$_POST['AgentID']."', '".$_POST['Title']."', '".$_POST['Position']."', '".$_POST['First']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO agent_promotion ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
                $ok = ($count==1) ? 1 : "";

                // Generate .htaccess
                GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Agent Promotion...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentEdit($param)
	{
		$sql = "SELECT * FROM agent_promotion WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Title' => $row['Title'],
			'Position' => $row['Position'],
			'First' => $row['First'],
			'Enabled' => $row['Enabled']);

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
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Agent Promotion", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/agent/edit.bottom.inc.php', 'agentpromotion_add' => $_SESSION['agent']['agentpromotion_add'], 'agentpromotion_edit' => $_SESSION['agent']['agentpromotion_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agentpromotion.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Edit Agent Promotion"),
		'content' => $result,
                'agent' => $result2,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['agentpromotion_add']);
		unset($_SESSION['agent']['agentpromotion_edit']);

		return $this->output;
	}

	public function AgentEditProcess($param)
	{
		$sql = "UPDATE agent_promotion SET AgentID='".$_POST['AgentID']."', Title='".$_POST['Title']."', Position='".$_POST['Position']."', First='".$_POST['First']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
                $ok = ($count==1) ? 1 : "";

                // Generate .htaccess
                GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Agent Promotion...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentDelete($param)
	{
		$sql = "DELETE FROM agent_promotion WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
                $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Agent Promotion...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}



	public function AdminSort($param)
    {
        $param = explode(",",$_POST['param']);

        $i = 0;
        foreach($param as $id)
        {
            $sql = "UPDATE agent_promotion SET Position='".$i."' WHERE ID='".$id."'";
            $count = $this->dbconnect->exec($sql);

            $i++;
        }

        $result = $i;

        return $result;
    }

    public function AdminBulkUpdate()
    {
        //Debug::displayArray($_POST);
        //exit;

         if(empty($_POST['Agent'])===FALSE)
         {

            //Check agent exist

            foreach ($_POST['Agent'] as $resellerID) {
                //Get each agent ID

                if(empty($_POST['Agentpromotion'][$resellerID])===FALSE)
                {
                    //Check if Product empty

                    foreach ($_POST['Agentpromotion'] as $Agent => $Product) {

                    //Separate and get each part of product

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $agentPromotionCount = count($_POST['Agentpromotion'][$Agent]);




                            for ($i=0; $i<$agentPromotionCount; $i++) {

                                    $concat.=$_POST['Agentpromotion'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$agentPromotionCount){



                                     }
                                     else
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $agentPromotion = array();

                            for ($i=0; $i<$agentPromotionCount; $i++) {
                                array_push($agentPromotion, "'".$_POST['Agentpromotion'][$Agent][$i]."'");
                            }



                            // Get Agent product created before this process
                            $AgentpromotionList = AgentPromotionModel::getAgentPromotionTitleWithoutCounter($Agent);

                            $AgentpromotionList = explode(',', $AgentpromotionList);

                            $AgentpromotionList['count'] = count($AgentpromotionList);


                            //Reason to use array_diff and array_intersect are to prevent wallet duplications

                            //Get products similarity between selected and created

                            $intersect = array_intersect($agentPromotion, $AgentpromotionList);

                            $intersect = array_values($intersect);

                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {


                                $sql = "DELETE FROM agent_promotion WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else
                            {
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM agent_promotion WHERE AgentID = '".$Agent."'";

                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$agentPromotionCount; $i++) {

                                        $key = "(AgentID, Title, Position, First, Enabled)";
                                        $value = "('".$Agent."', '".$_POST['Agentpromotion'][$Agent][$i]."', '', 'No', '1')";


                                        $sql2 = "INSERT INTO agent_promotion ".$key." VALUES ". $value;

                                        $this->dbconnect->exec($sql2);


                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $agentpromotiondeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM agent_promotion WHERE AgentID = '".$Agent."' AND Title NOT IN (".$agentpromotiondeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newAgentPromotionList = AgentPromotionModel::getAgentPromotionTitleWithoutCounter($Agent);

                                    $newAgentPromotionList = explode(',', $newAgentPromotionList);


                                    // Get selected products not included in created products
                                    $newAgentPromotion = array_diff($agentPromotion, $newAgentPromotionList);

                                    if(empty($newAgentPromotion)===TRUE)
                                    {


                                    }
                                    else
                                    {
                                        $newAgentPromotion = array_values($newAgentPromotion);
                                        $newAgentPromotion['count'] = count($newAgentPromotion);

                                        for ($i=0; $i<$newAgentPromotion['count']; $i++) {

                                                $key = "(AgentID, Title, Position, First, Enabled)";
                                                $value = "('".$Agent."', ".$newAgentPromotion[$i].", '', 'No', '1')";

                                                $sql2 = "INSERT INTO agent_promotion ".$key." VALUES ". $value;

                                                $this->dbconnect->exec($sql2);


                                        }

                                    }

                                }
                            }


                            //$sql6 = "UPDATE agent SET Product='".$concat."' WHERE ID='".$Agent."'";
                            //$this->dbconnect->exec($sql6);




                      }
                    }
                }
                else
                {
                    //echo 'hi<br>';


                    //$sql = "UPDATE agent_block SET Product='' WHERE ID='".$resellerID."'";
                    //$this->dbconnect->exec($sql);
                    //echo $sql.'<br>';

                    $sql2 = "DELETE FROM agent_promotion WHERE AgentID = '".$resellerID."'";
                    //echo $sql2.'<br>';
                    //exit;
                    $count = $this->dbconnect->exec($sql2);
                }
            }
        }

    }

    public function AgentBulkUpdate()
    {
        //Debug::displayArray($_POST);
        //exit;

         if(empty($_POST['Agent'])===FALSE)
         {

            //Check agent exist

            foreach ($_POST['Agent'] as $resellerID) {
                //Get each agent ID

                if(empty($_POST['Agentpromotion'][$resellerID])===FALSE)
                {
                    //Check if Product empty

                    foreach ($_POST['Agentpromotion'] as $Agent => $Product) {

                    //Separate and get each part of product

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $agentPromotionCount = count($_POST['Agentpromotion'][$Agent]);




                            for ($i=0; $i<$agentPromotionCount; $i++) {

                                    $concat.=$_POST['Agentpromotion'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$agentPromotionCount){



                                     }
                                     else
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $agentPromotion = array();

                            for ($i=0; $i<$agentPromotionCount; $i++) {
                                array_push($agentPromotion, "'".$_POST['Agentpromotion'][$Agent][$i]."'");
                            }



                            // Get Agent product created before this process
                            $AgentpromotionList = AgentPromotionModel::getAgentPromotionTitleWithoutCounter($Agent);

                            $AgentpromotionList = explode(',', $AgentpromotionList);

                            $AgentpromotionList['count'] = count($AgentpromotionList);


                            //Reason to use array_diff and array_intersect are to prevent wallet duplications

                            //Get products similarity between selected and created

                            $intersect = array_intersect($agentPromotion, $AgentpromotionList);

                            $intersect = array_values($intersect);

                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {


                                $sql = "DELETE FROM agent_promotion WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else
                            {
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM agent_promotion WHERE AgentID = '".$Agent."'";

                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$agentPromotionCount; $i++) {

                                        $key = "(AgentID, Title, Position, First, Enabled)";
                                        $value = "('".$Agent."', '".$_POST['Agentpromotion'][$Agent][$i]."', '', 'No', '1')";


                                        $sql2 = "INSERT INTO agent_promotion ".$key." VALUES ". $value;

                                        $this->dbconnect->exec($sql2);


                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $agentpromotiondeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM agent_promotion WHERE AgentID = '".$Agent."' AND Title NOT IN (".$agentpromotiondeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newAgentPromotionList = AgentPromotionModel::getAgentPromotionTitleWithoutCounter($Agent);

                                    $newAgentPromotionList = explode(',', $newAgentPromotionList);


                                    // Get selected products not included in created products
                                    $newAgentPromotion = array_diff($agentPromotion, $newAgentPromotionList);

                                    if(empty($newAgentPromotion)===TRUE)
                                    {


                                    }
                                    else
                                    {
                                        $newAgentPromotion = array_values($newAgentPromotion);
                                        $newAgentPromotion['count'] = count($newAgentPromotion);

                                        for ($i=0; $i<$newAgentPromotion['count']; $i++) {

                                                $key = "(AgentID, Title, Position, First, Enabled)";
                                                $value = "('".$Agent."', ".$newAgentPromotion[$i].", '', 'No', '1')";

                                                $sql2 = "INSERT INTO agent_promotion ".$key." VALUES ". $value;

                                                $this->dbconnect->exec($sql2);


                                        }

                                    }

                                }
                            }


                            //$sql6 = "UPDATE agent SET Product='".$concat."' WHERE ID='".$Agent."'";
                            //$this->dbconnect->exec($sql6);




                      }
                    }
                }
                else
                {
                    //echo 'hi<br>';


                    //$sql = "UPDATE agent_block SET Product='' WHERE ID='".$resellerID."'";
                    //$this->dbconnect->exec($sql);
                    //echo $sql.'<br>';

                    $sql2 = "DELETE FROM agent_promotion WHERE AgentID = '".$resellerID."'";
                    //echo $sql2.'<br>';
                    //exit;
                    $count = $this->dbconnect->exec($sql2);
                }
            }
        }

    }

    public function AdminManage($param)
    {
        // Initialise query conditions
        $query_condition = "";

        $crud = new CRUD();

        if ($_POST['Trigger']=='search_form')
        {

        // Reset Query Variable
                $_SESSION['agentpromotion_'.__FUNCTION__] = "";

                $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=");
                //$query_condition .= $crud->queryCondition("ID",$_POST['AgentBlock'],"=");
                //$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
                //$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

                $_SESSION['agentpromotion_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
                $_SESSION['agentpromotion_'.__FUNCTION__]['param']['AgentBlock'] = $_POST['AgentBlock'];
                $_SESSION['agentpromotion_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
                $_SESSION['agentpromotion_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

                // Set Query Variable
                $_SESSION['agentpromotion_'.__FUNCTION__]['query_condition'] = $query_condition;
                $_SESSION['agentpromotion_'.__FUNCTION__]['query_title'] = "Search Results";
        }

        // Reset query conditions
        if ($_GET['page']=="all")
        {
            $_GET['page'] = "";
            unset($_SESSION['agentpromotion_'.__FUNCTION__]);
        }

        // Determine Title
        if (isset($_SESSION['agentpromotion_'.__FUNCTION__]))
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
        #$query_count = "SELECT COUNT(*) AS num FROM permission ".$_SESSION['permission_'.__FUNCTION__]['query_condition'];

        $query_count = "SELECT COUNT(*) AS num FROM agent ".$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition'];

        /*echo $query_count;
        exit();*/

        #echo $query_count;
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

        $targetpage = $data['config']['SITE_DIR'].'/admin/agentpromotion/manage';
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

        #$sql = "SELECT * FROM permission ".$_SESSION['permission_'.__FUNCTION__]['query_condition']." ORDER BY ProfileID ASC LIMIT $start, $limit";

        $sql = "SELECT * FROM agent ".$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
        //echo $sql;
        //exit;
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'Agentpromotion' => AgentPromotionModel::getAgentPromotionTitle($row['ID']),
            'agentpromotion_list' => AgentPromotionModel::getAgentPromotionTitle($row['ID']),
            'Enabled' => CRUD::isActive($row['Enabled']));

            $i += 1;
        }

                $result['count'] = $i;

                $result2 = AgentModel::getAdminAgentAllParentChild();


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bulk Update", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/manage.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agentblock_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Manage"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'test1' => $result2['result2'], 'test2' => $result2['result3'], 'agentpromotion_list' => AgentPromotionModel::getAgentPromotionTitle()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


		return $this->output;
    }

    public function AgentManage($param)
    {
        // Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['agentpromotion_'.__FUNCTION__] = "";



                        $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=", 1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
                        $query_condition .= $crud->queryCondition("Position",$_POST['Position'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
                        $_SESSION['agentpromotion_'.__FUNCTION__]['param']['Position'] = $_POST['Position'];
			$_SESSION['agentpromotion_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentpromotion_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentpromotion_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agentpromotion_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_SESSION['agent']['ID']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_SESSION['agent']['ID']);
                }


                $child = implode(',', $_SESSION['agentchild']);

                unset($_SESSION['agentchild']);

                if(isset($_SESSION['agentpromotion_'.__FUNCTION__]['param']['Agent'])===true && empty($_SESSION['agentpromotion_'.__FUNCTION__]['param']['Agent'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND ID IN (".$child.")";
                }




                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition'];
                    //echo $query_count;
                    //exit;
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                    $targetpage = $data['config']['SITE_DIR'].'/agent/agentpromotion/manage';
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

                    $sql = "SELECT * FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentpromotion_'.__FUNCTION__]['query_condition']." ORDER BY Name DESC LIMIT $start, $limit";





		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
                        'ID' => $row['ID'],
                        'Name' => $row['Name'],
                        'Agentpromotion' => AgentPromotionModel::getAgentPromotionTitle($row['ID']),
                        'agentpromotion_list' => AgentPromotionModel::getAgentPromotionTitle($row['ID']),
                        'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);
                        if($count>'0')
                        {
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }
                        }
                        else
                        {
                         foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }
                        }

                        $result2['count'] = $z;



		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bulk Update", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/manage.inc.php', 'custom_bottom_inc' => 'off', 'custom_bottom_inc_loc' => $this->module_dir.'inc/agent/index.bottom.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agentblock_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Index"),
		'content' => $result,
                'agent' => $result2,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'agentpromotion_list' => AgentPromotionModel::getAgentPromotionTitle()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


		return $this->output;
    }

    public function AdminPosition($param)
    {
        $param = $_POST['param'];

        $crud = new CRUD();

        $sql = "SELECT * FROM agent_promotion WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Position' => $row['Position']);

            $i += 1;
        }

        $result = $result[0]['ID'].",".$result[0]['Position'];

        return $result;
    }

	public function getAgentPromotion($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent_promotion WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Title' => $row['Title'],
			'Position' => $row['Position'],
			'First' => $row['First'],
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

	public function getAgentPromotionList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent_promotion ORDER BY Title DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Title' => $row['Title'],
			'Position' => $row['Position'],
			'First' => $row['First'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

        public function getAgentPromotionListByAgent($param, $memberID)
	{
		$crud = new CRUD();

        // Get immediate platform agent ID
        if (AgentModel::getAgent($param, 'TypeID')=='2')
        {
            AgentModel::getloopAgentParent($param);

            $agent_platform = $_SESSION['platform_agent'];
            unset($_SESSION['platform_agent']);
        }
        else {
            $agent_platform = $param;
        }


		$sql = "SELECT * FROM agent_promotion WHERE AgentID = '".$agent_platform."' AND Enabled = '1' ORDER BY Position ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{

                     $count = TransactionModel::getTransactionByMemberID($memberID);

                     if($count > '0' && $row['First']=='Yes')
                     {


                     }
                     else
                     {
                         $result[$i] = array(
                            'ID' => $row['ID'],
                            'AgentID' => $row['AgentID'],
                            'Title' => $row['Title'],
                            'Position' => $row['Position'],
                            'First' => $row['First'],
                            'Enabled' => CRUD::isActive($row['Enabled']));



                        $i += 1;
                     }


		}

                $result['count'] = $i;


		return $result;
	}

        public function getAPIAgentPromotionListByAgent($param, $memberID)
	{
		$crud = new CRUD();

        // Get immediate platform agent ID
        if (AgentModel::getAgent($param, 'TypeID')=='2')
        {
            AgentModel::getloopAgentParent($param);

            $agent_platform = $_SESSION['platform_agent'];
            unset($_SESSION['platform_agent']);
        }
        else {
            $agent_platform = $param;
        }

		$sql = "SELECT * FROM agent_promotion WHERE AgentID = '".$agent_platform."' AND Enabled = '1' ORDER BY Position ASC";

		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{

                     $count = TransactionModel::getTransactionByMemberID($memberID);

                     if($count > '0' && $row['First']=='Yes')
                     {


                     }
                     else
                     {
                         $dataSet = array(
                            'ID' => $row['ID'],
                            'AgentID' => $row['AgentID'],
                            'Title' => $row['Title'],
                            'Position' => $row['Position'],
                            'First' => $row['First'],
                            'Enabled' => CRUD::isActive($row['Enabled']));


                         array_push($result, $dataSet);

                     }


		}


		return $result;
	}

        public function getAgentPromotionTitle($param)
	{

		$sql = "SELECT * FROM agent_promotion WHERE AgentID = '".$param."' AND Enabled = '1' ORDER BY Position ASC";

		$result = array();

                $i = 0;

		foreach ($this->dbconnect->query($sql) as $row)
		{

                         $result[$i] = $row['Title'];

                         $i += 1;

		}

                $result['count'] = $i;


		return $result;

	}


        public function getAgentPromotionTitleWithoutCounter($param)
	{

		$sql = "SELECT * FROM agent_promotion WHERE AgentID = '".$param."' AND Enabled = '1' ORDER BY Position ASC";

                $result = '';


		foreach ($this->dbconnect->query($sql) as $row)
		{
			$title = "'".$row['Title']."'";
			$result .= $title.',';



		}

                $result = rtrim($result, ',');


		return $result;

	}

        public function getAgentPromotionListByAgentID($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent_promotion WHERE AgentID = '".$param."' AND Enabled = '1' ORDER BY Position ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{

                    $result[$i] = array(
                    'ID' => $row['ID'],
                    'AgentID' => $row['AgentID'],
                    'Title' => $row['Title'],
                    'Position' => $row['Position'],
                    'First' => $row['First'],
                    'Enabled' => $row['Enabled']);

                    $i += 1;

		}


		$result['count'] = $i;

		return $result;
	}

        public function getEnabledAgentPromotionList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent_promotion WHERE Enabled = '1' ORDER BY Position ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{

                    $result[$i] = array(
                    'ID' => $row['ID'],
                    'AgentID' => $row['AgentID'],
                    'Title' => $row['Title'],
                    'Position' => $row['Position'],
                    'First' => $row['First'],
                    'Enabled' => $row['Enabled']);

                    $i += 1;

		}


		$result['count'] = $i;

		return $result;
	}

        public function getEnabledAgentPromotionListByAgentID($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent_promotion WHERE Enabled = '1' AND AgentID = '".$param."' ORDER BY Position ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{

                    $result[$i] = array(
                    'ID' => $row['ID'],
                    'AgentID' => $row['AgentID'],
                    'Title' => $row['Title'],
                    'Position' => $row['Position'],
                    'First' => $row['First'],
                    'Enabled' => $row['Enabled']);

                    $i += 1;

		}


		$result['count'] = $i;

		return $result;
	}

        public function getAgentPromotionListByAgentCount($param)
	{


		$sql = "SELECT COUNT(*) AS agentCount FROM agent_promotion WHERE AgentID = '".$param."' ORDER BY Position ASC";

		foreach ($this->dbconnect->query($sql) as $row)
		{

                    $result = $row['agentCount'];


		}



		return $result;
	}

	public function BlockIndex($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM agent_promotion";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/agentpromotion/index';
		$limit = 5;
		$stages = 3;
		$page = mysql_escape_string($param);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM agent_promotion ORDER BY Title DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Title' => $row['Title'],
			'Position' => $row['Position'],
			'First' => $row['First'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Agent Promotions", 'template' => 'common.tpl.php'),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'secure' => NULL,
        'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM agent_promotion ".$_SESSION['agentpromotion_'.$param]['query_condition']." ORDER BY Title DESC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Agent_Promotions";
		$result['header'] = $this->config['SITE_NAME']." | Agent Promotions (" . date('Y-m-d H:i:s') . ")\n\nID, Agent, Title, Position, First, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".AgentModel::getAgent($row['AgentID'])."\",";
			$result['content'] .= "\"".$row['Title']."\",";
			$result['content'] .= "\"".$row['Position']."\",";
			$result['content'] .= "\"".CRUD::isActive($row['First'])."\",";
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