<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
	// Used for registering and changing password form validation
	var $min_username = 4;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;

	function __construct()
	{
		parent::__construct();
		
		// load library
		$this->load->library('Form_validation');
		$this->load->library('DX_Auth');
		
		// load helper
		$this->load->helper('url');
		$this->load->helper('form');

		// load model
		$this->load->model('auth_model');

		// load language
        $this->language = $this->config->item('language');
        $this->auth_lang = $this->lang->load("controller/auth", $this->language, TRUE);
	}
	
	function index()
	{
		$this->login();
	}
	
	/* Callback function */
	
	function username_check($username)
	{
		$result = $this->dx_auth->is_username_available($username);
		if ( ! $result)
		{
			$this->form_validation->set_message('username_check', $this->auth_lang['form_validation']['username_check']);
		}
				
		return $result;
	}

	function email_check($email)
	{
		$result = $this->dx_auth->is_email_available($email);
		if ( ! $result)
		{
			$this->form_validation->set_message('email_check', $this->auth_lang['form_validation']['email_check']);
		}
				
		return $result;
	}

	function captcha_check($code)
	{
		
		$result = TRUE;
		
		if ($this->dx_auth->is_captcha_expired())
		{
			// Will replace this error msg with $lang
			$this->form_validation->set_message('captcha_check', $this->auth_lang['form_validation']['captcha_expired']);			
			$result = FALSE;
		}
		elseif ( ! $this->dx_auth->is_captcha_match($code))
		{
			$this->form_validation->set_message('captcha_check', $this->auth_lang['form_validation']['captcha_not_match']);			
			$result = FALSE;
		}
		return $result;
	}

	
	function recaptcha_check()
	{
		$result = $this->dx_auth->is_recaptcha_match();		
		if ( ! $result)
		{
			$this->form_validation->set_message('recaptcha_check', $this->auth_lang['form_validation']['recaptcha_not_match']);
		}
		
		return $result;
	}
	
	/* End of Callback function */
	
	
	function login()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_error_delimiters('<div class="clear"></div><div class="alert alert-danger">', '</div>');
			$val->set_rules('username', $this->auth_lang['login']['username'], 'trim|required');
			$val->set_rules('password', $this->auth_lang['login']['password'], 'trim|required');
			$val->set_rules('remember', $this->auth_lang['login']['remember'], 'integer');

			// Set captcha rules if login attempts exceed max attempts in config
			if ($this->dx_auth->is_max_login_attempts_exceeded())
			{
				$val->set_rules('captcha', $this->auth_lang['login']['captcha'], 'trim|required|callback_captcha_check');
			}
				
			if ($val->run() AND $this->dx_auth->login($val->set_value('username'), $val->set_value('password'), $val->set_value('remember')))
			{
				$user_id = $this->dx_auth->get_user_id();
				$user_permissions = $this->dx_auth->is_admin();

				if($user_id && $user_permissions) 
				{
					redirect("cms", 'location');
				}
				else 
				{
					$next_segment = $this->session->userdata('next_segment');
					$this->session->unset_userdata('next_segment');
					if(!$next_segment)
					{
						$next_segment = "home";
					}
					redirect("$next_segment", 'location');
				}
			}
			else
			{
				// Check if the user is failed logged in because user is banned user or not
				if ($this->dx_auth->is_banned())
				{
					// Redirect to banned uri
					$this->dx_auth->deny_access('banned');
				}
				else
				{						
					// Default is we don't show captcha until max login attempts eceeded
					$data['show_captcha'] = FALSE;
				
					// Show captcha if login attempts exceed max attempts in config
					if ($this->dx_auth->is_max_login_attempts_exceeded())
					{
						// Create catpcha						
						$this->dx_auth->captcha();
						
						// Set view data to show captcha on view file
						$data['show_captcha'] = TRUE;
					}
					
					// Load login page view
					$this->load_view($this->dx_auth->login_view, $data, TRUE);
				}
			}
		}
		else
		{
			$data['auth_message'] = $this->auth_lang['login']['already_logged_in'];
			$this->load_view($this->dx_auth->logged_in_view, $data, TRUE);
		}
	}
	
	function logout()
	{
		$this->dx_auth->logout();
		
		$data['auth_message'] = $this->auth_lang['logout']['logout_completed'];		
		$this->load_view($this->dx_auth->logout_view, $data, TRUE);
	}
	
	
	function register()
	{
		if ( ! $this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration)
		{	
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_error_delimiters('<div class="clear"></div><div class="alert alert-danger">', '</div>');
			$val->set_rules('username', $this->auth_lang['register']['username'], 'trim|required|min_length['.$this->min_username.']|max_length['.$this->max_username.']|callback_username_check|alpha_dash');
			$val->set_rules('password', $this->auth_lang['register']['password'], 'trim|required|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_password]');
			$val->set_rules('confirm_password', $this->auth_lang['register']['confirm_password'], 'trim|required');
			$val->set_rules('email', $this->auth_lang['register']['email'], 'trim|required|valid_email|callback_email_check');
			
			// Is registration using captcha
			if ($this->dx_auth->captcha_registration)
			{
				$val->set_rules('captcha', $this->auth_lang['register']['captcha'], 'trim|required|callback_captcha_check');
			}

			// Run form validation and register user if it's pass the validation
			if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email')))
			{	
				// Set success message accordingly
				if ($this->dx_auth->email_activation)
				{
					$data['auth_message'] = $this->auth_lang['register']['register_complete_email_activation'];
				}
				else
				{					
					$data['auth_message'] = $this->auth_lang['register']['register_complete'].anchor(site_url($this->dx_auth->login_uri), $this->auth_lang['activate']['login']);
				}
				
				// Load registration success page
				$this->load_view($this->dx_auth->register_success_view, $data, TRUE);
			}
			else
			{
				// Is registration using captcha
				if ($this->dx_auth->captcha_registration)
				{
					$this->dx_auth->captcha();										
				}

				// Load registration page
				$this->load_view($this->dx_auth->register_view, NULL, TRUE);
			}
		}
		elseif ( ! $this->dx_auth->allow_registration)
		{
			$data['auth_message'] = $this->auth_lang['register']['disable_registration'];
			$this->load_view($this->dx_auth->register_disabled_view, $data, TRUE);
		}
		else
		{
			$data['auth_message'] = $this->auth_lang['register']['logout_first'];
			$this->load_view($this->dx_auth->logged_in_view, $data, TRUE);
		}
	}
	
	function activate()
	{
		// Get key
		$key = $this->security_clean($this->uri->segment(3));

		if(!$key)
		{
			$this->message($this->auth_lang['activate']['no_key']);
		}

		if(!$user_tmp = $this->auth_model->get_one_user_temp_by_key($key)){
			$this->message($this->auth_lang['activate']['no_user_temp']);
		}

		$username = $user_tmp->username;

		// Activate user
		if ($this->dx_auth->activate($username, $key)) 
		{
			$data['auth_message'] = $this->auth_lang['activate']['activate_success'].anchor(site_url($this->dx_auth->login_uri), $this->auth_lang['activate']['login']);
			$this->load_view($this->dx_auth->activate_success_view, $data, TRUE);
		}
		else
		{
			$data['auth_message'] = $this->auth_lang['activate']['activate_failed'];
			$this->load_view($this->dx_auth->activate_failed_view, $data, TRUE);
		}
	}
	
	function forgot_password()
	{
		$val = $this->form_validation;
		
		// Set form validation rules
		$val->set_error_delimiters('<div class="clear"></div><div class="alert alert-danger">', '</div>');
		$val->set_rules('login', $this->auth_lang['forgot_password']['email'], 'trim|required');

		// Validate rules and call forgot password function
		if ($val->run() AND $this->dx_auth->forgot_password($val->set_value('login')))
		{
			$data['auth_message'] = $this->auth_lang['forgot_password']['forgot_password_success'];
			$this->load_view($this->dx_auth->forgot_password_success_view, $data, TRUE);
		}
		else
		{
			$this->load_view($this->dx_auth->forgot_password_view, NULL, TRUE);
		}
	}
	
	function reset_password()
	{
		// Get username and key
		$username = $this->uri->segment(3);
		$key = $this->uri->segment(4);

		// Reset password
		if ($this->dx_auth->reset_password($username, $key))
		{
			$data['auth_message'] = $this->auth_lang['reset_password']['reset_password_success'].anchor(site_url($this->dx_auth->login_uri), $this->auth_lang['reset_password']['login']);
			$this->load_view($this->dx_auth->reset_password_success_view, $data, TRUE);
		}
		else
		{
			$data['auth_message'] = $this->auth_lang['reset_password']['reset_password_failed'];
			$this->load_view($this->dx_auth->reset_password_failed_view, $data, TRUE);
		}
	}
	
	function change_password()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation
			$val->set_error_delimiters('<div class="clear"></div><div class="alert alert-danger">', '</div>');
			$val->set_rules('old_password', $this->auth_lang['change_password']['old_password'], 'trim|required|min_length['.$this->min_password.']|max_length['.$this->max_password.']');
			$val->set_rules('new_password', $this->auth_lang['change_password']['new_password'], 'trim|required|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_new_password]');
			$val->set_rules('confirm_new_password', $this->auth_lang['change_password']['confirm_new_password'], 'trim|required');
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password')))
			{
				$data['auth_message'] = $this->auth_lang['change_password']['change_password_completed'];
				$this->load_view($this->dx_auth->change_password_success_view, $data, TRUE);
			}
			else
			{
				$this->load_view($this->dx_auth->change_password_view, NULL, TRUE);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}	
	
	function cancel_account()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_error_delimiters('<div class="clear"></div><div class="alert alert-danger">', '</div>');
			$val->set_rules('password', $this->auth_lang['cancel_account']['password'], "trim|required");
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->cancel_account($val->set_value('password')))
			{
				// Redirect to homepage
				//redirect('', 'location');

				$this->message($this->auth_lang['cancel_account']['cancel_account_completed']);
				return FALSE;
			}
			else
			{
				$this->load_view($this->dx_auth->cancel_account_view, NULL, TRUE);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}

	function deny()
	{
		
		$data['auth_message'] = $this->auth_lang['deny']['access_denied'];
		$this->load_view($this->dx_auth->logout_view, $data, TRUE);
	}

	// Example how to get permissions you set permission in /backend/custom_permissions/
	function custom_permissions()
	{
		if ($this->dx_auth->is_logged_in())
		{
			echo 'My role: '.$this->dx_auth->get_role_name().'<br/>';
			echo 'My permission: <br/>';
			
			if ($this->dx_auth->get_permission_value('edit') != NULL AND $this->dx_auth->get_permission_value('edit'))
			{
				echo 'Edit is allowed';
			}
			else
			{
				echo 'Edit is not allowed';
			}
			
			echo '<br/>';
			
			if ($this->dx_auth->get_permission_value('delete') != NULL AND $this->dx_auth->get_permission_value('delete'))
			{
				echo 'Delete is allowed';
			}
			else
			{
				echo 'Delete is not allowed';
			}
		}
	}


}