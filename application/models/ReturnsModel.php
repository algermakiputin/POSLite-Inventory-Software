<?php 

class ReturnsModel extends CI_Model {

	public function insert($data, $OrderingLevelModel) {
 	

 		foreach ($data as $row) {
		 
    		if ($row['condition'] == "good") 
    			$OrderingLevelModel->addStocks( $row['item_id'], $row['return_qty'] );
    		 
    		$this->db->set('quantity', 'quantity-' . $row['return_qty'], false)
    					->where('id', $row['orderline_id'])
    					->update('sales_description', ['returned' => $row['return_qty']]);

    		$this->db->insert('returns', [
    					'item_id' => $row['item_id'],
    					'name'	=> $row['name'],
    					'item_condition'	=> $row['condition'],
    					'quantity'	=> $row['return_qty'],
    					'sales_description_id'	=> $row['orderline_id'],
    					'sales_id' => $row['sales_id'],
                        'date' => date('Y-m-d'),
                        'reason'    => $row['reason']
    			]);
    	}

	}

    public function get($limit, $start, $from, $to) {

        return $this->db->order_by('id', 'DESC')
                    ->where("date <=", $to)
                    ->where("date >=", $from)
                    ->get('returns',$limit, $start)
                    ->result();

    }

    public function count() {

        return $this->db->get('returns')
                        ->num_rows();
    }
}