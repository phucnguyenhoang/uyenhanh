<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->auth->check();
		$this->load->model(array('customer', 'report'));
	}

	public function index() {
		$fromDate = $this->input->get('fromdate');
		$toDate = $this->input->get('todate');
		if (empty($fromDate)) {
			$fromDate = '01-'.date('m-Y');
		}
		if (empty($toDate)) {
			$toDate = date('d-m-Y');
		}

		$customers = $this->customer->all(true);
		$customerId = $this->input->get('customer');
		if (empty($customerId) && !empty($customers)) {
			$customerId = $customers[0]->id;
		}

		$customer = $this->customer->get($customerId);
		if (empty($customer)) show_404();

		$viewData = array(
			'flash' => $this->session->flashdata('message'),
			'customers' => $customers,
			'fromDate' => $fromDate,
			'toDate' => $toDate,
			'customer' => $customer,
			'data' => $this->report->getReport($fromDate, $toDate, $customerId)
		);
		$data = array(
			'title' => lang('report'),
			'css' => 'bootstrap-datepicker3',
			'js' => array(
				'bootstrap-datepicker.min',
				'bootstrap-datepicker.vi.min'
			),
			'header' => array(
				'main' => lang('report'),
				'sub' => lang('list')
			),
			'breadcrumb' => array(
				lang('report') => 'reports',
				lang('list') => null
			),
			'view' => $this->load->view('reports/index', $viewData, true)
		);
		$this->load->view('template', $data);
	}
}
