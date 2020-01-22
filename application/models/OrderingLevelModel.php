<?php 

class OrderingLevelModel extends CI_Model { 

	public function insert( $item_id ) {
		$data = array(
				'quantity' => 0,
				'item_id' => $item_id
			);
		return $this->db->insert('ordering_level', $data);
	}

	public function getQuantity($id, $store) {

		$column = "store" . $store;   
		return $this->db->where('item_id', $id)->get('ordering_level')->row_array()[$column] ?? 0;

	}

	public function addStocks($id, $stocks) {
		$this->db->set('quantity', 'quantity+' . $stocks, FALSE);
		$this->db->where('item_id', $id);
		return $this->db->update('ordering_level'); 
	}

	public function update_stocks($items, $store_number) {

		$this->db->trans_begin(); 
		$column = "store" . $store_number;
		foreach ($items as $item) {

			$this->db->set("$column", "$column-" . $item['quantity'], FALSE);
			$this->db->where('item_id', $item['item_id']);
			$this->db->update('ordering_level');

		}

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback(); 
		        return false;
		}
		 

		$this->db->trans_commit(); 
		return true; 

	}

	public function stocks_transfer($items, $store_number) {

		$this->db->trans_begin(); 
		$column = "store" . $store_number;
 
		foreach ($items as $item) {

			$this->db->set("$column", "$column+" . $item->quantity, FALSE);
			$this->db->where('item_id', $item->item_id); 
			$this->db->update('ordering_level');

		}

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback(); 
		        return false;
		}
		 

		$this->db->trans_commit(); 
		return true; 

	}
}