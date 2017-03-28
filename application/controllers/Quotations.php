<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotations extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->auth->check();
		$this->load->model(array('quotation', 'product'));
	}

	public function index() {
		$viewData = array(
			'flash' => $this->session->flashdata('message'),
			'quotations' => $this->quotation->all()
		);

		$data = array(
			'title' => lang('quotation'),
			'js' => 'g-validator',
			'header' => array(
				'main' => lang('quotation'),
				'sub' => lang('list')
			),
			'breadcrumb' => array(
				lang('quotation') => 'quotations',
				lang('list') => null
			),
			'view' => $this->load->view('quotations/index', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function create() {
		if ($this->input->method() != 'post') show_404();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required|max_length[150]');
		$this->form_validation->set_rules('note', 'lang:note', 'trim|max_length[200]');
		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('create_error')));
            redirect('quotations');
        } else {
        	$newRow = $this->quotation->create($this->input->post());
            if ($newRow) {
            	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('create_success')));
            	redirect('quotations/view/'.$newRow);
            } else {
            	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('create_error')));
	            redirect('quotations');
            }
        }
	}

	public function view($id) {
		$quotation = $this->quotation->get($id);
		if (empty($quotation)) show_404();

		$viewData = array(
			'flash' => $this->session->flashdata('message'),
			'quotation' => $quotation,
			'products' => $this->quotation->getProducts($id)
		);

		$data = array(
			'title' => lang('quotation'),
			'js' => array('typehead', 'autoNumeric.min'),
			'header' => array(
				'main' => lang('quotation'),
				'sub' => lang('quotation_detail')
			),
			'breadcrumb' => array(
				lang('quotation') => 'orders',
				lang('quotation_detail') => null
			),
			'view' => $this->load->view('quotations/detail', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function edit() {
		if (!$this->input->is_ajax_request()) show_404();
		header('Content-Type: application/json');

		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$note = $this->input->post('note');
		$data = array('status' => false);

		$quotation = $this->quotation->get($id);
		if (empty($quotation)) {
    		echo json_encode($data);
    		exit;
		}

		if ($name == $quotation->name && $note == $quotation->note) {
			$data['status'] = true;
			echo json_encode($data);
    		exit;
		}
		
		if ($this->quotation->update($id, $name, $note)) {
			$data['status'] = true;
		}

    	echo json_encode($data);
	}

	public function delete($id) {
		if (empty($id)) show_404();

		$quotation = $this->quotation->get($id);
		if (empty($quotation)) show_404();

		if ($this->quotation->delete($id)) {
        	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('delete_success')));
        } else {
        	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('delete_error')));
        }

        redirect(base_url('quotations'));
	}

	public function addProduct() {		
		if (!$this->input->is_ajax_request()) show_404();
		header('Content-Type: application/json');

		$result = array(
			'error' => true,
			'body' => ''
		);

		$data = $this->input->post();
		if (!$this->product->exist($data['products_id']) || !$this->quotation->exist($data['quotations_id'])) {
			echo json_encode($result);
			exit();
		}

		if ($this->quotation->addProducts($data)) {
			$result['error'] = false;
			$tableData = array('quotationId' => $data['quotations_id'], 'products' => $this->quotation->getProducts($data['quotations_id']));
			$result['body'] = $this->load->view('quotations/_product_table', $tableData, true);
		}		

		echo json_encode($result);
	}

	public function viewProduct($id) {
		if (!$this->input->is_ajax_request()) show_404();
		header('Content-Type: application/json');

		$result = array(
			'error' => true,
			'product' => ''
		);

		$product = $this->quotation->getProduct($id);

		if (!empty($product)) {
			$result['error'] = false;
			$result['product'] = $product;
		}

		echo json_encode($result);
	}

	public function editProduct($id) {
		if (!$this->input->is_ajax_request()) show_404();
		header('Content-Type: application/json');

		$result = array(
			'error' => true,
			'body' => ''
		);

		$data = $this->input->post();
		$quotationId = $data['quotationId'];
		unset($data['quotationId']);
		$product = $this->quotation->getProduct($id);

		if (empty($product)) {
			echo json_encode($result);
			exit();
		}

		if ($product->price == $data['price'] && $product->note == $data['note']) {
			$result['error'] = false;
			echo json_encode($result);
			exit();
		}

		if($this->quotation->editProduct($id, $data)) {
			$result['error'] = false;
			$tableData = array('quotationId' => $quotationId, 'products' => $this->quotation->getProducts($quotationId));
			$result['body'] = $this->load->view('quotations/_product_table', $tableData, true);
		}

		echo json_encode($result);
	}

	public function deleteProduct($id, $productId) {
		if (empty($id) || empty($productId)) show_404();

		$quotation = $this->quotation->get($id);
		$product = $this->quotation->getProduct($productId);
		if (empty($quotation) || empty($product)) show_404();

		if ($this->quotation->deleteProduct($productId)) {
        	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('delete_success')));
        } else {
        	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('delete_error')));
        }

        redirect(base_url('quotations/view/'.$id));
	}
}
