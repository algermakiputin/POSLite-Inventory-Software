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
 					'<a href="'.base_url('ReportsController/product_ledger/' . $product->id).'" class="btn btn-primary btn-sm">Details</a>'
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

	public function product_ledger($id) {

		$product = $this->db->where('id', $id)->get('items')->row();
		if (!$product)
			return redirect('/');

		$data['product'] = $product;
		$data['content'] = 'reports/product_ledger';
		$data['staffs'] = $this->db->get('users')->result();

		$this->load->view('master', $data);
	}

	public function ledger() {

		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]');
		$id = $this->input->post('id');


		$from = $this->input->post('columns[0][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[0][search][value]');
		$to = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');
		$type = $this->input->post('columns[2][search][value]');
		$staff = $this->input->post('columns[3][search][value]');
		$merged = [];

		$sales = $this->db->where('item_id', $id)

								->where('DATE_FORMAT(created_at, "%Y-%m-%d") >=', $from)
								->where('DATE_FORMAT(created_at, "%Y-%m-%d") <=', $to)
								->like('staff', $staff, 'BOTH')			
								->get('sales_description')
								->result();

		$returns = $this->db->where('item_id', $id)
								->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
								->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
								->like('staff', $staff, 'BOTH')	
								->get('returns')
								->result();

		if ($type == "sales") {
			$merged = $sales;
		}else if ($type == "returns") {
			$merged = $returns;
		}else {
			$merged = array_merge($sales, $returns);
		}
		
		$datasets = [];

		foreach ($merged as $row) {

			$type = "Return";
			$date = "";
			if (array_key_exists('sales_id', $row)) {

				$type = "Sales";
				$date = date('Y-m-d', strtotime($row->created_at));
			}else {

				$date = date('Y-m-d', strtotime($row->date_time));

			} 

			$datasets[] = [
					$date,
					$type,
					$row->staff,
					$row->name, 
					$row->quantity,
					currency() . number_format($row->price, 2),
					currency() . number_format((float)$row->price * (float)$row->quantity,2)
				];
		}


		echo json_encode([
			'draw' => $draw,
			'recordsTotal' => count($datasets),
			'recordsFiltered' => count($merged),
			'data' => $datasets
		]);
	}

}