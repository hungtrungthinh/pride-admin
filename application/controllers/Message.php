<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	
	public function __construct()
	{
		parent::__construct();
				
		$this->load->model("message_model");
		$this->load->model("claim_model");
	}
	
	public function index()
	{
		if (!$this->session->userdata('logged_in'))
			redirect("user/index");
		$this->load->view('message');
		$this->session->set_userdata(array("page" => "message"));
	}
	
	public function getdata()
	{		
		header("Content-Type: text/plain");
		
		$xmlDoc = new DOMDocument();
		$root = $xmlDoc->appendChild($xmlDoc->createElement("rows"));
		
		$dateFrom = $this->input->get("dateFrom");
		$dateTo = $this->input->get("dateTo");
		foreach ($this->message_model->getMessages($dateFrom, $dateTo) as $data) {
			$row = $root->appendChild(
				$xmlDoc->createElement("row"));
           
			$row->appendChild(
				$xmlDoc->createAttribute("id"))->appendChild(
					$xmlDoc->createTextNode($data["id"]));
			
			$row->appendChild($xmlDoc->createElement("cell", ""));
			$row->appendChild($xmlDoc->createElement("cell", $data["request_time"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["message"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["full_name"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["phone_number"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["email"]));
			$claims = $this->claim_model->getClaims($data["claim_id"]);
			$claimType = (count($claims)) ? $claims[0]["caption"] : "";
			$row->appendChild($xmlDoc->createElement("cell", $claimType));
		}
		
		$xmlDoc->formatOutput = true;
		exit($xmlDoc->saveXML());
	}
	
	//for mobile
	public function savemessages()
	{
		header("Content-Type: text/json");
		
		exit($this->message_model->saveMessages(
					$this->input->post("full_name"), 
					$this->input->post("phone_number"), 
					$this->input->post("email"), 
					$this->input->post("claim_type"), 
					$this->input->post("message"), 
					$this->input->post("adjuster_id")));
	}
	
	public function updatemessages()
	{
		header("Content-Type: text/plain");
		
		exit($this->message_model->updateMessages($this->input->post()));
	}
}
