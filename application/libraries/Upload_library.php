<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Upload library
*/
class Upload_library
{
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('upload');
	}

	/**
	 * Upload file
	 * @param string $upload_path
	 * @param string $file_name
	 * @return array
	 */
	function upload($upload_path = '', $file_name)
	{
		// load configuration
		$config = $this->config($upload_path);
		$this->CI->upload->initialize($config);
		// upload file
		if ($this->CI->upload->do_upload($file_name))
		{
			$data = $this->CI->upload->data();
		}
		else
		{
			$data = $this->CI->upload->display_errors();
		}
		return $data;
	}

	/**
	 * Upload multiple file
	 * @param string $upload_path
	 * @param string $file_name
	 * @return array
	 */
	function upload_multi($upload_path = '', $file_name)
	{
		// load configuration
		$config = $this->config($upload_path);
		$this->CI->upload->initialize($config);

		// get total file upload
		$file = $_FILES[$file_name];
		$count = count($file["name"]);

		$image_list = array();
		for ($i=0; $i < $count; $i++) {
			$_FILES['userfile']['name']		= $file['name'][$i];
			$_FILES['userfile']['type']		= $file['type'][$i];
			$_FILES['userfile']['tmp_name']	= $file['tmp_name'][$i];
			$_FILES['userfile']['error']	= $file['error'][$i];
			$_FILES['userfile']['size']		= $file['size'][$i];

			// upload file
			if ($this->CI->upload->do_upload())
			{
				$data = $this->CI->upload->data();
			}
			else
			{
				$data = $this->CI->upload->display_errors();
			}
			$images_list[] = $data["file_name"];
		}
		
		return $images_list;
	}

	/**
	 * Configuration
	 * @param string $upload_path
	 * @return array
	 */
	function config($upload_path = '')
	{
		$config = array();
		// directory save file upload
		$config['upload_path'] 	= FCPATH.$upload_path;
		// overwrite if file exists
		$config['overwrite'] = TRUE;
		// file types allowed
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		// max size allowed
		$config['max_size']	= '5000';
		// max with allowed
		$config['max_width'] = '10240';
		// max height allowed
		$config['max_height']  = '7680';

		return $config;
	}
}