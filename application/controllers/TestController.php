<?php 

class TestController extends CI_Controller {

	public function insert_items() {

		$items = file_get_contents('./items.json');

		$decode = json_decode($items);
 
		foreach ($decode as $item) {

			$data = array(
				'name' => $item->name,
				'category_id' => $item->category_id,
				'description' => $item->description, 
				'supplier_id' => $item->supplier_id,
				'status' => 1,
				'barcode' => $item->barcode
			);

			$this->db->insert('items', $data);

			$item_id = $this->db->insert_id();

			$this->db->insert('prices', [
					'price' => $item->price,
					'capital' => $item->capital,
					'item_id' => $item_id,
					'wholesale' => 0
				]);

			$this->db->insert('ordering_level', [
					'quantity' => $item->quantity, 
					'item_id' => $item_id  
				]);

		}
	}
}