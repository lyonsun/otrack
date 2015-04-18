<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    //redirect them to the login page
    if (!$this->ion_auth->logged_in())
    {
      redirect(base_url('auth/login'), 'refresh');
    }
    
    //redirect them to the home page because they must be an administrator to view this
    if (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
    {
      return show_error('You must be an administrator to view this page.');
    }

    $this->load->model(array('customer'));
  }

	public function index()
	{
    $this->load->library('table');

    $this->data['title'] = 'Customers';
    $this->data['status'] = $this->session->flashdata('status');
    $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

    $this->data['number_of_customers'] = $this->customer->count();
    $this->data['customers'] = $this->customer->get();

		$this->load->view('otrack/customers', $this->data);
	}

	function create()
	{
    $this->data['title'] = "Create Customer";

    //validate form input
    $this->form_validation->set_rules('name', 'Customer Name', 'required');
    $this->form_validation->set_rules('phone', 'Phone Number', 'required');
    $this->form_validation->set_rules('address_1', 'Address 1', 'required');
    $this->form_validation->set_rules('district', 'District', 'required');
    $this->form_validation->set_rules('city', 'City', 'required');
    $this->form_validation->set_rules('Province', 'Province', 'required');

    if ($this->form_validation->run() == true)
    {
      $customer_data = array(
        'name'        => $this->input->post('name'),
        'phone'       => $this->input->post('phone'),
        'address_1'   => $this->input->post('address_1'),
        'address_2'   => $this->input->post('address_2'),
        'district'    => $this->input->post('district'),
        'city'        => $this->input->post('city'),
        'province'    => $this->input->post('province'),
        'zipcode'     => $this->input->post('zipcode'),
        'created_on'  => time(),
      );
    }

    if ($this->form_validation->run() == true && $this->customer->create($customer_data))
    {
      //check to see if we are creating the user
      //redirect them back to the admin page
      $this->session->set_flashdata('status', 'success');
      $this->session->set_flashdata('message', 'Customer created Successfully.');
      redirect(base_url('customers'), 'refresh');
    }
    else
    {
      //display the create user form
      //set the flash data error message if there is one
      $this->data['status'] = $this->session->flashdata('status');
      $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		  $this->load->view('otrack/customers/create', $this->data);
    }
	}
}
