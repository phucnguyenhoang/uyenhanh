<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->auth->check();
	}

	public function index() {
		$this->load->helper('security');
		$data = array(
			'title' => lang('home'),
			'view' => $this->load->view('home', '', true)
		);
		$this->load->view('template', $data);
	}
}
