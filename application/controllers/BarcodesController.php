<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");

class BarcodesController extends AppController {

	public function export($id, $number) {

		$generator = new Picqer\Barcode\BarcodeGeneratorHTML();

		// echo $generator->getBarcode('4807', $generator::TYPE_EAN_13);



		$item = $this->db->where('id', $id)->get('items')->row();

		if ( !$item )
			return "No barcode found";



		$data['generator'] = $generator;
		$data['barcode'] = $item;
		$data['number'] = $number; 

		$this->load->view('barcodes/export', $data);

 
	}

	public function export_all() {

		$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
		$barcodes = $this->db->order_by('id','DESC')->get('items')->result();



		$data['generator'] = $generator;
		$data['barcodes'] = $barcodes;
		
		$this->load->view('barcodes/export_all', $data);
	}

	public function create($id) {

		$item = $this->db->where('id', $id)->get('items')->row();

		$data['content'] = "barcodes/create";
		$data['barcode'] = $item;
		$this->load->view('master', $data);
	}


}


?>