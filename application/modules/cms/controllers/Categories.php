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
		$this->data['categories'] = $this->common_model->get_all_categories(NULL, 'parent_id ASC, sort_order ASC', $this->limit, $offset);
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

	/**
	 * Add new or edit a category
	 * @param id integer (NULL: add; !=NULL: edit)
	 * @return void
	 */
	public function form()
	{
		// menu active
		$this->data['menu_active'] = "product";
		$this->data['submenu_active'] = "categories";
		
		// get user id 
		$this->data["id"] = $this->security_clean($this->uri->segment(4, 0));

		// page title
		if ($this->data["id"])
		{
			$this->data["page_title"] = "Chỉnh sửa thông tin danh mục";
		}
		else
		{
			$this->data["page_title"] = "Thêm danh mục mới";
		}

		// prepare user information
		if($this->data["id"])
		{
			$this->data["category"] = $this->common_model->get_category_by_id($this->data["id"]);
			if(!$this->data["category"])
			{
				$this->session->set_flashdata("error", "Danh mục không tồn tại!");
                redirect("cms/category/search");
			}
		}
		else
		{
			$this->data["category"] = array(
				'name' => '',
				'parent_id' => '',
				'sort_order' => ''
			);
		}

		// list parent categories
		$this->data["parent_categories"] = $this->common_model->get_all_categories(array('parent_id' => 0));

		// form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Tên', 'trim|required|xss_clean|callback_chk_category_name_duplicate');
		$this->form_validation->set_rules('parent', 'Danh mục cha', 'trim|xss_clean');
		$this->form_validation->set_rules('sort_order', 'Thứ tự hiển thị', 'trim|xss_clean');

		if($this->form_validation->run())
		{
			// prepare user data
			$upd_data = array(
				'name' => $this->security_clean(set_value('name')),
				'parent_id' => $this->security_clean(set_value('parent_id')),
			);

			// insert data into table categories
			$message = "";
			$this->common_model->set_table('categories');
			if($this->data["id"]) // in case update
			{
				if($this->common_model->update($upd_data, array('id' => $this->data["id"])))
				{
					$message = "Cập nhật thông tin danh mục thành công!";
				}
				else 
				{
					$message = "Cập nhật thất bại!";
				}
			}
			else // in case insert
			{
				if($this->common_model->insert($upd_data))
				{
					$message = "Thêm mới danh mục thành công!";
				}
				else
				{
					$message = "Thêm mới danh mục thất bại!";
				}
			}

			$this->session->set_flashdata("message", $message);
            redirect("cms/categories/search");
		} 
		else 
		{
			// load view
			$this->load_view('categories/form', $this->data);
		}
	}

	/**
	 *
	 * Check category name duplicate
	 * @param string
	 * @return boolean
	 *
	 */
	public function chk_category_name_duplicate($name)
	{
		$this->common_model->set_table('categories');
		if($this->data["id"]) // in case edit
		{
			$where = array(
				'name' => $username,
				'id !=' => $this->data["id"]
			);
		}
		else // in case insert
		{
			$where = array(
				'name' => $username
			);
		}

		if($this->common_model->get_row($where))
		{
			$this->form_validation->set_message('chk_category_name_duplicate', 'Tên danh mục này đã có! Vui lòng nhập tên khác.');
			return FALSE;
		}

		return TRUE;
	}
}