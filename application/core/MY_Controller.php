<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $is_cache = FALSE;

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
}	