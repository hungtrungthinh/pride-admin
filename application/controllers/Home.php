<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
			redirect("user/index");
	}
	
	public function index()
	{
		$this->load->view('index', array("page" => $this->session->userdata('page')));
	}
}
