<?php 

class PriceModel extends CI_Model { 

	public function insert($price, $wholesale, $capital, $item_id) {
 
		$data = array(
				'price' => $price,
				'wholesale' => $wholesale,
				'capital' => $capital,
				'item_id' => $item_id,
				'date_time' => get_date_time(),
			);
		$data = $this->security->xss_clean($data);
		$this->db->insert('prices', $data);
		return $this->db->insert_id();
	}

	public function getPrice($id) {
		 
		return $this->db->where('item_id',$id)->get('prices')->row()->price ?? 0;
	}

	public function getCapital($id) {
		 
		return $this->db->where('item_id',$id)->get('prices')->row()->capital ?? 0;
	}

	public function setId($id,$item_id) {
		return $this->db->where('id',$id)->update('prices', ['item_id' => $item_id]);
	}

	public function update($price, $wholesale,$capital, $item_id) {
		$data = [
				'price' => $price,
				'wholesale' => $wholesale,
				'capital' => $capital,
				'status' => 1
			];
		$data = $this->security->xss_clean($data);
		return $this->db->where('item_id', $item_id)->update('prices',$data);
	}

}