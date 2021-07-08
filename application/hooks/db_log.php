<?php 

// Name of Class as mentioned in $hook['post_controller]
class Db_log {

	function __construct() {
       // Anything except exit() :P
	}
// Name of function same as mentioned in Hooks Config
	function logQueries() {
		$CI =& get_instance();             
		$times = $CI->db->query_times;
    //$dbs    = array();
		$output = NULL;     
		$queries = $CI->db->queries;
    //print_r($queries);
		if (count($queries) == 0){

		}else{
			foreach ($queries as $key=>$query){
 
				$output .= $query . "\n";  
			}

		}

		$CI->load->helper('file');
		if ( ! write_file(APPPATH  . "/logs/queries.log.txt", $output, 'a+')){
			log_message('debug','Unable to write query the file');
		}   
	}
}