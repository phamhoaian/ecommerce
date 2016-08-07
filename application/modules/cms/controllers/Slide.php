<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slide extends MY_Controller {

	function __construct() {

		$this->set_auth(TRUE);

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "CMS - Slide management";
        $this->data["description"] = SITE_NAME;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Slide management";

        // check permissions
		$this->chk_permission();

		// get username
		$this->data["user_name"] = $this->get_username();

		// limit per page
		$this->limit = 10;

		// upload directory
		$this->out_img_dir = "upload/slide/";
	}

	public function index() {
		$jump_url = site_url("cms/slide/search");
		header("Location: $jump_url");
		return false;
	}

	/**
	 *
	 * List slide
	 * @return void
	 *
	 */
	public function search()
	{
		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "content";
		$this->data['submenu_active'] = "slide";

		// offset
		$offset = $this->security_clean($this->uri->segment(4, 0));

		// get list slide
		$this->data['list_slide'] = $this->common_model->get_all_slide(NULL, 'sort_order ASC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_slide(NULL);

		// generate pagination
		$path = "cms/slide/search";
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 4, TRUE);

		// meta title
		if ($offset && !empty($this->data['list_slide'])){
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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/slide/search") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/slide/search/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("cms/slide/search/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('slide/search', $this->data);
	}

	/**
	 * Add new or edit a slide
	 * @param id integer (NULL: add; !=NULL: edit)
	 * @return void
	 */
	public function form()
	{
		// menu active
		$this->data['menu_active'] = "content";
		$this->data['submenu_active'] = "slide";
		
		// get slide id 
		$this->data["id"] = $this->security_clean($this->uri->segment(4, 0));

		// page title
		if ($this->data["id"])
		{
			$this->data["page_title"] = "Chỉnh sửa thông tin slide";
		}
		else
		{
			$this->data["page_title"] = "Thêm slide mới";
		}

		// prepare slide information
		if($this->data["id"])
		{
			$this->data["slide"] = $this->common_model->get_slide_by_id($this->data["id"]);
			if(!$this->data["slide"])
			{
				$this->session->set_flashdata("error", "Slide không tồn tại!");
                redirect("cms/slide/search");
			}
		}
		else
		{
			$this->data["slide"] = array(
				'name' => '',
				'image_name' => '',
				'image_link' => '',
				'link' => '',
				'info' => '',
				'sort_order' => ''
			);
		}

		// form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Tên slide', 'trim|required|xss_clean');
		$this->form_validation->set_rules('image_name', 'Tên ảnh', 'trim|xss_clean');
		$this->form_validation->set_rules('image_link', 'Hình ảnh', 'trim|xss_clean');
		$this->form_validation->set_rules('link', 'Link', 'trim|xss_clean');
		$this->form_validation->set_rules('info', 'Thông tin', 'trim|xss_clean');
		$this->form_validation->set_rules('sort_order', 'Thứ tự hiển thị', 'trim|xss_clean');

		if($this->form_validation->run())
		{
			// prepare slide data
			$upd_data = array(
				'name' => $this->security_clean(set_value('name')),
				'image_name' => $this->security_clean(set_value('image_name')),
				'link' => $this->security_clean(set_value('link')),
				'info' => $this->security_clean(set_value('info')),
				'sort_order' => $this->security_clean(set_value('sort_order'))
			);

			// insert data into table slide
			$message = "";
			$this->common_model->set_table('slide');
			if($this->data["id"]) // in case update
			{
				if($this->common_model->update($upd_data, array('id' => $this->data["id"])))
				{
					$message = "Cập nhật slide thành công!";
				}
				else 
				{
					$message = "Cập nhật thất bại!";
				}
			}
			else // in case insert
			{
				if($this->data["id"] = $this->common_model->insert($upd_data))
				{
					$message = "Thêm mới slide thành công!";
				}
				else
				{
					$message = "Thêm mới slide thất bại!";
				}
			}

			// load library upload
			$this->load->library("Upload_library");

			// upload image link
			$image_link = $this->input->post("image_link_slide");
            if (!empty($_FILES['image']['name'])) {
                $image_link = $this->upload_library->upload($this->out_img_dir, "image");
                if (isset($image_link["file_name"]) && $image_link["file_name"])
                {
                	$image_link = $image_link["file_name"];
                }
                else
                {
                	$this->session->set_flashdata("error", $image_link["error"]);
                	$image_link = '';
                }
            }

            $upd_data = array(
                "image_link" => $image_link
            );
            $this->common_model->update($upd_data, array('id' => $this->data["id"]));
			$this->session->set_flashdata("message", $message);
            redirect("cms/slide/search");
		} 
		else 
		{
			// load view
			$this->load_view('slide/form', $this->data);
		}
	}

	/**
	 *
	 * Delete a slide by slide_id
	 * @param  integer slide_id
	 * @return boolean
	 *
	 */
	public function del()
	{
		$slide_id = $this->security_clean($this->uri->segment(4, 0));
		if(is_numeric($slide_id) && $slide_id)
		{
			$slide = $this->common_model->get_slide_by_id($slide_id);
			if($slide)
			{
				// delete slide
				$this->common_model->set_table('slide');
				$del_flag = $this->common_model->delete(array('id' => $slide_id));
				if($del_flag)
				{
					$message = "Xóa slide thành công!";
					$this->session->set_flashdata("message", $message);
            		redirect("cms/slide");
					return TRUE;
				}
				else // in case no data
				{
					define('RETURN_URL', site_url("cms/slide"));
					$this->message("Không có dữ liệu!");
					return FALSE;
				}
			}
			else // in case slide doesn't exists
			{
				define('RETURN_URL', site_url("cms/slide"));
				$this->message("Slide không tồn tại!");
				return FALSE;
			}
		}
		else // in case slide_id isn't integer or empty
		{
			define('RETURN_URL', site_url("cms/slide"));
			$this->message("Truy cập bị từ chối!");
			return FALSE;
		}
	}

	/**
	 *
	 * Delete slide image
	 * @param  integer slide_id
	 * @return void
	 *
	 */
	public function photo_del()
	{
		// get slide id
		$slide_id = $this->security_clean($this->uri->segment(4, 0));
		if (!$slide_id) {
            $this->session->set_flashdata("error", "Có lỗi xảy ra!");
            redirect("cms/slide/search");
        }

        // check exists of slide
        $this->common_model->set_table("slide");
        $slide = $this->common_model->get_row(array("id" => $slide_id));
        if (!$slide) {
            $this->session->set_flashdata("error", "Slide không tồn tại!");
            redirect("cms/slide/search");
        }

        // delete image
        $file_dir = FCPATH.$this->out_img_dir;
        $file_name = $file_dir.$slide["image_link"];
        if (file_exists($file_name)) {
            unlink($file_name);
        }
        $upd_data = array(
            "image_link" => ''
        );
        $this->common_model->update($upd_data, array("id" => $slide_id));
        
        $this->session->set_flashdata("message", "Xóa hình ảnh thành công!");
        redirect("cms/slide/form/".$slide_id);
	}
}