<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");
class DashboardController extends AppController {

	public function index() {
 		
 		$this->load->model('sales_model');
 		//$this->load->model('ExpensesModel');


 		$yesterday = $date = date('Y-m-d', strtotime("-1 day"));
		$data['content'] = 'dashboard/index';
		$data['dataset'] = json_encode($this->line_chart(date('Y-m-d'))); 
		$data['yesterday'] = json_encode($this->line_chart($yesterday));
		$data['top_products'] = $this->top10_product();
		$data['not_selling'] = $this->not_selling_products()->num_rows();
		$data['low_stocks'] = count(low_stocks());
		$data['no_stocks'] = 1;//count(noStocks());
		$data['average_sales_per_day'] = $this->average_sales_per_day();
		$data['orders'] = $this->db->where('date_format(date_time, "%Y-%m-%d") =', date('Y-m-d'))->get('sales')->num_rows();
		$data['sales'] = number_format($this->sales_model->get_sales(date('Y-m-d'))->total,2);
		$data['expenses'] = 0//number_format( number_format($this->ExpensesModel->total, 2) );
		$data['revenue'] = number_format( $this->sales_model->get_annual_sales(date('Y'))->total );

		$lastweek = date('Y-m-d', strtotime('-7 days'));
		$today = date('Y-m-d');
 

		$this->load->view('master', $data);
	}

	public function diagnoses() {

		$data['content'] = "dashboard/diagnoses";
		$data['not_selling'] = $this->not_selling_products()->result();
		$data['out_of_stocks'] = noStocks();
		$data['low_stocks'] = low_stocks();
		$this->load->view('master', $data);
	}

	private function top10_product() {

		$date = date('Y-m-d');

		$sales = $this->db->select('SUM(quantity) as qty, name, SUM(quantity * price) as revenue')
								->from('sales_description')
								->group_by('item_id')
								->where('DATE_FORMAT(created_at, "%Y-%m-%d") =', $date)
								->where('quantity >=', 1)
								->order_by('qty', "DESC")
								->limit(10)
								->get()
								->result();
 
		
		return $sales;

	} 

	public function average_sales_per_day() {

		$last_month = date('Y-m-d', strtotime('-30 days'));

		$sales = $this->db->select('sales.id, SUM(sales_description.price * sales_description.quantity) as total')
								->from('sales')
								->join('sales_description', 'sales_description.sales_id = sales.id')
								->group_by('sales.id')
								->where('DATE_FORMAT(date_time, "%Y-%m-%d") >', $last_month)
								->get()
								->result();

		$count = count($sales);

		if ($count < 10) {

			return "Not enough data";
		}

		$total = 0;
		$average_sales_per_day = 0;

		foreach ($sales as $row) {

			$total += $row->total;
		} 

		return  currency() . number_format($total / $count,2);
 
		 
	}

	public function not_selling_products() {

		$query = "SELECT items.id, items.barcode, items.name, prices.price, ordering_level.quantity
						FROM items
						INNER JOIN prices ON prices.item_id = items.id
						INNER JOIN ordering_level ON ordering_level.item_id = items.id 
						WHERE items.id
						NOT IN
						(
							SELECT item_id
							FROM sales_description 
							WHERE DATE_FORMAT(sales_description.created_at, '%Y-%m-%d') >= '$lastweek'
						)
						LIMIT 450
					";

		return $this->db->query($query); 
	}

	private function line_chart($date) {


		$sales = $this->db->select("date_format(sales.date_time, '%H.%i') as time, sales.id,sales.id, SUM(sales_description.price * sales_description.quantity) as total_sales")
								->from('sales')
								->join('sales_description', 'sales_description.sales_id = sales.id', 'LEFT')
								->where('date_format(sales.date_time, "%Y-%m-%d") =', $date)
								->group_by('sales.id')
								->get()
								->result(); 
	 
		$total_sales = 0;

		$points = 24;
		$current_time = date('H') + 1.99;
		if ($date == date('Y-m-d'))
			$points = $current_time;

		$dataset = [];


		for ($y = 0; $y < $points; $y++) {

			$dataset[$y] = 0;
		}

 	
 		$time_slots = [0.0, 0.59, 1.59, 2.59, 3.59, 4.59, 5.59, 6.59, 7.59, 8.59, 9.59, 10.59, 11.59, 12.59, 13.59, 14.59, 15.59, 16.59, 17.59, 18.59, 19.59, 20.59, 21.59, 22.59, 23.59 ];

		foreach ($sales as $row) {
			
 		
			for ($i = 1; $i < count($time_slots); $i++) {

				$time = $row->time;

				if ($time > $time_slots[$i - 1] && $time < $time_slots[$i] && array_key_exists($i, $dataset)) {

					$dataset[$i] += $row->total_sales;
					continue;
				}

			}  

		} 


		for ($x = 1; $x < count($dataset); $x++) {

			$dataset[$x] = $dataset[$x - 1] + $dataset[$x];
		}

		return $dataset;
	}

}