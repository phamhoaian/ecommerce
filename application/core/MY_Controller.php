<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $is_cache = FALSE;

	protected $is_auth = FALSE;
	protected $is_bench = FALSE;

	private $cache_id = '';
	private $cache_group = '';
	protected $cache_output ='';
	private $cache_lifetime;

	public $css = "";
	public $js = "";
	public $js_foot = "";

	function __construct(){
		parent::__construct();

		// load config main
		$this->config->load('config_main', TRUE);

		// autoload helper
		$this->load->helper(array('url','path','form','main'));

		$this->init_APP();
	}

	/**
	* Initial Set-up
	*/
	private function init_APP()
	{
		// set default base_url()
		if( ! $this->config->config['base_url'] )
		{
			$this->config->config['base_url'] = $this->config->base_url();
		}

		// set authentication
		if ($this->is_auth)
		{
			$this->initialize_auth();
			$this->chk_auth();
		}
		$this->_url = current_url();

		// enable benchmark
		if($this->is_bench)
		{
			$this->output->enable_profiler(TRUE);
		}

		// seperate between cms and user side
		$controller = $this->uri->segment(1);
		switch ($controller) {
			case 'cms':
				break;
			
			default:
				{
					// load database
        			$this->load->database();

        			// load library
        			$this->load->library("session");
        			$this->load->library('cart');
        
					// load model
        			$this->load->model('common_model');

        			// get list categories
        			$this->data['list_categories'] = $this->common_model->get_all_categories(array('parent_id' => 0), 'id DESC');
					if($this->data['list_categories'])
					{
						foreach ($this->data['list_categories'] as &$row) {
							$row['sub'] = $this->common_model->get_all_categories(array('parent_id' => $row['id']), 'sort_order ASC');
						}
					}

					// get latest news
					$this->data['latest_news'] = $this->common_model->get_all_news(array('created <=' => date('Y:m:d H:i:s', time())), 'created DESC', 5);

					// get total items in cart
					$this->data['total_items'] = (int) $this->cart->total_items();

					break;
				}
		}
	}

	/**
	*	Load master view
	*/
	public function load_view($view_name,$view_data='',$layout_flag='TRUE',$layout_name='layout')
	{
		
		$this->load->vars(array('header'=>$this->set_header()));
		
		$data['main'] = $this->load->view($view_name,$view_data,TRUE);
		
		$this->load->vars(array('css'=>"$this->css",'js'=>"$this->js",'js_foot'=>"$this->js_foot"));
		
		if($layout_flag)
		{
			$body = $this->load->view($layout_name,$data,TRUE,'layout_this');
		}
		else
		{
			$body = $data['main'];
		}
		$this->output($body);
	}

	public function set_header()
    {
		$header = '';
		header('Content-Type: text/html; charset=UTF-8');
		
		return $header;
	}

	public function output($output)
	{
		# キャッシュの処理
		if($this->is_cache and !$this->cache_output)
		{
			$this->save_cache($output);
		}
		
		$this->output->set_output($output);
		$this->output->_display();
		exit;
	}

	protected function save_cache($data)
	{
		if(!$this->cache_id)
		{
			return FALSE;
		}
		
		if($this->cache and $this->config->item('cache_flag', 'config_main'))
		{
			$this->cache->save( "$this->cache_id", $data, $this->cahche_lifetime);
		}
	}

	/**
	*  Load css file
	*/
	protected function set_css($css_name)
	{
		if ( !preg_match("/\.css$/", $css_name) )
		{
			$css_name = $css_name.'.css';
		}
		$this->css .= '<link rel="stylesheet" href="'.base_url().'public/css/'.$css_name.'" type="text/css" />'."\n";
	}
	
	
	/**
	*  Load javascript file
	*/
	protected function set_js($js_name)
	{
		if ( preg_match('/^(http?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $js_name)
				|| preg_match('/^\/\/.+/', $js_name)
		)
		{
            $this->js .= '<script type="text/javascript" src="' . $js_name . '"></script>' . "\n";
        }
		else if (!preg_match("/\.js$/", $js_name))
		{
			$js_name = $js_name . '.js';
			$this->js .= '<script type="text/javascript" src="' . base_url() . 'public/js/' . $js_name . '"></script>' . "\n";
			
		}
		else
		{
			$this->js .= '<script type="text/javascript" src="' . base_url() . 'public/js/' . $js_name . '"></script>' . "\n";
		}
	}
	
	
	/**
	*  Load javascript file in footer
	*/
	protected function set_js_foot($js_name)
	{
		if ( preg_match('/^(http?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $js_name)
				|| preg_match('/^\/\/.+/', $js_name)
		)
		{
            $this->js_foot .= '<script type="text/javascript" src="' . $js_name . '"></script>' . "\n";
        }
		else if (!preg_match("/\.js$/", $js_name))
		{
			$js_name = $js_name . '.js';
			$this->js_foot .= '<script type="text/javascript" src="' . base_url() . 'public/js/' . $js_name . '"></script>' . "\n";
			
		}
		else
		{
			$this->js_foot .= '<script type="text/javascript" src="' . base_url() . 'public/js/' . $js_name . '"></script>' . "\n";
		}
	}

	public function security_clean($q)
	{
		$this->load->helper('security');
		
		$q = str_replace( "\0", "", $q );
		$q = str_replace( '\0', "", $q );
		
		
		$q = xss_clean($q);
		
		$q = strip_image_tags($q);
		$q = encode_php_tags($q);
		$q = preg_replace(array("/select/si", "/delete/si", "/update/si", "/insert/si","/from/si","/alert/si","/\[removed\]/si","/script/si","/\*/si"), "", $q);
		
		return $q;
	}

	public function message($message, $view_data = '')
	{
        $data = $view_data;
		$data['main'] = $message;
		
		$body = $this->load_view('message', $data, TRUE);
		$this->output($body);
	}

	/**
	 * To set whether the value to display the benchmark
	 */
	protected function set_bench($bench)
	{
		$this->is_bench = $bench;
	}

	public function get_username($user_id = '')
	{
		if (!$this->_chk_auth())
		{
			return FALSE;
		}
		return $this->dx_auth->get_username();
	}

	/**
	* Page view limited by the authority
	*/
	protected function chk_permission($this_role='9')
	{
		if(!$this->is_auth)
		{
			return FALSE;
		}

		$this->load->library('DX_Auth');
		if (! $this->dx_auth->is_logged_in()){
			$this->session->set_userdata('next_segment', $this->_url);
		}
		$this->dx_auth->check_uri_permissions();
	}

	/**
	 * To set the value for the Auth check
	 * @param   bool true or false
	 * @access  private
	 * @return  void
	 */
	protected function set_auth($auth)
	{
		$this->is_auth = $auth;
	}

	/**
	 * Perform the Auth check
	 * @access  private
	 * @return  void
	 */
	protected function chk_auth()
	{
		if ( ! $this->_chk_auth())
		{
			$this->session->set_userdata('next_segment', $this->_url);
			$this->dx_auth->deny_access('login');
		}
	}
	
	#
	# Whether the authentication state?
	# Only returns TRUE or FALSE
	protected function chk_auth_pass()
	{
		if(!$this->is_auth)
		{
			$this->initialize_auth();
		}
		
		if ( $this->_chk_auth())
		{
			$this->is_auth = TRUE;
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		return FALSE;
	}
	
	/**
	* Authentication initialize setting
	*/ 
	protected function initialize_auth()
	{
		$this->load->library('session');
		$this->load->library('DX_Auth');
		$this->session_flag = TRUE;
	}

	/**
	 * Determines whether the authentication page
	 *
	 * @access  private
	 * @return  void
	 */
	protected function get_auth()
	{
		return $this->is_auth;
	}

	/**
	 * To verify the authentication
	 *
	 * @access  private
	 * @return  void
	 */
	private function _chk_auth()
	{
		if (! $this->dx_auth->is_logged_in()){
			return FALSE;
		}
		return TRUE;
	}

	/**
	* Get the user ID
	*/
	protected function get_user_id()
	{
		if(!$this->is_auth)
		{
			return FALSE;
		}
		
		if($this->user_id)
		{
			return $this->user_id;
		}
		else
		{
			$this->user_id = $this->dx_auth->get_user_id();
			return $this->user_id;
		}
	}

	/**
	 * Pagination settings
	 */
	public function generate_pagination($path, $total, $limit=10 , $uri_segment, $query_string = FALSE)
	{
		$this->load->library('pagination');
		# Specify the destination URL.
		$config['base_url']       = $this->config->site_url($path);
		# Specify the total number.
		$config['total_rows']     = $total;
		# Specify the number of items to be displayed on one page.
		$config['per_page']       = $limit;
		# Specify whether the page number information is included in any URI segment.
		$config['uri_segment']    = $uri_segment;
		# Specify query string
		$config['use_page_numbers'] = $query_string;
    	$config['page_query_string'] = $query_string;
    	$config['query_string_segment'] = 'page';
		# Specify generation link in the template.
		$config['first_link']     = 'Trang đầu';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link']      = 'Trang cuối';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['full_tag_open']  = '<ol class="pager">';
		$config['full_tag_close'] = '</ol>';
		$config['cur_tag_open'] = '<li class="disabled"><span>';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$config['next_link'] = 'Trang kế';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Trang trước';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		
		$config['num_links'] = 4;
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
}	