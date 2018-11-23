<?php 

class PriceModel extends CI_Model { 

	public function insert($price, $item_id) {
		$this->load->database();
		$data = array(
				'price' => $price,
				'item_id' => $item_id
			);
		$this->db->insert('prices', $data);
		return $this->db->insert_id();
	}

	public function getPrice($id) {
		 
		return $this->db->where('item_id',$id)->get('prices')->row()->price;
	}

	public function setId($id,$item_id) {

		$this->load->database();

		return $this->db->where('id',$id)->update('prices', ['item_id' => $item_id]);
	}

	public function update($price, $item_id) {

		$this->load->database();

		return $this->db->where('item_id', $item_id)->update('prices',[
				'price' => $price,
				'status' => 1
			]);
	}

}