<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");
class VariationsController extends AppController {

	public function delete() {

		$id = $this->input->post('id');

		if ( $this->db->where('id', $id)->delete('variations') ) {

			echo "Variation deleted Successfully";
			return;
		}

		echo "Opps someting went wrong please try again later";
		return;
	}

	public function update() {

		$dataset = $this->input->post('dataset');
		$item_id = $this->input->post('item_id');


		$this->db->trans_begin();

		foreach ( $dataset as $key => $row) {

			$serial = $row['serial'];
			$new = $row['new_variation'];
			$name = $row['name'];
			$price = $row['price'];
			$stocks = $row['stock'];
			$variation_id = $row['variation_id'];
  
			if ( $new == 1) {

				$this->db->insert('variations', [
						'serial' => $serial,
						'name' => $name,
						'stocks'	=> $stocks,
						'price'	=> $price,
						'item_id' => $item_id
					]);


			}else {

				$this->db->where('id', $variation_id)
							->update('variations', [
								'serial' => $serial,
								'name'	=> $name,
								'price' => $price,
								'stocks' => $stocks,
							]);
			}
		}

		if ($this->db->trans_status() === FALSE) {
		      
		      $this->db->trans_rollback();
		      echo "Error: Duplicate Serial Code";
		      return;
		}

		$this->db->trans_commit(); 
		echo "Variations Updated Successfully";
		return;
		 
	}
}