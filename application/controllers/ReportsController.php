<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");

class ReportsController extends AppController 

{

	public function products() {

		$data['content'] = 'reports/products';
		$this->load->view('master', $data);
	}

	public function products_datatable() {

		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
		$count = $this->db->get('items')->num_rows();
		$datasets = [];
		$total = 0;
		$from = $this->input->post('columns[0][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[0][search][value]');
		$to = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');

		$products = $this->db->like('name', $search)
								->or_like('barcode', $search)
								->get('items', $limit, $start)->result();
 		 
 		foreach ($products as $product) {

 			$sales = $this->db->select("SUM(sales_description.quantity) as sold, sales_description.name, sales_description.item_id, sum(sales_description.quantity * sales_description.price) as total") 
									->from('sales_description')
									->group_by("sales_description.item_id")
									->where('item_id', $product->id)
									->where('date_format(created_at, "%Y-%m-%d") >=', $from)
									->where('date_format(created_at, "%Y-%m-%d") <=', $to)
									->get()
									->row(); 

 			$deliveries = $this->db->select("delivery.date_time, SUM(delivery_details.quantities) as total_in")
 						->from('delivery')
 						->join('delivery_details', 'delivery_details.delivery_id = delivery.id')
 						->where('delivery_details.item_id', $product->id) 
 						->where('delivery.date_time >=', $from)
						->where('delivery.date_time <=', $to)
 						->get()
 						->row();
 			
 			$returns = $this->db->select("SUM(quantity) as total")
 										->from('returns')
 										->where('item_id', $product->id)
 										->where('date_format(date_time, "%Y-%m-%d") >=', $from)
										->where('date_format(date_time, "%Y-%m-%d") <=', $to)
 										->get()
 										->row();

 			$datasets[] = [ 
 					$product->barcode,
 					$product->name,
 					$deliveries->total_in ? $deliveries->total_in : 0,
 					$sales->sold ? $sales->sold : 0,
 					$returns->total ? $returns->total : 0,
 					currency() . number_format($sales->total, 2),
 				];
 		}

 
 		usort($datasets, function($item1, $item2) {
  			return substr(str_replace(',', '', $item2[5]), 1) <=> substr(str_replace(',', '', $item1[5]), 1);
  		}); 

		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => count($datasets),
			'recordsFiltered' => $count,
			'data' => $datasets 
		]); 
	}

}