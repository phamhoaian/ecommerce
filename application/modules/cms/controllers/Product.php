<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	function __construct() {

		$this->set_auth(TRUE);

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "CMS - Product management";
        $this->data["description"] = SITE_NAME;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Product management";

        // check permissions
		$this->chk_permission();

		// get username
		$this->data["user_name"] = $this->get_username();

		// limit per page
		$this->limit = 1;
	}

	public function index() {
		$jump_url = site_url("cms/product/search");
		header("Location: $jump_url");
		return false;
	}

	/**
	 *
	 * List product
	 * @return void
	 *
	 */
	public function search()
	{
		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "product";
		$this->data['submenu_active'] = "product";

		// offset
		$offset = $this->security_clean($this->input->get('page'));
		if($offset)
		{
			$offset = intval($offset - 1);
		}

		// get list categories
		$this->data['list_categories'] = $this->common_model->get_all_categories(array('parent_id' => 0), 'id ASC');
		if($this->data['list_categories'])
		{
			foreach ($this->data['list_categories'] as &$row) {
				$row['child'] = $this->common_model->get_all_categories(array('parent_id' => $row['id']), 'id ASC');
			}
		}

		/* 
		 * Filter
		 * id: find product by id
		 * name: find product by name
		 * cat_id: find product belong category
		 */
		$where = array();
		$id = $this->security_clean(isset($_GET["id"]) ? $_GET["id"] : '');
		if($id > 0)
		{
			$where["product.id"] = $id;
		}

		$name = $this->security_clean(isset($_GET["name"]) ? $_GET["name"] : '');
		if($name)
		{
			$where["product.name LIKE '%$name%'"] = NULL;
		}

		$cat_id = $this->security_clean(isset($_GET["categories"]) ? $_GET["categories"] : '');
		if($cat_id > 0)
		{
			$where["product.cat_id"] = $cat_id;
		}

		// get list product
		$this->data['list_product'] = $this->common_model->get_all_product($where, 'id DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_product($where);

		// generate pagination
		$path = "cms/product/search?id=".$id."&name=".$name."&categories=".$cat_id;
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 4, TRUE);

		// meta title
		if ($offset && !empty($this->data['list_product'])){
            $this->data["title"] .= " (" . ((int) ($offset / $this->limit) + 1) . ")";
        }

        // link rel
        $this->data["link_rel"] = "";
		if ($offset) {
			$tmp_offset = (int) ($offset - $this->limit);
			if (!$tmp_offset) {
				$tmp_offset = "";
			}

			if (!$tmp_offset) {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/product/search") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/product/search/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("cms/product/search/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('product/search', $this->data);
	}
}