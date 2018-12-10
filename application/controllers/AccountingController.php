<?php 

class AccountingController extends CI_Controller {
	public $totalProfit = 0;

	public function index() {

		$data['graph'] = $this->graph();
		$data['items'] = $this->table();
		$data['content'] = "accounting/index";
		$this->load->view('master',$data);;

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

	public function table() {
		$datasets = [];
		$items = $this->db->get("items")->result();
		foreach ($items as $item) {
			$price = $this->db->where('item_id', $item->id)->get('prices')->row()->price;
			$sales = $this->db->where('item_id', $item->id)->get("sales_description")->result();
			$stocks = $this->db->where('item_id', $item->id)->get('ordering_level')->row()->quantity;
			$sold = 0;
			$capital = 0;
			$revenue = 0;
			$profit = 0;
			$sub = 0;
			foreach ($sales as $sale) {
				$sold++;
				$capital += (float)$stocks * (float) $price;
				$revenue += (float)$sale->quantity * (float) $item->retail_price;
				$sub += (float) $sale->quantity * (float) $price;
			}

			$datasets[] = [
					'name' => $item->name,
					'sold' => $sold,
					'capital' => number_format($capital,2),
					'revenue' => number_format($revenue,2),
					'profit' => number_format($revenue - $sub,2)
				];


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