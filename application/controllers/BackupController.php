<?php 

class BackupController extends CI_Controller {

	public function index() {
		
		$data['content'] = "backup/index";
		$data['backups'] = $this->db->get('backup')->result();
		$this->load->view('master', $data);
	}
	public function dump() { 
	 	$filename = './backup/backup'.date('Y-m-d-h-i-s').'.txt';
	 
		$this->db->insert("backup", ['id' => null, 'filename' => $filename]);
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
		$sql = file_get_contents('./backup/backup2019-09-20-07-43-01.txt');
		$sql = $this->encryption->decrypt($sql);
		$rows = explode(";", $sql);

		$this->db->trans_start();
		foreach ($rows as $query) {

			$pos = strpos($query,'ci_sessions');
		 
			if($pos == false) 
				$result = $this->db->query($query); 
			else  
				continue;
			 
		} 

		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('success', "Error restoring backup");
			return redirect('backups');
		}

		$this->session->set_flashdata('success', "Backup restored successfully");
		return redirect('backups');

	}
}