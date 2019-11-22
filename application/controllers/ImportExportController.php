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

			 $data = array(
				'name' => $item['SKU'],
				'category_id' => 78,
				'description' => '', 
				'supplier_id' => 10,
				'status' => 1,
				'barcode' => $item['BAR CODE']
			);

			$this->db->insert('items', $data);

			$item_id = $this->db->insert_id();

			$this->PriceModel->insert($item['SELLING PRICE/UNIT'],$item['Average Cost (₱)'], $item_id);
			$this->db->insert('ordering_level', ['quantity' => $item['QUANTITY'], 'item_id' => $item_id]);
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