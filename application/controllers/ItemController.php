<?php
class ItemController extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	
	}

	public function items () {
		$this->load->model('item_model');
		$this->load->model('PriceModel');
		$this->load->model('OrderingLevelModel');
		$this->load->model('categories_model');
		$data['items'] = $this->item_model->itemList();
		$data['page'] = 'inventory';
		$data['price'] = $this->PriceModel;
		$data['categoryModel'] = $this->categories_model;
		$data['orderingLevel'] = $this->OrderingLevelModel;
		$data['content'] = "items/index";
		$this->load->view('master', $data);

	}

	public function data() {
		$this->load->model('OrderingLevelModel');
		$this->load->model('PriceModel');

		$orderingLevel = $this->OrderingLevelModel;
		$price = $this->PriceModel;
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$items = $this->db->where('status', 1)->get('items', $start, $limit)->result();
		$count = count($items);
		$datasets = [];

		foreach ($items as $item) {

			$quantity = (int)$orderingLevel->getQuantity($item->id)->quantity;
			
			if ($quantity) {
				$datasets[] = [
					$item->id,
					ucwords($item->name),
					ucfirst($item->description),
					$quantity,
					'₱'. $price->getPrice($item->id)
				];
			}else 
				continue;

		}
	 
		echo json_encode([
				'draw' => $this->input->post('draw'),
				'recordsTotal' => $count,
				'recordsFiltered' => $count,
				'data' => $datasets
			]);
	}

	public function new() {
		$this->load->database();
		$this->load->model('categories_model');
		require 'vendor/autoload.php';
		$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
		$code = substr(uniqid(), 0, 7);
		$data['category'] = $this->db->get('categories')->result();
		$data['suppliers'] = $this->db->get('supplier')->result();
		$data['page'] = 'new_item';
		$data['content'] = "items/new";
		$data['barcode'] = $code;
		$data['code'] = $generator->getBarcode($code, $generator::TYPE_CODE_128);
		$this->load->view('master', $data);
	}

	public function insert() {

		$this->load->model('PriceModel');
		$name = $this->input->post('name');
		$category = $this->input->post('category');
		$description = $this->input->post('description');
		$supplier_id = $this->input->post('supplier');
		$barcode = $this->input->post('barcode');
		$quantity = 0;
		$price = $this->input->post('price');

		$this->load->model('item_model');
		$this->load->model('OrderingLevelModel');
		$item_id = $this->item_model->insertItem($name, $category, $description,$supplier_id,$barcode);
		$this->PriceModel->insert($price, $item_id);
		$this->OrderingLevelModel->insert($item_id);
		$this->session->set_flashdata('successMessage', '<div class="alert alert-success">New Item Has Been Added</div>');
		$this->session->set_flashdata('successMessage', '<div class="alert alert-success">New Item Has Been Added Successfully </div>');
		redirect(base_url('items'));

	}

	public function delete($id){

		$this->load->model('item_model');
		$del_item = $this->item_model->deleteItem($id);
		if ($del_item) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Item Deleted</div>');
			redirect(base_url('items'));
		}else {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps Something Went Wrong</div>');
			redirect(base_url('items'));
		}
	}

	public function stock_in($id) {
		
		$this->load->model('item_model');
		$this->load->model('PriceModel');
		$this->load->model('OrderingLevelModel');
		$this->load->model('categories_model');
		$data['item_info'] = $this->item_model->item_info(urldecode($id));
		$data['item_id'] = $id;
		$data['price'] = $this->PriceModel;
		$data['orderingLevel'] = $this->OrderingLevelModel;
		$data['categoryModel'] = $this->categories_model;
		$data['content'] = "items/stockin";
		$this->load->view('master', $data);
	}

	public function add_stocks() {
		$itemID = $this->input->post('item_id');
		 
		$stocks = $this->input->post('stocks');
		$this->form_validation->set_rules('stocks','Stocks','required|integer');

		if($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">' .validation_errors() . '</div>');
			redirect(base_url("items/stock-in/$itemID"));
		}else {
			 
			$this->load->model('OrderingLevelModel');
			$update = $this->OrderingLevelModel->addStocks($itemID,$stocks);

			if ($update) {
				$this->session->set_flashdata('successMessage', '<div class="alert alert-info">Stocks Added</div> ');
				redirect(base_url('items'));
				
			}else {
				$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps Something Went Wrong Please Try Again</div> ');
				redirect(base_url('items'));
			}
		}
	}

	public function edit($id) {

		$this->load->model('PriceModel');
		$this->load->model('item_model');
		$data['item'] = $this->db->where('id', $id)->get('items')->row();
		$data['price'] = $this->PriceModel;
		$data['categories'] = $this->db->get('categories')->result();

		$data['content'] = "items/edit";
		$this->load->view('master', $data);

	}

	public function update() {
		$this->load->model('item_model');
		$this->form_validation->set_rules('name', 'Item Name', 'required');
		$this->form_validation->set_rules('category', 'Item Name', 'required');
		$this->form_validation->set_rules('description', 'Item Name', 'required');
		$this->form_validation->set_rules('price', 'Item Name', 'required');
		$this->form_validation->set_rules('id', 'required');

 
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opss Something Went Wrong Updating The Item. Please Try Again.</div>');
				redirect(base_url('items'));
		}else {
			$this->load->model('item_model');
			$this->load->model('PriceModel');
	 		$updated_name = $this->input->post('name');
			$updated_category = $this->input->post('category');
			$updated_desc = strtolower($this->input->post('description'));
			$updated_price = $this->input->post('price');
			$id = $this->input->post('id');
			
			$price_id = $this->PriceModel->update($updated_price, $id);
			
			$update = $this->item_model->update_item($id,$updated_name,$updated_category,$updated_desc,$price_id);

			if ($update) {
				$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Item Updated</div>');
				redirect(base_url('items'));
			}
		}
		 		
	}

}