<?php

class Roles extends MY_Model 
{
	function __construct()
	{
		parent::__construct();
		
		// Other stuff
		$this->_prefix = $this->config->item('DX_table_prefix');
		$this->_table = $this->_prefix.$this->config->item('DX_roles_table');

		$this->set_table($this->_table);
	}
	
	function get_all_role($where = NULL, $order_by = '', $limit = 0, $offset = 0)
	{
		if($limit > 0)
		{
			return $this->get_all($where, $order_by, $limit, $offset);
		}
		return $this->get_all($where, $order_by);
	}

	function get_count_role($where = NULL)
	{
		return $this->get_count($where);
	}
	
	function get_role_by_id($role_id)
	{
		$where = array(
			'id' => $role_id
		);
		return $this->get_row($where);
	}
	
	function create_role($name, $parent_id = 0)
	{
		$data = array(
			'name' => $name,
			'parent_id' => $parent_id
		);
            
		return $this->insert($data);
	}
	
	function delete_role($role_id)
	{
		$where = array(
			'id' => $role_id
		);
		return $this->delete();		
	}
}