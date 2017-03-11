<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('product');
	}

	public function index() {
		$data = array(
			'title' => lang('product'),
			'header' => array(
				'main' => lang('product'),
				'sub' => lang('list')
			),
			'breadcrumb' => array(
				lang('product') => 'products',
				lang('list') => null
			),
			'view' => $this->load->view('products/index', '', true)
		);
		$this->load->view('template', $data);
	}
}
