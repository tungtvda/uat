<?php
// Require required models
Core::requireModel('generator');
Core::requireModel('moduletranslation');

class NewsModel extends BaseModel
{
	private $output = array();
    private $module_name = "News";
	private $module_dir = "modules/news/";
    private $module_default_url = "/main/news/index";
    private $module_default_admin_url = "/admin/news/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();
		
		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM news WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/news/index';
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
		
		$sql = "SELECT * FROM news WHERE Enabled = 1 ORDER BY Date DESC, ID DESC LIMIT $start, $limit";
		
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
		'page' => array('title' => "News", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
        'block' => array('side_nav' => $this->module_dir.'inc/main/side_nav.news.inc.php', 'common' => "false"),
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
        
		$sql = "SELECT * FROM news WHERE ID = '".$param."'".$query_condition;
		
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
        'block' => array('side_nav' => $this->module_dir.'inc/main/side_nav.news.inc.php', 'common' => "false"),      
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,$result[0]['Title']),
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
			$_SESSION['news_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("Title",$_POST['Title'],"LIKE");
			$query_condition .= $crud->queryCondition("FriendlyURL",$_POST['FriendlyURL'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",Helper::dateDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Source",$_POST['Source'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Content",$_POST['Content'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['news_'.__FUNCTION__]['param']['Title'] = $_POST['Title'];
			$_SESSION['news_'.__FUNCTION__]['param']['FriendlyURL'] = $_POST['FriendlyURL'];
			$_SESSION['news_'.__FUNCTION__]['param']['DateFrom'] = $_POST['DateFrom'];
			$_SESSION['news_'.__FUNCTION__]['param']['DateTo'] = $_POST['DateTo'];
			$_SESSION['news_'.__FUNCTION__]['param']['Source'] = $_POST['Source'];
			$_SESSION['news_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['news_'.__FUNCTION__]['param']['Content'] = $_POST['Content'];
			$_SESSION['news_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['news_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['news_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['news_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['news_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM news ".$_SESSION['news_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/news/index';
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
		
		$sql = "SELECT * FROM news ".$_SESSION['news_'.__FUNCTION__]['query_condition']." ORDER BY Date DESC, ID DESC LIMIT $start, $limit";
		
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
		'page' => array('title' => "News", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'news_delete' => $_SESSION['admin']['news_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.news_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['news_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create News", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'news_add' => $_SESSION['admin']['news_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.news_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create News"),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['news_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
	    // Handle Image Upload
        $upload['CoverImage'] = File::uploadFile('CoverImage',1,2,"news");
                
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

		$sql = "INSERT INTO news ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
        
        // Set Status
        $ok = ($count==1) ? 1 : "";
        
		// Generate .htaccess
		GeneratorModel::Generate();
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating News...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
         
		$sql = "SELECT * FROM news WHERE ID = '".$param."'";
	
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
                
                //$encoded_content = json_encode($result[0]['Content']);
                //echo '<pre>'.$encoded_content.'</pre>';

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit News", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'news_add' => $_SESSION['admin']['news_add'], 'news_edit' => $_SESSION['admin']['news_edit']),     
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.news_common.inc.php'),               
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit News"),
		'content' => $result,
                'test' => $test,    
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['news_add']);
		unset($_SESSION['admin']['news_edit']);
        			
		return $this->output;
	}
        
        
        public function AdminDefaultChange($param) 
	{
            
            switch ($_SESSION['admin']['DEFAULT_LANGUAGE']) {
                case "zhCN":
                    $LanguageID = LanguageModel::getLanguageID("zh_CN");
                    break;
                case "en":
                    $LanguageID = LanguageModel::getLanguageID("en");
                    break;
                case "ms":
                    $LanguageID = LanguageModel::getLanguageID("ms");
                    break;
            }
            
            
            $sql = "SELECT * FROM module_translation WHERE LanguageID = '".$LanguageID."' AND RowID IN (SELECT ID FROM news)";
            //echo $sql;
            //exit;
            $result = array();
            $i = 0;
            
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result = json_decode($row['Content'], TRUE);
                            
                $result[$i]['Title'] = ($result['Title']!='') ? base64_decode($result['Title']): ModuleTranslationModel::getColumnTranslation($param, $_GET['contentID'], "Title");
                $result[$i]['Content'] = ($result['Content']!='') ? base64_decode($result['Content']): ModuleTranslationModel::getColumnTranslation($param, $_GET['contentID'], "Content");
                $result[$i]['Description'] = ($result['Description']!='') ? base64_decode($result['Description']): ModuleTranslationModel::getColumnTranslation($param, $_GET['contentID'], "Description");
                $result[$i]['Source'] = ($result['Source']!='') ? base64_decode($result['Source']): ModuleTranslationModel::getColumnTranslation($param, $_GET['contentID'], "Source");
                $result[$i]['RowID'] = $result['RowID'];
                
                $i++;
                            
            }
            
            $result['count'] = $i;
            
            Debug::displayArray($result);
            exit;
                        
            for ($index = 0; $index < $result['count']; $index++) {
                
                $sql2 = "UPDATE news SET Title='".$result[$index]['Title']."', Source='".$result[$index]['Source']."', Description='".$result[$index]['Description']."', Content='".$result[$index]['Content']."' WHERE ID='".$result[$index]['RowID']."'";
                
		$count = $this->dbconnect->exec($sql2);
        
                // Set Status
                $ok = ($count<=1) ? 1 : "";
                
            }
         
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Swapping Language...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'ok' => $ok, 'error' => $error),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
            /*header('Content-Type: text/html; charset=utf-8');*/
            $con1 = array();
            $con1 = array('Label' => base64_encode("kita bersembang"));
                
            $con1 = json_encode($con1);
            
            $con2 = array();
            $con2 = array('Label' => base64_encode("mukabuku"));
                
            $con2 = json_encode($con2);
            
            $con3 = array();
            $con3 = array('Label' => base64_encode("e-mel"));
                
            $con3 = json_encode($con3);
            
            $con4 = array();
            $con4 = array('Label' => base64_encode("Whatapps"));
                
            $con4 = json_encode($con4);
            
            $con5 = array();
            $con5 = array('Label' => base64_encode("tiada"));
                
            $con5 = json_encode($con5);
            
            
            /*INSERT INTO tbl_name
            (a,b,c)
            VALUES
            (1,2,3),
            (4,5,6),
            (7,8,9);*/
            
		$sql = "INSERT INTO module_translation (Content, RowID, LanguageID) VALUES ('".$con1."', '5', '3'), ('".$con2."', '2', '3'), ('".$con3."', '4', '3'), ('".$con4."', '3', '3'), ('".$con5."', '1', '3')";
                //echo $sql;
		$count = $this->dbconnect->exec($sql);
        
        // Set Status
        $ok = ($count<=1) ? 1 : "";
        exit;
        
        
            
            
            
            
	    // Handle Image Upload
        $upload['CoverImage'] = File::uploadFile('CoverImage',1,2,"news");
                
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
                
                
                
            
            
            $sql = "UPDATE module_translation SET Title='".$_POST['Title']."', FriendlyURL='".$_POST['FriendlyURL']."', Date='".Helper::dateDisplaySQL($_POST['Date'])."', Source='".$_POST['Source']."', CoverImage='".$file_location['CoverImage']."', Description='".$_POST['Description']."', Content='".$_POST['Content']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
        
        // Set Status
        $ok = ($count<=1) ? 1 : "";
                    
                
        
		// Generate .htaccess
		GeneratorModel::Generate();
	
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing News...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'ok' => $ok, 'error' => $error),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
        // Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM news WHERE ID = '".$param."'";
        
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
		$sql = "DELETE FROM news WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
        
        // Set Status
        $ok = ($count==1) ? 1 : "";
        
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting News...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM news ".$_SESSION['news_'.$param]['query_condition']." ORDER BY Date DESC, ID DESC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_News";
		$result['header'] = $this->config['SITE_NAME']." | News (" . date('Y-m-d H:i:s') . ")\n\nID, Title, Friendly URL, Date, Source, Cover Image, Description, Content, Enabled";
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

	public function getNews($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM news WHERE ID = '".$param."'";
		
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

	public function getNewsList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM news ORDER BY Date DESC, ID DESC";
		
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
        $query_count = "SELECT COUNT(*) AS num FROM news WHERE Enabled = 1";
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_DIR'].'/main/news/index';
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
        
        $sql = "SELECT * FROM news WHERE Enabled = 1 ORDER BY Date DESC, ID DESC LIMIT $start, $limit";
        
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
        'page' => array('title' => "News", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
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
        $query_count = "SELECT COUNT(*) AS num FROM news WHERE Enabled = 1";
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_DIR'].'/main/news/index';
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
        
        $sql = "SELECT * FROM news WHERE Enabled = 1 ORDER BY Date DESC, ID DESC LIMIT $start, $limit";
        
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
        'page' => array('title' => "News", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'secure' => NULL,
        'meta' => array('active' => "on"));
                    
        return $this->output;
    }
}
?>