<?php
// Require required models
Core::requireModel('block');

class HookModel extends BaseModel
{
	private $output = array();
    private $module_name = "Hook";
	private $module_dir = "modules/hook/";
    private $module_default_url = "/main/hook/index";
    private $module_default_admin_url = "/admin/hook/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function CoreIndex($param) 
	{
		$result = BlockModel::getBlockHookList($param);
				
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Hook"),
		'content' => $result['content'],
		'content_param' => array('count' => $result['count']));
					
		return $this->output;
	}
}
?>