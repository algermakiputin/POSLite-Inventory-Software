<?php
class UsersController extends CI_Controller {
 
	public function __construct() {
		parent::__construct();
		
	}
	public function register_account( ) {
		$this->checkLogin();
		$this->form_validation->set_rules('Username', 'Username', 'required|min_length[5]');
		$this->form_validation->set_rules('Password', 'Password', 'required|min_length[8]');
		$this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|matches[Password]');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger"> '.validation_errors() . '</div>');
			return redirect(base_url('users'));
		} 
		 
		$this->load->model('UsersModel');
		$date_created = date('Y-m-d h:i:s a');
		$username = $this->input->post('Username');
		$password = $this->input->post('Password');
		$account_type = $this->input->post('account_type');
		$created_by = 'admin';
		$exec = $this->UsersModel->insert_account($username,$password,$account_type,$date_created,$created_by);
		if ($exec) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Account Created Successfully</div>');
			return redirect(base_url('users'));
		}
		
		$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps... Something Went Wrong Please Try Again.</div>' );
		return redirect(base_url('users'));
		

		 
	}

	public function delete($id){
		$this->checkLogin();
		$this->load->model('UsersModel');
		$exec = $this->UsersModel->delete_account($id);
		if ($exec) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Account Deleted Successsfully</div>');
			return redirect(base_url('users'));
		}
		$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps... Something Went Wrong Please Try Again.</div>' );
		return redirect(base_url('users'));
	}

	public function users () {
		$this->checkLogin();
		$data['page'] = 'accounts';
		$this->load->model('UsersModel');
		$data['accountsList'] = $this->UsersModel->display_accounts();
		$data['content'] = "users/index";
		$this->load->view('master',$data);
		 
	}

	public function history() {
		$this->checkLogin();
		$data['history'] = $this->db->order_by('id','DESC')
						->select('users.account_type, users.username, history.*')
						->from('history')
						->join('users', 'users.id = history.user_id')
						->get()->result();
	 
		$data['content'] = "users/history";
		$this->load->view('master',$data);
	}

	public function checkLogin() {
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}

	
}