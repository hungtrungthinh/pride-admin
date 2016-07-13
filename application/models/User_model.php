<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	
	private $_table;
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = "tbl_users";
	}
	
	public function checkUser($user_id, $user_pass)
	{
		$query = $query = $this->db->get_where($this->_table, array('user_id' => $user_id));
		foreach ($query->result_array() as $row) {
			if (md5($user_pass) != $row['user_pass'])
				return "NOT_PASSWORD";
			
			if ($row['allow'] != 1)
				return "NOT_ALLOWED";
			
			return "SUCCEED";
		}
		return "NOT_EXIST";
	}
	
	public function registUser($user_id, $user_pass)
	{
		$query = $this->db->get_where($this->_table, array("user_id"=>$user_id));
		if (count($query->result_array()))
			return "EXISTED_NAME";
		
		$data = array(
			'user_id'	=> $user_id,
			'user_pass' => md5($user_pass),
			'reg_date' 	=> date("Y-m-d")
		);
		return ($this->db->insert($this->_table, $data)) ? "SUCCEED" : "FAILURE";
	}
	
	public function getUsers()
	{
		return  $this->db->get($this->_table)->result_array();
	}
	
	public function saveUsers($postData)
	{
		$xmlStr = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$xmlStr .= '<data>';
		
		$ids = explode(",", $postData["ids"]);
		for ($i=0; $i<count($ids); $i++) {
			$rowId = $ids[$i];
			
			$data = array(
				'user_id' 	  => $postData[$rowId . "_user_id"],
				'user_pass'	  => md5($postData[$rowId . "_user_pass"]),
				'full_name'	  => $postData[$rowId . "_full_name"],
				'allow'	      => $postData[$rowId . "_allow"],
				'reg_date'	  => $postData[$rowId . "_reg_date"],
				'access_count'=> $postData[$rowId . "_access_count"]
			);
			switch($postData[$rowId . "_!nativeeditor_status"]) {
				case "inserted":
					$this->db->insert($this->_table, $data);
					$xmlStr .= '<action type="insert" sid="' . $rowId . '" tid="' . $this->db->insert_id() . '" />';
					break;
				case "updated":
					$this->db->where('id', $rowId);
					$this->db->update($this->_table, $data);
					$xmlStr .= '<action type="update" sid="' . $rowId . '" tid="' . $rowId . '" />';
					break;
				case "deleted":
					$this->db->delete($this->_table, array('id' => $rowId)); 
					$xmlStr .= '<action type="delete" sid="' . $rowId . '" tid="' . $rowId . '" />';
					break;
				default:
					break;
			}
		}		
		return $xmlStr . "</data>";
	}
	
}


                      
						
