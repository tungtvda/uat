<?php
// Require required models
Core::requireModel('generator');
Core::requireModel('productcategory');
Core::requireModel('state');
Core::requireModel('agent');

class searchModel extends BaseModel
{
	private $output = array();
    private $module_name = "search";
	private $module_dir = "modules/search/";
    private $module_default_url = "/main/search/index";
    private $module_default_admin_url = "/admin/search/index";

	public function __construct()
	{
		parent::__construct();
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM search WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/search/index';
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

		$sql = "SELECT * FROM search WHERE Enabled = 1 ORDER BY Date DESC, ID DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['CoverImage']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['CoverImage'],'cover');
			}

			$result[$i] = array(
			'ID' => $row['ID'],
			'Title' => $row['Title'],
			'FriendlyURL' => $row['ID']."-".$row['FriendlyURL'],
			'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			'Source' => $row['Source'],
			'CoverImage' => $cover_image,
			'Description' => $row['Description'],
			'Content' => $row['Content'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "search", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
        'block' => array('side_nav' => $this->module_dir.'inc/main/side_nav.search.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
	    if ($_GET['preview']==1)
        {
            $query_condition ="";
        }
        else
        {
    	   $query_condition = " AND Enabled = 1";
        }

		$sql = "SELECT * FROM search WHERE ID = '".$param."'".$query_condition;

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Title' => $row['Title'],
			'FriendlyURL' => $row['FriendlyURL'],
			'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			'Source' => $row['Source'],
			'CoverImage' => $row['CoverImage'],
			'Description' => $row['Description'],
			'Content' => $row['Content'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/view.inc.php'),
        'block' => array('side_nav' => $this->module_dir.'inc/main/side_nav.search.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,$result[0]['Title']),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        public function ProductAgentGroupDefault($param)
	{
            //echo $param;
            //exit;
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
                //echo $child;
                //exit;

                unset($_SESSION['agentchild']);
            
                //echo $param;
                $dataSet = explode('|', $_POST['name']);
                
                
                $dataSet[1] = ltrim($dataSet[1]);
                $dataSet[0] = rtrim($dataSet[0]);
                //echo $dataSet[1];
                 $sql = "SELECT ID FROM `member` WHERE member.Name = '".$dataSet[0]."' AND member.Username = '".$dataSet[1]."' AND Agent IN(".$child.") AND Enabled = '1'";
                 //echo $sql;
                 //exit;

		 foreach ($this->dbconnect->query($sql) as $row)
	         {
                       $ID = $row['ID'];
                 }
            
                 
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "search", 'template' => 'admin.common.tpl.php'),
		'content' => $ID);

		return $this->output;

	}
        
         public function ProductAgentDefault($param)
	{
                
            
                //echo $param;
                $dataSet = explode('|', $_POST['name']);
                
                $dataSet[1] = ltrim($dataSet[1]);
                $dataSet[0] = rtrim($dataSet[0]);
                 $sql = "SELECT ID FROM `member` WHERE member.Name = '".$dataSet[0]."' AND member.Username = '".$dataSet[1]."' AND Agent = '".$_SESSION['agent']['ID']."' AND Enabled = '1'";
                 //echo $sql;
                 //exit;

		 foreach ($this->dbconnect->query($sql) as $row)
	         {
                       $ID = $row['ID'];
                 }
            
                 
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "search", 'template' => 'admin.common.tpl.php'),
		'content' => $ID);

		return $this->output;

	}
        
        public function ProductDefault($param)
	{                
            
                //echo $param;
                $dataSet = explode('|', $_POST['name']);
                
                $dataSet[1] = ltrim($dataSet[1]);
                $dataSet[0] = rtrim($dataSet[0]);
                 $sql = "SELECT ID FROM `member` WHERE member.Name = '".$dataSet[0]."' AND member.Username = '".$dataSet[1]."' AND Enabled = '1'";
                 //echo $sql;
                 //exit;

		 foreach ($this->dbconnect->query($sql) as $row)
	         {
                       $ID = $row['ID'];
                 }
            
                 
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "search", 'template' => 'admin.common.tpl.php'),
		'content' => $ID);

		return $this->output;

	}
        
	public function ProductSearch($param)
	{
		// get what user typed in autocomplete input
		$term = trim($_GET['term']);

		$a_json = array();
		$a_json_row = array();

		$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
		$json_invalid = json_encode($a_json_invalid);

		// replace multiple spaces with one
		$term = preg_replace('/\s+/', ' ', $term);

		// SECURITY HOLE ***************************************************************
		// allow space, any unicode letter and digit, underscore and dash
		if(preg_match("/[^\040\pL\pN_-]/u", $term)) {
		  print $json_invalid;
		  exit;
		}

                  $nameCounter = 0;  
		  $sql = "SELECT * FROM `member` WHERE Enabled = '1' AND Name LIKE '%".$term."%' OR Username LIKE '%".$term."%'";

		   foreach ($this->dbconnect->query($sql) as $row)
	        {
	                  $a_json_row["id"] = $row['ID'];
			  $a_json_row["value"] = $row['Name'].' | '.$row['Username'];
			  $a_json_row["label"] = $row['Name'].' | '.$row['Username'];
			  array_push($a_json, $a_json_row);
                          $nameCounter += 1;
	        }
                
                
                /*if($nameCounter==0)
                {
                    $a_json = array();
                    $a_json_row = array();
                    
                    $sql = "SELECT * FROM `member` WHERE member.Username LIKE '%".$term."%' AND Enabled = '1'";

		   foreach ($this->dbconnect->query($sql) as $row)
                    {
                              $a_json_row["id"] = $row['ID'];
                              $a_json_row["value"] = $row['Name'].' | '.$row['Username'];
                              $a_json_row["label"] = $row['Name'].' | '.$row['Username'];
                              array_push($a_json, $a_json_row);
                              
                    }
                }*/    

		  /*$sql = "SELECT * FROM `member` WHERE member.Username LIKE '%".$term."%' AND Enabled = '1'";

		  foreach ($this->dbconnect->query($sql) as $row)
	        {
	                  $a_json_row["id"] = $row['ID'];
			  $a_json_row["value"] = $row['Username'];
			  $a_json_row["label"] = $row['Username'];
			  array_push($a_json, $a_json_row);
	        }*/

		   /*$sql = "SELECT * FROM `product` WHERE product.NAME LIKE '%".$term."%' AND Enabled = '1'";

		  foreach ($this->dbconnect->query($sql) as $row)
	        {
	          $CategoryID =	ProductCategoryModel::getProductCategory($row['CategoryID'], "Name");
	          $a_json_row["id"] = $this->config['SITE_DIR'].'/main/product/view/'.$row['ID'];
			  $a_json_row["value"] = $row['Name'];

			  $a_json_row["label"] = $CategoryID." &gt; ".$row['Name'];
			  array_push($a_json, $a_json_row);
	        }*/
	

		// highlight search results
		$a_json = $this->apply_highlight($a_json, $term);
		 
		if($a_json[0]['value']=='')
		{
			$a_json[0]['id'] = $this->config['SITE_DIR'].'/';
			$a_json[0]['label'] = 'Empty Result';
			$a_json[0]['value'] = '';
			$json = json_encode($a_json);
			print $json;
		}
		else 
		{
			$json = json_encode($a_json);
		        print $json;
		}

	}
        
        public function ProductAgentGroupSearch($param)
	{
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
                //echo $child;
                //exit;

                unset($_SESSION['agentchild']);
            
		// get what user typed in autocomplete input
		$term = trim($_GET['term']);

		$a_json = array();
		$a_json_row = array();

		$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
		$json_invalid = json_encode($a_json_invalid);

		// replace multiple spaces with one
		$term = preg_replace('/\s+/', ' ', $term);

		// SECURITY HOLE ***************************************************************
		// allow space, any unicode letter and digit, underscore and dash
		if(preg_match("/[^\040\pL\pN_-]/u", $term)) {
		  print $json_invalid;
		  exit;
		}


		  $sql = "SELECT * FROM `member` WHERE Agent IN (".$child.") AND (Name LIKE '%".$term."%' OR Username LIKE '%".$term."%') AND Enabled = '1'";

                  $nameCounter = 0;
		   foreach ($this->dbconnect->query($sql) as $row)
	        {
	                  $a_json_row["id"] = $row['ID'];
			  $a_json_row["value"] = $row['Name'].' | '.$row['Username'];
			  $a_json_row["label"] = $row['Name'].' | '.$row['Username'];
			  array_push($a_json, $a_json_row);
                          $nameCounter += 1;
	        }
                
                
                
                /*if($nameCounter==0) {
                    
                    $a_json = array();
                    $a_json_row = array();
                    
                    $sql = "SELECT * FROM `member` WHERE Agent IN (".$child.") AND Username LIKE '%".$term."%' AND Enabled = '1'";
                    
                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                              $a_json_row["id"] = $row['ID'];
                              $a_json_row["value"] = $row['Name'].' | '.$row['Username'];
                              $a_json_row["label"] = $row['Name'].' | '.$row['Username'];
                              array_push($a_json, $a_json_row);
                    }
                }*/
                //echo $sql;

		  /*$sql = "SELECT * FROM `member` WHERE member.Username LIKE '%".$term."%' AND Enabled = '1'";

		  foreach ($this->dbconnect->query($sql) as $row)
	        {
	                  $a_json_row["id"] = $row['ID'];
			  $a_json_row["value"] = $row['Username'];
			  $a_json_row["label"] = $row['Username'];
			  array_push($a_json, $a_json_row);
	        }*/

		   /*$sql = "SELECT * FROM `product` WHERE product.NAME LIKE '%".$term."%' AND Enabled = '1'";

		  foreach ($this->dbconnect->query($sql) as $row)
	        {
	          $CategoryID =	ProductCategoryModel::getProductCategory($row['CategoryID'], "Name");
	          $a_json_row["id"] = $this->config['SITE_DIR'].'/main/product/view/'.$row['ID'];
			  $a_json_row["value"] = $row['Name'];

			  $a_json_row["label"] = $CategoryID." &gt; ".$row['Name'];
			  array_push($a_json, $a_json_row);
	        }*/
	

		// highlight search results
		$a_json = $this->apply_highlight($a_json, $term);
		 
		if($a_json[0]['value']=='')
		{
			$a_json[0]['id'] = $this->config['SITE_DIR'].'/';
			$a_json[0]['label'] = 'Empty Result';
			$a_json[0]['value'] = '';
			$json = json_encode($a_json);
			print $json;
		}
		else 
		{
			$json = json_encode($a_json);
		        print $json;
		}

	}
        
        public function ProductAgentSearch($param)
	{
                
            
		// get what user typed in autocomplete input
		$term = trim($_GET['term']);

		$a_json = array();
		$a_json_row = array();

		$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
		$json_invalid = json_encode($a_json_invalid);

		// replace multiple spaces with one
		$term = preg_replace('/\s+/', ' ', $term);

		// SECURITY HOLE ***************************************************************
		// allow space, any unicode letter and digit, underscore and dash
		if(preg_match("/[^\040\pL\pN_-]/u", $term)) {
		  print $json_invalid;
		  exit;
		}

                $nameCounter = 0;
                
		  $sql = "SELECT * FROM `member` WHERE Agent = '".$_SESSION['agent']['ID']."' AND (Name LIKE '%".$term."%' OR Username LIKE '%".$term."%') AND Enabled = '1'";

		   foreach ($this->dbconnect->query($sql) as $row)
	        {
	                  $a_json_row["id"] = $row['ID'];
			  $a_json_row["value"] = $row['Name'].' | '.$row['Username'];
			  $a_json_row["label"] = $row['Name'].' | '.$row['Username'];
			  array_push($a_json, $a_json_row);
                          
                          $nameCounter+=1;
	        }
                
                /*if($nameCounter==0)
                { 
                    
                    $a_json = array();
		    $a_json_row = array();
                
                    $sql = "SELECT * FROM `member` WHERE member.Username LIKE '%".$term."%' AND Agent = '".$_SESSION['agent']['ID']."' AND Enabled = '1'";

                       foreach ($this->dbconnect->query($sql) as $row)
                    {
                              $a_json_row["id"] = $row['ID'];
                              $a_json_row["value"] = $row['Name'].' | '.$row['Username'];
                              $a_json_row["label"] = $row['Name'].' | '.$row['Username'];
                              array_push($a_json, $a_json_row);
                    }
                }*/

		  /*$sql = "SELECT * FROM `member` WHERE member.Username LIKE '%".$term."%' AND Enabled = '1'";

		  foreach ($this->dbconnect->query($sql) as $row)
	        {
	                  $a_json_row["id"] = $row['ID'];
			  $a_json_row["value"] = $row['Username'];
			  $a_json_row["label"] = $row['Username'];
			  array_push($a_json, $a_json_row);
	        }*/

		   /*$sql = "SELECT * FROM `product` WHERE product.NAME LIKE '%".$term."%' AND Enabled = '1'";

		  foreach ($this->dbconnect->query($sql) as $row)
	        {
	          $CategoryID =	ProductCategoryModel::getProductCategory($row['CategoryID'], "Name");
	          $a_json_row["id"] = $this->config['SITE_DIR'].'/main/product/view/'.$row['ID'];
			  $a_json_row["value"] = $row['Name'];

			  $a_json_row["label"] = $CategoryID." &gt; ".$row['Name'];
			  array_push($a_json, $a_json_row);
	        }*/
	

		// highlight search results
		$a_json = $this->apply_highlight($a_json, $term);
		 
		if($a_json[0]['value']=='')
		{
			$a_json[0]['id'] = $this->config['SITE_DIR'].'/';
			$a_json[0]['label'] = 'Empty Result';
			$a_json[0]['value'] = '';
			$json = json_encode($a_json);
			print $json;
		}
		else 
		{
			$json = json_encode($a_json);
		        print $json;
		}

	}

	public function AdminIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['search_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("Title",$_POST['Title'],"LIKE");
			$query_condition .= $crud->queryCondition("FriendlyURL",$_POST['FriendlyURL'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",Helper::dateDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Source",$_POST['Source'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['search_'.__FUNCTION__]['param']['Title'] = $_POST['Title'];
			$_SESSION['search_'.__FUNCTION__]['param']['FriendlyURL'] = $_POST['FriendlyURL'];
			$_SESSION['search_'.__FUNCTION__]['param']['DateFrom'] = $_POST['DateFrom'];
			$_SESSION['search_'.__FUNCTION__]['param']['DateTo'] = $_POST['DateTo'];
			$_SESSION['search_'.__FUNCTION__]['param']['Source'] = $_POST['Source'];
			$_SESSION['search_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['search_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
			$_SESSION['search_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['search_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['search_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['search_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['search_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM search ".$_SESSION['search_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/search/index';
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

		$sql = "SELECT * FROM search ".$_SESSION['search_'.__FUNCTION__]['query_condition']." ORDER BY Date DESC, ID DESC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['CoverImage']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['CoverImage'],'cover');
			}

			$result[$i] = array(
			'ID' => $row['ID'],
			'Title' => $row['Title'],
			'FriendlyURL' => $row['ID']."-".$row['FriendlyURL'],
			'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			'Source' => $row['Source'],
			'CoverImage' => $cover_image,
			'Description' => Helper::truncate($row['Description'],200),
			'Content' => $row['Content'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "search", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'search_delete' => $_SESSION['admin']['search_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.search_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['search_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create search", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'search_add' => $_SESSION['admin']['search_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.search_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create search"),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['search_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
	    // Handle Image Upload
        $upload['CoverImage'] = File::uploadFile('CoverImage',1,2,"search");

        if ($upload['CoverImage']['upload']['status']=="Empty")
        {
            $file_location['CoverImage'] = "";
        }
        else if ($upload['CoverImage']['upload']['status']=="Uploaded")
        {
            $file_location['CoverImage'] = $upload['CoverImage']['upload']['destination'];
            Image::generateImage($file_location['CoverImage'],100,100,'cover');
        }
        else
        {
            $error['count'] += 1;
            $error['CoverImage'] = $upload['CoverImage']['error'];

            $file_location['CoverImage'] = "";
        }

		$key = "(Title, FriendlyURL, Date, Source, CoverImage, Description, Content, Enabled)";
		$value = "('".$_POST['Title']."', '".$_POST['FriendlyURL']."', '".Helper::dateDisplaySQL($_POST['Date'])."', '".$_POST['Source']."', '".$file_location['CoverImage']."', '".$_POST['Description']."', '".$_POST['Content']."', '".$_POST['Enabled']."')";

		$sql = "INSERT INTO search ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

        // Set Status
        $ok = ($count==1) ? 1 : "";

		// Generate .htaccess
		GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating search...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM search WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['CoverImage']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['CoverImage'],'cover');
            }

            $result[$i] = array(
			'ID' => $row['ID'],
			'Title' => $row['Title'],
			'FriendlyURL' => $row['FriendlyURL'],
			'Date' => Helper::dateSQLToDisplay($row['Date']),
			'Source' => $row['Source'],
			'CoverImageCover' => $cover_image,
			'CoverImage' => $row['CoverImage'],
			'Description' => $row['Description'],
			'Content' => $row['Content'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit search", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'search_add' => $_SESSION['admin']['search_add'], 'search_edit' => $_SESSION['admin']['search_edit']),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.search_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit search"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['search_add']);
		unset($_SESSION['admin']['search_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
	    // Handle Image Upload
        $upload['CoverImage'] = File::uploadFile('CoverImage',1,2,"search");

        if ($upload['CoverImage']['upload']['status']=="Empty")
        {
            if ($_POST['CoverImageRemove']==1)
            {
                $file_location['CoverImage'] = "";
                Image::deleteImage($_POST['CoverImageCurrent']);
                Image::deleteImage(Image::getImage($_POST['CoverImageCurrent'],'cover'));
            }
            else
            {
                $file_location['CoverImage'] = $_POST['CoverImageCurrent'];
            }
        }
        else if ($upload['CoverImage']['upload']['status']=="Uploaded")
        {
            $file_location['CoverImage'] = $upload['CoverImage']['upload']['destination'];
            Image::generateImage($file_location['CoverImage'],100,100,'cover');
            Image::deleteImage($_POST['CoverImageCurrent']);
            Image::deleteImage(Image::getImage($_POST['CoverImageCurrent'],'cover'));
        }
        else
        {
            $error['count'] += 1;
            $error['CoverImage'] = $upload['CoverImage']['error'];

            $file_location['CoverImage'] = "";
        }

		$sql = "UPDATE search SET Title='".$_POST['Title']."', FriendlyURL='".$_POST['FriendlyURL']."', Date='".Helper::dateDisplaySQL($_POST['Date'])."', Source='".$_POST['Source']."', CoverImage='".$file_location['CoverImage']."', Description='".$_POST['Description']."', Content='".$_POST['Content']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count<=1) ? 1 : "";

		// Generate .htaccess
		GeneratorModel::Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing search...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'ok' => $ok, 'error' => $error),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
        // Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM search WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'CoverImage' => $row['CoverImage']);

            $i += 1;
        }

        Image::deleteImage($result[0]['CoverImage']);
        Image::deleteImage(Image::getImage($result[0]['CoverImage'],'cover'));

		// Delete entry from table
		$sql = "DELETE FROM search WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting search...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM search ".$_SESSION['search_'.$param]['query_condition']." ORDER BY Date DESC, ID DESC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_search";
		$result['header'] = $this->config['SITE_NAME']." | search (" . date('Y-m-d H:i:s') . ")\n\nID, Title, Friendly URL, Date, Source, Cover Image, Description, Content, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['Title']."\",";
			$result['content'] .= "\"".$row['FriendlyURL']."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['Date'])."\",";
			$result['content'] .= "\"".$row['Source']."\",";
			$result['content'] .= "\"".$row['CoverImage']."\",";
			$result['content'] .= "\"".Helper::stripNLTags($row['Description'])."\",";
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

	public function getsearch($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM search WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Title' => $row['Title'],
			'FriendlyURL' => $row['ID']."-".$row['FriendlyURL'],
			'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			'Source' => $row['Source'],
			'CoverImage' => $cover_image,
			'Description' => Helper::truncate($row['Description'],200),
			'Content' => $row['Content'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result = $result[0]['Title'];

		return $result;
	}

	public function getsearchList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM search ORDER BY Date DESC, ID DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Title' => $row['Title'],
			'FriendlyURL' => $row['ID']."-".$row['FriendlyURL'],
			'Date' => Helper::dateSQLToLongDisplay($row['Date']),
			'Source' => $row['Source'],
			'CoverImage' => $cover_image,
			'Description' => Helper::truncate($row['Description'],200),
			'Content' => $row['Content'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

    public function BlockIndex()
    {
        $crud = new CRUD();

        // Prepare Pagination
        $query_count = "SELECT COUNT(*) AS num FROM search WHERE Enabled = 1";
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

        $targetpage = $data['config']['SITE_DIR'].'/main/search/index';
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

        $sql = "SELECT * FROM search WHERE Enabled = 1 ORDER BY Date DESC, ID DESC LIMIT $start, $limit";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            if ($row['CoverImage']=='')
            {
                $cover_image = $this->config['THEME_DIR'].'img/no_image.png';
            }
            else
            {
                $cover_image = Image::getImage($row['CoverImage'],'cover');
            }

            $result[$i] = array(
            'ID' => $row['ID'],
            'Title' => $row['Title'],
            'FriendlyURL' => $row['ID']."-".$row['FriendlyURL'],
            'Date' => Helper::dateSQLToLongDisplay($row['Date']),
            'Source' => $row['Source'],
            'CoverImage' => $cover_image,
            'Description' => $row['Description'],
            'Content' => $row['Content'],
            'Enabled' => CRUD::isActive($row['Enabled']));

            $i += 1;
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "search", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'secure' => NULL,
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function BlockHomeIndex()
    {
        $crud = new CRUD();

        // Prepare Pagination
        $query_count = "SELECT COUNT(*) AS num FROM search WHERE Enabled = 1";
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

        $targetpage = $data['config']['SITE_DIR'].'/main/search/index';
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

        $sql = "SELECT * FROM search WHERE Enabled = 1 ORDER BY Date DESC, ID DESC LIMIT $start, $limit";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            if ($row['CoverImage']=='')
            {
                $cover_image = $this->config['THEME_DIR'].'img/no_image.png';
            }
            else
            {
                $cover_image = Image::getImage($row['CoverImage'],'cover');
            }

            $result[$i] = array(
            'ID' => $row['ID'],
            'Title' => $row['Title'],
            'FriendlyURL' => $row['ID']."-".$row['FriendlyURL'],
            'Date' => Helper::dateSQLToLongDisplay($row['Date']),
            'Source' => $row['Source'],
            'CoverImage' => $cover_image,
            'Description' => $row['Description'],
            'Content' => $row['Content'],
            'Enabled' => CRUD::isActive($row['Enabled']));

            $i += 1;
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "search", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'secure' => NULL,
        'meta' => array('active' => "on"));

        return $this->output;
    }

	public function mb_stripos_all($haystack, $needle){

		  $s = 0;
		  $i = 0;

		  while(is_integer($i)) {

		    $i = mb_stripos($haystack, $needle, $s);

		    if(is_integer($i)) {
		      $aStrPos[] = $i;
		      $s = $i + mb_strlen($needle);
		    }
		  }

		  if(isset($aStrPos)) {
		    return $aStrPos;
		  } else {
		    return false;
		  }
	}

	public function apply_highlight($a_json, $parts){
		  
		  $p = count($parts);
		  $rows = count($a_json);

		  /*echo $parts;
		  echo $a_json;	
		  echo $p;
		  exit;*/

		  for($row = 0; $row < $rows; $row++) {

		    $label = $a_json[$row]["label"];
		    $a_label_match = array();

		    for($i = 0; $i < $p; $i++) {

		      $part_len = mb_strlen($parts);
		      $a_match_start = $this->mb_stripos_all($label, $parts);
				
				//Debug::displayArray($a_match_start);
				//echo $a_match_start;
				//exit;	
		      foreach($a_match_start as $part_pos) {

		        $overlap = false;
		        foreach($a_label_match as $pos => $len) {
		          if($part_pos - $pos >= 0 && $part_pos - $pos < $len) {
		            $overlap = true;
		            break;
		          }
		        }
		        if(!$overlap) {
		          $a_label_match[$part_pos] = $part_len;
		        }

		      }

		    }

		    if(count($a_label_match) > 0) {
		      ksort($a_label_match);

		      $label_highlight = '';
		      $start = 0;
		      $label_len = mb_strlen($label);

		      foreach($a_label_match as $pos => $len) {
		        if($pos - $start > 0) {
		          $no_highlight = mb_substr($label, $start, $pos - $start);
		          $label_highlight .= $no_highlight;
		        }
		        $highlight = '<span class="hl_results">' . mb_substr($label, $pos, $len) . '</span>';
		        $label_highlight .= $highlight;
		        $start = $pos + $len;
		      }

		      if($label_len - $start > 0) {
		        $no_highlight = mb_substr($label, $start);
		        $label_highlight .= $no_highlight;
		      }

		      $a_json[$row]["label"] = $label_highlight;
		    }

		  }

		  return $a_json;




	}


}
?>