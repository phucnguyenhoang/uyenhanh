<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exports extends CI_Controller {

	public $pdfDir = ROOT.'/resources/pdf/';

	public function __construct() {
		parent::__construct();

		$this->auth->check();
		$this->load->model(array('order', 'quotation', 'customer', 'report'));
		$this->load->library('pdf');
	}

	public function index() {
		$type = $this->input->get('type');
		switch ($type) {
			case 'order':
				$orderId = $this->input->get('id');
				$fileName = $this->input->get('file');

				$order = $this->order->get($orderId);
				if (empty($order)) show_404();

				$viewData = array(
					'order' => $order,
					'products' => $this->order->getProducts($orderId)
				);
				
				$html = $this->load->view('exports/order', $viewData, true);
				$header = array(
					'title' => 'Đơn hàng ngày: '.date('d/m/Y', strtotime($order->order_date)),
					'sub' => 'Đối tác: '.$order->name
				);
				$this->pdf->render($header, $html, $fileName);
				break;
			
			case 'quotation':
				$quotationId = $this->input->get('id');
				$fileName = $this->input->get('file');

				$quotation = $this->quotation->get($quotationId);
				if (empty($quotation)) show_404();

				$viewData = array(
					'quotation' => $quotation,
					'products' => $this->quotation->getProducts($quotationId)
				);
				
				$html = $this->load->view('exports/quotation', $viewData, true);
				$header = array(
					'title' => 'Bảng báo giá',
					'sub' => 'Ngày: '.date('d/m/Y', strtotime($quotation->created_date))
				);
				$this->pdf->render($header, $html, $fileName);
				break;

			case 'report':
				$fromDate = $this->input->get('fromDate');
				$toDate = $this->input->get('toDate');
				$customerId = $this->input->get('customer');
				$fileName = $this->input->get('fileName');
				$customer = $this->customer->get($customerId);

				if (empty($customer)) show_404();

				$viewData = array(
					'customer' => $customer,
					'fromDate' => $fromDate,
					'toDate' => $toDate,
					'products' => $this->report->getReport($fromDate, $toDate, $customerId)
				);
				
				$html = $this->load->view('exports/report', $viewData, true);
				$header = array(
					'title' => 'Đơn hàng từ ngày '.date('d/m/Y', strtotime($fromDate)).' đến ngày '.date('d/m/Y', strtotime($toDate)),
					'sub' => 'Đối tác: '.$customer->name
				);
				$this->pdf->render($header, $html, $fileName);
				break;

			default:
				show_404();
				break;
		}
	}
}
