<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImportExportController extends CI_Controller {


	public function import_items() {

		$items = file_get_contents('./items.json');
 		$items = json_decode($items, true); 

 		$this->load->model('PriceModel');
		$this->load->model('OrderingLevelModel');


		$this->db->trans_begin();

		foreach ($items['Sheet1'] as $item) {
			$category_id = 0;
			$category = $this->db->where('name', $item['Category'])->get('categories')->row();

			if ($category) {
				$category_id = $category->id;
			}else {
				$this->db->insert('categories', ['name' => $item['Category'], 'active' => 1]);
				$category_id = $this->db->insert_id();
			}

			$data = array(
				'name' => $item['Item Name'],
				'category_id' => $category_id,
				'description' => '', 
				'supplier_id' => 10,
				'status' => 1,
				'barcode' => $item['Barcode']
			);

			$this->db->insert('items', $data);

			$item_id = $this->db->insert_id();

			$this->PriceModel->insert($item['Retail Price'], $item['Capital per/ Item'], $item_id);
			$this->db->insert('ordering_level', ['quantity' => $item['Stocks'], 'item_id' => $item_id]);
		}


		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		        echo "failed"; 
		        return false;
		}
		 
		$this->db->trans_commit(); 
	 
		echo "success";
	}

}