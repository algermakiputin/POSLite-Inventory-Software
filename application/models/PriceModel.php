<?php 

class PriceModel extends CI_Model { 

	public function insert($price,$capital, $item_id) {
 
		$data = array(
				'price' => $price,
				'capital' => $capital,
				'item_id' => $item_id
			);
		$data = $this->security->xss_clean($data);
		$this->db->insert('prices', $data);
		return $this->db->insert_id();
	}

	public function getPrice($id) {
		 
		return $this->db->where('item_id',$id)->get('prices')->row()->price;
	}

	public function getCapital($id) {
		 
		return $this->db->where('item_id',$id)->get('prices')->row()->capital;
	}

	public function setId($id,$item_id) {
		return $this->db->where('id',$id)->update('prices', ['item_id' => $item_id]);
	}

	public function update($price,$capital, $item_id) {
		$data = [
				'price' => $price,
				'capital' => $capital,
				'status' => 1
			];
		$data = $this->security->xss_clean($data);
		return $this->db->where('item_id', $item_id)->update('prices',$data);
	}

}