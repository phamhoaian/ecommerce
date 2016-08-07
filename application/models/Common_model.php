<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends MY_Model { 

	function __construct() {

		parent::__construct();
		$this->_prefix = $this->config->item('DX_table_prefix');
		$this->_user_table = $this->_prefix.$this->config->item('DX_users_table');	;
		$this->_user_profile_table = $this->_prefix.$this->config->item('DX_user_profile_table');	;
		$this->_roles_table = $this->_prefix.$this->config->item('DX_roles_table');

		$this->_categories_table = "categories";
		$this->_product_table = "product";
		$this->_news_table = "news";
	}

	public function get_all_user($where = NULL, $order_by = '', $limit = 0, $offset = 0)
	{
		$this->set_table($this->_user_table);
		$this->db->select("{$this->_user_table}.*, {$this->_user_profile_table}.phone, {$this->_roles_table}.name AS role_name");
		$this->db->join($this->_user_profile_table, "{$this->_user_table}.id = {$this->_user_profile_table}.user_id", "left");
		$this->db->join($this->_roles_table, "{$this->_user_table}.role_id = {$this->_roles_table}.id", "inner");
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
			$this->db->select("{$this->_user_table}.*, {$this->_user_profile_table}.phone");
			$this->db->join($this->_user_profile_table, "{$this->_user_table}.id = {$this->_user_profile_table}.user_id", "left");
			return $this->get_row(array("{$this->_user_table}.id" => $id));
		}
		return FALSE;		
	}

	public function get_all_categories($where = NULL, $order_by = '', $limit = 0, $offset = 0)
	{
		$this->set_table($this->_categories_table);
		if (is_int($limit) && $limit > 0) {
			return $this->get_all($where, $order_by, $limit, $offset);
		}
		else {
			return $this->get_all($where, $order_by);
		}
	}

	public function get_count_categories($where = NULL)
	{
		$this->set_table($this->_categories_table);
		return $this->get_count($where);
	}

	public function get_category_by_id($id)
	{
		if(is_numeric($id) && $id)
		{
			$this->set_table($this->_categories_table);
			return $this->get_row(array("id" => $id));
		}
		return FALSE;		
	}

	public function get_category_parent($parent_id)
	{
		if(is_numeric($parent_id) && $parent_id)
		{
			$this->set_table($this->_categories_table);
			return $this->get_row(array("id" => $parent_id));
		}
		return FALSE;		
	}

	public function get_all_product($where = NULL, $order_by = '', $limit = 0, $offset = 0)
	{
		$this->set_table($this->_product_table);
		$this->db->select("{$this->_product_table}.*, {$this->_categories_table}.name AS cat_name");
		$this->db->join($this->_categories_table, "{$this->_product_table}.cat_id = {$this->_categories_table}.id", "left");
		if (is_int($limit) && $limit > 0) {
			return $this->get_all($where, $order_by, $limit, $offset);
		}
		else {
			return $this->get_all($where, $order_by);
		}
	}

	public function get_count_product($where = NULL)
	{
		$this->set_table($this->_product_table);
		return $this->get_count($where);
	}

	public function get_product_by_id($id)
	{
		if(is_numeric($id) && $id)
		{
			$this->set_table($this->_product_table);
			return $this->get_row(array("id" => $id));
		}
		return FALSE;		
	}

	public function get_all_news($where = NULL, $order_by = '', $limit = 0, $offset = 0)
	{
		$this->set_table($this->_news_table);
		if (is_int($limit) && $limit > 0) {
			return $this->get_all($where, $order_by, $limit, $offset);
		}
		else {
			return $this->get_all($where, $order_by);
		}
	}

	public function get_count_news($where = NULL)
	{
		$this->set_table($this->_news_table);
		return $this->get_count($where);
	}

	public function get_news_by_id($id)
	{
		if(is_numeric($id) && $id)
		{
			$this->set_table($this->_news_table);
			return $this->get_row(array("id" => $id));
		}
		return FALSE;		
	}
}