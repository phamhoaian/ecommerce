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
        $this->data["title"] = "Home";
        $this->data["description"] = SITE_NAME;

        // initialize breadcrumbs
        $this->position['item'][0]['title'] = "Home";
	}

	public function index() {

		// breadcrumbs
		$this->data['position'] = $this->load->view("parts/position", $this->position, TRUE);

		// menu active
		$this->data['menu_active'] = "home";

		// load view
		$this->load_view('home', $this->data);
	}
}