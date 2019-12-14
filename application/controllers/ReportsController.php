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
  			return (int)substr(str_replace(',', '', $item2[5]), 1) <=> (int)substr(str_replace(',', '', $item1[5]), 1);
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
		$running_balance = 0;

		$from = $this->input->post('columns[0][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[0][search][value]');
		$to = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');
		$type = $this->input->post('columns[2][search][value]');
		$staff = $this->input->post('columns[3][search][value]');
		$merged = [];
		$stocks = 0;
		$stock_sign = "+";

		$sales = $this->db->select('sales_description.*, sales_description.created_at as delivery_date')
								->where('item_id', $id) 
								->where('DATE_FORMAT(created_at, "%Y-%m-%d") >=', $from)
								->where('DATE_FORMAT(created_at, "%Y-%m-%d") <=', $to)
								->like('staff', $staff, 'BOTH')			
								->get('sales_description')
								->result();

		$returns = $this->db->select('returns.*, returns.date_time as delivery_date')
								->where('item_id', $id)
								->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
								->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
								->like('staff', $staff, 'BOTH')	
								->get('returns')
								->result();

		$deliveries = $this->db->select('delivery.received_by, delivery_details.*')
								->from('delivery')
								->join('delivery_details', 'delivery_details.delivery_id = delivery.id')
								->where('delivery_details.item_id', $id)
								->where('delivery.date_time >=', $from)
								->where('delivery.date_time <=', $to) 
								->get()
								->result();

		$expired = $this->db->where('item_id', $id)
								->where('expiry_date >=', $from)
								->where('expiry_date <=', $to) 
								->get('expiries')
								->result();
 		
	 	
	 	foreach ($expired as $expire) {
	 		$expire->expiry = true;
	 	 	$expire->delivery_date = $expire->expiry_date;
	 	}
 

		$merged = array_merge( $expired, $sales, $returns, $deliveries);



	 	
		usort($merged, function($a, $b) {
  			
  			return strtotime(str_replace('/', '-', $a->delivery_date)) < strtotime(str_replace('/', '-', $b->delivery_date));
  		}); 
     

		$datasets = [];

		$rows = count($merged) - 1;
		for ( $i = $rows; $i >= 0; $i-- ) {

			$sign = "+";
			$type = "Return";
			$date = "";

			
			if (array_key_exists('sales_id', $merged[$i])) {
				//Sales
				$type = "Sales";
				$date = date('Y-m-d', strtotime($merged[$i]->created_at));
				$stocks -= $merged[$i]->quantity;
				$stock_sign = "-";
				
			}else if (array_key_exists('delivery_id', $merged[$i])) { 
				// Stock in
				$type = "Stock in";  
				$date = date('Y-m-d', strtotime($merged[$i]->delivery_date));
				$merged[$i]->price = $merged[$i]->capital;
				$merged[$i]->staff = $merged[$i]->received_by;
				$merged[$i]->quantity = $merged[$i]->quantities;
				$stocks += $merged[$i]->quantity;

 
			}else if (array_key_exists('expired', $merged[$i])) {
				// Expired
				$type = "Expired";
				$date = date('Y-m-d', strtotime($merged[$i]->expiry_date));
				$merged[$i]->price = $merged[$i]->capital;
				$merged[$i]->staff = $merged[$i]->received_by;
				$merged[$i]->quantity = $merged[$i]->quantities;
				$stocks -= $merged[$i]->quantity;
				$sign = "-";
				$stock_sign = "-";
			} else { 
				$stocks -= $merged[$i]->quantity;
				$date = date('Y-m-d', strtotime($merged[$i]->date_time)); 
				$sign = "-";
			} 

			if ($type == "Return" || $type == "Expired") {
				
				$running_balance -= (float)$merged[$i]->price * (float)$merged[$i]->quantity;
				$stock_sign = "";
			}else if ($type == "Stock in" || $type == "Sales") {
				$running_balance += (float)$merged[$i]->price * (float)$merged[$i]->quantity;
			}

			$datasets[] = [
					$date,
					$type,
					$merged[$i]->staff,
					$merged[$i]->name, 
					$merged[$i]->quantity,
					currency() . number_format($merged[$i]->price, 2),
					"<b>$sign </b>" . currency() . number_format((float)$merged[$i]->price * (float)$merged[$i]->quantity,2),
					currency() . number_format($running_balance, 2),
					"<b>$stock_sign </b>" . $merged[$i]->quantity,
					$stocks
				];
		} 

		echo json_encode([
			'draw' => $draw,
			'recordsTotal' => count($datasets),
			'recordsFiltered' => count($merged),
			'data' => array_reverse($datasets)
		]);
	}

	public function insert_delivery() {

		$stocks = $this->db->select('ordering_level.quantity, items.*, prices.capital,prices.price')
							->from('ordering_level')
							->join('items', 'items.id = ordering_level.item_id')
							->join('prices', 'prices.item_id = ordering_level.item_id')
							->get()
							->result();

		
		$this->db->insert('delivery', [
					'supplier_id' => 8,
					'date_time' => date('Y-m-d', strtotime("-45 days")),
					'received_by' => 'admin'
			]); 

		$delivery_id = $this->db->insert_id();

		foreach ($stocks as $stock) {

			if (!$stock->quantity)
				continue;

			$data = array(
				'item_id'	=> $stock->id,
				'quantities' => $stock->quantity,
				'delivery_id' => $delivery_id,
				'capital'	=>	$stock->capital,
				'expiry_date' => date('Y-m-d', strtotime('+2 years', strtotime((date('Y-m-d'))))),
				'defectives' => 0,
				'remarks'	=> '',
				'barcode' => $stock->barcode,
				'name' => $stock->name,
				'price' => $stock->price,
				'delivery_date' => date('Y-m-d', strtotime("-45 days")),
			);


			$this->db->insert('delivery_details', $data);
		}
	}

}