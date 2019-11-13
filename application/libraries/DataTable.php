<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DataTable {

	private $CI;

	public function __construct()  { 

		$this->CI = & get_instance();
		$this->CI->load->helper('url');
 
	}

	/**
     * Returns JSON encoded object for Datatable.
     *
     * @param int $draw
     * @param string[] $data 
     * @param int[] $recordsFiltered 
     * @param string[] $extra

     * @return json[]
   */ 
	public function format($draw = 1, $data, $columns, $data_count, $extra = []) {

		$datasets = []; 

		foreach ($data as $line) {

			$row = [];

			foreach ($columns as $key => $col) { 
				array_push($row, $line->$key);
			}
 
			$datasets[] = $row;
		} 
 
		return json_encode([
			'draw' => $draw,
			'recordsTotal' => count($datasets),
			'recordsFiltered' => $data_count,
			'data' => $datasets,
			'extra' => json_encode($extra)
		]);

	}
}