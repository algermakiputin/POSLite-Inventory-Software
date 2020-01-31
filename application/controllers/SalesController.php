<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SalesController extends CI_Controller {

	public function __construct() {

		parent::__construct();
	 
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}

	public function find_invoice() {

		$invoice_number = $this->input->post('invoice_number');

		$invoice = $this->db->where('transaction_number', $invoice_number)->get('sales')->row();

		if ($invoice) {

			$orderline = $this->db->where('sales_id', $invoice->id)->get('sales_description')->result();

			echo json_encode([
					'invoice'	=> $invoice,
					'orderline'	=> $orderline
				]);
		}else {

			echo "0";

		}



	}

	public function confirm_sale() {

		$invoice_number = $this->input->post('invoice_number');
		$payment_type = $this->input->post('payment_type');

		$insert = $this->db->where('transaction_number', $invoice_number)->update('sales', ['status' => 1, 'payment_type' => $payment_type]);


		if (!$insert) {

			errorMessage("Opps Something Went Wrong Please Try Again Later");
		} 


		success("Sales Registered Successfully");
		return redirect('sales/new');
	}
 

	public function sales () {
		$data['widget_column'] = is_admin() ? 4 : 6;
		$data['dataset'] = $this->graphSales();
		$data['content'] = "sales/index";
		$this->load->view('master',$data);
		 
	}

	public function export() {
		$dompdf = new Dompdf\Dompdf;
		$html = "";
		$from = $this->input->get('start');
		$to = $this->input->get('end');
		$totalSales = 0;
		$tbody = "";
		$sales = $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
					->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
					->order_by('id', 'DESC')
					->get('sales')->result();
		foreach ($sales as $sale) {
			$sales_description = $this->db->where('sales_id', $sale->id)->get('sales_description')->result();
			$sub_total = 0;
		 	
			foreach ($sales_description as $desc) {
	 			
				$price = $desc->price;
				$sub_total += ((float)$desc->quantity * (float) $price);
				
				if ($desc) {
					$tbody .= "<tr>
						<td>".date('Y-m-d h:i:s a', strtotime($sale->date_time))."</td>
						<td>".ucwords($desc->name)."</td>
						<td>".$desc->quantity."</td>
						<td>".('<span class="sign">&#x20b1;</span>'. $price)."</td>
						<td>".('&#x20b1;'. number_format((float)$desc->quantity * (float)$price))."</td>
						</tr>
					";
				}	
				 
			} 
			$totalSales += $sub_total; 
		}

		$html .= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
				<link type='text/css' href='".base_url('assets/print.css')."' rel='stylesheet'>
				<link type='text/css' href='".base_url('assets/print.css')."' rel='stylesheet'>
			";
		$html .= "<h1 class='text-center'>Sales Reports</h1>";
		$html .= "<div class='date'><h4>Date:</h4>";
		$html .= "<div class='date'>From: " . $from . "</div>";
		$html .= "<div class='date'>To: " . $to . "</div></div>";
		$html .= "<div class='right'><h4>Total Sales:</h4>₱".number_format($totalSales)."</div>";
		$html .= "<div class='clearfix'></div>";
		$html .= "<br>";
		$html .= "<table class='table table-striped'>";
		$html .= "<thead><tr>";
		$html .= "<th>DateTime</th> <th>Item Name</th> <th>Quantity</th><th>Price</th><th>Sub Total</th>";
		$html .= "</tr></thead>";
		
		$html .= "<tbody>";
		$html .= $tbody;
		$html .= "</tbody>";
		$html .= "</table>";
	 
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portraite');
		$dompdf->render();
		$dompdf->stream();
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
						$item = $this->db->where('id', $descr->item_id)->get('items')->row();
						$total += $descr->price * $descr->quantity;
					}	
				}

				$datasets[$date->format($format)][] = round($total,2);
		    	}else {
		    		$datasets[$date->format($format)][] = 0;
		    	}

		    	$total = 0;
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

	public function new() {

		$data['content'] = "sales/new_sales";
		$this->load->view('master', $data);
	}
 
	public function lastWeek() {
		return $sunday = strtotime(date("Y-m-d h:i:s")." -6 days");
	}

	public function getSalesDescription($id) {
		 
		return $this->db->where('sales_id', $id)->get('sales_description')->result();
 
	}

	public function insert() {
		$data = [];
		// $last_sales_id = $this->db->select_max('id')->get('sales')->row()->id;
		// $transaction_number = "TRN000" . ((int)$last_sales_id + 1 ); 

		$status = 0;
		$sales = $this->input->post('sales');
		$type = $this->input->post('transaction_type');
		$status = $type == "cash" || $type == "cod" ? 1 : 0;
		$total_amount = $this->input->post('total_amount');
		$customer_id = $this->input->post('customer_id');
		$supplier_id = $this->input->post('supplier_id');
		$supplier_name = $this->input->post('supplier_name');
		$store_number = $this->session->userdata('store_number');
		$invoice_number = $this->input->post('invoice');
		$user_name = $this->session->userdata('username');

		$address = "";
		$city = "";
		$zipcode = "";

		if ( $customer_id ) {

			$customer = $this->db->where('id', $customer_id)->get('customers')->row();
		 
			if ($customer) {

				$address = $customer->address;
				$city = $customer->city;
				$zipcode = $customer->zipcode;

			}
		}

		$this->load->model("PriceModel");
		$this->load->model("OrderingLevelModel");
		$this->db->trans_begin(); 

		/*	4 Types of Transactions 
			1. Cash - When cash is selected, Automatically insert transaction as done, and update inventory.
			2. Credit - Transaction is not yet completed as the payment will still be credit to the customer account but inventory would be updated,
			3. Stand By - Transaction would be saved as standby status. There is no sales yet, and can be modified until the transaction is completed by the user.
			4. Invoice - This is an invoice contain prices of the products that will be sent to the customer, No transaction yet so will not update inventory value.
		*/
		$this->db->insert('sales',[
				'id' => null , 
				'transaction_number' => $invoice_number, 
				'user_id' => $this->session->userdata('id'),
				'customer_id' => $customer_id,
				'customer_name' => $this->input->post('customer_name'),
				'type' => $this->input->post('transaction_type'),
				'status' => $status,
				'total' => $total_amount,
				'note' => $this->input->post('note'),
				'address' => $address,
				'city'	=> $city,
				'zipcode' => $zipcode,
				'supplier_id' => $supplier_id,
				'supplier_name' => $supplier_name,
				'date_time' => get_date_time(),
				'user_id' => $this->session->userdata('id'),
				'store_number' => $store_number,
				'user_name' => $user_name
			]);

		$sales_id = $this->db->insert_id();
		$sales = $this->security->xss_clean($sales);
		$column = "store" . $store_number;

		foreach ($sales as $sale) {
			$transactionProfit = $this->db->where('item_id', $sale['id'])->get('prices')->row()->capital;

			$data[] = [ 
				'item_id' => $sale['id'],
				'quantity' => $sale['quantity'],
				'sales_id' => $sales_id, 
				'price' => $sale['price'],
				'name' => $sale['name'],
				'discount' => $sale['discount'] ?? 0,
				'profit' => $transactionProfit,
				'user_id' => $this->session->userdata('id'),
				'created_at' => get_date_time()  
			];
			 
		}
  
		$this->db->insert_batch('sales_description', $data);
		$this->OrderingLevelModel->update_stocks($data, $store_number);

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		        return false;
		}
		 
		$this->db->trans_commit(); 
		echo $invoice_number;
		return;
	}


	public function insert_invoice_po() {
		$data = [];
		// $last_sales_id = $this->db->select_max('id')->get('sales')->row()->id;
		// $transaction_number = "TRN000" . ((int)$last_sales_id + 1 ); 

		$status = 0; 
		$type = $this->input->post('transaction_type');
		$status = $type == "cash" || $type == "cod" ? 1 : 0;
		$total_amount = $this->input->post('total_amount');
		$customer_id = $this->input->post('customer_id');
		$supplier_id = $this->input->post('supplier_id');
		$supplier_name = $this->input->post('supplier_name');
		$store_number = $this->session->userdata('store_number');
		$invoice_number = $this->input->post('invoice');
		$user_name = $this->session->userdata('username');

		$address = "";
		$city = "";
		$zipcode = "";

		if ( $customer_id ) {

			$customer = $this->db->where('id', $customer_id)->get('customers')->row();
		 
			if ($customer) {

				$address = $customer->address;
				$city = $customer->city;
				$zipcode = $customer->zipcode;

			}
		}

		$this->load->model("PriceModel");
		$this->load->model("OrderingLevelModel");
		$this->db->trans_begin(); 

		/*	4 Types of Transactions 
			1. Cash - When cash is selected, Automatically insert transaction as done, and update inventory.
			2. Credit - Transaction is not yet completed as the payment will still be credit to the customer account but inventory would be updated,
			3. Stand By - Transaction would be saved as standby status. There is no sales yet, and can be modified until the transaction is completed by the user.
			4. Invoice - This is an invoice contain prices of the products that will be sent to the customer, No transaction yet so will not update inventory value.
		*/
		$this->db->insert('sales',[
				'id' => null , 
				'transaction_number' => $invoice_number, 
				'user_id' => $this->session->userdata('id'),
				'customer_id' => $customer_id,
				'customer_name' => $this->input->post('customer_name'),
				'type' => $this->input->post('transaction_type'),
				'status' => $status,
				'total' => $total_amount,
				'note' => $this->input->post('note'),
				'address' => $address,
				'city'	=> $city,
				'zipcode' => $zipcode,
				'supplier_id' => $supplier_id,
				'supplier_name' => $supplier_name,
				'date_time' => get_date_time(),
				'user_id' => $this->session->userdata('id'),
				'store_number' => $store_number,
				'user_name' => $user_name
			]);

		$sales_id = $this->db->insert_id();
		$sales = $this->security->xss_clean($sales);
		$column = "store" . $store_number;

		$item_ids = $this->input->post('product_id[]');
		$quantity = $this->input->post('quantity[]');
		$price = $this->input->post('price[]');
		$product = $this->input->post('product[]'); 

		
		for ($i = 0; $i < count($item_ids); $i++) {
			$item_id = $sales_id[$i];
			$qty = $quantity[$i];
			$name = $product[$i];
			$price = $price[$i];

			$transactionProfit = $this->db->where('item_id', $sales_id[$i])->get('prices')->row()->capital;

			$data[] = [ 
				'item_id' => $item_id,
				'quantity' => $qty,
				'sales_id' => $sales_id, 
				'price' => $price,
				'name' => $name,
				'discount' =>  0,
				'profit' => $transactionProfit,
				'user_id' => $this->session->userdata('id'),
				'created_at' => get_date_time()  
			];
		}
			 
  
		$this->db->insert_batch('sales_description', $data);
		$this->OrderingLevelModel->update_stocks($data, $store_number);

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		        errorMessage("Opps Something Went Wrong Please Try Again");
		        return redirect('sales/new');
		}
		 
		$this->db->trans_commit(); 
		success("New Sales Saved Successfully");
		return redirect('sales/new');

	}

	public function enter_sales() {

		
		$this->db->set("$column", "$column-" . $sale['quantity'], FALSE);
		$this->db->where('item_id', $sale['id']);
		$this->db->update('ordering_level');
	}


	public function reports() {

		$this->start = $this->input->post('start');
		$this->limit = $this->input->post('length');
		$datasets = [];
		$totalSales = 0;
		$from = $this->input->post('columns[0][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[0][search][value]');
		$to = $this->input->post('columns[1][search][value]') == "" ? date('Y-m-d') : $this->input->post('columns[1][search][value]');
		$sales = $this->filterReports($from, $to);
		$count = count($sales);
		$totalExpenses = 0;
		$transactionProfit = 0;
		$expenses = $this->db->select("SUM(cost) as total")
							->where('date >=', $from)
							->where('date <=', $to)
							->get('expenses')
							->row();

		if ($expenses) {
			$totalExpenses = $expenses->total;
		}

		foreach ($sales as $sale) {
			$sales_description = $this->db->where('sales_id', $sale->id)->get('sales_description')->result();
			$sub_total = 0;
			foreach ($sales_description as $desc) {
		 		$item = $this->db->where('id', $desc->item_id)->get('items')->row();
		 		$user = $this->db->where('id', $desc->user_id)->get('users')->row();
		 		$staff = $user ? $user->username : 'Not found';
				$sub_total += ((float)$desc->quantity * (float) $desc->price) - $desc->discount;
				$saleProfit = (($desc->price - $desc->profit) * $desc->quantity) - $desc->discount;
				$transactionProfit += $saleProfit;
				$datasets[] = [ 
					date('Y-m-d', strtotime($sale->date_time)), 
					'₱' . number_format($saleProfit),
					$staff,
					$desc->name,
					$desc->quantity,
					'₱' . number_format((float)$desc->price),
					'₱' . number_format($desc->discount),
					'₱'. number_format(((float)$desc->quantity * (float)$desc->price) - $desc->discount),
					$this->session->userdata('account_type') == 'Admin' ? '
						<a class="btn btn-sm btn-danger delete-sale" data-id="'.$desc->id.'" href="'.base_url('SalesController/destroy/') . $desc->id.'">Delete</a>
					' : 'No Action'
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
				'to' => $to,
				'profit' => number_format($transactionProfit), 
				'expenses' => number_format($totalExpenses)
			]);

	}

	public function destroy($id) {
		$sale = $this->db->where('id', $id)->get('sales_description')->row();
		$this->load->model('OrderingLevelModel');
		
		$this->db->trans_start();
		$this->OrderingLevelModel->addStocks($sale->item_id, $sale->quantity);
		$this->db->where('id', $id)->delete('sales_description');

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        echo "0";
	        return;
		}
		else
		{
			echo "1";
	        return $this->db->trans_commit();
		}

 
	}

	public function filterReports($from, $to) {
		$from = $from ? $from : date('Y-m-d');
		$to = $to ? $to : date('Y-m-d'); 

		return $this->db->where('DATE_FORMAT(date_time, "%Y-%m-%d") >=', $from)
					->where('DATE_FORMAT(date_time, "%Y-%m-%d") <=', $to)
					->order_by('id', 'DESC')
					->get('sales', $this->start, $this->limit)->result();
		 
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