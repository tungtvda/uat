<?php
// Require required models
Core::requireModel('agent');
Core::requireModel('bank');

class BankInfoModel extends BaseModel
{
	private $output = array();
        private $module_name = "Bank Info";
	private $module_dir = "modules/bankinfo/";
        private $module_default_url = "/main/bankinfo/index";
        private $module_default_admin_url = "/admin/bankinfo/index";
        private $module_default_agent_url = "/agent/bankinfo/index";

	public function __construct()
	{
		parent::__construct();
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM bank_info WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/bankinfo/index';
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

		$sql = "SELECT * FROM bank_info WHERE Enabled = 1 ORDER BY ResellerID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'cover');
			}

			$result[$i] = array(
			'ID' => $row['ID'],
			'ResellerID' => $row['ResellerID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'Description' => $row['Description']);

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bank Infos", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM bank_info WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ResellerID' => $row['ResellerID'],
			'Name' => $row['Name'],
			'ImageURL' => $row['ImageURL'],
			'Description' => $row['Description']);

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/view.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,$result[0]['Title']),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

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
                $_SESSION['bankinfo_'.__FUNCTION__] = "";

                $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=");
                //$query_condition .= $crud->queryCondition("ID",$_POST['AgentBlock'],"=");
                //$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
                //$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

                $_SESSION['bankinfo_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
                $_SESSION['bankinfo_'.__FUNCTION__]['param']['AgentBlock'] = $_POST['AgentBlock'];
                $_SESSION['bankinfo_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
                $_SESSION['bankinfo_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

                // Set Query Variable
                $_SESSION['bankinfo_'.__FUNCTION__]['query_condition'] = $query_condition;
                $_SESSION['bankinfo_'.__FUNCTION__]['query_title'] = "Search Results";
        }

        // Reset query conditions
        if ($_GET['page']=="all")
        {
            $_GET['page'] = "";
            unset($_SESSION['bankinfo_'.__FUNCTION__]);
        }

        // Determine Title
        if (isset($_SESSION['bankinfo_'.__FUNCTION__]))
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

        $query_count = "SELECT COUNT(*) AS num FROM agent ".$_SESSION['bankinfo_'.__FUNCTION__]['query_condition'];

        /*echo $query_count;
        exit();*/

        #echo $query_count;
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

        $targetpage = $data['config']['SITE_DIR'].'/admin/bankinfo/manage';
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

        $sql = "SELECT * FROM agent ".$_SESSION['bankinfo_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
        //echo $sql;
        //exit;
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'Bankinfo' => BankInfoModel::getBankInfoListByAgent($row['ID']),
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
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'test1' => $result2['result2'], 'test2' => $result2['result3'], 'bankinfo_list' => BankInfoModel::getBankInfoName()),
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

                if(empty($_POST['Bankinfo'][$resellerID])===FALSE)
                {
                    //Check if Product empty

                    foreach ($_POST['Bankinfo'] as $Agent => $Product) {

                    //Separate and get each part of product

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $bankInfoCount = count($_POST['Bankinfo'][$Agent]);




                            for ($i=0; $i<$bankInfoCount; $i++) {

                                    $concat.=$_POST['Bankinfo'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$bankInfoCount){



                                     }
                                     else
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $bankInfo = array();

                            for ($i=0; $i<$bankInfoCount; $i++) {
                                array_push($bankInfo, "'".$_POST['Bankinfo'][$Agent][$i]."'");
                            }



                            // Get Agent product created before this process
                            $BankinfoList = BankInfoModel::getBankInfoNameWithoutCounter($Agent);

                            $BankinfoList = explode(',', $BankinfoList);

                            $BankinfoList['count'] = count($BankinfoList);


                            //Reason to use array_diff and array_intersect are to prevent wallet duplications

                            //Get products similarity between selected and created

                            $intersect = array_intersect($bankInfo, $BankinfoList);

                            $intersect = array_values($intersect);

                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {

                                $sql = "DELETE FROM bank_info WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else
                            {
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM bank_info WHERE AgentID = '".$Agent."'";
                                    echo 'hi<br>';
                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$bankInfoCount; $i++) {


                                        $key = "(AgentID, Name, ImageURL, Description)";
                                        $value = "('".$Agent."', ".$_POST['Bankinfo'][$Agent][$i].", '', '')";

                                        $sql2 = "INSERT INTO bank_info ".$key." VALUES ". $value;

                                        $this->dbconnect->exec($sql2);


                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $bankinfodeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM bank_info WHERE AgentID = '".$Agent."' AND Name NOT IN (".$bankinfodeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newBankInfoList = BankInfoModel::getBankInfoNameWithoutCounter($Agent);

                                    $newBankInfoList = explode(',', $newBankInfoList);


                                    // Get selected products not included in created products
                                    $newBankInfo = array_diff($bankInfo, $newBankInfoList);

                                    if(empty($newBankInfo)===TRUE)
                                    {


                                    }
                                    else
                                    {
                                        $newBankInfo = array_values($newBankInfo);
                                        $newBankInfo['count'] = count($newBankInfo);

                                        for ($i=0; $i<$newBankInfo['count']; $i++) {

                                                $key = "(AgentID, Name, ImageURL, Description)";
                                                $value = "('".$Agent."', ".$newBankInfo[$i].", '', '')";

                                                $sql2 = "INSERT INTO bank_info ".$key." VALUES ". $value;

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

                    $sql2 = "DELETE FROM bank_info WHERE AgentID = '".$resellerID."'";
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

                if(empty($_POST['Bankinfo'][$resellerID])===FALSE)
                {
                    //Check if Product empty

                    foreach ($_POST['Bankinfo'] as $Agent => $Product) {
                        //echo $Agent.'<br>';

                    //Separate and get each part of product

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $bankInfoCount = count($_POST['Bankinfo'][$Agent]);

                            //Debug::displayArray($_POST['Bankinfo'][$Agent]);


                            for ($i=0; $i<$bankInfoCount; $i++) {

                                    $concat.=$_POST['Bankinfo'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$bankInfoCount){



                                     }
                                     else
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $bankInfo = array();

                            for ($i=0; $i<$bankInfoCount; $i++) {
                                array_push($bankInfo, "'".$_POST['Bankinfo'][$Agent][$i]."'");
                            }



                            // Get Agent product created before this process
                            $BankinfoList = BankInfoModel::getBankInfoNameWithoutCounter($Agent);

                            $BankinfoList = explode(',', $BankinfoList);

                            $BankinfoList['count'] = count($BankinfoList);


                            //Reason to use array_diff and array_intersect are to prevent wallet duplications

                            //Get products similarity between selected and created

                            $intersect = array_intersect($bankInfo, $BankinfoList);

                            $intersect = array_values($intersect);

                            //echo '<pre>intersect';
                            //print_r($intersect);
                            //echo '</pre>';

                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {

                                $sql = "DELETE FROM bank_info WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else
                            {
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM bank_info WHERE AgentID = '".$Agent."'";
                                    //echo 'hi<br>';
                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$bankInfoCount; $i++) {


                                        $key = "(AgentID, Name, ImageURL, Description)";
                                        $value = "('".$Agent."', '".$_POST['Bankinfo'][$Agent][$i]."', '', '')";

                                        $sql2 = "INSERT INTO bank_info ".$key." VALUES ". $value;
                                        echo $sql2.'<br>';
                                        $this->dbconnect->exec($sql2);


                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $bankinfodeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM bank_info WHERE AgentID = '".$Agent."' AND Name NOT IN (".$bankinfodeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newBankInfoList = BankInfoModel::getBankInfoNameWithoutCounter($Agent);

                                    $newBankInfoList = explode(',', $newBankInfoList);


                                    // Get selected products not included in created products
                                    $newBankInfo = array_diff($bankInfo, $newBankInfoList);



                                    if(empty($newBankInfo)===TRUE)
                                    {


                                    }
                                    if(empty($newBankInfo)===FALSE)
                                    {
                                        $newBankInfo = array_values($newBankInfo);
                                        $newBankInfo['count'] = count($newBankInfo);

                                        //echo '<pre>diff new bank info';
                                        //print_r($newBankInfo);
                                        //echo '</pre>';

                                        for ($i=0; $i<$newBankInfo['count']; $i++) {

                                                $key = "(AgentID, Name, ImageURL, Description)";
                                                $value = "('".$Agent."', ".$newBankInfo[$i].", '', '')";

                                                $sql2 = "INSERT INTO bank_info ".$key." VALUES ". $value;
                                                //echo $sql2.'<br>';
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

                    $sql2 = "DELETE FROM bank_info WHERE AgentID = '".$resellerID."'";
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
			$_SESSION['bankinfo_'.__FUNCTION__] = "";



                        $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=", 1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
                        $query_condition .= $crud->queryCondition("Position",$_POST['Position'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['bankinfo_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
			$_SESSION['bankinfo_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['bankinfo_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
                        $_SESSION['bankinfo_'.__FUNCTION__]['param']['Position'] = $_POST['Position'];
			$_SESSION['bankinfo_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['bankinfo_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['bankinfo_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['bankinfo_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['bankinfo_'.__FUNCTION__]))
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

                if(isset($_SESSION['bankinfo_'.__FUNCTION__]['param']['Agent'])===true && empty($_SESSION['bankinfo_'.__FUNCTION__]['param']['Agent'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND ID IN (".$child.")";
                }




                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['bankinfo_'.__FUNCTION__]['query_condition'];
                    //echo $query_count;
                    //exit;
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                    $targetpage = $data['config']['SITE_DIR'].'/agent/bankinfo/manage';
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

                    $sql = "SELECT * FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['bankinfo_'.__FUNCTION__]['query_condition']." ORDER BY Name DESC LIMIT $start, $limit";





		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
                        'ID' => $row['ID'],
                        'Name' => $row['Name'],
                        'Bankinfo' => BankInfoModel::getBankInfoListByAgent($row['ID']),
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
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bankinfo_list' => BankInfoModel::getBankInfoName()),
		'secure' => TRUE,
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
			$_SESSION['bankinfo_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");

			$_SESSION['bankinfo_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['bankinfo_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['bankinfo_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];

			// Set Query Variable
			$_SESSION['bankinfo_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['bankinfo_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['bankinfo_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['bankinfo_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM bank_info ".$_SESSION['bankinfo_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/bankinfo/index';
		$limit = 100000;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM bank_info ".$_SESSION['bankinfo_'.__FUNCTION__]['query_condition']." ORDER BY AgentID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'cover');
			}

			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => AgentModel::getAgent($row['AgentID'] ,"Name"),
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'Description' => $row['Description']);

			$i += 1;
		}

                $result2 = AgentModel::getAdminAgentAllParentChild();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Bank Infos", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'bankinfo_delete' => $_SESSION['admin']['bankinfo_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.bankinfo_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Index"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList(), 'agent_list1' => $result2['result2'], 'agent_list2' => $result2['result3']),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['bankinfo_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Bank Info", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'bankinfo_add' => $_SESSION['admin']['bankinfo_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.bankinfo_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Bank Info"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['bankinfo_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"bankinfo");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            $file_location['ImageURL'] = "";
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],146,45,'cover');
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

		$key = "(AgentID, Name, ImageURL, Description)";
		$value = "('".$_POST['AgentID']."', '".$_POST['Name']."', '".$file_location['ImageURL']."', '".$_POST['Description']."')";

		$sql = "INSERT INTO bank_info ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Bank Info...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM bank_info WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['ImageURL'],'cover');
            }

			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Description' => $row['Description']);

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Bank Info",
					'template' => 'admin.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php',
					'bankinfo_add' => $_SESSION['admin']['bankinfo_add'],
                    'bankinfo_edit' => $_SESSION['admin']['bankinfo_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.bankinfo_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Product Image"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['bankinfo_add']);
		unset($_SESSION['admin']['bankinfo_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"bankinfo");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['ImageURLRemove']==1)
            {
                $file_location['ImageURL'] = "";
                Image::deleteImage($_POST['ImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['ImageURL'] = $_POST['ImageURLCurrent'];
            }
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],146,45,'cover');
            Image::deleteImage($_POST['ImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

		$sql = "UPDATE bank_info SET AgentID='".$_POST['AgentID']."', Name='".$_POST['Name']."', ImageURL='".$file_location['ImageURL']."', Description='".$_POST['Description']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Bank Info...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM bank_info WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'ImageURL' => $row['ImageURL']);

            $i += 1;
        }

        Image::deleteImage($result[0]['ImageURL']);
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'cover'));

		// Delete entry from table
		$sql = "DELETE FROM bank_info WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Bank Info...", 'template' => 'admin.common.tpl.php'),
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
			$_SESSION['bankinfo_'.__FUNCTION__] = "";


			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=", 1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");

			$_SESSION['bankinfo_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['bankinfo_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['bankinfo_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];

			// Set Query Variable
			$_SESSION['bankinfo_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['bankinfo_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['bankinfo_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['bankinfo_'.__FUNCTION__]))
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




                if(isset($_SESSION['bankinfo_'.__FUNCTION__]['param']['AgentID'])===true && empty($_SESSION['bankinfo_'.__FUNCTION__]['param']['AgentID'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND AgentID IN (".$child.")";
                }



                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM bank_info WHERE TRUE = TRUE ".$query_part." ".$_SESSION['bankinfo_'.__FUNCTION__]['query_condition'];
                    //echo $query_count;
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                    $targetpage = $data['config']['SITE_DIR'].'/agent/bankinfo/index';
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

                    $sql = "SELECT * FROM bank_info WHERE TRUE = TRUE ".$query_part." ".$_SESSION['bankinfo_'.__FUNCTION__]['query_condition']." ORDER BY AgentID ASC LIMIT $start, $limit";




		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'cover');
			}

			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => AgentModel::getAgent($row['AgentID'] ,"Name"),
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'Description' => $row['Description']);

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
		'page' => array('title' => "Bank Infos", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'bankinfo_delete' => $_SESSION['agent']['bankinfo_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.bankinfo_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Index"),
		'content' => $result,
                'agent' => $result2,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['bankinfo_delete']);

		return $this->output;
	}

        public function AgentAdd()
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
		'page' => array('title' => "Create Bank Info", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/add.inc.php', 'bankinfo_add' => $_SESSION['agent']['bankinfo_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.bankinfo_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"admin",$this->config,"Create Bank Info"),
                'agent' => $result2,
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['bankinfo_add']);

		return $this->output;
	}

	public function AgentAddProcess()
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"bankinfo");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            $file_location['ImageURL'] = "";
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],146,45,'cover');
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

		$key = "(AgentID, Name, ImageURL, Description)";
		$value = "('".$_POST['AgentID']."', '".$_POST['Name']."', '".$file_location['ImageURL']."', '".$_POST['Description']."')";

		$sql = "INSERT INTO bank_info ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Bank Info...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentEdit($param)
	{
		$sql = "SELECT * FROM bank_info WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['ImageURL'],'cover');
            }

			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Description' => $row['Description']);

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
		'page' => array(
					'title' => "Edit Bank Info",
					'template' => 'agent.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php',
					'bankinfo_add' => $_SESSION['agent']['bankinfo_add'],
                    'bankinfo_edit' => $_SESSION['agent']['bankinfo_edit']),
                'agent' => $result2,
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.bankinfo_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"admin",$this->config,"Edit Bank Info"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['bankinfo_add']);
		unset($_SESSION['agent']['bankinfo_edit']);

		return $this->output;
	}

	public function AgentEditProcess($param)
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"bankinfo");

        if ($upload['ImageURL']['upload']['status']=="Empty")
        {
            if ($_POST['ImageURLRemove']==1)
            {
                $file_location['ImageURL'] = "";
                Image::deleteImage($_POST['ImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['ImageURL'] = $_POST['ImageURLCurrent'];
            }
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded")
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],146,45,'cover');
            Image::deleteImage($_POST['ImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];

            $file_location['ImageURL'] = "";
        }

		$sql = "UPDATE bank_info SET AgentID='".$_POST['AgentID']."', Name='".$_POST['Name']."', ImageURL='".$file_location['ImageURL']."', Description='".$_POST['Description']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
                $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Bank Info...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentDelete($param)
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM bank_info WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'ImageURL' => $row['ImageURL']);

            $i += 1;
        }

        Image::deleteImage($result[0]['ImageURL']);
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'cover'));

		// Delete entry from table
		$sql = "DELETE FROM bank_info WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Bank Info...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM bank_info ".$_SESSION['bankinfo_'.$param]['query_condition']." ORDER BY ResellerID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Bank_Info";
		$result['header'] = $this->config['SITE_NAME']." | Bank Info (" . date('Y-m-d H:i:s') . ")\n\nID, Reseller, Name, ImageURL, Description";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ResellerModel::getReseller($row['ResellerID'] ,"Name")."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['ImageURL']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Description'])."\"\n";

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

	public function getBankInfo($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM bank_info WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ResellerID' => $row['ResellerID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'Description' => $row['Description']);

			$i += 1;
		}

		$result = $result[0]['ProductID'];

		return $result;
	}


        public function getBankInfoByAgentAndName($agent, $name)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM bank_info WHERE AgentID = '".$agent."' AND Name IN (".$name.")";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'ImageURL' => $row['ImageURL'],
			'Description' => $row['Description']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function getBankInfoList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM bank_info ORDER BY ResellerID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ResellerID' => $row['ResellerID'],
			'Name' => $row['Name'],
			'ImageURL' => $cover_image,
			'Description' => $row['Description']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

        public function getUniqueBank($Bank, $BankAccountNo)
	{

		$sql = "SELECT COUNT(*) AS bank_count FROM member WHERE Bank = '".$Bank."' AND BankAccountNo = '".$BankAccountNo."'";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['bank_count'];
		}

		return $result;
	}

    public function getAgentBankInfoList($param)
	{

        $sql2 = "SELECT Agent FROM member WHERE ID = '".$param."'";

		foreach ($this->dbconnect->query($sql2) as $row2)
		{
			$agent = $row2['Agent'];

		}

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

		$sql = "SELECT * FROM bank_info WHERE AgentID = '".$agent_platform."' ORDER BY AgentID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'ImageURL' => $this->config['SITE_URL'].$row['ImageURL'],
			'Description' => $row['Description']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

         public function getBankInfoName()
	{


		$sql = "SELECT * FROM bank WHERE Enabled = '1'";
		//echo $sql;exit;
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = $row['Label'];

			$i += 1;
		}


                $result['count'] = $i;
		return $result;
	}

        public function getBankInfoNameWithoutCounter($param)
	{


		$sql = "SELECT * FROM bank_info WHERE AgentID = '".$param."'";
		//echo $sql;exit;
		$result = '';

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result .= "'".$row['Name']."',";


		}


                $result = rtrim($result, ',');
            	//Debug::displayArray($result);
                //exit;

		return $result;
	}

    public function getAPIAgentBankInfoList($param)
	{
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

		$sql = "SELECT * FROM bank_info WHERE AgentID = '".$agent_platform."' ORDER BY Name ASC";

                $BackgroundColour = AgentModel::getAgent($param, "BackgroundColour");
                $FontColour = AgentModel::getAgent($param, "FontColour");

		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$dataSet = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'ImageURL' => $this->config['SITE_URL'].$row['ImageURL'],
			'Description' => "<!DOCTYPE html>
                                    <head>
                                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                    <meta name='viewport' content='width=device-width, initial-scale=1' />
                                    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                    <style type='text/css'>
                                    body{
                                        margin: 25px 25px;
                                        font-size: 80%;
                                        background-color: #fff !important;
                                        color: #000 !important;
                                     }
                                    </style>
                                    </head>
                                    <body>
                                   ".$row['Description']."</body></html>");

                        array_push($result, $dataSet);
		}


		return $result;
	}

        public function getBankInfoListByAgent($param)
	{

		$sql = "SELECT * FROM bank_info WHERE AgentID = '".$param."' ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
                    /*if ($row['ImageURL']=='')
                    {
                            $cover_image = $this->config['THEME_DIR'].'img/no_image.png';
                    }
                    else
                    {
                            $cover_image = Image::getImage($row['ImageURL'],'cover');
                    }*/

			$result[$i] = array(
			'ID' => $row['ID'],
			'AgentID' => $row['AgentID'],
			'Name' => $row['Name'],
			'ImageURL' => $row['ImageURL'],
			'Description' => $row['Description']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

        public function getBankInfoListByAgentCount($param)
	{

		$sql = "SELECT COUNT(*) AS agentCount FROM bank_info WHERE AgentID = '".$param."' ORDER BY Name ASC";

		foreach ($this->dbconnect->query($sql) as $row)
		{


			$result = $row['agentCount'];

		}


		return $result;
	}


}
?>