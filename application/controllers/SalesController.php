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
		$data['content'] = "sales/index";
		$this->load->view('master',$data);;
		 
	}

	public function insert() {
		$data = [];
		$sales = $this->input->post('sales');
		$this->db->trans_begin();
		
		foreach ($sales as $sale) {
			$data[] = [
				'item_id' => $sale[0],
				'quantity' => $sale[1],
				'price' => $sale[2],
				'sub_total' => $sale[3],
				'customer_id' => $sale[4]
			];

			$this->db->set('quantity', "quantity -$sale[1]" , false);
			$this->db->where('item_id', $sale[0]);
			$this->db->update('ordering_level');
		}
 

		$this->db->insert_batch('sales', $data);

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		}
		else
		{
		        $this->db->trans_commit();
		}

		return 0;
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
						->get('sales', $start, $limit)->result();


		}else {
			$date = date('Y-m-d');
			$sales = $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") =', $date)
						->get('sales', $start, $limit)->result();
		}

		$count = count($sales);
		foreach ($sales as $sale) {
			$totalSales += $sale->sub_total;
			$datasets[] = [
				$sale->date_time,
				$sale->item_id,
				$this->db->where('id', $sale->item_id)->get('items')->row()->name,
				$sale->quantity,
				$sale->sub_total
			];
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
}
?>