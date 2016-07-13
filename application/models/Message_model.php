<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model {
	
	private $_table;
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = "tbl_messages";
	}
	
	public function getMessages($dateFrom = null, $dateTo = null)
	{
		$dateFrom = (is_null($dateFrom) ? date("Y-m-d") : $dateFrom);
		$dateFrom = sprintf("%s 00:00:00", $dateFrom);
		$dateTo = (is_null($dateFrom) ? date("Y-m-d") : $dateTo);
		$dateTo = sprintf("%s 23:59:59", $dateTo);
		
		$timezone = "America/Los_Angeles";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		
		$this->db->where('request_time >=', $dateFrom);
		$this->db->where('request_time <=', $dateTo);
		$query = $this->db->get($this->_table);
		return $query->result_array();
	}
	
	/**
	*
	* This function is used by mobile users. 
	*
	* @params: $fullName: string
	*		   $phoneNumber: string
	*		   $email: string
	*		   $claimType: int
	*		   $message: string
	*		   $requestTime: string
	*
	* @return: "SUCCEED" | "FAILURE"
	*/
	public function saveMessage($fullName, $phoneNumber, $email, $claimId, $message, $adjusterId, $requestTime = null)
	{
		$data = array(
			'full_name'	   => $fullName,
			'phone_number' => $phoneNumber,
			'email' 	   => $email,
			'claim_id' 	   => $claimId,
			'message' 	   => $message,
			'adjuster_id'  => $adjusterId,
			'request_time' => (is_null($requestTime)) ? date("Y-m-d") : $requestTime
		);
		return json_encode(array("status" => ($this->db->insert($this->_table, $data)) ? "SUCCEED" : "FAILURE"));
	}
	
	public function updateMessages($postData)
	{
		$xmlStr = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$xmlStr .= '<data>';
		
		$ids = explode(",", $postData["ids"]);
		for ($i=0; $i<count($ids); $i++) {
			$rowId = $ids[$i];
				
			$data = array(
				'full_name' 	  => $postData[$rowId . "_full_name"],
				'phone_number' 	  => $postData[$rowId . "_phone_number"],
				'email' 	  => $postData[$rowId . "_email"],
				'claim_id' 	  => $postData[$rowId . "_claim_id"],
				'message' 	  => $postData[$rowId . "_message"],
				'request_time' => $postData[$rowId . "_request_time"]
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


                      
						
