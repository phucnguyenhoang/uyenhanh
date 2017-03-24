<?php
require_once(APPPATH.'third_party/tcpdf.php');


class Pdf {

	public $CI;
	public $tcpdf;

	public function __construct() {
		$this->tcpdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	}

	/**
	* $header: array(
	* 	'title' => 'Title and header of pdf file',
	*	'sub' => 'Sub header'
	* )
	* 
	* $content: content of pdf
	*
	* $fileName: name of pdf file
	*/
	public function render($header, $content, $fileName, $type = 'I') {
		$this->tcpdf->SetCreator('TCPDF');
		$this->tcpdf->SetAuthor('Phuc Nguyen');
		$this->tcpdf->SetTitle($header['title']);

		// set default header data
		$this->tcpdf->SetHeaderData('', 0, $header['title'], $header['sub'], array(100,100,100), array(80,80,80));
		$this->tcpdf->setFooterData(array(100,100,100), array(80,80,80));

		// set header and footer fonts
		$this->tcpdf->setHeaderFont(Array('freesans', '', 10));
		$this->tcpdf->setFooterFont(Array('freesans', '', 8));

		// set default monospaced font
		$this->tcpdf->SetDefaultMonospacedFont('courier');

		// set margins
		$this->tcpdf->SetMargins(15, 25, 15);
		$this->tcpdf->SetHeaderMargin(5);
		$this->tcpdf->SetFooterMargin(10);

		// set auto page breaks
		$this->tcpdf->SetAutoPageBreak(TRUE, 25);

		// set image scale factor
		$this->tcpdf->setImageScale(1.25);

		// set default font subsetting mode
		$this->tcpdf->setFontSubsetting(true);

		$this->tcpdf->SetFont('freesans', '', 11, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$this->tcpdf->AddPage();

		//$this->tcpdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);

		// output the HTML content
		$this->tcpdf->writeHTML($content, true, false, true, false, '');

		// reset pointer to the last page
		$this->tcpdf->lastPage();

		return $this->tcpdf->Output($fileName, $type);
	}
}