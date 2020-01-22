<?php

class ItemModel extends CI_Model {

	private $barcode, $name, $description, $status, $image; 

	public function itemList () { 
		return $this->db->select("items.*, supplier.name as supplier_name")
					->from("items")
					->join("supplier", "supplier.id = items.supplier_id", "both")
					->get()
					->result(); 
	}
 
	public function deleteItem($id) {

		$id = $this->security->xss_clean($id);
 		$this->db->trans_start();
 		$this->db->where('item_id', $id)->delete('ordering_level');
		$this->db->where('item_id', $id)->delete('prices');
		$this->db->where('id', $id)->delete('items');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}

		return $this->db->trans_commit();
		
	}

	public function getDetails($id) {
		$id = $this->security->xss_clean($id);
		return $this->db->where('id', $id)->get('items')->row();
	}

	public function item_info($id) {
		$id = $this->security->xss_clean($id);
		$sql = $this->db->where('id', $id)->get('items');
		return $sql->row();

	}

	public function update_item($item) { 
		 
		$data = array(
			'name' => $item['name'],
			'category_id' => $item['category'],
			'description' => $item['description'],
			'supplier_id' => $item['supplier'],
			'barcode' => $item['barcode'], 
			);
 
		if ($image != '')
			$data['image'] = $item['image'];
 
		return $this->db->where('id',$item['id'])->update('items',$data);
	}

	public function get_all_item() {
		$items = $this->db->select('name')->get('items');
		return $items->result_array();
	}

	public function total($store_number) {
		
		$column = "store" . $store_number;
		$total = $this->db->select("SUM(prices.capital * ordering_level.$column) as total")
								->from("items")
								->join("prices", "prices.item_id = items.id", "both")
								->join("ordering_level", "ordering_level.item_id = items.id", "both")
								->get()
								->row();

		return $total;

	}

}

?>