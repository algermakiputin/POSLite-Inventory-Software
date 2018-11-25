<?php
class SalesController extends CI_Controller {
	public function __construct() {
		
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}

	public function index() {
		
	}

	public function sales () {

		$data['dataset'] = $this->graphSales();
		$data['content'] = "sales/index";
		$this->load->view('master',$data);;
		 
	}

	public function graphSales($range = "week") {
	 
		if ($range == "week") {
			$currentDate = date('Y-m-d');
			$lastWeek = date('Y-m-d', $this->lastWeek());
			$begin = new DateTime( $lastWeek );
			$end = new DateTime( $currentDate );
			$end = $end->modify( '+1 day' );
			$format = "D, d";
			$sqlDateFormat = "%Y-%m-%d";
			$dateFormat = 'Y-m-d';
			$int = "P1D";

		}else if ($range == "month") {
			$firstMonth = date('Y-1-1');
			$lastMonth = date('Y-12-1');
			$begin = new DateTime($firstMonth);
			$end = new DateTime($lastMonth);
			$end->modify('last day of this month');
			$format = "M";
			$sqlDateFormat = "%Y-%m";
			$dateFormat = "Y-m";
			$int = "P1M";
		}else if ($range == "year") {
		 
			$firstMonth = date('2016-1-1');
		 
			$lastMonth = date('Y-12-1');
			$begin = new DateTime($firstMonth);
			$end = new DateTime($lastMonth);

			$end->modify('last day of this month');
			$format = "Y";
			$sqlDateFormat = "%Y";
			$dateFormat = "Y";
			$int = "P1Y";
		}
		
		$datasets = [];

	 	 

		$interval = new DateInterval($int);
		$daterange = new DatePeriod($begin, $interval ,$end);
		$total = 0;

		foreach($daterange as $date){
	 	  
		 	$sales = $this->db->where('DATE_FORMAT(date_time,"'.$sqlDateFormat.'") =', $date->format($dateFormat)) 
						->get('sales')
						->result();
			
		    	if ($sales) {
		    		foreach ($sales as $sale) {
			    		$description = $this->getSalesDescription($sale->id);
			    		
					foreach ( $description as $descr) {
						$price = $this->db->where('item_id', $descr->item_id)->get('prices')->row()->price;
						$total += $price * $descr->quantity;
						
					}	
				}
				$datasets[$date->format($format)][] = $total;
		    	}else {
		    		$datasets[$date->format($format)][] = 0;
		    	}
		}

		return $datasets;
	}

	public function graphFilter() {
		$type = $this->input->post('type');
		echo json_encode($this->graphSales($type));
		return;
	}

	public function hasSales($sales, $date) {
		foreach ($sales as $sale) {

			$saleDate = date('Y-m-d', strtotime($sale->date_time));
			if (!$saleDate == $date)
				continue;

			return true;
		}

		return false;
	}

	public function lastWeek() {
		return $sunday = strtotime(date("Y-m-d h:i:s")." -6 days");
	}

	public function getSalesDescription($id) {
		 
		return $this->db->where('sales_id', $id)->get('sales_description')->result();
 
	}

	public function insert() {
		$data = [];
		$sales = $this->input->post('sales');
		 
		$this->db->insert('sales',[
				'id' => null 
			]);

		$sales_id = $this->db->insert_id();
			 
		$this->db->trans_begin();
		
		foreach ($sales as $sale) {
			$data[] = [
				'item_id' => $sale[0],
				'quantity' => $sale[1],
				'sales_id' => $sales_id
			];

			$this->db->set('quantity', "quantity -$sale[1]" , false);
			$this->db->where('item_id', $sale[0]);
			$this->db->update('ordering_level');
		}
 

		$this->db->insert_batch('sales_description', $data);

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		}
		else
		{
		        $this->db->trans_commit();
		}

		echo $sales_id;
		return;
	}

	public function reports() {

		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$datasets = [];
		$totalSales = 0;
		$from = $this->input->post('columns[0][search][value]');
		$to = $this->input->post('columns[1][search][value]');
		
		if ($from && $to) {
			$sales = $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
						->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
						->order_by('id', 'DESC')
						->get('sales', $start, $limit)->result();


		}else {
			$date = date('Y-m-d');
			$sales = $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") =', $date)
						->order_by('id', 'DESC')
						->get('sales', $start, $limit)->result();
		}

		$count = count($sales);
		
		foreach ($sales as $sale) {
			$sales_description = $this->db->where('sales_id', $sale->id)->get('sales_description')->result();
			$sub_total = 0;
			
			foreach ($sales_description as $desc) {
				$item = $this->db->where('id', $desc->item_id)->get('items')->row();
				$price = $this->db->where('item_id', $desc->item_id)->get('prices')->row()->price;
				$sub_total += ((int)$desc->quantity * (int) $price);
				$datasets[] = [ 
					date('Y-m-d h:i:s a', strtotime($sale->date_time)), 
					$item->barcode,
					$item->name,
					$desc->quantity,
					'₱'. (int)$desc->quantity * (int)$price
				];
			}

			$totalSales += $sub_total;
			
		}

		echo json_encode([
				'draw' => $this->input->post('draw'),
				'recordsTotal' => $count,
				'recordsFiltered' => $count,
				'data' => $datasets,
				'total_sales' => number_format($totalSales),
				'from' => $from,
				'to' => $to
			]);

	}

	public function details() {
		$id = $this->input->post('id');
		$datasets = [];

		$description = $this->db->where('sales_id', $id)->get('sales_description')->result();
		foreach ($description as $desc) {
			$item = $this->db->where('id', $desc->item_id)->get('items')->row();
			$price = $this->db->where('item_id', $item->id)->get('prices')->row()->price;
			$sub_total = (int)$price * (int)$desc->quantity;
			$datasets[] = [
				$item->id,
				$item->name,
				$price,
				$desc->quantity,
				$sub_total
			];
		}
		echo json_encode($datasets);
		return;
	}
}
?>