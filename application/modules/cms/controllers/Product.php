<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	function __construct() {

		$this->set_auth(TRUE);

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "CMS - Product management";
        $this->data["description"] = SITE_NAME;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Product management";

        // check permissions
		$this->chk_permission();

		// get username
		$this->data["user_name"] = $this->get_username();

		// limit per page
		$this->limit = 10;

		// upload directory
		$this->out_img_dir = "upload/product/";
	}

	public function index() {
		$jump_url = site_url("cms/product/search");
		header("Location: $jump_url");
		return false;
	}

	/**
	 *
	 * List product
	 * @return void
	 *
	 */
	public function search()
	{
		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "product";
		$this->data['submenu_active'] = "product";

		// offset
		$offset = $this->security_clean($this->input->get('page'));
		if($offset)
		{
			$offset = intval($offset - 1);
		}

		// get list categories
		$this->data['list_categories'] = $this->common_model->get_all_categories(array('parent_id' => 0), 'id ASC');
		if($this->data['list_categories'])
		{
			foreach ($this->data['list_categories'] as &$row) {
				$row['child'] = $this->common_model->get_all_categories(array('parent_id' => $row['id']), 'id ASC');
			}
		}

		/* 
		 * Filter
		 * id: find product by id
		 * name: find product by name
		 * cat_id: find product belong category
		 */
		$where = array();
		$id = $this->security_clean(isset($_GET["id"]) ? $_GET["id"] : '');
		if($id > 0)
		{
			$where["product.id"] = $id;
		}

		$name = $this->security_clean(isset($_GET["name"]) ? $_GET["name"] : '');
		if($name)
		{
			$where["product.name LIKE '%$name%'"] = NULL;
		}

		$cat_id = $this->security_clean(isset($_GET["categories"]) ? $_GET["categories"] : '');
		if($cat_id > 0)
		{
			$where["product.cat_id"] = $cat_id;
		}

		// get list product
		$this->data['list_product'] = $this->common_model->get_all_product($where, 'id DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_product($where);

		// generate pagination
		$path = "cms/product/search?id=".$id."&name=".$name."&categories=".$cat_id;
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 4, TRUE);

		// meta title
		if ($offset && !empty($this->data['list_product'])){
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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/product/search") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("cms/product/search/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("cms/product/search/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('product/search', $this->data);
	}

	/**
	 * Add new or edit a product
	 * @param id integer (NULL: add; !=NULL: edit)
	 * @return void
	 */
	public function form()
	{
		// menu active
		$this->data['menu_active'] = "product";
		$this->data['submenu_active'] = "product";
		
		// get product id 
		$this->data["id"] = $this->security_clean($this->uri->segment(4, 0));

		// page title
		if ($this->data["id"])
		{
			$this->data["page_title"] = "Chỉnh sửa thông tin sản phẩm";
		}
		else
		{
			$this->data["page_title"] = "Thêm sản phẩm mới";
		}

		// prepare product information
		if($this->data["id"])
		{
			$this->data["product"] = $this->common_model->get_product_by_id($this->data["id"]);
			if(!$this->data["product"])
			{
				$this->session->set_flashdata("error", "Sản phẩm không tồn tại!");
                redirect("cms/product/search");
			}
		}
		else
		{
			$this->data["product"] = array(
				'name' => '',
				'cat_id' => '',
				'maker_id' => '',
				'price' => '',
				'content' => '',
				'discount' => '',
				'image_link' => '',
				'image_list' => '',
				'site_title' => '',
				'warranty' => '',
				'gifts' => '',
				'video' => '',
				'feature' => '',
				'meta_key' => '',
				'meta_desc' => '',
				'created' => ''
			);
		}

		// get list categories
		$this->data['list_categories'] = $this->common_model->get_all_categories(array('parent_id' => 0), 'id ASC');
		if($this->data['list_categories'])
		{
			foreach ($this->data['list_categories'] as &$row) {
				$row['child'] = $this->common_model->get_all_categories(array('parent_id' => $row['id']), 'id ASC');
			}
		}

		// form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Tên', 'trim|required|xss_clean|callback_chk_product_name_duplicate');
		$this->form_validation->set_rules('cat_id', 'Thể loại', 'trim|required|xss_clean');
		$this->form_validation->set_rules('maker_id', 'Nhà sản xuất', 'trim|xss_clean');
		$this->form_validation->set_rules('price', 'Giá', 'trim|required|xss_clean');
		$this->form_validation->set_rules('content', 'Mô tả', 'trim|xss_clean');
		$this->form_validation->set_rules('discount', 'Giảm giá', 'trim|xss_clean');
		$this->form_validation->set_rules('image_link', 'Ảnh đại diện', 'trim|xss_clean');
		$this->form_validation->set_rules('image_list', 'Ảnh kèm theo', 'trim|xss_clean');
		$this->form_validation->set_rules('site_title', 'Tiêu đề trang', 'trim|xss_clean');
		$this->form_validation->set_rules('warranty', 'Bảo hành', 'trim|xss_clean');
		$this->form_validation->set_rules('gifts', 'Quà tặng', 'trim|xss_clean');
		$this->form_validation->set_rules('video', 'Video', 'trim|xss_clean');
		$this->form_validation->set_rules('feature', 'Nổi bật', 'trim|xss_clean');
		$this->form_validation->set_rules('meta_key', 'Meta key', 'trim|xss_clean');
		$this->form_validation->set_rules('meta_desc', 'Meta description', 'trim|xss_clean');
		$this->form_validation->set_rules('created', 'Ngày tạo', 'trim|xss_clean');

		if($this->form_validation->run())
		{
			// prepare user data
			$upd_data = array(
				'name' => $this->security_clean(set_value('name')),
				'cat_id' => intval($this->security_clean(set_value('cat_id'))),
				'maker_id' => intval($this->security_clean(set_value('maker_id'))),
				'price' => $this->security_clean(str_replace(',', '', set_value('price'))),
				'content' => htmlspecialchars($this->security_clean(set_value('content'))),
				'discount' => $this->security_clean(set_value('discount')),
				'site_title' => $this->security_clean(set_value('site_title')),
				'warranty' => $this->security_clean(set_value('warranty')),
				'gifts' => $this->security_clean(set_value('gifts')),
				'video' => $this->security_clean(set_value('video')),
				'feature' => $this->security_clean(set_value('feature')),
				'meta_key' => htmlspecialchars($this->security_clean(set_value('meta_key'))),
				'meta_desc' => htmlspecialchars($this->security_clean(set_value('meta_desc')))
			);

			// insert data into table product
			$message = "";
			$this->common_model->set_table('product');
			if($this->data["id"]) // in case update
			{
				if($this->common_model->update($upd_data, array('id' => $this->data["id"])))
				{
					$message = "Cập nhật thông tin sản phẩm thành công!";
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
					$message = "Thêm mới sản phẩm thành công!";
				}
				else
				{
					$message = "Thêm mới sản phẩm thất bại!";
				}
			}

			// load library upload
			$this->load->library("Upload_library");

			// upload image link
			$image_link = $this->input->post("image_link_product");
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

            // upload image list
			$image_list = $this->input->post("image_list_product");
			$image_list_json = array();
			if($image_list)
			{
				$image_list_json = json_decode($image_list, TRUE);
			}
            if (!empty($_FILES['image_list']['name'])) {
                $image_upload = $this->upload_library->upload_multi($this->out_img_dir, "image_list");
                $image_list = array_merge($image_list_json, $image_upload);
                $image_list = json_encode($image_list);
            }

            $upd_data = array(
                "image_list" => $image_list
            );
            $this->common_model->update($upd_data, array('id' => $this->data["id"]));

			$this->session->set_flashdata("message", $message);
            redirect("cms/product/search");
		} 
		else 
		{
			// load view
			$this->load_view('product/form', $this->data);
		}
	}

	/**
	 *
	 * Delete a product by product_id
	 * @param  integer product_id
	 * @return boolean
	 *
	 */
	public function del()
	{
		$product_id = $this->security_clean($this->uri->segment(4, 0));
		if(is_numeric($product_id) && $product_id)
		{
			$product = $this->common_model->get_product_by_id($product_id);
			if($product)
			{
				// delete product
				$this->common_model->set_table('product');
				$del_flag = $this->common_model->delete(array('id' => $product_id));
				if($del_flag)
				{
					$message = "Xóa sản phẩm thành công!";
					$this->session->set_flashdata("message", $message);
            		redirect("cms/product");
					return TRUE;
				}
				else // in case no data
				{
					define('RETURN_URL', site_url("cms/product"));
					$this->message("Không có dữ liệu!");
					return FALSE;
				}
			}
			else // in case product doesn't exists
			{
				define('RETURN_URL', site_url("cms/product"));
				$this->message("Sản phẩm không tồn tại!");
				return FALSE;
			}
		}
		else // in case product_id isn't integer or empty
		{
			define('RETURN_URL', site_url("cms/product"));
			$this->message("Truy cập bị từ chối!");
			return FALSE;
		}
	}

	/**
	 *
	 * Delete multi categories by list product_id
	 * @param  array product_ids
	 * @return boolean
	 *
	 */
	public function del_all()
	{
		// status flag
		$status = FALSE;

		// get list product_id
		$product_ids = $this->security_clean($this->input->post('ids'));
		
		if ($product_ids)
		{
			$product_ids = implode(",", $product_ids);

			$this->common_model->set_table('product');
			$del_flag = $this->common_model->delete(array("id IN({$product_ids})" => NULL));
			if($del_flag)
			{
				$status = TRUE;
			}
		}
		return $status;
	}

	/**
	 *
	 * Delete product image
	 * @param  integer product_id
	 * @return void
	 *
	 */
	public function photo_del()
	{
		// get product id
		$product_id = $this->security_clean($this->uri->segment(4, 0));
		if (!$product_id) {
            $this->session->set_flashdata("error", "Có lỗi xảy ra!");
            redirect("cms/product/search");
        }

        // check exists of product
        $this->common_model->set_table("product");
        $product = $this->common_model->get_row(array("id" => $product_id));
        if (!$product) {
            $this->session->set_flashdata("error", "Sản phẩm không tồn tại!");
            redirect("cms/product/search");
        }

        // delete image
        $file_dir = FCPATH.$this->out_img_dir;
        $file_name = $file_dir.$product["image_link"];
        if (file_exists($file_name)) {
            unlink($file_name);
        }
        $upd_data = array(
            "image_link" => ''
        );
        $this->common_model->update($upd_data, array("id" => $product_id));
        
        $this->session->set_flashdata("message", "Xóa hình ảnh sản phẩm thành công!");
        redirect("cms/product/form/".$product_id);
	}

	/**
	 *
	 * Delete product image list
	 * @param  string image_name
	 * @return void
	 *
	 */
	public function photo_list_del()
	{
		// get product_id
		$product_id = $this->security_clean($this->uri->segment(4, 0));
		// get image_name
		$image_name = $this->security_clean($this->uri->segment(5, 0));
		if (!$product_id || !$image_name) {
            $this->session->set_flashdata("error", "Có lỗi xảy ra!");
            redirect("cms/product/search");
        }

        // check exists of product
        $this->common_model->set_table("product");
        $product = $this->common_model->get_row(array("id" => $product_id));
        if (!$product) {
            $this->session->set_flashdata("error", "Sản phẩm không tồn tại!");
            redirect("cms/product/search");
        }

        // delete image
        $file_dir = FCPATH.$this->out_img_dir;
        $file_name = $file_dir.$image_name;
        if (file_exists($file_name)) {
            unlink($file_name);
        }

        $image_list = json_decode($product["image_list"], TRUE);
        foreach ($image_list as $key => $value) {
		    if ($image_name == $value) {
		        unset($image_list[$key]);
		    }
		}
		$image_list = json_encode($image_list);

		// upload database
        $upd_data = array(
            "image_list" => $image_list
        );
        $this->common_model->update($upd_data, array("id" => $product_id));
        
        $this->session->set_flashdata("message", "Xóa ảnh thành công!");
        redirect("cms/product/form/".$product_id);
	}

	/**
	 *
	 * Check product name duplicate
	 * @param string @name
	 * @return boolean
	 *
	 */
	public function chk_product_name_duplicate($name)
	{
		$this->common_model->set_table('product');
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
			$this->form_validation->set_message('chk_product_name_duplicate', 'Tên sản phẩm này đã có! Vui lòng nhập tên khác.');
			return FALSE;
		}

		return TRUE;
	}
}