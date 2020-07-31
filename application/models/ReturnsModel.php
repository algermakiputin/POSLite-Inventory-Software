<?php 

class ReturnsModel extends CI_Model {

	public function insert($data) {
 	    
 		foreach ($data as $row) {

    		if ($row['condition'] == "good")  {

                $this->db->set('stocks', 'stocks+' . $row['return_qty'], FALSE);
                $this->db->where('serial', $row['barcode']); 
                $this->db->update('variations'); 
            }
    		

    		$this->db->set('quantity', 'quantity-' . $row['return_qty'], false)
    					->where('barcode', $row['barcode'])
                        ->where('transaction_number', $row['transaction_number'])
    					->update('sales_description', ['returned' => $row['return_qty']]);

    		$this->db->insert('returns', [
    					'barcode' => $row['barcode'],
    					'name'	=> $row['name'],
    					'item_condition'	=> $row['condition'],
    					'quantity'	=> $row['return_qty'],
    					'transaction_number'	=> $row['transaction_number'], 
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