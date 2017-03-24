<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->auth->check();
		$this->load->model('product');
	}

	public function index() {
		$viewData = array(
			'flash' => $this->session->flashdata('message'),
			'products' => $this->product->all()
		);
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
			'view' => $this->load->view('products/index', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function create() {
		// create product
		if ($this->input->method() == 'post') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules($this->product->rule['create']);
			if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('create_error')));
            } else {
                $newProduct = $this->product->create($this->input->post());
                if ($newProduct) {
                	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('create_success')));
                	redirect('products');
                } else {
                	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('create_error')));
                }
            }
		}

		$viewData = array(
			'flash' => $this->session->flashdata('message')
		);
		$data = array(
			'title' => lang('create_product'),
			'js' => 'g-validator',
			'header' => array(
				'main' => lang('product'),
				'sub' => lang('create_product')
			),
			'breadcrumb' => array(
				lang('product') => 'products',
				lang('create_product') => null
			),
			'view' => $this->load->view('products/create', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function edit($id) {
		if (empty($id)) show_404();

		$product = $this->product->get($id);
		if (empty($product)) show_404();

		// edit product
		if ($this->input->method() == 'post') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules($this->product->rule['edit']);
			if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('edit_error')));
            } else {
                if ($this->product->edit($id, $this->input->post())) {
                	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('edit_success')));
                	redirect('products');
                } else {
                	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('edit_error')));
                }
            }
		}

		$viewData = array(
			'flash' => $this->session->flashdata('message'),
			'product' => $product
		);
		$data = array(
			'title' => lang('edit_product'),
			'js' => 'g-validator',
			'header' => array(
				'main' => lang('product'),
				'sub' => lang('edit_product')
			),
			'breadcrumb' => array(
				lang('product') => 'products',
				lang('edit_product') => null
			),
			'view' => $this->load->view('products/edit', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function delete($id) {
		if (empty($id)) show_404();

		$product = $this->product->get($id);
		if (empty($product)) show_404();

		if ($this->product->delete($id)) {
        	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('delete_success')));
        } else {
        	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('delete_error')));
        }

        redirect('products');
	}

	public function autocomplate() {
		//if (!$this->input->is_ajax_request()) show_404();
		header('Content-Type: application/json');
		$products = $this->product->autoComplate();
		
		echo json_encode($products);
	}
}
