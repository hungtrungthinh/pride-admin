<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adjuster extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	
	public function __construct()
	{
		parent::__construct();
				
		$this->load->model("adjuster_model");
	}
	
	public function index()
	{
		
		if (!$this->session->userdata('logged_in'))
			redirect("user/index");
		
		$this->session->set_userdata(array("page" => "adjuster"));
		
		$this->load->view('adjuster');
	}
	
	public function getadjusters()
	{
		if (!is_null($this->input->get("geolocation"))) {
			header("Content-Type: text/json");
			exit(json_encode($this->adjuster_model->getAdjusters($this->input->get("geolocation"))));
		}
		
		header("Content-Type: text/plain");		
		$xmlDoc = new DOMDocument();
		$root = $xmlDoc->appendChild($xmlDoc->createElement("rows"));
		
		foreach ($this->adjuster_model->getAdjusters() as $data) {
			$row = $root->appendChild(
				$xmlDoc->createElement("row"));
           
			$row->appendChild(
				$xmlDoc->createAttribute("id"))->appendChild(
					$xmlDoc->createTextNode($data["id"]));
			
			$birthday = explode("-", $data["birthday"]);
			if (count($birthday) == 3) {
				$birthdayStr = $birthday[2] . "/" . $birthday[1] . "/" . $birthday[0];
			}
			$row->appendChild($xmlDoc->createElement("cell", ""));
			$row->appendChild($xmlDoc->createElement("cell", $data["full_name"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["gender"]));		
			$row->appendChild($xmlDoc->createElement("cell", $birthdayStr));		
			$row->appendChild($xmlDoc->createElement("cell", $data["address"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["geolocation"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["phone_number"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["email"]));
			$row->appendChild($xmlDoc->createElement("cell", $data["avator"]));
		}
		
		$xmlDoc->formatOutput = true;
		exit($xmlDoc->saveXML());
	}
	
	public function upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			print_r("<SCRIPT>window.parent.uploadFailure('" .  $error["error"] . "')</SCRIPT>");
		}
		else
		{
			$data = $this->upload->data();
			print_r("<SCRIPT>window.parent.uploadFinished(true, '" . $data["file_name"] . "', '". $data["file_size"] . "')</SCRIPT>");
		}
	}
	
	public function saveadjusters()
	{
		header("Content-Type: text/plain");
		
		exit($this->adjuster_model->saveAdjusters($this->input->post()));
	}
}
