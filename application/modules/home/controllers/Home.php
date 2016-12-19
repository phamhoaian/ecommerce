<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct() {

		parent::__construct();

		// load database
        $this->load->database();

        // load model
        $this->load->model('common_model');

        // meta title, description
        $this->data["title"] = "Trang chủ";
        $this->data["description"] = SITE_NAME;
	}

	public function index() {

		// menu active
		$this->data['menu_active'] = "home";

		// load css and js
		$this->set_css("royalslider/royalslider.css");
		$this->set_css("royalslider/skins/minimal-white/rs-minimal-white.css");
		$this->set_js("jquery/royalslider/jquery.royalslider.min.js");

		// get list slide
		$this->data["list_slide"] = $this->common_model->get_all_slide(NULL, 'sort_order ASC');

		// get list latest news
		$this->data['latest_news'] = $this->common_model->get_all_news(NULL, 'created DESC', 3);

		// get list latest product
		$this->data["latest_product"] = $this->common_model->get_all_product(NULL, 'created DESC', 3);

		// get list best seller product
		$this->data["best_seller_product"] = $this->common_model->get_all_product(NULL, 'buyed DESC', 3);

		// load view
		$this->load_view('top', $this->data);
	}

	/**
	 * Test side ci
	 *
	 * @return void
	 */
	public function side_ci()
	{
		$this->data['exhibition']['name'] = 'test';

		// load view
		$this->load_view('side_ci', $this->data);
	}
}
// End of file side_ci.php
// Location: ./modules/home/views/side_ci.php