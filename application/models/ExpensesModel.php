<?php 

class ExpensesModel extends CI_Model {

	public function annual_expenses() {

		return $this->db->select("SUM(cost) as total")
					->from('expenses')
					->where("DATE_FORMAT(date, '%Y') =", date('Y'))
					->get()
					->row();

	}

	public function daily_expenses() {

		return $this->db->select("SUM(cost) as total")
					->from('expenses')
					->where("DATE_FORMAT(date, '%Y-%m-%d') =", date('Y-m-d'))
					->get()
					->row();

	}
}