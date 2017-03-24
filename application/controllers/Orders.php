<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->auth->check();
		$this->load->model(array('order', 'product', 'customer'));
	}

	public function index() {
		$date = $this->input->get('date');
		if (empty($date)) {
			$date = date('d-m-Y');
		}

		$viewData = array(
			'flash' => $this->session->flashdata('message'),
			'date' => $date,
			'orders' => $this->order->all(date('Y-m-d', strtotime($date))),
			'customers' => $this->customer->all(true)
		);

		$data = array(
			'title' => lang('order'),
			'css' => 'bootstrap-datepicker3',
			'js' => array(
				'bootstrap-datepicker.min',
				'bootstrap-datepicker.vi.min'
			),
			'header' => array(
				'main' => lang('order'),
				'sub' => lang('list')
			),
			'breadcrumb' => array(
				lang('order') => 'orders',
				lang('list') => null
			),
			'view' => $this->load->view('orders/index', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function create() {
		if ($this->input->method() != 'post') show_404();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('order_date', 'lang:order_date', 'trim|required');
		$this->form_validation->set_rules('customers_id', 'lang:customer', array('trim', 'required', array($this->customer, 'isExist')));
		$this->form_validation->set_rules('note', 'lang:note', 'trim|max_length[200]');
		$data = array(
			'order_date' => date('Y-m-d', strtotime($this->input->post('date'))),
			'customers_id' => $this->input->post('customer'),
			'note' => $this->input->post('note')
		);
		$this->form_validation->set_data($data);
		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('create_error')));
            redirect('orders');
        } else {
        	$newOrder = $this->order->create($data);
            if ($newOrder) {
            	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('create_success')));
            	redirect('orders/view/'.$newOrder);
            } else {
            	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('create_error')));
	            redirect('orders');
            }
        }
	}

	public function view($id) {
		$order = $this->order->get($id);
		if (empty($order)) show_404();

		$viewData = array(
			'flash' => $this->session->flashdata('message'),
			'order' => $order,
			'products' => $this->order->getProducts($id)
		);

		$data = array(
			'title' => lang('order'),
			'js' => array('typehead', 'autoNumeric.min'),
			'header' => array(
				'main' => lang('order'),
				'sub' => lang('order_detail')
			),
			'breadcrumb' => array(
				lang('order') => 'orders',
				lang('order_detail') => null
			),
			'view' => $this->load->view('orders/detail', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function delete($id, $orderDate) {
		if (empty($id)) show_404();

		$order = $this->order->get($id);
		if (empty($order)) show_404();

		if ($this->order->delete($id)) {
        	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('delete_success')));
        } else {
        	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('delete_error')));
        }

        redirect(base_url('orders').'?date='.date('d-m-Y', strtotime($orderDate)));
	}

	public function isExist() {
		if (!$this->input->is_ajax_request()) show_404();

		$orderDate = $this->input->post('date');
		$orderDate = date('Y-m-d', strtotime($orderDate));
		$customerId = $this->input->post('customer');
		$type = $this->input->post('type');

		$check = $this->order->isExist($orderDate, $customerId, $type);

		$data = array('existed' => false);
		if (!empty($check)) {
			$data['existed'] = true;
			$data['id'] = $check->id;
		}
		header('Content-Type: application/json');
    	echo json_encode($data);
	}

	public function edit() {
		if (!$this->input->is_ajax_request()) show_404();
		header('Content-Type: application/json');

		$id = $this->input->post('id');
		$note = $this->input->post('note');
		$type = $this->input->post('type');
		$data = array('status' => false);

		$order = $this->order->get($id);
		if (empty($order)) {
    		echo json_encode($data);
    		exit;
		}

		if ($note == $order->note && $type == $order->type) {
			$data['status'] = true;
			echo json_encode($data);
    		exit;
		}
		
		if ($this->order->updateNote($id, $note, $type)) {
			$data['status'] = true;
		}

    	echo json_encode($data);
	}

	public function addProduct() {		
		if (!$this->input->is_ajax_request()) show_404();
		header('Content-Type: application/json');

		$result = array(
			'error' => true,
			'body' => ''
		);

		$data = $this->input->post();
		if (!$this->product->exist($data['products_id']) || !$this->order->exist($data['orders_id'])) {
			echo json_encode($result);
			exit();
		}

		if ($this->order->addProducts($data)) {
			$result['error'] = false;
			$tableData = array('orderId' => $data['orders_id'], 'products' => $this->order->getProducts($data['orders_id']));
			$result['body'] = $this->load->view('orders/_product_table', $tableData, true);
		}		

		echo json_encode($result);
	}

	public function deleteProduct($id, $productId) {
		if (empty($id) || empty($productId)) show_404();

		$order = $this->order->get($id);
		$product = $this->order->getProduct($productId);
		if (empty($order) || empty($product)) show_404();

		if ($this->order->deleteProduct($productId)) {
        	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('delete_success')));
        } else {
        	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('delete_error')));
        }

        redirect(base_url('orders/view/'.$id));
	}

	public function viewProduct($id) {
		if (!$this->input->is_ajax_request()) show_404();
		header('Content-Type: application/json');

		$result = array(
			'error' => true,
			'product' => ''
		);

		$product = $this->order->getProduct($id);

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
		$orderId = $data['orderId'];
		unset($data['orderId']);
		$product = $this->order->getProduct($id);

		if (empty($product)) {
			echo json_encode($result);
			exit();
		}

		if ($product->price == $data['price'] && $product->quantity == $data['quantity'] && $product->ship == $data['ship'] && $product->note == $data['note']) {
			$result['error'] = false;
			echo json_encode($result);
			exit();
		}

		if($this->order->editProduct($id, $data)) {
			$result['error'] = false;
			$tableData = array('orderId' => $orderId, 'products' => $this->order->getProducts($orderId));
			$result['body'] = $this->load->view('orders/_product_table', $tableData, true);
		}

		echo json_encode($result);
	}
}
