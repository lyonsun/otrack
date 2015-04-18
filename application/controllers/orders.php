<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    if (!$this->ion_auth->logged_in()) {
      redirect(base_url('auth/login'),'refresh');
    }
    elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
    {
      //redirect them to the home page because they must be an administrator to view this
      return show_error('You must be an administrator to view this page.');
    }
    $this->load->library('ion_auth');
  }

	function index()
	{
		$this->load->view('otrack/orders');
	}

	function create()
	{
		$this->load->view('otrack/orders/create');
	}
}
