<?php
class Item_model extends CI_Model {

	public function insertItem($name, $category, $description,$supplier_id) 
	{
		$this->load->database();

		$data = array(
			'name' => $name,
			'category' => $category,
			'description' => $description, 
			'supplier_id' => $supplier_id

			);
		
		$sql = $this->db->insert('items', $data);

		if ($sql) {
			return $this->db->insert_id();
		}
	}

	public function deleteItem($id) {

		$this->load->database();
		$this->db->where('item_id', $id)->delete('ordering_level');
		$this->db->where('item_id', $id)->delete('prices');
		$sql = $this->db->where('id', $id)->delete('items');
		return $sql;
		
	}

	public function getDetails($id) {

		return $this->db->where('id', $id)->get('items')->row();
	}



	public function add_stocks($id,$stocks) {
		$this->load->database();
		

		return $this->db->where('item_id', $id)->update('ordering_level',['quantity' => 'quantity +' . $stocks]);

	}

	public function item_info($id) {

		$this->load->database();
		$sql = $this->db->where('id', $id)->get('items');
		return $sql->row();

	}

	public function update_item($id,$name,$category,$description,$price_id) {
		$this->load->database();
		$data = array(
			'name' => $name,
			'category' => $category,
			'description' => $description, 
			);

		return $this->db->where('id',$id)->update('items',$data);
	}

	public function get_all_item() {
		$this->load->database();
		$items = $this->db->select('name')->get('items');
		return $items->result_array();
	}

}

?>