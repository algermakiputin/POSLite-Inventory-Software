<?php
class Sales_model extends CI_Model {

	public function insert_sales($records,$customer_id) {

		$this->load->database();
		
		date_default_timezone_set("Asia/Manila");
		 
		$data = json_decode($records,true); 
		$id = '00' + rand();
		foreach ($data as $sale) {
			
			$item_price = trim($sale[3], '₱');
			$sub_total = trim($sale[4], '₱');
			$arr = array(
				'sale_id' => "$id",
				'item_id' => "$sale[0]", 
				'quantity' => "$sale[2]",
				'sub_total' => "$sub_total", 
				'price_id' => $sale[5],
				'customer_id' => $customer_id

			);

			$insert = $this->db->insert('sales',$arr);
		}

		if ($insert) {
			return true;
		}

		return false;
	}

	public function updateStocks($cart) {
		$data = json_decode($cart,true);
		$this->load->database();
		foreach ($data as $stock) {
			$id = $stock[0];
			$quantity = $stock[2];
			$this->db->query("UPDATE ordering_level SET quantity = quantity - $quantity WHERE item_id = $id");
		}


	}
	public function daily_sales_report() {
		$date = date('Y-m-d');
		$this->load->database();
		$sql = $this->db->where('DATE_FORMAT(date_time,"%Y-%m-%d")',$date)->get('sales');
		return $sql->result();
	}

	public function weekly_sales_report() {
		$monday = date('d.m.Y',strtotime('last monday'));
		$sunday = date('d.m.Y',strtotime('next sunday'));
	 
		$this->load->database();
		$sql = $this->db->where('DATE_FORMAT(date_time,"%d.%m.%Y") BETWEEN "'. $monday .'" AND "'.$sunday.'"')->get('sales');
		
		return $sql->result();
	}
	
	public function monthly_sales_report() {
		$firstDayOfMonth = date('01-m-Y');
		$lastDayOfMonth = date('t-m-Y');

		$this->load->database();
		$sql = $this->db->where('DATE_FORMAT(date_time,"%d.%m.%Y") BETWEEN "'. $firstDayOfMonth .'" AND "'.$lastDayOfMonth.'"')->get('sales');
		return $sql->result();
	}

	public function yearly_sales_report() {
		$year= date('Y');
		$this->load->database();
		$sql = $this->db->where('DATE_FORMAT(date_time,"%Y")', $year)->get('sales');
		return $sql->result();
	}
}
?>