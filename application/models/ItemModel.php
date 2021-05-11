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

	public function inventory_value() {

		return $this->db->select("SUM(items.capital * ordering_level.quantity) as total")
												->from('items')
												->join('ordering_level', 'ordering_level.item_id = items.id')
												->get()
												->row()
												->total;
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

	public function update_item(
			$id,
			$name,
			$category,
			$description,
			$price_id, 
			$image, 
			$supplier_id, 
			$barcode, 
			$price, 
			$capital 
		) {
		
		$item = $this->db->where('id',$id)->get('items')->row(); 

		$data = array(
			'name' => $name,
			'category_id' => $category,
			'description' => $description,
			'supplier_id' => $supplier_id,
			'barcode' => $barcode,
			'price'	=> $price,
			'capital' => $capital
			);

		$data = $this->security->xss_clean($data);
		if ($image != '')
			$data['image'] = $image;
 
		return $this->db->where('id',$id)->update('items',$data);
	}

	public function get_all_item() {
		$items = $this->db->select('name')->get('items');
		return $items->result_array();
	}

	public function total() {
		return $this->db->select("SUM(prices.capital * ordering_level.quantity) as total")
					->from("items")
					->join("prices", "prices.item_id = items.id", "both")
					->join("ordering_level", "ordering_level.item_id = items.id", "both")
					->get()
					->row();
	}

}

?>