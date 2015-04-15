<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect(base_url('auth/login'),'refresh');
		}
		
		$this->load->view('otrack/home');
	}
}
