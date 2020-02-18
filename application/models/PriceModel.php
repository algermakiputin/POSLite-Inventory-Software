<?php 

class PriceModel extends CI_Model { 

	public function insert($price,$capital, $item_id) {
 		
 		$stores = 6;

 		$prices = [];

 		

		$data = array(
				'price' => $price,
				'item_id' => $item_id,
				'date_time' => get_date_time(),
			);

		if ($capital) {

			$data['capital'] = $capital;
		}
 

		for ($i = 1; $i <= $stores; $i++) {
			

			$data["store" . $i . "_capital"] = $capital;
			$data['store' . $i . "_retail"] = $price;
 			 
 		}
 		
		$data = $this->security->xss_clean($data);
		$this->db->insert('prices', $data);
		return $this->db->insert_id();
	}

	public function getPrice($id, $store) {

		$column = "store" . $store . '_retail';  

		return $this->db->where('item_id',$id)->get('prices')->row_array()[$column] ?? 0;
	}

	public function getCapital($id, $store) {

		$column = "store" . $store . '_capital'; 
		 
		return $this->db->where('item_id',$id)->get('prices')->row_array()[$column] ?? 0;

	}

	public function setId($id,$item_id) {
		return $this->db->where('id',$id)->update('prices', ['item_id' => $item_id]);
	}

	public function update($price,$capital, $item_id, $store_number) {

		if ($this->session->userdata('account_type') == "Admin") {

			$stores = $this->db->get('stores')->num_rows();
			$data = [];

			for ($i = 1; $i <= $stores; $i++) {
 
				$data['store' . $i . '_capital'] = $capital;
				$data['store' . $i . '_retail'] = $price;
		 
		 
			}

 			return $this->db->where('item_id', $item_id)->update('prices', $data);

		}



		$capital_column = "store" . $store_number . "_capital";
		$retail_column = "store" . $store_number . "_retail";

		$data = [
				$retail_column => $price,
				$capital_column => $capital,
				'status' => 1
			];
		$data = $this->security->xss_clean($data);
		return $this->db->where('item_id', $item_id)->update('prices',$data);
	}

}