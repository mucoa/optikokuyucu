<?php

class Data_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();

	}
	// Getirilme işlemi
	public function get_all($where = array(), $tabload){
		return $this->db->where($where)->get($tabload)->result();
	}
	// Ekleme işlemi
	public function add($data = array(), $tabload){
		return $this->db->insert($tabload, $data);
	}
	//Tek bir kayıt getirme
	public function get($where = array(), $tabload){
		return $this->db->where($where)->get($tabload)->row();
	}
	public function update($where = array(), $data = array(), $tabload){
		return $this->db->where($where)->update($tabload, $data);
	}
	public function delete($where = array(), $tabload){
		return $this->db->where($where)->delete($tabload);
	}
}
