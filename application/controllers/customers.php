<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

	public function index()
	{
		$this->load->view('otrack/customers');
	}

	function create()
	{
		$this->load->view('otrack/customers/create');
	}
}
