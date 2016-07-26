<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	function __construct() {

		$this->set_auth(TRUE);
		$this->set_bench(TRUE);

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "CMS - Users management";
        $this->data["description"] = SITE_NAME;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Users management";

        // check permissions
		$this->chk_permission();

		// get username
		$this->data["user_name"] = $this->get_username();

		// limit per page
		$this->limit = 10;
	}

	public function index() 
	{
		$jump_url = site_url("cms/user/search");
		header("Location: $jump_url");
		return false;
	}

	/**
	 * Display list user 
	 * @return void
	 */
	public function search()
	{
		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "account";
		$this->data['submenu_active'] = "user";

		// offset
		$offset = $this->security_clean($this->uri->segment(4, 0));

		// get list user
		$this->data['list_user'] = $this->common_model->get_all_user(NULL, 'users.id DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_user(NULL);

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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/user/search") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/user/search/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("cms/user/search/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('user/search', $this->data);
	}

	/**
	 * Add new or edit a user
	 * @param id integer (NULL: add; !=NULL: edit)
	 * @return void
	 */
	public function form()
	{
		// menu active
		$this->data['menu_active'] = "account";
		$this->data['submenu_active'] = "user";
		
		// get user id 
		$this->data["id"] = $this->security_clean($this->uri->segment(4, 0));

		// page title
		if ($this->data["id"])
		{
			$this->data["page_title"] = "Chỉnh sửa thông tin thành viên";
		}
		else
		{
			$this->data["page_title"] = "Thêm thành viên";
		}

		// prepare user information
		if($this->data["id"])
		{
			$this->data["user"] = $this->common_model->get_user_by_id($this->data["id"]);
			if(!$this->data["user"])
			{
				$this->session->set_flashdata("error", "Thành viên không tồn tại!");
                redirect("cms/user/search");
			}
		}
		else
		{
			$this->data["user"] = array(
				'username' => '',
				'password' => '',
				'confirm_password' => '',
				'email' => '',
				'phone' => ''
			);
		}

		// form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Tên thành viên', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Mật khẩu (nhập lại)', 'trim|xss_clean|matches[password]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|callback_chk_email_duplicate');
		$this->form_validation->set_rules('phone', 'Điện thoại', 'trim|xss_clean');

		if($this->form_validation->run())
		{
			// prepare data
			$upd_data = array(
				'username' => $this->security_clean(set_value('username')),
				'email' => $this->security_clean(set_value('email')),
			);

			$upd_data_profile = array(
				'phone' => $this->security_clean(set_value('phone')),
			);

			// insert data into table user
			$message = "";
			$this->common_model->set_table('users');
			if($this->data["id"]) // in case update
			{
				$upd_data["modified"] = date('Y-m-d H:i:s', time());
				if($this->common_model->update($upd_data, array('id' => $this->data["id"])))
				{
					// insert data into table user_profile
					$this->common_model->set_table('user_profile');
					$this->common_model->update($upd_data_profile, array('user_id' => $this->data["id"]));
					$message = "Cập nhật thông tin thành viên thành công!";
				}
				else 
				{
					$message = "Cập nhật thất bại!";
				}
			}
			else // in case insert
			{
				$upd_data["created"] = date('Y-m-d H:i:s', time());
				$this->data["id"] = $this->common_model->insert($upd_data);

				// insert data into table user_profile
				$this->common_model->set_table('user_profile');
				$this->common_model->insert($upd_data_profile, array('user_id' => $this->data["id"]));
				$message = "Thêm mới thành viên thành công!";
			}

			$this->session->set_flashdata("message", $message);
            redirect("cms/user/search");
		} 
		else 
		{
			// load view
			$this->load_view('user/form', $this->data);
		}
	}

	public function chk_email_duplicate($email)
	{
		$this->common_model->set_table('users');
		if($this->data["id"]) // in case edit
		{
			$where = array(
				'email' => $email,
				'id !=' => $this->data["id"]
			);
		}
		else // in case insert
		{
			$where = array(
				'email' => $email
			);
		}

		if($this->common_model->get_row($where))
		{
			$this->form_validation->set_message('chk_email_duplicate', 'Email này đã có! Vui lòng nhập email khác.');
			return FALSE;
		}

		return TRUE;
	}
}