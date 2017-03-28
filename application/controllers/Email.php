<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	public $fromEmail = 'vokhoanam@gmail.com';
	public $emailName = 'Nam Vo';
	public $pdfDir = ROOT.'/resources/pdf/';

	public function __construct() {
		parent::__construct();

		$this->auth->check();
		$this->load->model(array('order', 'quotation', 'customer', 'report'));
		$this->load->library('pdf');
	}

	public function index() {
		if (!$this->input->is_ajax_request()) show_404();
		header('Content-Type: application/json');
		$res = array('error' => true);

		$type = $this->input->post('type');
		$toEmail = $this->input->post('toEmail');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_data(array('email' => $toEmail));
		if (empty($toEmail) || $this->form_validation->run() == FALSE) {
            echo json_encode($res);
            exit();
        }

		switch ($type) {
			case 'dayOrder':
				$orderId = $this->input->post('id');
				$order = $this->order->get($orderId);
				if (empty($order)) {
					echo json_encode($res);
            		exit();
				}

				$receverName = $this->input->post('receverName');
				if (empty($receverName)) {
					$receverName = substr($toEmail, 0, strpos($toEmail, '@'));
				}
				$orderDate = $order->order_date;

				// begin make pdf file
				$pdfFile = uniqid().'.pdf';
				$pdfFilePath = $this->pdfDir.$pdfFile;
				$pdfData = array(
					'order' => $order,
					'products' => $this->order->getProducts($orderId)
				);
				
				$html = $this->load->view('exports/order', $pdfData, true);
				$header = array(
					'title' => 'Đơn hàng ngày: '.date('d/m/Y', strtotime($orderDate)),
					'sub' => 'Đối tác: '.$order->name
				);
				$this->pdf->render($header, $html, $pdfFilePath, 'F');
				if (!file_exists($pdfFilePath)) {
					echo json_encode($res);
            		exit();
				}
				// end make pdf file

				// make email content
				$viewData = array(
					'receverName' => $receverName,
					'orderDate' => date('d/m/Y', strtotime($orderDate)),
					'content' => $this->input->post('content')
				);

				$emailTitle = 'Đơn hàng ngày '.date('d/m/Y', strtotime($orderDate));
				$emailContent = $this->load->view('email/day_order', $viewData, true);
				// send email
				$this->load->library('email');

				$this->email->from($this->fromEmail, $this->emailName);
				$this->email->to($toEmail);

				$this->email->subject($emailTitle);
				$this->email->attach($pdfFilePath, 'attachment', 'don-hang-'.date('dmY', strtotime($orderDate)).'.pdf');
				$this->email->message($emailContent);

				if ($this->email->send()) {
					$this->email->print_debugger(array('headers'));
					$res['error'] = false;
				}

				echo json_encode($res);
            	exit();
				break;

			case 'quotation':
				$quotationId = $this->input->post('id');
				$quotation = $this->quotation->get($quotationId);
				if (empty($quotation)) {
					echo json_encode($res);
            		exit();
				}

				$receverName = $this->input->post('receverName');
				if (empty($receverName)) {
					$receverName = substr($toEmail, 0, strpos($toEmail, '@'));
				}
				$quotationDate = $quotation->created_date;

				// begin make pdf file
				$pdfFile = uniqid().'.pdf';
				$pdfFilePath = $this->pdfDir.$pdfFile;
				$pdfData = array(
					'quotation' => $quotation,
					'products' => $this->quotation->getProducts($quotationId)
				);
				
				$html = $this->load->view('exports/quotation', $pdfData, true);
				$header = array(
					'title' => 'Bảng báo giá',
					'sub' => 'Ngày: '.date('d/m/Y', strtotime($quotationDate))
				);
				$this->pdf->render($header, $html, $pdfFilePath, 'F');
				if (!file_exists($pdfFilePath)) {
					echo json_encode($res);
            		exit();
				}
				// end make pdf file

				// make email content
				$viewData = array(
					'receverName' => $receverName,
					'quotationDate' => date('d/m/Y', strtotime($quotationDate)),
					'content' => $this->input->post('content')
				);

				$emailTitle = 'Bảng báo giá ngày: '.date('d/m/Y', strtotime($quotationDate));
				$emailContent = $this->load->view('email/quotation', $viewData, true);
				// send email
				$this->load->library('email');

				$this->email->from($this->fromEmail, $this->emailName);
				$this->email->to($toEmail);

				$this->email->subject($emailTitle);
				$this->email->attach($pdfFilePath, 'attachment', 'bang-bao-gia-'.date('dmY', strtotime($quotationDate)).'.pdf');
				$this->email->message($emailContent);

				if ($this->email->send()) {
					$this->email->print_debugger(array('headers'));
					$res['error'] = false;
				}

				echo json_encode($res);
            	exit();
				break;

			case 'report':
				$fromDate = $this->input->post('fromDate');
				$toDate = $this->input->post('toDate');
				$customerId = $this->input->post('customerId');
				$customer = $this->customer->get($customerId);
				if (empty($customer)) {
					echo json_encode($res);
            		exit();
				}

				$receverName = $this->input->post('receverName');
				if (empty($receverName)) {
					$receverName = substr($toEmail, 0, strpos($toEmail, '@'));
				}

				// begin make pdf file
				$pdfFile = uniqid().'.pdf';
				$pdfFilePath = $this->pdfDir.$pdfFile;
				$pdfData = array(
					'fromDate' => $fromDate,
					'toDate' => $toDate,
					'customer' => $customer,
					'products' => $this->report->getReport($fromDate, $toDate, $customerId)
				);
				
				$html = $this->load->view('exports/report', $pdfData, true);
				$header = array(
					'title' => 'Đơn hàng từ ngày '.date('d/m/Y', strtotime($fromDate)).' đến ngày '.date('d/m/Y', strtotime($toDate)),
					'sub' => 'Đối tác: '.$customer->name
				);
				$this->pdf->render($header, $html, $pdfFilePath, 'F');
				if (!file_exists($pdfFilePath)) {
					echo json_encode($res);
            		exit();
				}
				// end make pdf file

				// make email content
				$viewData = array(
					'receverName' => $receverName,
					'fromDate' => date('d/m/Y', strtotime($fromDate)),
					'toDate' => date('d/m/Y', strtotime($toDate)),
					'content' => $this->input->post('content')
				);

				$emailTitle = 'Đơn hàng từ ngày '.date('d/m/Y', strtotime($fromDate)).' đến ngày '.date('d/m/Y', strtotime($toDate));
				$emailContent = $this->load->view('email/report', $viewData, true);
				// send email
				$this->load->library('email');

				$this->email->from($this->fromEmail, $this->emailName);
				$this->email->to($toEmail);

				$this->email->subject($emailTitle);
				$this->email->attach($pdfFilePath, 'attachment', 'don-hang-tu-ngay-'.date('dmY', strtotime($fromDate)).'-den-'.date('dmY', strtotime($toDate)).'.pdf');
				$this->email->message($emailContent);

				if ($this->email->send()) {
					$this->email->print_debugger(array('headers'));
					$res['error'] = false;
				}

				echo json_encode($res);
            	exit();
				break;

			default:
				show_404();
				break;
		}
	}
}
