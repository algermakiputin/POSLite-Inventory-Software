<?php 

class OrderingLevelModel extends CI_Model { 

	public function insert( $item_id ) {
		$data = array(
				'quantity' => 0,
				'item_id' => $item_id
			);
		return $this->db->insert('ordering_level', $data);
	}

	public function getQuantity($id) {
		return $this->db->where('item_id', $id)->get('ordering_level')->row();
	}

	public function addStocks($id, $stocks) {
		$ordering_level = $this->db->where('item_id', $id)->get('ordering_level')->row();
		$quantity = (int) $ordering_level->quantity + $stocks;
		return $this->db->where('item_id', $id)->update('ordering_level', ['quantity' => $quantity]);
	}
}