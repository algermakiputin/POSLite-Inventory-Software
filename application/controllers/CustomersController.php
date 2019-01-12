<?php

class CustomersController Extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
	}
	
	public function index() {

		$data['page'] = "Suppliers";
		$data['customers'] = $this->db->order_by('id','DESC')->get('customers')->result();
 		$data['content'] = "customers/index";
 		$data['controller'] = $this;
		$this->load->view('master',$data);


	}

	public function insert() {

		$data = array(
				'name' =>	$this->input->post('name'), 
				'gender' => $this->input->post('gender'),
				'home_address' => $this->input->post('home_address'),
				'outlet_location' => $this->input->post('outlet_location'),
				'outlet_address' => $this->input->post('outlet_address'), 
				'contact_number' => $this->input->post('mobileNumber'),
				'membership' => 0
 
			);


		if ($this->db->insert('customers',$data) ) {
			
			$this->session->set_flashdata('success','Customer added Successfully');
			return redirect($_SERVER['HTTP_REFERER']);
		}

	}

	public function getMembership() {

		if ($this->input->post('id')) {
			$membership = $this->db->where('customer_id', $this->input->post('id'))
									->get('memberships')
									->row();
			echo json_encode($membership);
		}
	}

	public function open($id) {
		$data['customer'] = $this->db->where('id', $id)->get('customers')->row();
		$data['content'] = "customers/open";

		$this->load->view('master',$data);
	}

	public function openMembership() {
		$this->db->insert('memberships', [
					'customer_id' => $this->input->post('customer_id'),
					'date_open' => $this->input->post('date_open'),
					'active' => 1,
					'expiry_date' => Carbon\Carbon::parse($this->input->post('date_open'))->addYears(3)->format('Y-m-d')
				]);
		$this->db->where('id', $this->input->post('customer_id'))->update('customers',['membership' => 1]);
		$this->session->set_flashdata('success', 'Membership opened Successfully');
		return redirect('customers');
	}

	public function renewMembership() {

		if ($id = $this->input->post('customer_id')) {
			$this->db->where('customer_id', $id)->update('memberships',[
						'expiry_date' => Carbon\Carbon::now()->addYears(3)->format('Y-m-d'),
						'date_open' => date('Y-m-d')

					]);
			$this->session->set_flashdata('success','Membership renewed Successfully');
			return redirect('customers');
		}
	}
 
	public function getDateOpen($id) {
		return $this->db->where('customer_id', $id)->get('memberships')->row()->date_open;
	}

	public function getExpiration($id) {
		return $this->db->where('customer_id', $id)->get('memberships')->row()->expiry_date;
	}

	public function update() {

		$data = array(
				'name' =>	$this->input->post('name'), 
				'gender' => $this->input->post('gender'),
				'home_address' => $this->input->post('home_address'),
				'outlet_location' => $this->input->post('outlet_location'),
				'outlet_address' => $this->input->post('outlet_address'), 
				'contact_number' => $this->input->post('contact_number'),

			);

		$this->db->where('id',$this->input->post('customer_id'))->update('customers',$data);
 
		return redirect($_SERVER['HTTP_REFERER']);
	}

	public function destroy($id) {
		$this->load->database();

		$this->db->delete('customers',array('id' => $id));

		return redirect($_SERVER['HTTP_REFERER']);
	}

	public function find() {

		$this->load->database();

		$customer = $this->db->where('id',$this->input->post('id'))->get('customers')->row();

		echo json_encode($customer);
	}

}