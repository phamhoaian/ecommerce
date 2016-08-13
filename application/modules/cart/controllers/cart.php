<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller {

	function __construct() {
		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // load library
        $this->load->library('cart');

        // meta title, description
        $this->data["title"] = "Giỏ hàng";
        $this->data["description"] = SITE_NAME;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Trang chủ";
        $this->position['item'][0]['url'] = site_url();
        $this->position['item'][1]['title'] = "Giỏ hàng";
	}

	/** 
	 * Display all items in cart
	 * @return void
	 */
	public function index()
	{
		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// get cart information
		$this->data["carts"] = $this->cart->contents();

		// load view
		$this->load_view('top', $this->data);
	}

	/**
	 * Add a item into cart
	 * @param integer $product_id
	 * @return void
	 */
	public function add()
	{
		// get product_id
		$product_id = $this->security_clean($this->uri->segment(3,0));
		if (!$product_id || !is_numeric($product_id))
		{
			redirect();
		}

		// check exists of product
		$product = $this->common_model->get_product_by_id($product_id);
		if (!$product)
		{
			redirect();
		}

		// prepare data
		$price = $product["price"];
		if ($product["discount"] > 0)
		{
			$price = (int) $product["price"] - $product["discount"];
		}
		$data = array(
			'id' 			=> $product["id"],
			'qty'			=> 1,
			'name'			=> url_title($product["name"]),
			'price'			=> $price,
			'image_link'	=> $product["image_link"]
		);

		// add product into cart
		$this->cart->insert($data);
		redirect("cart");
	}

	/** 
	 * Update cart
	 * @return void
	 */
	public function update()
	{
		// get cart information
		$this->data["carts"] = $this->cart->contents();

		foreach ($this->data["carts"] as $key => $row) {
			$total_qty = $this->input->post('qty_'.$row["id"]);
			$data = array();
			$data["rowid"] = $key;
			$data["qty"] = $total_qty;
			$this->cart->update($data);
		}

		redirect("cart");
	}

	/** 
	 * Delete item in cart
	 * @param string $rowid (NULL: delete all items)
	 * @return void
	 */
	public function del()
	{
		$rowid = $this->security_clean($this->uri->segment(3,0));
		if ($rowid)
		{
			$this->cart->remove($rowid);
		}
		else
		{
			$this->cart->destroy();
		}

		redirect("cart");
	}
}