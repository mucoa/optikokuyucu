<?php

class User_model extends CI_Model{

	public $tableName ="";

	public function __construct()
	{
		parent::__construct();
		$this->tableName = "user";
	}

	public function get($where = array()){
		return $this->db->where($where)->get($this->tableName)->row();
	}

}
