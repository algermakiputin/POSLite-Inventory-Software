<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DeliveriesController extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
	 
	}

	public function new() {
		$this->load->model('PriceModel');
		$data['page'] = "New Delivery";
		$data['suppliers'] = $this->db->get('supplier')->result();
		$products = $this->db->select('items.id as data, items.name as value, items.capital, ordering_level.quantity')
							->from('items')
							->join('ordering_level', 'ordering_level.item_id = items.id') 
							->get()
							->result();
		 
		$data['products'] = json_encode($products);
		 
 		$data['content'] = "deliveries/new";
		$this->load->view('master',$data);
		 
	}

	public function details($id) {
		$data['delivery'] = $this->db->select('delivery.*, supplier.name')
								->from('delivery')

								->join('supplier', 'supplier.id = delivery.supplier_id')
								->where('delivery.id', $id)
								->get()
								->row();

		 
		$data['deliveryDetails'] = $this->db->select("delivery_details.*, items.name as product_name, SUM(delivery_details.price * delivery_details.quantities) as subTotal")
								->join('items', 'items.id = delivery_details.item_id', 'BOTH')
								->where('delivery_details.delivery_id', $id)
								->group_by('delivery_details.id')
								->get('delivery_details')->result();
		$data['total'] = 0;
		$data['content'] = "deliveries/details";
		return $this->load->view('master',$data);
	}


	public function insert() {
		$this->load->model('InventoryModel');
		
		$products = $this->input->post("product");
		$current_stocks = $this->input->post("stocks");
		$products_id = $this->input->post("product_id");
		$expiry_date = $this->input->post("expiry_date");
		$price = $this->input->post("price");
		$quantity = $this->input->post("quantity");
		$defectives = $this->input->post("defective");
		$remarks = $this->input->post("remarks");
		$due_date = $this->input->post('due_date');
		$payment_status = $this->input->post('payment_status'); 
 
		$data = array(
			'supplier_id' => $this->input->post('supplier_id'),
			'date_time' => $this->input->post('delivery_date'),
			'received_by' => $this->session->userdata('username'),
			'due_date' => $due_date,
			'payment_status' => $payment_status
			);

		$data = $this->security->xss_clean($data);

		$this->db->trans_begin();
		$this->db->insert('delivery',$data);
		$delivery_id = $this->db->insert_id();
		$orderDetails = array();

		foreach ($products as $key => $product) {
			if (!$products_id[$key])
				continue;
			
			$this->InventoryModel->insert( $products_id[$key], $quantity[$key], $product, $current_stocks[$key], "stockin");
			$orderDetails[] = array(
				'item_id'	=> $products_id[$key],
				'quantities' => $quantity[$key],
				'delivery_id' => $delivery_id,
				'price'	=>	$price[$key], 
				'defectives' => $defectives[$key],
				'remarks'	=> $remarks[$key],
				'name' => $products[$key],
				'expiry_date' => $expiry_date[$key]
			);
 			//Update Product Quantities
			$this->db->set('quantity', 'quantity+' . $quantity[$key], FALSE);
			$this->db->where('item_id', $products_id[$key]);
			$this->db->update('ordering_level'); 
		}
  
		$this->db->insert_batch('delivery_details', $orderDetails);
	 	
	 	if ( $this->db->trans_status() === FALSE ) {
			 
	        $this->db->trans_rollback();
	        $this->session->set_flashdata('error', 'Opps! something went wrong please try again');
			return redirect('new-delivery');
		} 

		$this->db->trans_commit();  
		$this->session->set_flashdata('success', 'Delivery saved successfully');
		return redirect('new-delivery'); 

	}

	public function index() {
	
	 
 		$data['content'] = "deliveries/index";
		$this->load->view('master',$data);
		 
	}

	public function destroy($id) {
		$id = $this->security->xss_clean($id);
		$this->db->where('delivery_id', $id)->delete('delivery_details');
		$this->db->where('id', $id)->delete('delivery');
		$this->session->set_flashdata('success', "Delivery deleted successfully");
		return redirect(deliveries);
	}

	public function datatable() {

		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
		
		$count = $this->db->select("delivery.*")
								->from('delivery') 
								->group_by('delivery.id')
								->join('supplier', 'supplier.id = delivery.supplier_id', 'both')
								->join('delivery_details', 'delivery_details.delivery_id = delivery.id')
								->get()
								->num_rows();



		$columns = ['date_time', 'received_by', 'due_date', 'name', 'total', 'defectives', 'payment_status', 'defectives', '', 'id'];
	 	$order_column = $this->input->post('order[0][column]');
	 	$order = $this->input->post('order[0][dir]');
	 	$order = $order == "" ? 8 : $order;

	 	$deliveries = $this->db->select("delivery.*, supplier.name, SUM(delivery_details.quantities * delivery_details.price) as total, SUM(delivery_details.defectives) as defectives")
							->from('delivery') 
							->join('supplier', 'supplier.id = delivery.supplier_id', 'both')
							->join('delivery_details', 'delivery_details.delivery_id = delivery.id')
							->group_by('delivery.id')
							->order_by($columns[$order_column], $order)
							->order_by('id', 'DESC')
							->like('received_by', $search, 'both')
							->limit($limit, $start)
							->get()
							->result();
		  
		$datasets = array_map(function($delivery) {
			
			$admin = "";

			if ( is_admin() )
				$admin = '
						<li>
                      <a class="" href="' . base_url('DeliveriesController/edit/' . $delivery->id ) .'">
                          <i class="fa fa-edit"></i> Edit</a>
                  </li>
						<li>
                      <a class="delete-data" href="' . base_url('DeliveriesController/destroy/' . $delivery->id ) .'">
                          <i class="fa fa-trash"></i> Delete</a>
                  </li>';

			return [ 
				date('Y-m-d', strtotime($delivery->date_time)),
				$delivery->received_by,
				$delivery->due_date,
				$delivery->name,
				currency() . number_format($delivery->total),
				$delivery->defectives,
				$delivery->payment_status == 1 ? "<span class='badge badge-success'>Paid</span>" : "<span class='badge badge-warning'>Pending</span>",
				'
				<div class="dropdown">
              	<a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
              	<ul class="dropdown-menu">
              	
                  <li>
                  	<a href="'. base_url("deliveries/details/" . $delivery->id) .'"><i class="fa fa-eye"></i> View Details</a> 
                  </li> 
                  '. $admin .'
              	</ul>
            </div> 
				',
			];

		}, $deliveries);

		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => $count,
			'recordsFiltered' => $count,
			'data' => $datasets
		]);
	}

	public function edit( $id ) {

		$data['content'] = "deliveries/edit";
		$data['delivery'] = $this->db->where('id', $id)->get('delivery')->row();
		$data['suppliers'] = $this->db->get('supplier')->result();
		$data['details'] = $this->db->where('delivery_id', $data['delivery']->id)->get('delivery_details')->result();
		$data['products'] = json_encode(
									$this->db->select('items.id as data, items.name as value, items.capital') 
												->get('items')
												->result());

		$this->load->view('master', $data);

	}


	public function update() {
		
		$id = $this->input->post('delivery_id');
		$this->load->model('InventoryModel');
		$products = $this->input->post("product");
		$products_id = $this->input->post("product_id");
		$expiry_date = $this->input->post("expiry_date");
		$price = $this->input->post("price");
		$quantity = $this->input->post("quantity");
		$defectives = $this->input->post("defective");
		$remarks = $this->input->post("remarks");
		$due_date = $this->input->post('due_date');
		$payment_status = $this->input->post('payment_status') == "Paid" ? 1 : 0;
		$supplier = $this->input->post('supplier_id'); 
		$deliveryDetails = $this->db->where('delivery_id', $id)->get('delivery_details')->result();
		// dd($deliveryDetails);
		foreach ($deliveryDetails as $details) {
			$current_stocks = $this->db->where('item_id', $details->item_id)->get('ordering_level')->row()->quantity;
		
			$this->InventoryModel->insert( $details->item_id, $details->quantities * -1, $details->name, $current_stocks, 'stockin', 0, 0 );
		}
		$this->db->trans_begin(); 
		$this->rollback_delivery($id);
		
		$delivery_id = $id;
		$orderDetails = array();
		
		$this->db->where('id', $id)->update('delivery', [
				'supplier_id' => $supplier,
				'payment_status' => $payment_status,
				'due_date' => $due_date
			]);
		

		foreach ($products as $key => $product) {
			if (!$products_id[$key])
				continue;
			
			$orderDetails[] = array(
				'item_id'	=> $products_id[$key],
				'quantities' => $quantity[$key],
				'delivery_id' => $delivery_id,
				'price'	=>	$price[$key], 
				'defectives' => $defectives[$key],
				'remarks'	=> $remarks[$key],
				'name' => $products[$key],
				'expiry_date' => $expiry_date[$key]
			);
			
			$current_stocks = $this->db->where('item_id', $products_id[$key])->get('ordering_level')->row()->quantity;
 			//Update Product Quantities
			$this->InventoryModel->insert( $products_id[$key], $quantity[$key], $products[$key], $current_stocks, 'stockin', 0, 0 );
			$this->db->set('quantity', 'quantity+' . $quantity[$key], FALSE);
			$this->db->where('item_id', $products_id[$key]);
			$this->db->update('ordering_level'); 
		}
  
		$this->db->insert_batch('delivery_details', $orderDetails);
	 	
	 	if ( $this->db->trans_status() === FALSE ) {
			 
	        $this->db->trans_rollback();
	        
	        $this->session->set_flashdata('error', 'Opps! something went wrong please try again');
				return redirect('deliveries');
		} 

		$this->db->trans_commit();  
		$this->session->set_flashdata('success', 'Delivery Updated Successfully');
		return redirect('deliveries'); 

	}
 

	public function rollback_delivery( $id ) {

		$delivery_details = $this->db->where('delivery_id', $id)
											->get('delivery_details')
											->result();

 

		foreach ($delivery_details as $delivery) {
 

			$this->db->set('quantity', 'quantity-' . $delivery->quantities, FALSE);
			$this->db->where('item_id', $delivery->item_id);
			$this->db->update('ordering_level');


			$this->db->where('id', $delivery->id)->delete('delivery_details');
		}
 
		return;

	}

}