<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exports extends CI_Controller {

	public $pdfDir = ROOT.'/resources/pdf/';

	public function __construct() {
		parent::__construct();

		$this->auth->check();
		$this->load->model(array('order'));
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
				var_dump('quotation');
				break;
			default:
				show_404();
				break;
		}
		//$this->pdf->render($header, $view, $this->pdfDir.$fileName, 'F');
	}
}
