<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");

class InventoryController extends AppController { 

	private $name, $stocks, $unit, $price;

	public function index() {

		$data['content'] = "inventory/index";
		$data['inventory'] = $this->db->get('inventory')->result();
 
		$this->load->view('master', $data);

	}



	public function new() {

		$data['content'] = "inventory/new";
		$this->load->view('master', $data);
		
	}

	public function insert() {
		
		$this->setter();
		
		$data = [
			'name' => $this->name,
			'stocks' => $this->stocks,
			'unit' => $this->unit,
			'price' => $this->price
		];

		$this->db->insert("inventory", $data);
		
		success("Ingredient save successfully");

		return redirect("inventory");


	}

	public function setter() {

		$this->name = $this->input->post('name');
		$this->stocks = $this->input->post('stocks');
		$this->unit = $this->input->post('unit');
		$this->price = $this->input->post('price');

	}
}