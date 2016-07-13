<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claim_model extends CI_Model {
	
	private $_table;
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = "tbl_claims";
	}
	
	public function getClaims($claimId = null)
	{
		$query = (is_null($claimId)) ? $this->db->get($this->_table) : $this->db->get_where($this->_table, array("id"=>$claimId));
		return $query->result_array();
	}
	
	public function saveClaims($postData)
	{
		$xmlStr = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$xmlStr .= '<data>';
		
		$ids = explode(",", $postData["ids"]);
		for ($i=0; $i<count($ids); $i++) {
			$rowId = $ids[$i];
			
			$data = array(
				'caption' 	  => $postData[$rowId . "_caption"],
				'description' 	  => $postData[$rowId . "_description"],
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


                      
						
