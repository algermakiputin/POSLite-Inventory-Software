<?php

class CustomersController Extends CI_Controller {


	public function index() {
		$this->load->database();
		$data['page'] = "Suppliers";
		$data['customers'] = $this->db->order_by('id','DESC')->get('customers')->result();
 
		$this->load->view('header',$data);
		$this->load->view('side_menu');
		$this->load->view('customers/index',$data);
		$this->load->view('footer');

	}

	public function insert() {
		$this->load->database();
		$data = array(
				'name' =>	$this->input->post('name'),
				'email' => $this->input->post('email'),
				'gender' => $this->input->post('gender'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'zipcode'	=> $this->input->post('zipcode'),
				'mobileNumber' => $this->input->post('mobileNumber'),

			);

		$this->db->insert('customers',$data);

		$this->session->set_flashdata('success','Customer added Successfully');
		return redirect($_SERVER['HTTP_REFERER']);
	}

	public function update() {
		$this->load->database();
		$data = array(
				'name' =>	$this->input->post('name'),
				'email' => $this->input->post('email'),
				'gender' => $this->input->post('gender'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'zipcode'	=> $this->input->post('zipcode'),
				'mobileNumber' => $this->input->post('mobileNumber'),

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