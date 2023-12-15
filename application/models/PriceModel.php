<?php 

class PriceModel extends CI_Model { 

	public function insert($price_label, $advance_price, $item_id) {

		
 		$this->db->where('item_id', $item_id)->delete('prices');

 		foreach ($price_label as $key => $label) {


 			if (!$price_label || !$advance_price[$key])
 				continue;
 			 

 			$data = array(
 				'label' => $label,
				'price' => $advance_price[$key],
				'capital' => 0,
				'item_id' => $item_id,
				'date_time' => get_date_time(),
			);

			$data = $this->security->xss_clean($data);
			$this->db->insert('prices', $data);
 		}
		
	}

	public function getPrice($id) {
		 
		return $this->db->where('item_id',$id)->get('prices')->row()->price ?? 0;
	}

	public function getCapital($id) {
		 
		return $this->db->where('item_id',$id)->get('prices')->row()->capital ?? 0;
	}

	public function setId($id,$item_id) {
		return $this->db->where('id',$id)->update('prices', ['item_id' => $item_id]);
	}

	public function update($price,$capital, $item_id) {
		$data = [
				'price' => $price,
				'capital' => $capital,
				'status' => 1
			];
		$data = $this->security->xss_clean($data);
		return $this->db->where('item_id', $item_id)->update('prices',$data);
	}

}