<?php

class ItemModel extends CI_Model {

	public function itemList () {
		$this->load->database();
		$sql = $this->db->order_by('id','DESC')->where('status', 1)->get('items');
		$result = $sql->result();
		return $result;
	}

	public function insertItem($name, $category, $description,$supplier_id,$barcode, $criticalLevel) 
	{

		$data = array(
			'name' => $name,
			'category_id' => $category,
			'description' => $description, 
			'supplier_id' => $supplier_id,
			'status' => 1,
			'barcode' => $barcode,
			'critical_level' => $criticalLevel

			);
		
		$sql = $this->db->insert('items', $data);

		if ($sql) {
			return $this->db->insert_id();
		}
	}

	public function deleteItem($id) {
 		
 		$this->db->where('item_id', $id)->delete('ordering_level');
		$this->db->where('item_id', $id)->delete('prices');
		return $this->db->where('id', $id)->delete('items');
		
	}

	public function getDetails($id) {

		return $this->db->where('id', $id)->get('items')->row();
	}

	public function item_info($id) {

		$sql = $this->db->where('id', $id)->get('items');
		return $sql->row();

	}

	public function update_item($id,$name,$category,$description,$price_id, $retail_price) {
		$item = $this->db->where('id',$id)->get('items')->row();

		$data = array(
			'name' => $name,
			'category_id' => $category,
			'description' => $description, 
			'retail_price' => $retail_price
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