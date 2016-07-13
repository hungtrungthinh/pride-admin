<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adjuster_model extends CI_Model {
	
	private $_table;
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = "tbl_adjusters";
	}
	
	private function getDistanceBetweenPointsNew($curLocation, $desLocation, $unit = 'Mi') {
		$theta = $curLocation[1] - $desLocation[1];
		$distance = (sin(deg2rad($curLocation[0] * 1.0)) * sin(deg2rad($desLocation[0] * 1.0))) + (cos(deg2rad($curLocation[0] * 1.0)) * cos(deg2rad($desLocation[0] * 1.0)) * cos(deg2rad($theta * 1.0)));
		$distance = acos($distance);
		$distance = rad2deg($distance);
		$distance = $distance * 60 * 1.1515;
		switch($unit) {
			case 'Mi': 
				break; 
			case 'Km' : 
				$distance = $distance * 1.609344;
			default:
				break;
		}
		return (round($distance,2));
	}
	
	public function getAdjusters($geolocation = null)
	{
		$query = $this->db->get($this->_table);
		$rows = $query->result_array();
		
		if (!is_null($geolocation)) {
			if (count($rows) > 0) {
				$tempArr = array();
				foreach ($rows as $row) {
					array_push($tempArr, array("row"=>$row, "distance"=>($this->getDistanceBetweenPointsNew(explode( ",", $geolocation), explode(",", $row['geolocation'])))));
				}
				if (count($tempArr) > 3) {
					for ($i=0; $i<count($tempArr)-1; $i++) {
						for ($j=$i+1; $j<count($tempArr); $j++) {
							if ($tempArr[$i]["distance"] > $tempArr[$j]["destance"]) {
								$c = $tempArr[$i]; 
								$tempArr[$i] = $tempArr[$j]; 
								$tempArr[$j] = $c; 
								continue;
							}
						}
					}
				}
				$retArr = array();
				for ($i=0; $i < ((count($tempArr)<3) ? count($tempArr) : 3); $i++) {
					array_push($retArr, $tempArr[$i]["row"]);
				}
				return $retArr;
			}
		}
		return $rows;
	}
	
	public function getAdjusterById($id) {
		if (is_null($id))
			return array();
		
		$query = $this->db->get_where($this->_table, array("id"=>$id));
		$rows = $query->result_array();
		return (count($rows) > 0 ) ? $rows[0] : array();
		
	}
	
	public function saveAdjusters($postData)
	{
		$xmlStr = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$xmlStr .= '<data>';
		$ids = explode(",", $postData["ids"]);
		for ($i=0; $i<count($ids); $i++) {
			$rowId = $ids[$i];
			
			$birthday = explode("/", $postData[$rowId . "_birthday"]);
			$data = array(
				'full_name' 	  => $postData[$rowId . "_full_name"],
				'gender' 	  => $postData[$rowId . "_gender"],
				'birthday' 	  => $birthday[2] . "-" . $birthday[1] . "-" . $birthday[0],
				'address' 	  => $postData[$rowId . "_address"],
				'geolocation' => $postData[$rowId . "_geolocation"],
				'phone_number' 	  => $postData[$rowId . "_phone_number"],
				'email' 	  => $postData[$rowId . "_email"],
				'avator' 	  => $postData[$rowId . "_avator"]
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


                      
						
