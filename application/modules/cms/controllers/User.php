<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	function __construct() {

		$this->set_auth(TRUE);

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
				'email' => '',
				'phone' => '',
				'role_id' => ''
			);
		}

		// list roles
		$this->load->model('dx_auth/roles', 'roles');
		$this->data["roles"] = $this->roles->get_all()->result_array();

		// form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('DX_Auth', 'dx_auth');
		$this->form_validation->set_rules('username', 'Tên thành viên', 'trim|required|xss_clean|callback_chk_username_duplicate');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|callback_chk_email_duplicate');
		$this->form_validation->set_rules('phone', 'Điện thoại', 'trim|xss_clean');

		if(!$this->data["id"])
		{
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|xss_clean');
			$this->form_validation->set_rules('confirm_password', 'Mật khẩu (nhập lại)', 'trim|required|xss_clean|matches[password]');
		}

		if($this->form_validation->run())
		{
			// prepare user data
			$upd_data = array(
				'username' => $this->security_clean(set_value('username')),
				'email' => $this->security_clean(set_value('email')),
			);

			// prepare user profile data
			$upd_data_profile = array(
				'phone' => $this->security_clean(set_value('phone')),
			);

			// insert data into table user
			$message = "";
			$this->common_model->set_table('users');
			if($this->data["id"]) // in case update
			{
				$upd_data["modified"] = date('Y-m-d H:i:s', time());
				$upd_data["role_id"] = $this->security_clean(set_value('role'));
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
				if($this->dx_auth->register($this->security_clean(set_value('username')), $this->security_clean(set_value('password')), $this->security_clean(set_value('email'))))
				{
					$message = "Thêm mới thành viên thành công!";
				}
				else
				{
					$message = "Thêm mới thành viên thất bại!";
				}
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

	/**
	 *
	 * Delete a user by user_id
	 * @param user_id integer
	 * @return boolean
	 *
	 */
	public function del()
	{
		$user_id = $this->security_clean($this->uri->segment(4, 0));
		if(is_numeric($user_id) && $user_id)
		{
			$user = $this->common_model->get_user_by_id($user_id);
			if($user)
			{
				// delete user
				$this->common_model->set_table('users');
				$del_flag = $this->common_model->delete(array('id' => $user_id));
				if($del_flag)
				{
					$this->common_model->set_table('user_profile');
					$this->common_model->delete(array('user_id' => $user_id));
					$message = "Xóa thành viên thành công!";
					$this->session->set_flashdata("message", $message);
            		redirect("cms/user/search");
					return TRUE;
				}
				else // in case no data
				{
					define('RETURN_URL', site_url("cms/user/search"));
					$this->message("Không có dữ liệu!");
					return FALSE;
				}
			}
			else // in case user doesn't exists
			{
				define('RETURN_URL', site_url("cms/user/search"));
				$this->message("Thành viên không tồn tại!");
				return FALSE;
			}
		}
		else // in case user_id isn't integer or empty
		{
			define('RETURN_URL', site_url("cms/user/search"));
			$this->message("Truy cập bị từ chối!");
			return FALSE;
		}
	}

	/**
	 *
	 * Delete multi user by list user_id
	 * @param user_ids array
	 * @return boolean
	 *
	 */
	public function del_all()
	{
		// status flag
		$status = FALSE;

		// get list user_id
		$users_ids = $this->security_clean($this->input->post('ids'));
		
		if ($users_ids)
		{
			$users_ids = implode(",", $users_ids);

			$this->common_model->set_table('users');
			$del_flag = $this->common_model->delete(array("id IN({$users_ids})" => NULL));
			if($del_flag)
			{
				$this->common_model->set_table('user_profile');
				$this->common_model->delete(array("id IN({$users_ids})" => NULL));
				$status = TRUE;
			}
		}
		return $status;
	}

	/**
	 *
	 * Banned multi user by list user_id
	 * @param user_ids array
	 * @return boolean
	 *
	 */
	public function ban()
	{
		// get list user_id
		$users_ids = $this->security_clean($this->input->post('id'));

		if ($users_ids)
		{
			$count = count($users_ids);
			$users_ids = implode(",", $users_ids);

			// update 
			$this->common_model->set_table('users');
			$this->common_model->update(array("banned" => 1), array("id IN({$users_ids})" => NULL));

			// flash message
            $this->session->set_flashdata("message", "Có {$count} thành viên vừa cập nhật!");
		}

		$jump_url = site_url("cms/user/search");
        header("Location: $jump_url");
	}

	/**
	 *
	 * Unbanned multi user by list user_id
	 * @param user_ids array
	 * @return boolean
	 *
	 */
	public function unban()
	{
		// get list user_id
		$users_ids = $this->security_clean($this->input->post('id'));

		if ($users_ids)
		{
			$count = count($users_ids);
			$users_ids = implode(",", $users_ids);

			// update 
			$this->common_model->set_table('users');
			$this->common_model->update(array("banned" => 0), array("id IN({$users_ids})" => NULL));

			// flash message
            $this->session->set_flashdata("message", "Có {$count} thành viên vừa cập nhật!");
		}

		$jump_url = site_url("cms/user/search");
        header("Location: $jump_url");
	}

	/**
	 *
	 * Reset password multi user by list user_id
	 * @param user_ids array
	 * @return boolean
	 *
	 */
	public function reset_password()
	{
		// load model
		$this->load->model('dx_auth/users', 'users');

		// get list user_id
		$users_ids = $this->security_clean($this->input->post('id'));

		if ($users_ids)
		{
			$count = 0;

			foreach ($users_ids as $row) {
				// Get user and check if User ID exist
				if ($query = $this->users->get_user_by_id($row) AND $query->num_rows() == 1)
				{		
					// Get user record				
					$user = $query->row();
					
					// Create new key, password and send email to user
					if ($this->dx_auth->forgot_password($user->username))
					{
						// Query once again, because the database is updated after calling forgot_password.
						$query = $this->users->get_user_by_id($row);
						// Get user record
						$user = $query->row();
													
						// Reset the password
						if ($this->dx_auth->reset_password($user->username, $user->newpass_key))
						{							
							$count++;
						}
					}
				}
			}

			if($count > 0)
			{
				// flash message
            	$this->session->set_flashdata("message", "Có {$count} thành viên vừa được lấy lại mật khẩu!");
			}
			
		}

		$jump_url = site_url("cms/user/search");
        header("Location: $jump_url");
	}

	/**
	 *
	 * List roles
	 * @return void
	 *
	 */
	public function roles()
	{
		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "account";
		$this->data['submenu_active'] = "roles";

		// offset
		$offset = $this->security_clean($this->uri->segment(4, 0));

		// load model
		$this->load->model('dx_auth/roles', 'roles');

		// get list roles
		$this->data['list_roles'] = $this->roles->get_all_role(NULL, 'id DESC', $this->limit, $offset);
		$this->data['count'] = $this->roles->get_count_role();

		// generate pagination
		$path = $this->uri->slash_segment(1, 0).$this->uri->slash_segment(2, 0).$this->uri->slash_segment(3, 0);
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 4);

		// meta title
		if ($offset && !empty($this->data['list_roles'])){
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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/user/roles") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/user/roles/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("cms/user/roles/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('user/roles', $this->data);
	}

	/**
	 * Add new or edit a role
	 * @param id integer (NULL: add; !=NULL: edit)
	 * @return void
	 */
	public function form_role()
	{
		// load model
		$this->load->model('dx_auth/roles', 'roles');

		// menu active
		$this->data['menu_active'] = "account";
		$this->data['submenu_active'] = "roles";
		
		// get role id 
		$this->data["id"] = $this->security_clean($this->uri->segment(4, 0));

		// page title
		if ($this->data["id"])
		{
			$this->data["page_title"] = "Chỉnh sửa thông tin nhóm quản trị";
		}
		else
		{
			$this->data["page_title"] = "Thêm nhóm quản trị";
		}

		// prepare user information
		if($this->data["id"])
		{
			$this->data["role"] = $this->roles->get_role_by_id($this->data["id"])->row_array();
			if(!$this->data["role"])
			{
				$this->session->set_flashdata("error", "Nhóm quản trị không tồn tại!");
                redirect("cms/user/roles");
			}
		}
		else
		{
			$this->data["role"] = array(
				'name' => '',
				'parent_id' => ''
			);
		}

		// list roles
		$this->data["roles"] = $this->roles->get_all_role(NULL, 'id DESC');
		if ( $this->data["id"] )
		{
			$this->data["roles"] = $this->roles->get_all_role(array("id !=" => $this->data["id"]));
		}

		// form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('DX_Auth', 'dx_auth');
		$this->form_validation->set_rules('name', 'Tên nhóm quản trị', 'trim|required|xss_clean|callback_chk_role_name_duplicate');
		$this->form_validation->set_rules('parent', 'Nhóm cha', 'trim|xss_clean');

		if($this->form_validation->run())
		{
			// prepare role data
			$upd_data = array(
				'name' => $this->security_clean(set_value('name')),
				'parent_id' => $this->security_clean(set_value('parent')),
			);

			// insert data into table roles
			$message = "";
			if($this->data["id"]) // in case update
			{
				if($this->roles->update_role($upd_data, $this->data["id"]))
				{
					$message = "Cập nhật thông tin nhóm quản trị thành công!";
				}
				else 
				{
					$message = "Cập nhật thất bại!";
				}
			}
			else // in case insert
			{
				if($this->roles->create_role($this->security_clean(set_value('name')), $this->security_clean(set_value('parent_id'))))
				{
					$message = "Thêm mới nhóm quản trị thành công!";
				}
				else
				{
					$message = "Thêm mới nhóm quản trị thất bại!";
				}
			}

			$this->session->set_flashdata("message", $message);
            redirect("cms/user/roles");
		} 
		else 
		{
			// load view
			$this->load_view('user/form_role', $this->data);
		}
	}

	/**
	 *
	 * Delete multi roles by list user_id
	 * @param role_ids array
	 * @return boolean
	 *
	 */
	public function del_role_all()
	{
		// status flag
		$status = FALSE;

		// get list user_id
		$role_ids = $this->security_clean($this->input->post('ids'));
		
		if ($role_ids)
		{
			$role_ids = implode(",", $role_ids);

			$this->common_model->set_table('roles');
			$del_flag = $this->common_model->delete(array("id IN({$role_ids})" => NULL));
			if($del_flag)
			{
				$status = TRUE;
			}
		}
		return $status;
	}

	/**
	 *
	 * Check username duplicate
	 * @param string
	 * @return boolean
	 *
	 */
	public function chk_username_duplicate($username)
	{
		$this->common_model->set_table('users');
		if($this->data["id"]) // in case edit
		{
			$where = array(
				'username' => $username,
				'id !=' => $this->data["id"]
			);
		}
		else // in case insert
		{
			$where = array(
				'username' => $username
			);
		}

		if($this->common_model->get_row($where))
		{
			$this->form_validation->set_message('chk_username_duplicate', 'Tên thành viên này đã có người sử dụng! Vui lòng nhập tên khác.');
			return FALSE;
		}

		return TRUE;
	}

	/**
	 *
	 * Check email duplicate
	 * @param string
	 * @return boolean
	 *
	 */
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

	/**
	 *
	 * Check role name duplicate
	 * @param string
	 * @return boolean
	 *
	 */
	public function chk_role_name_duplicate($name)
	{
		$this->common_model->set_table('roles');
		if($this->data["id"]) // in case edit
		{
			$where = array(
				'name' => $name,
				'id !=' => $this->data["id"]
			);
		}
		else // in case insert
		{
			$where = array(
				'name' => $name
			);
		}

		if($this->common_model->get_row($where))
		{
			$this->form_validation->set_message('chk_role_name_duplicate', 'Tên nhóm quản trị này đã có! Vui lòng nhập tên khác.');
			return FALSE;
		}

		return TRUE;
	}
}