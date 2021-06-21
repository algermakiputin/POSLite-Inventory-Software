<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class DatabaseController Extends CI_Controller { 

    public function update() { 
        $this->db->query('ALTER TABLE payments ADD remarks varchar(199) NULL'); 
        return redirect('/');
    }
}