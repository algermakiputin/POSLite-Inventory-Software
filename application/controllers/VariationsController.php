<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


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

	public function export_variations() {

	 	$category_id = $this->input->get('category');
	 	$condition = $this->input->get('condition');
 

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Serial');
		$sheet->setCellValue('B1', 'Product');
		$sheet->setCellValue('C1', 'Capital');
		$sheet->setCellValue('D1', 'Price');
		$sheet->setCellValue('E1', 'Stocks'); 
		$sheet->setCellValue('F1', 'Condition'); 

		$conditions = ["Brand New", "Used"];

		$variations = $this->db->select('items.*, variations.*')
									->from('items') 
									->join('variations', 'variations.item_id = items.id')
									->like('items.condition_status', $conditions[$condition], "BOTH")
									->like('items.category_id', $category_id, "BOTH") 
									->get()
									->result();
 
		foreach ($variations as $key => $row ) {

			$i = 2 + $key;
	
			$sheet->setCellValue('A' . $i, $row->serial);
			$sheet->setCellValue('B' . $i, $row->name);
			$sheet->setCellValue('C' . $i, currency() . number_format($row->capital, 2));
			$sheet->setCellValue('D' . $i, currency() . number_format($row->price,2));
			$sheet->setCellValue('E' . $i, $row->stocks);  	
			$sheet->setCellValue('F' . $i, $row->condition_status);  
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="DeliveriesReport-'.$from . ' - ' . $to.'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');	
	}
}