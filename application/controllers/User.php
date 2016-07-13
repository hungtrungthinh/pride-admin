<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("user_model");
	}
	
	public function index()
	{
		$this->load->view('login');
	}
	
	public function checkuser()
	{
		$user_id = $this->input->post("user_id");
		$user_pass = $this->input->post("password");
		
		$loginMsg = $this->user_model->checkUser($user_id, $user_pass);
		if ($loginMsg == "SUCCEED") {
			$sessData = array(
				'user_id'  => $user_id,
				'logged_in' => TRUE,
				'page'		=> "message",
			);
			$this->session->set_userdata($sessData);
		}
		exit($loginMsg);
	}
	
	public function signup()
	{
		$this->load->view('signup');
	}
	
	public function register()
	{
		exit($this->user_model->registUser($this->input->post("user_id"), $this->input->post("password")));
	}
	
	public function logout()
	{
		$this->session->unset_userdata(array("user_id", "logged_in", "page"));
		redirect("user/index");
	}
	
	public function users()
	{
		if (!$this->session->userdata('logged_in'))
			redirect("user/index");
		$this->load->view('users');
		$this->session->set_userdata(array("page" => "/user/users"));
	}
	
	public function saveusers()
	{
		if (!$this->session->userdata('logged_in'))
			redirect("user/index");
		
		header("Content-Type: text/plain");
		
		exit($this->user_model->saveUsers($this->input->post()));
	}
	
	public function getregistedusers()
	{
		if (!$this->session->userdata('logged_in'))
			redirect("user/index");
		
		header("Content-Type: text/plain");		
		$xmlDoc = new DOMDocument();
		$root = $xmlDoc->appendChild($xmlDoc->createElement("rows"));
		
		foreach ($this->user_model->getUsers() as $data) {
			$row = $root->appendChild(
				$xmlDoc->createElement("row"));
           
			$row->appendChild(
				$xmlDoc->createAttribute("id"))->appendChild(
					$xmlDoc->createTextNode($data["id"]));
					
			$row->appendChild($xmlDoc->createElement("cell", ""));
			$row->appendChild($xmlDoc->createElement("cell", $data["user_id"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["user_pass"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["full_name"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["reg_date"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["allow"]));		
			$row->appendChild($xmlDoc->createElement("cell", $data["access_count"]));		
		}
		
		$xmlDoc->formatOutput = true;
		exit($xmlDoc->saveXML());
	}
}
