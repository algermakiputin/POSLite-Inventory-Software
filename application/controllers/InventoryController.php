<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class InventoryController extends CI_Controller {

	
	public function __construct() {

		parent::__construct();
		$this->load->model('InventoryModel');

	}

	public function set_inventory() {

		$items = $this->db->select('items.*, ordering_level.quantity')
									->from('items')
									->join('ordering_level', 'ordering_level.item_id = items.id')
									->get()
									->result(); 

		foreach ($items as $item) {

			$this->InventoryModel->insert( 
					$item->id, 
					0, 
					$item->name, 
					$item->quantity, 
					'set'
				);
		}
	}

	public function expiry_reports() {

		$data['content'] = "inventory/expiry";
		$this->load->view('master', $data);
	}

	public function stocks() {
		$data['content'] = 'inventory/stocks';
		$this->load->view('master', $data);
	}

	public function inventory_reports() {

		$data['content'] = "inventory/inventory_reports";
		$this->load->view('master', $data);
	}

	public function expiry_reports_datatable() {
		$items = $this->InventoryModel->get_expiry_reports_datatable();
  		$dataset = [];
		$month_diff = date('Y-m-d', strtotime("+30 days"));

		foreach ( $items[0] as $item ) {  
			
			$categoryName = $this->db->select('items.id, categories.name')
										->from('items') 
										->join('categories', 'items.category_id = categories.id') 
										->where('items.id', $item->item_id)
										->get()
										->row()->name;
			
			$status = "<span class='badge badge-success'>Good</span>";

			if ( date("Y-m-d") > $item->expiry_date) 
				$status = "<span class='badge badge-danger'>Expired</span>";

			if ( $item->expiry_date >= date('Y-m-d') && $item->expiry_date <= $month_diff) {

				$status = "<span class='badge badge-warning'>Expiring in a Month</span>";
			} 

			$dataset[] = [
				$item->expiry_date, 
				$item->name,
				$categoryName,
				$item->quantities, 
				$item->quantity,
				$status
			];
		}

		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => $items[1],
			'recordsFiltered' => $items[1],
			'data' => $dataset
		]);
	}

	public function reports_datatable() {

		$inventory = $this->InventoryModel->get_reports_datatable(); 
		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => $total_records,
			'recordsFiltered' => $inventory[1],
			'data' => $inventory[0]
		]);
	}

	public function stocksDatatable() {
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]');    
		$startDate = $this->input->post('columns[0][search][value]');
		$endDate = $this->input->post('columns[1][search][value]');  
		$startDate = $startDate ? $startDate : date('Y-m-d');
		$endDate = $endDate ? $endDate : date('Y-m-d');   
		$baseQuery = $this->db->where('DATE_FORMAT(date, "%Y-%m-%d") >=', $startDate)
							->where('DATE_FORMAT(date, "%Y-%m-%d") <=', $endDate)
							->like('product', $search, 'BOTH') 
							->order_by('date', 'DESC')
							->get('stocks', $limit, $start);
		$records = $baseQuery->result(); 
		$numRows = $baseQuery->num_rows(); 
		$datasets = [];   
		foreach ($records as $record) { 
			$datasets[] = [
				$record->date,
				$record->product,
				$record->quantity,
				$record->price, 
				$record->user
			];
		}  
		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => $numRows,
			'recordsFiltered' => $numRows,
			'data' => $datasets, 
		]);
	}
	
}