<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

	function __construct() {

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "Đặt hàng";
        $this->data["description"] = SITE_NAME;

        // limit per page
        $this->limit = 9;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Trang chủ";
        $this->position['item'][0]['url'] = site_url();
        $this->position['item'][1]['title'] = "Đặt hàng";
	}

	public function checkout()
	{
		// menu active
		$this->data['menu_active'] = "home";

		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// get cart information
		$this->data["carts"] = $this->cart->contents();
		if(!$this->data["carts"])
		{
			redirect();
		}

		// get user's information logged in
		$user_id = $this->get_user_id();

		// get total amount
		$total_amount = 0;
		foreach ($this->data["carts"] as $row) {
			$total_amount += $row["subtotal"];
		}

		// form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Tên', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('phone', 'SĐT', 'trim|required|integer');
		$this->form_validation->set_rules('payment', 'Phương thức thanh toán', 'trim|required');
		$this->form_validation->set_rules('message', 'Ghi chú', 'trim|max_lenght[50]');

		if($this->form_validation->run())
		{
			// prepare data transaction
			$upd_data = array(
				'user_id'		=> $user_id,
				'user_name'		=> $this->security_clean(set_value('name')),
				'user_email'	=> $this->security_clean(set_value('email')),
				'user_phone'	=> $this->security_clean(set_value('phone')),
				'payment'		=> $this->security_clean(set_value('payment')),
				'message'		=> $this->security_clean(set_value('message')),
				'status'		=> 0, // transaction not yet review
				'created'		=> date('Y-m-d H:i:s', time()),
				'amount' 		=> $total_amount
			);

			// insert data into transaction
			$this->common_model->set_table("transaction");
			$transaction_id = $this->common_model->insert($upd_data);

			// insert data into order
			$this->common_model->set_table("order");
			foreach ($this->data["carts"] as $row) {
				$upd_data = array(
					'transaction_id'	=> $transaction_id,
					'product_id'		=> $row["id"],
					'qty'				=> $row["qty"],
					'amount'			=> $row["price"]
				);
				$this->common_model->insert($upd_data);
			}

			// destroy cart
			$this->cart->destroy();

			// message
			$this->session->set_flashdata("message", "Bạn đã đặt hàng thành công. Chúng tôi sẽ kiểm tra và liên hệ sớm.");

			// redirect to home page
			redirect();
		}

		// load view
		$this->load_view('checkout', $this->data);
	}
}