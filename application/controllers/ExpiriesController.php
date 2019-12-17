<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");
class ExpiriesController extends AppController {


	public function new() {

		$data['products'] = $data['products'] = json_encode($this->db->select('items.id as data, items.barcode, items.name as value, prices.capital, prices.price')->join('prices', 'prices.item_id = items.id')->get('items')->result()); 
		$data['content'] = "expiries/new";
		$this->load->view('master', $data);
	}

	public function insert() {

		$barcode = $this->input->post('barcode');
		$item_id = $this->input->post('item_id');
		$quantities = $this->input->post('quantities');
		$price = $this->input->post('retail');
		$name = $this->input->post('name');
		$capital = $this->input->post('capital'); 
		$expiry_date = $this->input->post('expiry_date');
 		 
		$insert = $this->db->insert('expiries', [
				'item_id' => $item_id,
				'barcode' => $barcode,
				'quantities' => $quantities,
				'price' => substr($price, 1),
				'name' => $name,
				'capital' => substr($capital, 1),
				'expiry_date' => $expiry_date . ' ' . date("H:i:s")
			]);

		 
		success("Expired product added successfully");
		return redirect('expiries');
	}

	public function index() {

		$data['content'] = "expiries/index";
		$this->load->view('master', $data);

	}

	public function datatable() {

		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
		$expiries = $this->db->like('name', $search, "both")
								->order_by('id', "DESC")
								->get('expiries', $limit, $start)
								->result();

		$count = $this->db->get('expiries')->num_rows();

		$datasets = array_map(function($expiry) use ($orderingLevel){ 
			
			return [
				$expiry->expiry_date,
				$expiry->barcode,
				$expiry->name,
				$expiry->quantities,
				$expiry->price,
				$expiry->capital,
				$expiry->price * $expiry->capital
			];
		}, $expiries);
 
		echo json_encode([
				'draw' => $this->input->post('draw'),
				'recordsTotal' => count($datasets),
				'recordsFiltered' => $count,
				'data' => $datasets
			]);
	}
}
 