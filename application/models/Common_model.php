<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends MY_Model { 

	function __construct() {

		parent::__construct();
		$this->_user_table = "users";
		$this->_user_profile_table = "user_profile";
	}

	public function get_all_user($where = NULL, $order_by = '', $limit = 0, $offset = 0)
	{
		$this->set_table($this->_user_table);
		$this->db->join($this->_user_profile_table, "{$this->_user_table}.id = {$this->_user_profile_table}.user_id", "inner");
		if (is_int($limit) && $limit > 0) {
			return $this->get_all($where, $order_by, $limit, $offset);
		}
		else {
			return $this->get_all($where, $order_by);
		}
	}

	public function get_count_user($where = NULL)
	{
		$this->set_table($this->_user_table);
		return $this->get_count($where);
	}

	public function get_user_by_id($id)
	{
		if(is_numeric($id) && $id)
		{
			$this->set_table($this->_user_table);
			$this->db->join($this->_user_profile_table, "{$this->_user_table}.id = {$this->_user_profile_table}.user_id", "inner");
			return $this->get_row(array("{$this->_user_table}.id" => $id));
		}
		return FALSE;		
	}
}