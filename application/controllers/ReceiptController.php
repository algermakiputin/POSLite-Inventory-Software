<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReceiptController extends CI_Controller {


	public function invoice($invoice_number) {

		$invoice = $this->db->where('transaction_number', $invoice_number)
									->get('sales')
									->row();

		if (!$invoice)  {
			echo "No Invoice Found";
			return;
		}

		$orderline = $this->db->where('sales_id', $invoice->id)
			  						->get('sales_description')
			  						->result();

		$data['invoice']	= $invoice;
		$data['orderline'] = $orderline;
		$data['defaultRow'] = 10 - count($orderline);

		$this->load->view('receipt/invoice', $data);
	}
}