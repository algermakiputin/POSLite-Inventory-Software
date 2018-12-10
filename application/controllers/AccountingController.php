<?php 

class AccountingController extends CI_Controller {
	public function index() {
		
		$this->graph();
		$data['content'] = "accounting/index";
		$this->load->view('master',$data);;

	}

	public function graph() {

		$sales = $this->db->get("sales")->result();
		$description = $this->salesDescription($sales);
		$profit = 0;
		$capital = 0;

		foreach ($description as $desc) {
			$profit += (float) $desc['sale_price'] - (float) $desc['price'];
			$capital += (float) $desc['price'];
		}

	 

	}

	public function salesDescription($sales) {
		$data = [];

		foreach ($sales as $sale) {
			$description = $this->db->where('sales_id', $sale->id)->get("sales_description")->result();
			foreach ($description as $desc) {
			 
				$data[] = [
						'price' => $desc->price,
						'sale_price' => $desc->retail_price, 

					];
			}
		}
		return $data;
	}


 

}