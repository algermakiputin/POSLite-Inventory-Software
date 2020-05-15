<?php 

class BackupController extends CI_Controller {

	public function index() {
		
		$data['content'] = "backup/index";
		$data['backups'] = $this->db->get('backup')->result();
		$this->load->view('master', $data);
	}
	public function dump() { 
	 	$filename = './backup/backup'.date('Y-m-d-h-i-s').'.txt';
	 	
		$this->db->insert("backup", ['id' => null, 'filename' => $filename, 'date_time' => get_date_time()]);
		$this->backup($filename);
		$this->session->set_flashdata('success', "Backup successfully");
		return redirect('backups');
	}

	public function delete($id) {
		$this->db->where('id', $id)->delete('backup');
		return redirect('backups');
	}

	public function backup($filename){
	    // Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$prefs = array(    // Array of tables to backup.
		        'ignore'        => array(),                     // List of tables to omit from the backup
		        'format'        => 'txt',                       // gzip, zip, txt
		        'filename'      => 'mybackup.sql',              // File name - NEEDED ONLY WITH ZIP FILES
		        'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
		        'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
		        'newline'       => "\n"                         // Newline character used in backup file
		);

		$backup = $this->dbutil->backup($prefs);
		$encrypted_backup = $this->encryption->encrypt($backup); 
		
		$handle = fopen($filename, 'w') or die('Cannot open file:  '.$my_file);
		fwrite($handle, $encrypted_backup);
		fclose($handle);  

	}

	public function import() {

		$file = $_FILES['file'];

		$sql = file_get_contents($file['tmp_name']);

		dd($sql);
		if (!$sql)
			return redirect('/');

		$sql = $this->encryption->decrypt($sql); 

		$rows = explode(";", $sql);
  

		$this->db->trans_start();
 
 		$this->truncate_tables();

		foreach ($rows as $key => $query) {
 		
			if ( strpos($query, "INSERT INTO") ) {
 	
				$this->db->query($query);
			}
		} 
 	
 		

		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', "Error restoring backup");
 
			return redirect('backups');
		}

		$this->session->set_flashdata('success', "Backup restored successfully");
 
		return redirect('backups');
 	 

	}

	public function truncate_tables() {

		$tables = ['backup', 'categories', 'customers', 'delivery', 'delivery_details', 'expenses', 'history', 'items', 'memberships', 'ordering_level', 'payments', 'prices', 'purchase_order', 'purchase_order_line', 'sales', 'sales_description', 'settings', 'supplier', 'users'];


		$this->db->trans_start();

		foreach ($tables as $table) {

			$this->db->empty_table($table);
		}


		$this->db->trans_complete();
		
		if ($this->db->trans_status() !== FALSE) {
			return true;
		}

		return false;

	}
}