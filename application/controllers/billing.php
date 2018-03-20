<?php
class Billing extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}
	public function index() {
		$this->load->view('billing_view');

	}

	public function complete() {
		$cart = $this->input->post('cart');
		$total = $this->input->post('total');
		$payment = $this->input->post('payment');
		$change = $this->input->post('change');
		$this->form_validation->set_rules('payment','Payment','required');
		if($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">' . validation_errors() . '</div>');
			redirect(base_url('billing'));
		}else {
			$data['payment'] = $payment;
			$data['total'] = $total;
			$data['change'] = $change;
			$this->load->model('sales_model');
			$insert_sales = $this->sales_model->insert_sales($cart);

			if ($insert_sales) {
				$this->sales_model->updateStocks($cart);
				$this->load->view('complete',$data);
			}
		}
		

	}
}

?>