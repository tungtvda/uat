<?php
class MenuTreeModel extends BaseModel
{
	private $output = array();
    private $module_name = "Menu Tree";
	private $module_dir = "modules/menutree/";
    private $module_default_url = "/main/menutree/index";
    private $module_default_admin_url = "/admin/menutree/index";
	
	public $tree_data = array();
	public $tree_index = array();
	public $tree_menu = array();
	
	
	public function __construct($param) 
	{
		parent::__construct();
		
		try 
		{
			$sql = "SELECT ID, ParentID, Name FROM ".$param;
			
			foreach ($this->dbconnect->query($sql) as $row){
			
				$ID = $row["ID"];
				$ParentID = $row["ParentID"] === NULL ? "NULL" : $row["ParentID"];
				
				$this->tree_data[$ID] = $row;
				$this->tree_index[$ParentID][] = $ID;
			}			
		}
		catch(PDOException $e) 
		{
			echo $e->getMessage();
		}
	}
	
	public function getListBoxMenuTree($param="", $ParentID=0, $level=0)
	{
		$ParentID = $ParentID === NULL ? "NULL" : $ParentID;
	
		if (isset($this->tree_index[$ParentID])) {
		
	
			foreach ($this->tree_index[$ParentID] as $id) {
				
				$this->tree_menu[][$this->tree_data[$id]["ID"]]=str_repeat("-", $level).$this->tree_data[$id]["Name"];
			
				$this->getListBoxMenuTree($param, $id, $level + 1);
			}
		}
		
		return $this->tree_menu;
	}	
}
?>