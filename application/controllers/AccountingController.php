<?php 

class AccountingController extends CI_Controller {
	public $totalProfit = 0;

	public function index() {

		$data['graph'] = $this->graph();
		$data['items'] = $this->table();
		$data['content'] = "accounting/index";
		$data['profit'] = $this->totalProfit;
		$this->load->view('master',$data);;

	}

	public function data() {
		$start = $this->input->post("columns[0][search][value]");
		$end = $this->input->post("columns[1][search][value]");

		$data = $this->table($start, $end);
		$count = count($data);
		echo json_encode([
				'draw' => $this->input->post('draw'),
				'recordsTotal' => $count,
				'recordsFiltered' => $count,
				'data' => $data,
				'profit' => $this->totalProfit
			]);
	}

	public function graph() {
		$lastWeek = (new Carbon\Carbon)->subDays(6);
		$date = new Carbon\Carbon;
		$datasets = [];
		for ( $i = $lastWeek; $i <= $date; $lastWeek->addDay()) {
			$sales = $this->db->where("DATE_FORMAT(date_time, '%Y-%m-%d') =", $i->format("Y-m-d"))
							->get("sales")->result();

			$description = $this->salesDescription($sales);
		 

			if ($description) {
				$profit = 0;
				foreach ($description as $desc) {
					$profit += (float) $desc['sale_price'] - (float) $desc['price'];
					$this->totalProfit += $profit;
					
				}

				$datasets[$i->format("l")] = $profit;
				continue;
			}

			$datasets[$i->format("l")] = 0;

		}

 		return $datasets;
	 
	}

	public function table($from = null, $to = null) {
		$this->totalProfit = 0;
		$from = $from ? $from : date('Y-m-d');
		$to = $to ? $to : date('Y-m-d');

		$datasets = [];
		$items = $this->db->get("items")->result();
		foreach ($items as $item) {
			$price = $this->db->where('item_id', $item->id)->get('prices')->row()->price;
			$sales = $this->db->where('item_id', $item->id)
							->where('DATE_FORMAT(created_at,"%Y-%m-%d") >=', $from)
							->where('DATE_FORMAT(created_at,"%Y-%m-%d") <=', $to)
							->get("sales_description")->result();
			$stocks = $this->db->where('item_id', $item->id)->get('ordering_level')->row()->quantity;
			$sold = 0;
			$capital = (float)$stocks * (float) $price;
			$revenue = 0;
			$profit = 0;
			$sub = 0;
		 	

			foreach ($sales as $sale) {
				$sold++;
				 
				$revenue += (float)$sale->quantity * (float) $item->retail_price;
				$sub += (float) $sale->quantity * (float) $price;

			}

			$datasets[] = [
					$item->name,
					$sold,
					number_format($capital,2),
					number_format($revenue,2),
					number_format($revenue - $sub,2)
				];

			$this->totalProfit += $revenue - $sub;
		}

		return ($datasets);


	}

	public function salesDescription($sales) {
		$data = [];

		foreach ($sales as $sale) {
			$description = $this->db->where('sales_id', $sale->id)->get("sales_description")->result();
			foreach ($description as $desc) {
			 	$item = $this->db->where('id', $desc->item_id)->get('items')->row();
		 		$price = $this->db->where('item_id', $desc->item_id)->get('prices')->row()->price;
				$data[] = [
						'price' => $price,
						'sale_price' => $item->retail_price, 

					];
			}
		}
		return $data;
	}


 

}