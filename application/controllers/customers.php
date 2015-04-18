<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    if (!$this->ion_auth->logged_in())
    {
      //redirect them to the login page
      redirect(base_url('auth/login'), 'refresh');
    }
    elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
    {
      //redirect them to the home page because they must be an administrator to view this
      return show_error('You must be an administrator to view this page.');
    }
  }

	public function index()
	{
		$this->load->view('otrack/customers');
	}

	function create()
	{
		$this->load->view('otrack/customers/create');
	}
}
