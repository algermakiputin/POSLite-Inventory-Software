<?php 


class OrderingLevelController extends CI_Controller {

	public function set_barcode () {

		$ordering_level = $this->db->get('ordering_level')->result();

		foreach ($ordering_level as $row) {

			$item = $this->db->where('id', $row->item_id)->get('items')->row();

			if ($item) {

				$this->db->where('id', $row->id)
							->update('ordering_level', [
										'barcode' => $item->barcode
									]);
			}
		}
	}
}