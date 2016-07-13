<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claim extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	
	public function __construct()
	{
		parent::__construct();
				
		$this->load->model("claim_model");
	}
	
	public function index()
	{
		
		if (!$this->session->userdata('logged_in'))
			redirect("user/index");
		$this->session->set_userdata(array("page" => "claim"));
		
		$this->load->view('claim');
	}
	
	public function getdata()
	{
		header("Content-Type: text/plain");		
		$xmlDoc = new DOMDocument();
		$root = $xmlDoc->appendChild($xmlDoc->createElement("rows"));
		
		foreach ($this->claim_model->getClaims() as $data) {
			$row = $root->appendChild(
				$xmlDoc->createElement("row"));
           
			$row->appendChild(
				$xmlDoc->createAttribute("id"))->appendChild(
					$xmlDoc->createTextNode($data["id"]));
			
			$row->appendChild($xmlDoc->createElement("cell", ""));
			$row->appendChild($xmlDoc->createElement("cell", $data["caption"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["description"]));		
		}
		
		$xmlDoc->formatOutput = true;
		exit($xmlDoc->saveXML());
	}
	
	public function savedata()
	{
		header("Content-Type: text/plain");
		
		exit($this->claim_model->saveClaims($this->input->post()));
	}
	
	public function getclaimjson()
	{
		header("Content-Type: text/json");	
		exit(json_encode($this->claim_model->getClaims()));
	}
}
