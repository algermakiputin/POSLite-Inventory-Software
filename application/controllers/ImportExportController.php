<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImportExportController extends CI_Controller {


	public function import_items() {

		$items = file_get_contents('./items.json');
 		$items = json_decode($items, true);



		$this->db->trans_begin();

		foreach ($items['Sheet1'] as $item) {

			 
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