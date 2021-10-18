<?php 

class InventoryModel extends CI_Model {

	

	public function expiry_reports_query() {

		$filter = $this->input->post('columns[0][search][value]'); 
		$search = $this->input->post('search[value]'); 

		$from = $from ? $from : date('Y-m-1');
		$to = $to ? $to : date('Y-m-31');

		$this->db->select("delivery_details.expiry_date, delivery_details.quantities, delivery_details.name, delivery_details.item_id, ordering_level.quantity") 
					->from("delivery_details")
					->join('ordering_level', 'ordering_level.barcode = delivery_details.barcode', 'LEFT')
					->like('delivery_details.name', "$search");
	 
		if ($filter == "expiring") {

			$month_diff = date('Y-m-d', strtotime("+30 days"));
			$this->db->where('DATE_FORMAT(delivery_details.expiry_date, "%Y-%m-%d") >=', date('Y-m-d'));
			$this->db->where('DATE_FORMAT(delivery_details.expiry_date, "%Y-%m-%d") <=', $month_diff);

		}else if ($filter == "expired") {

			$pastMonths = date('Y-m-d', strtotime("-6 months"));
			$this->db->where('DATE_FORMAT(delivery_details.expiry_date, "%Y-%m-%d") <', date('Y-m-d'));
			$this->db->where('DATE_FORMAT(delivery_details.expiry_date, "%Y-%m-%d") >', $pastMonths);
		}
 
		return $this->db->order_by('delivery_details.id', 'DESC');
		 
	}


	public function get_expiry_reports_datatable() {

		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		
		$count = $this->expiry_reports_query()->get()->num_rows();
		$items = $this->expiry_reports_query()->limit($limit, $start)->get()->result();

		return [$items, $count];
	}

	public function insert( $barcode, $quantity, $description, $current_stocks, $action, $price = 0, $capital = 0) {

		$stocks_remaining = $current_stocks;

		if ( $action == "stockin") 
			$stocks_remaining += $quantity;

		else if ( $action == "sell")
			$stocks_remaining -= $quantity;
		 
		else if ( $action == "edit" && $current_stocks !== $quantity) {

			if ( $quantity > $current_stocks) {
				$quantity = $quantity - $current_stocks;  
				$stocks_remaining += $quantity;

			}else {
				 
				$quantity = $current_stocks - $quantity;
				$stocks_remaining -= $quantity;
			}

		}

		$checkInventory = $this->db->where('date_time >=', date("Y-m-01"))
									->where('barcode', $barcode)
									->get('inventory')
									->row();
		// IF no record for this month. Create a record as beginning inventory
		if (!$checkInventory) {
			$this->db->insert('inventory', [
				'date_time' => date('Y-m-01 h:i:s A'),
				'barcode' => $barcode,
				'description' => $description,
				'quantity' => 0,
				'stocks_remaining' => $current_stocks,
				'action' => $action,
				'price' => $price,
				'capital' => $capital
			]);
		}

		return $this->db->insert('inventory', [
				'date_time' => date('Y-m-d h:i:s A'),
				'barcode' => $barcode,
				'description' => $description,
				'quantity' => $quantity,
				'stocks_remaining' => $stocks_remaining,
				'action' => $action,
				'price' => $price,
				'capital' => $capital
			]);
	}

	public function get_reports_datatable() {

		// Base on Date Range
		// Current Inventory Report


		// get the date range
		// Pag wala
		// get the least date


		// This is one is current Inventory Report
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$from = $this->input->post('columns[0][search][value]');
		$to = $this->input->post('columns[1][search][value]');
		$search = $this->input->post('search[value]'); 

		$from = $from ? $from : date('Y-m-01');
		$to = $to ? $to : date('Y-m-t');

		$inventory = [];	
 
		$items = $this->inventory_reports_query($search, $limit, $start)->result();
		$totalRecords = $this->inventory_reports_query($search, false, false)->num_rows(); 
 
		foreach ( $items as $key => $item ) {

			// Inventory Records In the Given Date Period
			$row = $this->db->where('date_time >=', $from)
							->where('date_time <=', $to)
							->where('barcode', $item->id)
							->order_by('date_time', 'ASC')
							->get('inventory')
							->result(); 

			// SUM of breakage in the given date period
			// $breakage = $this->db->select("SUM(quantity) as quantity")
			// 							->where('barcode', $item->id)
			// 							->where('date >=', $from)
			// 							->where('date <=', $to)
			// 							->get('breakage')
			// 							->row()->quantity;
			$breakage = 0;
			
	 		// If Inventory Has Records
			if ( count($row) ) { 
 				 
				$purchases = 0;
				$sales = 0;
				$sold = 0;

				foreach ( $row as $x) {
 
					$sales += $x->price * $x->quantity;
					$action = $x->action;

					if ( $action == "sell")
						$sold += $x->quantity;

					if ( $action == "stockin")
						$purchases += $x->quantity;
				}

				$inventory[] = [
					$item->barcode,
					$item->name,
					$item->cat_name,
					$row[0]->stocks_remaining,
					$purchases, 
					$sold, 
					$breakage ?? 0,
					$row[count($row) - 1]->stocks_remaining,
				];
			 
			}else {

				// If Inventory Has no records, find the nearest records backwords
				$product = $this->db->where('date_time <=', $from)
								->order_by('date_time', "DESC")
								->where('barcode', $item->id)
								->get('inventory')
								->row();
				 
				if ( $product ) {
 
					$inventory[] = [
							$item->barcode,
							$item->name, // Description
							$item->cat_name, // Category
							$item->quantity, // Initial Quantity 
							0, // Purchases 
							0, // Sold
							$breakage ?? 0, // breakage
							$product->stocks_remaining, // stocks remaining
						];
				}else {

					$inventory[] = [
							$item->barcode,
							$item->name,
							$item->cat_name,
							0,
							0,
							0, 
							0,
							0,
						];
				}
			} 
			
		}

		return [$inventory, $totalRecords];

		
	}

	public function inventory_reports_query($search, $limit, $start) {
	 
		$this->db->select('items.*, categories.name as cat_name, ordering_level.quantity');
		$this->db->from('items');
		$this->db->join('categories', 'categories.id = items.category_id', "LEFT");
		$this->db->join('ordering_level', 'ordering_level.id = items.id');
		$this->db->like('items.name', $search, "BOTH");
		$this->db->order_by('items.id', 'DESC');
		if ($limit) {
			$this->db->limit($limit, $start);
		}
		return $this->db->get();
		 
	}
} 