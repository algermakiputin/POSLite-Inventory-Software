<?php
class Item_model extends CI_Model {

	public function itemList () {
		$this->load->database();
		$sql = $this->db->order_by('id','DESC')->where('status', 1)->get('items');
		$result = $sql->result();
		return $result;
	}

	public function insertItem($name, $category, $description,$supplier_id,$barcode) 
	{

		$data = array(
			'name' => $name,
			'category_id' => $category,
			'description' => $description, 
			'supplier_id' => $supplier_id,
			'status' => 1,
			'barcode' => $barcode

			);
		
		$sql = $this->db->insert('items', $data);

		if ($sql) {
			return $this->db->insert_id();
		}
	}

	public function deleteItem($id) {
 
		return $this->db->where('id', $id)->update('items', ['status' => 0]);
		
	}

	public function getDetails($id) {

		return $this->db->where('id', $id)->get('items')->row();
	}

	public function item_info($id) {

		$sql = $this->db->where('id', $id)->get('items');
		return $sql->row();

	}

	public function update_item($id,$name,$category,$description,$price_id) {
		$item = $this->db->where('id',$id)->get('items')->row();

		$data = array(
			'name' => $name,
			'category_id' => $category,
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