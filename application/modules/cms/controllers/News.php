<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {

	function __construct() {

		$this->set_auth(TRUE);

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "CMS - News management";
        $this->data["description"] = SITE_NAME;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "News management";

        // check permissions
		$this->chk_permission();

		// get username
		$this->data["user_name"] = $this->get_username();

		// limit per page
		$this->limit = 10;

		// upload directory
		$this->out_img_dir = "upload/news/";
	}

	public function index() {
		$jump_url = site_url("cms/news/search");
		header("Location: $jump_url");
		return false;
	}

	/**
	 *
	 * List news
	 * @return void
	 *
	 */
	public function search()
	{
		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "content";
		$this->data['submenu_active'] = "news";

		// offset
		$offset = $this->security_clean($this->input->get('page'));
		if($offset)
		{
			$offset = intval($offset - 1);
		}

		/* 
		 * Filter
		 * id: find news by id
		 * title: find news by title
		 */
		$where = array();
		$id = $this->security_clean(isset($_GET["id"]) ? $_GET["id"] : '');
		if($id > 0)
		{
			$where["news.id"] = $id;
		}

		$title = $this->security_clean(isset($_GET["title"]) ? $_GET["title"] : '');
		if($title)
		{
			$where["news.title LIKE '%$title%'"] = NULL;
		}

		// get list news
		$this->data['list_news'] = $this->common_model->get_all_news($where, 'created DESC, id DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_news($where);

		// generate pagination
		$path = "cms/news/search?id=".$id."&title=".$title;
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 4, TRUE);

		// meta title
		if ($offset && !empty($this->data['list_news'])){
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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/news/search") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/news/search/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("cms/news/search/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('news/search', $this->data);
	}

	/**
	 * Add new or edit a news
	 * @param id integer (NULL: add; !=NULL: edit)
	 * @return void
	 */
	public function form()
	{
		// menu active
		$this->data['menu_active'] = "content";
		$this->data['submenu_active'] = "news";
		
		// get news id 
		$this->data["id"] = $this->security_clean($this->uri->segment(4, 0));

		// page title
		if ($this->data["id"])
		{
			$this->data["page_title"] = "Chỉnh sửa thông tin tin tức";
		}
		else
		{
			$this->data["page_title"] = "Thêm tin tức mới";
		}

		// prepare news information
		if($this->data["id"])
		{
			$this->data["news"] = $this->common_model->get_news_by_id($this->data["id"]);
			if(!$this->data["news"])
			{
				$this->session->set_flashdata("error", "Tin tức không tồn tại!");
                redirect("cms/news/search");
			}
		}
		else
		{
			$this->data["news"] = array(
				'title' => '',
				'intro' => '',
				'content' => '',
				'image_link' => '',
				'meta_key' => '',
				'meta_desc' => '',
				'feature' => ''
			);
		}

		// form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Tên', 'trim|required|xss_clean');
		$this->form_validation->set_rules('intro', 'Mô tả ngắn', 'trim|xss_clean');
		$this->form_validation->set_rules('content', 'Nội dung', 'trim|xss_clean');
		$this->form_validation->set_rules('image_link', 'Ảnh đại diện', 'trim|xss_clean');
		$this->form_validation->set_rules('meta_key', 'Meta key', 'trim|xss_clean');
		$this->form_validation->set_rules('meta_desc', 'Meta description', 'trim|xss_clean');
		$this->form_validation->set_rules('feature', 'Nổi bật', 'trim|xss_clean');

		if($this->form_validation->run())
		{
			// prepare user data
			$upd_data = array(
				'title' => $this->security_clean(set_value('title')),
				'intro' => htmlspecialchars($this->security_clean(set_value('intro'))),
				'content' => htmlspecialchars_decode($this->security_clean(set_value('content'))),
				'meta_key' => htmlspecialchars($this->security_clean(set_value('meta_key'))),
				'meta_desc' => htmlspecialchars($this->security_clean(set_value('meta_desc'))),
				'feature' => $this->security_clean(set_value('feature')),
			);

			// insert data into table news
			$message = "";
			$this->common_model->set_table('news');
			if($this->data["id"]) // in case update
			{
				if($this->common_model->update($upd_data, array('id' => $this->data["id"])))
				{
					$message = "Cập nhật tin tức thành công!";
				}
				else 
				{
					$message = "Cập nhật thất bại!";
				}
			}
			else // in case insert
			{
				$upd_data['created'] = date('Y-m-d H:i:s', time());
				if($this->data["id"] = $this->common_model->insert($upd_data))
				{
					$message = "Thêm mới tin tức thành công!";
				}
				else
				{
					$message = "Thêm mới tin tức thất bại!";
				}
			}

			// load library upload
			$this->load->library("Upload_library");

			// upload image link
			$image_link = $this->input->post("image_link_news");
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
            redirect("cms/news/search");
		} 
		else 
		{
			// load view
			$this->load_view('news/form', $this->data);
		}
	}

	/**
	 *
	 * Delete a news by news_id
	 * @param  integer news_id
	 * @return boolean
	 *
	 */
	public function del()
	{
		$news_id = $this->security_clean($this->uri->segment(4, 0));
		if(is_numeric($news_id) && $news_id)
		{
			$news = $this->common_model->get_news_by_id($news_id);
			if($news)
			{
				// delete news
				$this->common_model->set_table('news');
				$del_flag = $this->common_model->delete(array('id' => $news_id));
				if($del_flag)
				{
					$message = "Xóa tin tức thành công!";
					$this->session->set_flashdata("message", $message);
            		redirect("cms/news");
					return TRUE;
				}
				else // in case no data
				{
					define('RETURN_URL', site_url("cms/news"));
					$this->message("Không có dữ liệu!");
					return FALSE;
				}
			}
			else // in case news doesn't exists
			{
				define('RETURN_URL', site_url("cms/news"));
				$this->message("Tin tức không tồn tại!");
				return FALSE;
			}
		}
		else // in case news_id isn't integer or empty
		{
			define('RETURN_URL', site_url("cms/news"));
			$this->message("Truy cập bị từ chối!");
			return FALSE;
		}
	}

	/**
	 *
	 * Delete multi news by list news_id
	 * @param  array news_ids
	 * @return boolean
	 *
	 */
	public function del_all()
	{
		// status flag
		$status = FALSE;

		// get list news_id
		$news_ids = $this->security_clean($this->input->post('ids'));
		
		if ($news_ids)
		{
			$news_ids = implode(",", $news_ids);

			$this->common_model->set_table('news');
			$del_flag = $this->common_model->delete(array("id IN({$news_ids})" => NULL));
			if($del_flag)
			{
				$status = TRUE;
			}
		}
		return $status;
	}

	/**
	 *
	 * Delete news image
	 * @param  integer news_id
	 * @return void
	 *
	 */
	public function photo_del()
	{
		// get news id
		$news_id = $this->security_clean($this->uri->segment(4, 0));
		if (!$news_id) {
            $this->session->set_flashdata("error", "Có lỗi xảy ra!");
            redirect("cms/news/search");
        }

        // check exists of news
        $this->common_model->set_table("news");
        $news = $this->common_model->get_row(array("id" => $news_id));
        if (!$news) {
            $this->session->set_flashdata("error", "Tin tức không tồn tại!");
            redirect("cms/news/search");
        }

        // delete image
        $file_dir = FCPATH.$this->out_img_dir;
        $file_name = $file_dir.$news["image_link"];
        if (file_exists($file_name)) {
            unlink($file_name);
        }
        $upd_data = array(
            "image_link" => ''
        );
        $this->common_model->update($upd_data, array("id" => $news_id));
        
        $this->session->set_flashdata("message", "Xóa hình ảnh thành công!");
        redirect("cms/news/form/".$news_id);
	}
}