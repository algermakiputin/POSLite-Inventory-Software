<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SettingsController extends CI_Controller { 

	public function index() {
		$data['content'] = "settings/index";  
		$data['settings'] = $this->db->get('settings')->row(); 
		$this->load->view('master',$data);;
	}

	public function do_upload()
    {
        $config['upload_path']          = './assets/logo';
        $config['allowed_types']        = 'jpg|png|jpeg|JPEG';
        $config['max_size']             = 100;
        $config['max_width']            = 300;
        $config['max_height']           = 300;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('logo'))
        {
                $error = array('error' => $this->upload->display_errors());
                return false;
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());

                return $this->upload->data('file_name');
        }
    }

     public function update() {

        $business_name = $this->input->post('business_name');
        $business_address = $this->input->post('business_address');
        $contact = $this->input->post('contact');
        $email = $this->input->post('email');

        $update = $this->db->where('id', 1)
                            ->update('settings', [
                            'business_name' => $business_name,
                            'business_address' => $business_address,
                            'contact' => $contact,
                            'email' => $email
                        ]);

        if ( $update ) {

            success("Business Info updated successfully");
            return redirect('settings');
        }

        error("Opps something went wrong please try again later");
        return redirect('settings');

    }

}