<?php 
class AuthController extends CI_Controller {

	public function login() {
		$data['page_name'] = "Login";
		$this->load->view('template/header',$data);
		$this->load->view('login');
		$this->load->view('template/footer');
	}
 

	public function login_validation() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$this->form_validation->set_rules('username','Username', 'required');
		$this->form_validation->set_rules('password','Password', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">' . validation_errors() . '</div>');
			return redirect(base_url('login'));
		} 

		$this->load->model('UsersModel');

		$verify_login = $this->UsersModel->login($username);
		
		if ($verify_login) {
			$hash_password = $verify_login->password;
			$verifyPassword = password_verify($password,$hash_password);
			if ($verifyPassword) {
				$userdata = array( 
					'id' => "$verify_login->id",
					'username' => "$verify_login->username",
					'log_in' => true,
					'account_type' => "$verify_login->account_type"
					);
				$this->db->insert('history', [
						'user_id' => $userdata['id'],
						'action' => 'Log in',
					]);
				$this->session->set_userdata($userdata);
				$this->session->set_flashdata('successMessage','<div class="alert alert-success">Login Successfully, Welcome '.$this->session->userdata['username'].'</div>');
				return $this->redirectUser();
				
			}
			
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Incorrect Login Name Or Password</div>');
			return redirect(base_url('login'));
			
		} 
		
		$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Incorrect Login Name Or Password</div>');
		return redirect(base_url('login'));
		 
		 
	}

	public function redirectUser() {
		if ($this->session->userdata('account_type') == "Cashier")  
			return redirect(base_url('pos'));
	 

		if ($this->session->userdata('account_type') == "Admin") 
			return redirect(base_url('items'));
	 

		if ($this->session->userdata('account_type') == "Clerk") 
			return redirect(base_url('items'));
	 
	}

	public function logout() {
		$this->inserLoginHistory();
		$data = array('id','username','log_in','account_type');
		$this->session->unset_userdata($data);
		$this->session->set_flashdata('successMessage','<div class="alert alert-success">Lagout Successfully</div>');
		redirect(base_url('login'));
	}

	public function inserLoginHistory() {
		$this->db->insert('history', [
							'user_id' => $this->session->userdata('id'),
							'action' => 'Log out',
						]);
	}
}

?>