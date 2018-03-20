<?php
class Item_model extends CI_Model {
	public function insertItem($name, $category, $description, $date_time, $creator, $quantity, $price) 
	{
		$data = array(
			'name' => "$name",
			'category' => "$category",
			'description' => "$description",
			'date_time' => "$date_time",
			'creator' => "$creator",
			'quantities' => "$quantity",
			'price' =>	"$price"
			);
		$this->load->database();
		$sql = $this->db->insert('items', $data);
		if ($sql) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">New Item Has Been Added</div>');
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">New Item Has Been Added Successfully </div>');
			redirect(base_url('inventory'));
		}
	}

	public function deleteItem($id) {
		$this->load->database();
		$sql = $this->db->where('id', $id)
						->delete('items');
		return $sql;
		
	}

	public function add_stocks($itemName,$stocks) {
		$this->load->database();
		$sql = $this->db->query("UPDATE items SET quantities = quantities + ".$this->db->escape($stocks)." WHERE name = ".$this->db->escape($itemName)."");
		return $sql;

	}

	public function item_info($itemName) {
		$this->load->database();
		$sql = $this->db->where('name', urldecode($itemName))->get('items');
		return $sql->row();

	}

	public function update_item($id,$name,$category,$description,$price) {
		$this->load->database();
		$data = array(
			'name' => "$name",
			'category' => "$category",
			'description' => "$description",
			'price' => "$price"
			);

		$this->db->where('id',$id);
		return $this->db->update('items',$data);
	}

	public function get_all_item() {
		$this->load->database();
		$items = $this->db->select('name')->get('items');
		return json_encode($items->result_array());
	}

}

?>