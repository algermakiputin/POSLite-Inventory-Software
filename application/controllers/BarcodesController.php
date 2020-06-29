<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");

class BarcodesController extends AppController {

	public function export($id, $number) {

		$generator = new Picqer\Barcode\BarcodeGeneratorHTML();

		// echo $generator->getBarcode('4807', $generator::TYPE_EAN_13);



		$barcodes = $this->db->where('item_id', $id)
									->get('barcodes')
									->row();

		if ( !$barcodes )
			return "No barcode found";



		$data['generator'] = $generator;
		$data['barcode'] = $barcodes;
		$data['number'] = $number; 

		$this->load->view('barcodes/export', $data);

 
	}

	public function export_all() {

		$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
		$barcodes = $this->db->get('barcodes')->result();

		$data['generator'] = $generator;
		$data['barcodes'] = $barcodes;
		
		$this->load->view('barcodes/export_all', $data);
	}

	public function create($id) {

		$barcode = $this->db->where('item_id', $id)->get('barcodes')->row();

		$data['content'] = "barcodes/create";
		$data['barcode'] = $barcode;
		$this->load->view('master', $data);
	}


}


?>