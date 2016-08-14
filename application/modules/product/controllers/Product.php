<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	function __construct() {

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "Sản phẩm";
        $this->data["description"] = SITE_NAME;

        // limit per page
        $this->limit = 9;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Trang chủ";
        $this->position['item'][0]['url'] = site_url();
        $this->position['item'][1]['title'] = "Sản phẩm";
	}

	/**
	 * Display list latest product
	 * @return void
	 */
	public function index() {

		// menu active
		$this->data['menu_active'] = "product";

		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// offset
		$offset = $this->security_clean($this->uri->segment(3, 0));

		// get list product
		$this->data["list_product"] = $this->common_model->get_all_product(NULL, 'created DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_product();

		// generate pagination
		$path = $this->uri->segment(1, 0);
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 3, TRUE);

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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("product/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('top', $this->data);
	}

	/**
	 * Display list latest product by category
	 * @return void
	 */
	public function category() {

		// menu active
		$this->data['menu_active'] = "product";

		// category id
		$cat_id = $this->security_clean($this->uri->segment(3, 0));
		if (!$cat_id || !is_numeric($cat_id))
		{
            redirect();
		}

		$category = $this->common_model->get_category_by_id($cat_id);
		if (!$category)
		{
            redirect();
		}

		// offset
		$offset = $this->security_clean($this->uri->segment(4, 0));

		// breadcrumbs
		$this->position['item'][1]['url'] = site_url("product");
		$this->position['item'][2]['title'] = $category["name"];
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);		

		// get list product
		$this->data["list_product"] = $this->common_model->get_all_product(array("cat_id" => $cat_id), 'created DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_product(array("cat_id" => $cat_id));

		// generate pagination
		$path = $this->uri->segment(1, 0).$this->uri->segment(2, 0).$this->uri->segment(3, 0);
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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/category/".$cat_id) . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/category/".$cat_id . "/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("product/category/".$cat_id . "/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('top', $this->data);
	}

	/**
	 * Display product information detail
	 * @param integer $product_id
	 * @return void
	 */
	public function detail()
	{
		// load css and js
		$this->set_css("jqzoom_ev/css/jquery.jqzoom.css");
		$this->set_js("jquery/jqzoom_ev/jquery.jqzoom-core.js");
		$this->set_js("jquery/tivi/jwplayer.js");

		// get product_id
		$product_id = $this->security_clean($this->uri->segment(3,0));

		// check valid product_id
		if (!$product_id || !is_numeric($product_id))
		{
			redirect();
		}

		// check exists of product
		$this->data["product"] = $this->common_model->get_product_by_id($product_id);
		if (!$this->data["product"])
		{
			redirect();
		}

		// get category name
		$category = $this->common_model->get_category_by_id($this->data["product"]["cat_id"]);
		$this->data["product"]["cat_name"] = $category["name"];

		// relatest product
		$this->data["relatest_product"] = $this->common_model->get_all_product(array("product.id !=" => $product_id, "cat_id" => $this->data["product"]["cat_id"]), "RAND()", 3);

		// load view
		$this->load_view('detail', $this->data);
	}

	/**
	 * Search product by keyword
	 * @param string $keyword
	 * @return void
	 */
	public function search()
	{
		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "product";

		// offset
		$offset = $this->security_clean($this->input->get('page'));
		if($offset)
		{
			$offset = intval($offset - 1);
		}

		/* 
		 * Filter
		 * keyword: find product by name
		 */
		$where = array();
		$keyword = '';
		if ($this->uri->segment(3) === "auto")
		{
			$keyword = $this->security_clean($this->input->get('term'));
		}
		else
		{
			$keyword = $this->security_clean($this->input->get('keyword'));
		}
		$this->data["keyword"] = trim($keyword);

		if($keyword)
		{
			$where["product.name LIKE '%$keyword%'"] = NULL;
		}

		// get list product
		$this->data['list_product'] = $this->common_model->get_all_product($where, 'id DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_product($where);

		if ($this->uri->segment(3) === "auto")
		{
			$result = array();
			foreach ($this->data["list_product"] as $row) {
				$item = array();
				$item["id"] = $row["id"];
				$item["label"] = $row["name"];
				$item["value"] = $row["name"];
				$result[] = $item;
			}
			die(json_encode($result));
		}

		// generate pagination
		$path = "product/search?keyword=".$this->data["keyword"];
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 3, TRUE);

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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/search") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/search/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("product/search/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('search', $this->data);
	}

	/**
	 * Search product by price
	 * @param integer $price_from
	 * @param integer $price_to
	 * @return void
	 */
	public function search_price()
	{
		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "product";

		// offset
		$offset = $this->security_clean($this->input->get('page'));
		if($offset)
		{
			$offset = intval($offset - 1);
		}

		/* 
		 * Filter
		 * price_from: find product from specify price
		 * price_to: to specify price
		 */
		$where = array();
		$price_from = intval($this->security_clean($this->input->get('price_from')));
		$price_to = intval($this->security_clean($this->input->get('price_to')));
		if ($price_from > $price_to)
		{
			$tmp_price = $price_from;
			$price_from = $price_to;
			$price_to = $tmp_price;
		}
		if ($price_from > 0)
		{
			$where["product.price >="] = $price_from;
		}
		if ($price_to > 0)
		{
			$where["product.price <="] = $price_to;
		}
		$this->data["price_from_value"] = $price_from;
		$this->data["price_to_value"] = $price_to;

		// get list product
		$this->data['list_product'] = $this->common_model->get_all_product($where, 'id DESC', $this->limit, $offset);
		$this->data['count'] = $this->common_model->get_count_product($where);

		// generate pagination
		$path = "product/search_price?price_from=".$price_from."&price_to=".$price_to;
		$this->data['pagination'] = $this->generate_pagination($path, $this->data['count'], $this->limit, 3, TRUE);

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
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/search") . '" />' . "\n";
			} else {
				$this->data["link_rel"] .= '<link rel="prev" href="' . site_url("product/search/" . $tmp_offset) . '" />' . "\n";
			}
		}
		
		if ($this->data["count"] > ($offset + $this->limit)) {
			$tmp_offset = $offset + $this->limit;
			$this->data["link_rel"] .= '<link rel="next" href="' . site_url("product/search/" . $tmp_offset) . '" />' . "\n";
		}

		// load view
		$this->load_view('search', $this->data);
	}
}