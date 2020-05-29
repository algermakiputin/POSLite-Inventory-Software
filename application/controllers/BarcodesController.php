<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");

class BarcodesController extends AppController {

	public function export() {

		$generator = new Picqer\Barcode\BarcodeGeneratorHTML();

		// echo $generator->getBarcode('4807', $generator::TYPE_EAN_13);

		$barcodes = $this->db->get('barcodes')->result();

		$data['generator'] = $generator;
		$data['barcodes'] = $barcodes;
		$data['content'] = "barcodes/export";

		$this->load->view('barcodes/export', $data);

 
	}


}


?>