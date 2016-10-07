<?php
// Require required models
Core::requireModel('agent');
Core::requireModel('generator');

class AgentBlockModel extends BaseModel
{
	private $output = array();
        private $module_name = "Agent Block";
	private $module_dir = "modules/agentblock/";
        private $module_default_url = "/main/agentblock/index";
        private $module_default_admin_url = "/admin/agentblock/index";
        private $module_default_agent_url = "/agent/agentblock/index";

	public function __construct()
	{
		parent::__construct();
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM agent_block";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/agentblock/index';
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

		$sql = "SELECT * FROM agent_block ORDER BY Name DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['agentblock']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Blocks", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['agentblock']['dir'].'inc/main/index.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module['agentblock']['dir'].'inc/main/index.bottom.inc.php'),
        'block' => array('side_nav' => $this->module['agentblock']['dir'].'inc/main/side_nav.agentblock.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['agentblock']['dir'].'meta/main/index.inc.php'));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM agent_block WHERE ID = '".$param."'".$query_condition;

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['agentblock']['name'], "Link" => $this->module['agentblock']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['agentblock']['dir'].'inc/main/view.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module['agentblock']['dir'].'inc/main/view.bottom.inc.php'),
        'block' => array('side_nav' => $this->module['agentblock']['dir'].'inc/main/side_nav.agentblock.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['agentblock']['dir'].'meta/main/view.inc.php'));

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
			$_SESSION['agentblock_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
                        $query_condition .= $crud->queryCondition("Position",$_POST['Position'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['agentblock_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['agentblock_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['agentblock_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
                        $_SESSION['agentblock_'.__FUNCTION__]['param']['Position'] = $_POST['Position'];
			$_SESSION['agentblock_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['agentblock_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentblock_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentblock_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agentblock_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM agent_block ".$_SESSION['agentblock_'.__FUNCTION__]['query_condition'];

		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/agentblock/index';
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

		$sql = "SELECT * FROM agent_block ".$_SESSION['agentblock_'.__FUNCTION__]['query_condition']." ORDER BY Name DESC LIMIT $start, $limit";
                //echo $sql;
                //exit;

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => AgentModel::getAgent($row['AgentID'], "Name"),
			'Name' => $row['Name'],
			'Content' => $row['Content'],
                        'Position' => $row['Position'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

                $result['count'] = $i;


		//$data = AgentModel::getAdminAgentAllParentChild();
                //Debug::displayArray($data[0]['ID']);
                //exit;
                /*$data = AgentModel::getAgentParentChildExist();

                 $comma_separated = implode(", ", $data);

                 $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID NOT IN (".$comma_separated.") AND ParentID = '0'";

                        $result2 = array();
                        $g = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$g] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $g += 1;
                        }

                 $sql3 = "SELECT * FROM agent WHERE Enabled = 1 AND ID IN (".$comma_separated.")";

                        $result3 = array();
                        $z = 0;

                        foreach ($this->dbconnect->query($sql3) as $row3)
                        {
                                $result3[$z] = array(
                                        'ID' => $row3['ID'],
                                        'Name' => $row3['Name'],
                                        'Company' => $row3['Company']);

                                $z += 1;
                        }


                        $result2['count'] = $g;
                        $result3['count'] = $z;*/

                        $result2 = AgentModel::getAdminAgentAllParentChild();

                //Debug::displayArray($result2);
                //Debug::displayArray($result3);
                //exit;
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Blocks", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/admin/index.bottom.inc.php', 'agentblock_delete' => $_SESSION['admin']['agentblock_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agentblock_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Index"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'test1' => $result2['result2'], 'test2' => $result2['result3']),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agentblock_delete']);

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
			$_SESSION['agentblock_'.__FUNCTION__] = "";



                        $query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=", 1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
                        $query_condition .= $crud->queryCondition("Position",$_POST['Position'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['agentblock_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['agentblock_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['agentblock_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
                        $_SESSION['agentblock_'.__FUNCTION__]['param']['Position'] = $_POST['Position'];
			$_SESSION['agentblock_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['agentblock_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentblock_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentblock_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agentblock_'.__FUNCTION__]))
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

                if(isset($_SESSION['agentblock_'.__FUNCTION__]['param']['AgentID'])===true && empty($_SESSION['agentblock_'.__FUNCTION__]['param']['AgentID'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND AgentID IN (".$child.")";
                }




                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM agent_block WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentblock_'.__FUNCTION__]['query_condition'];
                    //echo $query_count;
                    //exit;
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                    $targetpage = $data['config']['SITE_DIR'].'/agent/agentblock/index';
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

                    $sql = "SELECT * FROM agent_block WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentblock_'.__FUNCTION__]['query_condition']." ORDER BY Name DESC LIMIT $start, $limit";





		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => AgentModel::getAgent($row['AgentID'], "Name"),
			'Name' => $row['Name'],
			'Content' => $row['Content'],
                        'Position' => $row['Position'],
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

                        $result2['count'] = $z;



		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Blocks", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/index.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/agent/index.bottom.inc.php', 'agentblock_delete' => $_SESSION['agent']['agentblock_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agentblock_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Index"),
		'content' => $result,
                'agent' => $result2,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['agentblock_delete']);

		return $this->output;
	}


        public function AdminManage($param)
    {
        // Initialise query conditions
        $query_condition = "";

        $crud = new CRUD();

        if ($_POST['Trigger']=='search_form')
        {

        // Reset Query Variable
                $_SESSION['agentblock_'.__FUNCTION__] = "";

                $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=");
                //$query_condition .= $crud->queryCondition("ID",$_POST['AgentBlock'],"=");
                //$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
                //$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

                $_SESSION['agentblock_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
                $_SESSION['agentblock_'.__FUNCTION__]['param']['AgentBlock'] = $_POST['AgentBlock'];
                $_SESSION['agentblock_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
                $_SESSION['agentblock_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

                // Set Query Variable
                $_SESSION['agentblock_'.__FUNCTION__]['query_condition'] = $query_condition;
                $_SESSION['agentblock_'.__FUNCTION__]['query_title'] = "Search Results";
        }

        // Reset query conditions
        if ($_GET['page']=="all")
        {
            $_GET['page'] = "";
            unset($_SESSION['agentblock_'.__FUNCTION__]);
        }

        // Determine Title
        if (isset($_SESSION['agentblock_'.__FUNCTION__]))
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

        $query_count = "SELECT COUNT(*) AS num FROM agent ".$_SESSION['agentblock_'.__FUNCTION__]['query_condition'];

        /*echo $query_count;
        exit();*/

        #echo $query_count;
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

        $targetpage = $data['config']['SITE_DIR'].'/admin/agentblock/manage';
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

        $sql = "SELECT * FROM agent ".$_SESSION['agentblock_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
        //echo $sql;
        //exit;
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'Agentblock' => AgentBlockModel::getAgentBlockByAgentID($row['ID']));

            $i += 1;
        }

                $result['count'] = $i;


		//$data = AgentModel::getAdminAgentAllParentChild();
                //Debug::displayArray($data[0]['ID']);
                //exit;
                /*$data = AgentModel::getAgentParentChildExist();

                 $comma_separated = implode(", ", $data);

                 $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID NOT IN (".$comma_separated.") AND ParentID = '0'";

                        $result2 = array();
                        $g = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$g] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $g += 1;
                        }

                 $sql3 = "SELECT * FROM agent WHERE Enabled = 1 AND ID IN (".$comma_separated.")";

                        $result3 = array();
                        $z = 0;

                        foreach ($this->dbconnect->query($sql3) as $row3)
                        {
                                $result3[$z] = array(
                                        'ID' => $row3['ID'],
                                        'Name' => $row3['Name'],
                                        'Company' => $row3['Company']);

                                $z += 1;
                        }


                        $result2['count'] = $g;
                        $result3['count'] = $z;*/

                        $result2 = AgentModel::getAdminAgentAllParentChild();

                //Debug::displayArray($result2);
                //Debug::displayArray($result3);
                //exit;
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bulk Update", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/manage.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agentblock_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Manage"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'test1' => $result2['result2'], 'test2' => $result2['result3'], 'agentblock_list' => AgentBlockModel::getAgentBlockPosition(), 'agentblocklist' => AgentBlockModel::getAgentBlockList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


		return $this->output;
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

                if(empty($_POST['Agentblock'][$resellerID])===FALSE)
                {
                    //Check if Product empty

                    foreach ($_POST['Agentblock'] as $Agent => $Product) {

                    //Separate and get each part of product

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $agentBlockCount = count($_POST['Agentblock'][$Agent]);




                            for ($i=0; $i<$agentBlockCount; $i++) {

                                    $concat.=$_POST['Agentblock'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$agentBlockCount){



                                     }
                                     else
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $agentBlock = array();

                            for ($i=0; $i<$agentBlockCount; $i++) {
                                array_push($agentBlock, "'".$_POST['Agentblock'][$Agent][$i]."'");
                            }



                            // Get Agent product created before this process
                            $AgentblockList = AgentBlockModel::getAgentBlockPositionWithoutCounter($Agent);

                            $AgentblockList = explode(',', $AgentblockList);

                            $AgentblockList['count'] = count($AgentblockList);


                            //Reason to use array_diff and array_intersect are to prevent wallet duplications

                            //Get products similarity between selected and created

                            $intersect = array_intersect($agentBlock, $AgentblockList);

                            $intersect = array_values($intersect);

                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {

                                $sql = "DELETE FROM agent_block WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else
                            {
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM agent_block WHERE AgentID = '".$Agent."'";

                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$agentBlockCount; $i++) {

                                        $key = "(AgentID, Name, Content, Position, Enabled)";
                                        $value = "('".$Agent."', '', '', '".$_POST['Agentblock'][$Agent][$i]."', '1')";

                                        $sql2 = "INSERT INTO agent_block ".$key." VALUES ". $value;
                                        echo $sql2.'<br>';
                                        $this->dbconnect->exec($sql2);


                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $agentblockdeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM agent_block WHERE AgentID = '".$Agent."' AND Position NOT IN (".$agentblockdeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newAgentBlockList = AgentBlockModel::getAgentBlockPositionWithoutCounter($Agent);

                                    $newAgentBlockList = explode(',', $newAgentBlockList);


                                    // Get selected products not included in created products
                                    $newAgentBlock = array_diff($agentBlock, $newAgentBlockList);

                                    if(empty($newAgentBlock)===TRUE)
                                    {


                                    }
                                    else
                                    {
                                        $newAgentBlock = array_values($newAgentBlock);
                                        $newAgentBlock['count'] = count($newAgentBlock);

                                        for ($i=0; $i<$newAgentBlock['count']; $i++) {

                                                $key = "(AgentID, Name, Content, Position, Enabled)";
                                                $value = "('".$Agent."', '', '', ".$newAgentBlock[$i].", '1')";

                                                $sql2 = "INSERT INTO agent_block ".$key." VALUES ". $value;

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

                    $sql2 = "DELETE FROM agent_block WHERE AgentID = '".$resellerID."'";
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

                if(empty($_POST['Agentblock'][$resellerID])===FALSE)
                {
                    //Check if Product empty

                    foreach ($_POST['Agentblock'] as $Agent => $Product) {

                    //Separate and get each part of product

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $agentBlockCount = count($_POST['Agentblock'][$Agent]);




                            for ($i=0; $i<$agentBlockCount; $i++) {

                                    $concat.=$_POST['Agentblock'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$agentBlockCount){



                                     }
                                     else
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $agentBlock = array();

                            for ($i=0; $i<$agentBlockCount; $i++) {
                                array_push($agentBlock, "'".$_POST['Agentblock'][$Agent][$i]."'");
                            }



                            // Get Agent product created before this process
                            $AgentblockList = AgentBlockModel::getAgentBlockPositionWithoutCounter($Agent);

                            $AgentblockList = explode(',', $AgentblockList);

                            $AgentblockList['count'] = count($AgentblockList);


                            //Reason to use array_diff and array_intersect are to prevent wallet duplications

                            //Get products similarity between selected and created

                            $intersect = array_intersect($agentBlock, $AgentblockList);

                            $intersect = array_values($intersect);

                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {

                                $sql = "DELETE FROM agent_block WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else
                            {
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM agent_block WHERE AgentID = '".$Agent."'";

                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$agentBlockCount; $i++) {

                                        $key = "(AgentID, Name, Content, Position, Enabled)";
                                        $value = "('".$Agent."', '', '', '".$_POST['Agentblock'][$Agent][$i]."', '1')";

                                        $sql2 = "INSERT INTO agent_block ".$key." VALUES ". $value;

                                        $this->dbconnect->exec($sql2);


                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $agentblockdeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM agent_block WHERE AgentID = '".$Agent."' AND Position NOT IN (".$agentblockdeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newAgentBlockList = AgentBlockModel::getAgentBlockPositionWithoutCounter($Agent);

                                    $newAgentBlockList = explode(',', $newAgentBlockList);


                                    // Get selected products not included in created products
                                    $newAgentBlock = array_diff($agentBlock, $newAgentBlockList);

                                    if(empty($newAgentBlock)===TRUE)
                                    {


                                    }
                                    else
                                    {
                                        $newAgentBlock = array_values($newAgentBlock);
                                        $newAgentBlock['count'] = count($newAgentBlock);

                                        for ($i=0; $i<$newAgentBlock['count']; $i++) {

                                                $key = "(AgentID, Name, Content, Position, Enabled)";
                                                $value = "('".$Agent."', '', '', ".$newAgentBlock[$i].", '1')";

                                                $sql2 = "INSERT INTO agent_block ".$key." VALUES ". $value;

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

                    $sql2 = "DELETE FROM agent_block WHERE AgentID = '".$resellerID."'";
                    //echo $sql2.'<br>';
                    //exit;
                    $count = $this->dbconnect->exec($sql2);
                }
            }
        }

    }

    public function AgentManage($param)
    {
        // Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['agentblock_'.__FUNCTION__] = "";



                        $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=", 1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
                        $query_condition .= $crud->queryCondition("Position",$_POST['Position'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['agentblock_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
			$_SESSION['agentblock_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['agentblock_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
                        $_SESSION['agentblock_'.__FUNCTION__]['param']['Position'] = $_POST['Position'];
			$_SESSION['agentblock_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['agentblock_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentblock_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentblock_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agentblock_'.__FUNCTION__]))
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

                if(isset($_SESSION['agentblock_'.__FUNCTION__]['param']['Agent'])===true && empty($_SESSION['agentblock_'.__FUNCTION__]['param']['Agent'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND ID IN (".$child.")";
                }




                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentblock_'.__FUNCTION__]['query_condition'];
                    //echo $query_count;
                    //exit;
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                    $targetpage = $data['config']['SITE_DIR'].'/agent/agentblock/manage';
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

                    $sql = "SELECT * FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agentblock_'.__FUNCTION__]['query_condition']." ORDER BY Name DESC LIMIT $start, $limit";





		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
                        'ID' => $row['ID'],
                        'Name' => $row['Name'],
                        'Agentblock' => AgentBlockModel::getAgentBlockByAgentID($row['ID']),
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

                        $result2['count'] = $z;



		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bulk Update", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/manage.inc.php', 'custom_bottom_inc' => 'off', 'custom_bottom_inc_loc' => $this->module_dir.'inc/agent/index.bottom.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agentblock_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Index"),
		'content' => $result,
                'agent' => $result2,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'agentblock_list' => AgentBlockModel::getAgentBlockPosition(), 'agentblocklist' => AgentBlockModel::getAgentBlockList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


		return $this->output;
    }

	public function AdminAdd($param)
	{


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Agent Block", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/admin/add.bottom.inc.php', 'agentblock_add' => $_SESSION['admin']['agentblock_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agentblock_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Agent Block"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agentblock_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(AgentID, Name, Content, Position, Enabled)";
		$value = "('".$_POST['AgentID']."', '".$_POST['Name']."', '".$_POST['Content']."', '".$_POST['Position']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO agent_block ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

        // Generate .htaccess
        GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Agent Block...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM agent_block WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
                        'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}


		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Agent Block", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/admin/edit.bottom.inc.php', 'agentblock_add' => $_SESSION['admin']['agentblock_add'], 'agentblock_edit' => $_SESSION['admin']['agentblock_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agentblock.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Agent Block"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agentblock_add']);
		unset($_SESSION['admin']['agentblock_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		$sql = "UPDATE agent_block SET AgentID='".$_POST['AgentID']."', Name='".$_POST['Name']."', Content='".$_POST['Content']."', Position='".$_POST['Position']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

        // Generate .htaccess
        GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Agent Block...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM agent_block WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Agent Block...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

        public function AgentEdit($param)
	{
		$sql = "SELECT * FROM agent_block WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
                        'Position' => $row['Position'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}


		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Agent Block", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/agent/edit.bottom.inc.php', 'agentblock_add' => $_SESSION['agent']['agentblock_add'], 'agentblock_edit' => $_SESSION['agent']['agentblock_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agentblock.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Edit Agent Block"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['agentblock_add']);
		unset($_SESSION['agent']['agentblock_edit']);

		return $this->output;
	}

	public function AgentEditProcess($param)
	{
		$sql = "UPDATE agent_block SET AgentID='".$_POST['AgentID']."', Name='".$_POST['Name']."', Content='".$_POST['Content']."', Position='".$_POST['Position']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

        // Generate .htaccess
        GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Agent Block...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentDelete($param)
	{
		$sql = "DELETE FROM agent_block WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Agent Block...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getAgentBlock($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent_block WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
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

    public function getAgentBlockByAgent($agent, $type)
	{
	    // Get immediate platform agent ID
        if (AgentModel::getAgent($agent, 'TypeID')=='2')
        {
            AgentModel::getloopAgentParent($agent);

            $agent_platform = $_SESSION['platform_agent'];
            unset($_SESSION['platform_agent']);
        }
        else {
            $agent_platform = $agent;
        }

        if($type == 'withdrawal')
        {
    		$crud = new CRUD();

    		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$agent_platform."' AND Enabled = '1' AND Position IN ('Withdrawal Top', 'Withdrawal Bottom', 'Withdrawal Popup')";

    		$result = array();
    		$i = 0;
    		foreach ($this->dbconnect->query($sql) as $row)
    		{
    			$result[$i] = array(
    			'ID' => $row['ID'],
    			'AgentID' => $row['AgentID'],
    			'Name' => $row['Name'],
    			'Content' => $row['Content'],
    			'Enabled' => CRUD::isActive($row['Enabled']));

    			$i += 1;
    		}
        }

        if ($type == 'transfer')
        {
    		$crud = new CRUD();

    		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$agent_platform."' AND Enabled = '1' AND Position = 'Transfer Popup'";

    		$result = array();
    		$i = 0;
    		foreach ($this->dbconnect->query($sql) as $row)
    		{
    			$result[$i] = array(
    			'ID' => $row['ID'],
    			'AgentID' => $row['AgentID'],
    			'Name' => $row['Name'],
    			'Content' => $row['Content'],
    			'Enabled' => CRUD::isActive($row['Enabled']));

    			$i += 1;
    		}
        }

        if($type == 'deposit')
        {
    		$crud = new CRUD();

    		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$agent_platform."' AND Enabled = '1' AND Position IN ('Deposit Top', 'Deposit Bottom', 'Deposit Popup')";

    		$result = array();
    		$i = 0;
    		foreach ($this->dbconnect->query($sql) as $row)
    		{
    			$result[$i] = array(
    			'ID' => $row['ID'],
    			'AgentID' => $row['AgentID'],
    			'Name' => $row['Name'],
    			'Content' => $row['Content'],
    			'Enabled' => CRUD::isActive($row['Enabled']));

    			$i += 1;
    		}
        }

        if ($type == 'login')
        {
    		$crud = new CRUD();

    		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$agent_platform."' AND Enabled = '1' AND Position = 'Login'";

    		$result = array();
    		$i = 0;
    		foreach ($this->dbconnect->query($sql) as $row)
    		{
    			$result[$i] = array(
    			'ID' => $row['ID'],
    			'AgentID' => $row['AgentID'],
    			'Name' => $row['Name'],
    			'Content' => $row['Content'],
    			'Enabled' => CRUD::isActive($row['Enabled']));

    			$i += 1;
    		}
        }

        $result['count'] = $i;
		return $result;
	}

    public function getAPIAgentBlockByAgent($agent, $type)
	{
	    // Get immediate platform agent ID
        if (AgentModel::getAgent($agent, 'TypeID')=='2')
        {
            AgentModel::getloopAgentParent($agent);

            $agent_platform = $_SESSION['platform_agent'];
            unset($_SESSION['platform_agent']);
        }
        else {
            $agent_platform = $agent;
        }

        $BackgroundColour = AgentModel::getAgent($agent_platform, "BackgroundColour");
        $FontColour = AgentModel::getAgent($agent_platform, "FontColour");

        if ($type == 'withdrawal')
        {
    		$crud = new CRUD();

    		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$agent_platform."' AND Enabled = '1' AND Position IN ('Withdrawal Top', 'Withdrawal Bottom', 'Withdrawal Popup')";

    		$result = array();

    		foreach ($this->dbconnect->query($sql) as $row)
    		{
                        $row['Content'] = str_replace("/lib/kcfinder", $this->config['SITE_URL']."/lib/kcfinder", $row['Content']);
                        $row['Content'] = str_replace("width:800px", "width:630px", $row['Content']);
    			$dataSet = array(
    			'ID' => $row['ID'],
    			'AgentID' => $row['AgentID'],
    			'Name' => $row['Name'],
    			'Content' => "<!DOCTYPE html>
                                        <head>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <meta name='viewport' content='width=device-width, initial-scale=1' />
                                        <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                        <style type='text/css'>
                                        body{
                                            margin: 20px 20px;
                                            font-size: 80%;
                                            background-color: #fff !important;
                                            color: #000 !important;
                                         }
                                         img{
                                            height: 400px;
                                            width: 100px;
                                         }
                                        </style>
                                        </head>
                                        <body>
                                       ".$row['Content']."</body></html>",
    			'Enabled' => "<!DOCTYPE html>
                                        <head>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <meta name='viewport' content='width=device-width, initial-scale=1' />
                                        <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                        <style type='text/css'>
                                        body{
                                            margin: 20px 20px;
                                            font-size: 80%;
                                            background-color: #fff !important;
                                            color: #000 !important;
                                         }
                                        </style>
                                        </head>
                                        <body>
                                       ".CRUD::isActive($row['Enabled'])."</body></html>");

    			array_push($result, $dataSet);
    		}
        }

        if($type == 'transfer')
        {
    		$crud = new CRUD();

    		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$agent_platform."' AND Enabled = '1' AND Position = 'Transfer Popup'";

    		$result = array();

    		foreach ($this->dbconnect->query($sql) as $row)
    		{

                        $row['Content'] = str_replace("/lib/kcfinder", $this->config['SITE_URL']."/lib/kcfinder", $row['Content']);
                        $row['Content'] = str_replace("width:800px", "width:630px", $row['Content']);

    			$dataSet = array(
    			'ID' => $row['ID'],
    			'AgentID' => $row['AgentID'],
    			'Name' => $row['Name'],
    			'Content' => "<!DOCTYPE html>
                                        <head>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <meta name='viewport' content='width=device-width, initial-scale=1' />
                                        <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                        <style type='text/css'>
                                        body{
                                            margin: 20px 20px;
                                            font-size: 80%;
                                            background-color: #fff !important;
                                            color: #000 !important;
                                         }
                                         img{
                                            height: 400px;
                                            width: 100px;
                                         }
                                        </style>
                                        </head>
                                        <body>
                                       ".$row['Content']."</body></html>",
    			'Enabled' => "<!DOCTYPE html>
                                        <head>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <meta name='viewport' content='width=device-width, initial-scale=1' />
                                        <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                        <style type='text/css'>
                                        body{
                                            margin: 20px 20px;
                                            font-size: 80%;
                                            background-color: #fff !important;
                                            color: #000 !important;
                                         }
                                        </style>
                                        </head>
                                        <body>
                                       ".CRUD::isActive($row['Enabled'])."</body></html>");

    			array_push($result, $dataSet);
    		}
        }

        if($type == 'deposit')
        {
    		$crud = new CRUD();

    		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$agent_platform."' AND Enabled = '1' AND Position IN ('Deposit Top', 'Deposit Bottom', 'Deposit Popup')";

    		$result = array();

    		foreach ($this->dbconnect->query($sql) as $row)
    		{
                        $row['Content'] = str_replace("/lib/kcfinder", $this->config['SITE_URL']."/lib/kcfinder", $row['Content']);
                        $row['Content'] = str_replace("width:800px", "width:630px", $row['Content']);
                        //$row['Content'] = str_replace("<strong>Important :</strong>", "<strong class=\"yellow\">Important</strong>", $row['Content']);
    			$dataSet = array(
    			'ID' => $row['ID'],
    			'AgentID' => $row['AgentID'],
    			'Name' => $row['Name'],
    			'Content' => "<!DOCTYPE html>
                                        <head>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <meta name='viewport' content='width=device-width, initial-scale=1' />
                                        <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                        <style type='text/css'>
                                        body{
                                            margin: 20px 20px;
                                            font-size: 80% !important;
                                            background-color: #fff !important;
                                            color: #000 !important;
                                         }
                                         img{
                                            height: 400px;
                                            width: 100px;
                                         }
                                        </style>
                                        </head>
                                        <body>
                                       ".$row['Content']."</body></html>",
    			'Enabled' => "<!DOCTYPE html>
                                        <head>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <meta name='viewport' content='width=device-width, initial-scale=1' />
                                        <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                        <style type='text/css'>
                                        body{
                                            margin: 20px 20px;
                                            font-size: 80% !important;
                                            background-color: #fff !important;
                                            color: #000 !important;
                                         }
                                        </style>
                                        </head>
                                        <body>
                                       ".CRUD::isActive($row['Enabled'])."</body></html>"
    			);

    			array_push($result, $dataSet);
    		}
        }

        if($type == 'login')
        {


    		$crud = new CRUD();

    		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$agent_platform."' AND Enabled = '1' AND Position = 'Login'";

    		$result = array();

    		foreach ($this->dbconnect->query($sql) as $row)
    		{
                        $row['Content'] = str_replace("/lib/kcfinder", $this->config['SITE_URL']."/lib/kcfinder", $row['Content']);
                    $row['Content'] = str_replace("width:800px", "width:630px", $row['Content']);
    			$dataSet = array(
    			'ID' => $row['ID'],
    			'AgentID' => $row['AgentID'],
    			'Name' => $row['Name'],
    			'Content' => "<!DOCTYPE html>
                                        <head>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <meta name='viewport' content='width=device-width, initial-scale=1' />
                                        <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                        <style type='text/css'>
                                        body{
                                            margin: 20px 20px;
                                            font-size: 80% !important;
                                            background-color: #fff !important;
                                            color: #000 !important;
                                         }
                                         img{
                                            height: 400px;
                                            width: 100px;
                                         }
                                        </style>
                                        </head>
                                        <body>
                                       ".$row['Content']."</body></html>",
    			'Enabled' => "<!DOCTYPE html>
                                        <head>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <meta name='viewport' content='width=device-width, initial-scale=1' />
                                        <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                        <style type='text/css'>
                                        body{
                                            margin: 20px 20px;
                                            font-size: 80% !important;
                                            background-color: #fff !important;
                                            color: #000 !important;
                                         }
                                        </style>
                                        </head>
                                        <body>
                                       ".CRUD::isActive($row['Enabled'])."</body></html>");

    			array_push($result, $dataSet);
    		}
        }

		return $result;
	}

        public function getAgentBlockByAgentID($agent)
	{

		$crud = new CRUD();


		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$agent."'";
		//echo $sql;exit;
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
                        'Position' =>  $row['Position'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}


                $result['count'] = $i;
		return $result;
	}

        public function getAgentBlockPosition()
	{

		$result = array(0 => "Login", 1 => "Withdrawal Top", 2 => "Withdrawal Bottom", 3 => "Deposit Top", 4 => "Deposit Bottom", 5 => "Deposit Popup", 6 => "Transfer Popup", 7 => "Withdrawal Popup");


                $result['count'] = 8;
		return $result;
	}

        public function getAgentBlockPositionWithoutCounter($param)
	{

		$sql = "SELECT * FROM agent_block WHERE AgentID = '".$param."' AND Enabled = '1' ORDER BY Position ASC";

                $result = '';


		foreach ($this->dbconnect->query($sql) as $row)
		{
			$position = "'".$row['Position']."'";
			$result .= $position.',';



		}

                $result = rtrim($result, ',');


		return $result;

	}


        /*public function getAgentBlockPositionWithoutCounter()
	{

		$result = "Login,Withdrawal Top,Withdrawal Bottom,Deposit Top,Deposit Bottom,Deposit Popup,Transfer Popup,Withdrawal Popup";



		return $result;
	}*/

        public function getAgentBlockByAgentCount($agent)
	{

		$crud = new CRUD();

		$sql = "SELECT COUNT(*) AS agentCount FROM agent_block WHERE AgentID = '".$agent."'";


		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['agentCount'];


		}


		return $result;
	}

	public function getAgentBlockList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent_block ORDER BY Name DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
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
		$query_count = "SELECT COUNT(*) AS num FROM agent_block";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/agentblock/index';
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

		$sql = "SELECT * FROM agent_block ORDER BY Name DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'Content' => $row['Content'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Agent Blocks", 'template' => 'common.tpl.php'),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'secure' => NULL,
        'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM agent_block ".$_SESSION['agentblock_'.$param]['query_condition']." ORDER BY Name DESC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Agent_Blocks";
		$result['header'] = $this->config['SITE_NAME']." | Agent Blocks (" . date('Y-m-d H:i:s') . ")\n\nID, Agent, Name, Content, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".AgentModel::getAgent($row['AgentID'], "Name")."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Content'])."\",";
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