<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {

	function __construct() {

		$this->set_auth(TRUE);

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "CMS - Categories management";
        $this->data["description"] = SITE_NAME;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Categories management";

        // check permissions
		$this->chk_permission();

		// get username
		$this->data["user_name"] = $this->get_username();

		// limit per page
		$this->limit = 10;
	}

	public function index() 
	{
		$jump_url = site_url("cms/categories/search");
		header("Location: $jump_url");
		return false;
	}

	public function search() {

		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "product";
		$this->data['submenu_active'] = "categories";

		// offset
		$offset = $this->security_clean($this->uri->segment(4, 0));

		// get list user
		$this->data['categories'] = $this->common_model->get_all_categories(NULL, 'id DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_categories(NULL);

		// generate pagination
		$path = $this->uri->slash_segment(1, 0).$this->uri->slash_segment(2, 0).$this->uri->slash_segment(3, 0);
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 4);

		// meta title
		if ($offset && !empty($this->data['list_user'])){
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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/categories/search") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/categories/search/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("cms/categories/search/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('categories/search', $this->data);
	}
}