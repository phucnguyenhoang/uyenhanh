<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->auth->check();
		$this->load->model('customer');
	}

	public function index() {
		$viewData = array(
			'flash' => $this->session->flashdata('message'),
			'customers' => $this->customer->all()
		);
		$data = array(
			'title' => lang('customer'),
			'header' => array(
				'main' => lang('customer'),
				'sub' => lang('list')
			),
			'breadcrumb' => array(
				lang('customer') => 'customers',
				lang('list') => null
			),
			'view' => $this->load->view('customers/index', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function create() {
		// create customer
		if ($this->input->method() == 'post') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules($this->customer->rule['create']);
			if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('create_error')));
            } else {
                $newCustomer = $this->customer->create($this->input->post());
                if ($newCustomer) {
                	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('create_success')));
                	redirect('customers');
                } else {
                	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('create_error')));
                }
            }
		}

		$viewData = array(
			'flash' => $this->session->flashdata('message')
		);
		$data = array(
			'title' => lang('create_customer'),
			'js' => 'g-validator',
			'header' => array(
				'main' => lang('customer'),
				'sub' => lang('create_customer')
			),
			'breadcrumb' => array(
				lang('customer') => 'customers',
				lang('create_customer') => null
			),
			'view' => $this->load->view('customers/create', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function edit($id) {
		if (empty($id)) show_404();

		$customer = $this->customer->get($id);
		if (empty($customer)) show_404();

		// edit customer
		if ($this->input->method() == 'post') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'lang:name', 'trim|required|max_length[150]');
			$this->form_validation->set_rules('address', 'lang:address', 'trim|max_length[200]');
			$this->form_validation->set_rules('note', 'lang:note', 'trim|max_length[200]');
			if ($this->input->post('phone') != $customer->phone) {
				$this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|max_length[20]|is_unique[customers.phone]');
			}
			if ($this->input->post('email') != $customer->email) {
				$this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[150]|is_unique[customers.email]');
			}
			if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('edit_error')));
            } else {
                if ($this->customer->edit($id, $this->input->post())) {
                	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('edit_success')));
                	redirect('customers');
                } else {
                	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('edit_error')));
                }
            }
		}

		$viewData = array(
			'flash' => $this->session->flashdata('message'),
			'customer' => $customer
		);
		$data = array(
			'title' => lang('edit_customer'),
			'js' => 'g-validator',
			'header' => array(
				'main' => lang('customer'),
				'sub' => lang('edit_customer')
			),
			'breadcrumb' => array(
				lang('customer') => 'customers',
				lang('edit_customer') => null
			),
			'view' => $this->load->view('customers/edit', $viewData, true)
		);
		$this->load->view('template', $data);
	}

	public function delete($id) {
		if (empty($id)) show_404();

		$customer = $this->customer->get($id);
		if (empty($customer)) show_404();

		if ($this->customer->delete($id)) {
        	$this->session->set_flashdata('message', array('type' => 'success', 'msg' => lang('delete_success')));
        } else {
        	$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('delete_error')));
        }

        redirect('customers');
	}
}
