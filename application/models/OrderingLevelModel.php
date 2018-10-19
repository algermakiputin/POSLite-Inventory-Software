<?php 

class OrderingLevelModel extends CI_Model { 

	public function insert( $item_id) {
		$this->load->database();
		$data = array(
				'quantity' => 0,
				'item_id' => $item_id
			);

		return $this->db->insert('ordering_level', $data);

	}

	public function getQuantity($id) {
		$this->load->database();

		return $this->db->where('item_id', $id)->get('ordering_level')->row();
	}
}