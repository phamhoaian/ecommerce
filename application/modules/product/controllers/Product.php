<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	function __construct() {

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "Sản phẩm";
        $this->data["description"] = SITE_NAME;

        // limit per page
        $this->limit = 3;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Trang chủ";
        $this->position['item'][0]['url'] = site_url();
        $this->position['item'][1]['title'] = "Sản phẩm";
	}

	public function index() {

		// menu active
		$this->data['menu_active'] = "product";

		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// offset
		$offset = $this->security_clean($this->uri->segment(3, 0));

		// get list product
		$this->data["list_product"] = $this->common_model->get_all_product(NULL, 'created DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_product();

		// generate pagination
		$path = $this->uri->segment(1, 0);
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 3, TRUE);

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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("product/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('top', $this->data);
	}

	public function category() {

		// menu active
		$this->data['menu_active'] = "product";

		// category id
		$cat_id = $this->security_clean($this->uri->segment(3, 0));
		if (!$cat_id || !is_numeric($cat_id))
		{
            redirect();
		}

		$category = $this->common_model->get_category_by_id($cat_id);
		if (!$category)
		{
            redirect();
		}

		// offset
		$offset = $this->security_clean($this->uri->segment(4, 0));

		// breadcrumbs
		$this->position['item'][1]['url'] = site_url("product");
		$this->position['item'][2]['title'] = $category["name"];
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);		

		// get list product
		$this->data["list_product"] = $this->common_model->get_all_product(array("cat_id" => $cat_id), 'created DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_product(array("cat_id" => $cat_id));

		// generate pagination
		$path = $this->uri->segment(1, 0).$this->uri->segment(2, 0).$this->uri->segment(3, 0);
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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/category/".$cat_id) . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/category/".$cat_id . "/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("product/category/".$cat_id . "/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('top', $this->data);
	}
}