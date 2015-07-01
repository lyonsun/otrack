<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			redirect(base_url('login'),'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$this->load->library('ion_auth');
		$this->load->model(array('customer','order'));
	}

	function index()
	{
		$this->data['title'] = $this->lang->line('home_heading');
		$this->data['status'] = $this->session->flashdata('status');
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->data['number_of_customers'] = $this->customer->count();

    $this->data['number_of_orders'] = $this->order->count();

    $this->data['number_of_international_orders'] = $this->order->count('', 1);
    $this->data['number_of_domestic_orders'] = $this->order->count('', 2);

    $this->data['number_of_pending_orders'] = $this->order->count(1, '');
    $this->data['number_of_finished_orders'] = $this->order->count(2, '');
		
		$this->load->view('otrack/home', $this->data);
	}
}
